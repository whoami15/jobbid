<?php

class SQLQuery {
    protected $_dbHandle;
    protected $_result;
	protected $_query;
	protected $_table;
	protected $_describe = array();
	protected $_orderBy;
	protected $_groupBy;
	protected $_order;
	protected $_extraConditions;
	protected $_hO;
	protected $_hJoin;
	protected $_page;
	protected $_limit;
	protected $_hOModels = array();
	protected $_hParentModels = array();
	protected $_hChildModels = array();

    /** Connects to database **/
    function connect($address, $account, $pwd, $name) {
        $this->_dbHandle = mysql_pconnect($address, $account, $pwd);
        if ($this->_dbHandle != 0) {
            if (mysql_select_db($name, $this->_dbHandle)) {
				mysql_query("SET NAMES 'utf8'");
                return 1;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }
 
    /** Disconnects from database **/
    function disconnect() {
        if (@mysql_close($this->_dbHandle) != 0) {
            return 1;
        }  else {
            return 0;
        }
    }

    /** Select Query **/
	function where($strWhere) {
		$this->_extraConditions .= $strWhere;
	}
	function groupBy($strGroupBy) {
		$this->_groupBy = " group by $strGroupBy";
	}
	function showHasOne($arrModels=null) {
		$this->_hO = 1;
		if($arrModels!=null) {
			foreach($arrModels as $model)
				array_push($this->_hOModels,$model);
		}
	}
	function hasJoin($arrChilds = null,$arrParents=null) {
		$this->_hJoin = 1;
		if( $arrParents!=null && count($arrParents)==count($arrChilds) ) {
			foreach($arrParents as $model)
				array_push($this->_hParentModels,$model);
			foreach($arrChilds as $model)
				array_push($this->_hChildModels,$model);
		}
	}

	function setLimit($limit) {
		$this->_limit = $limit;
	}

	function setPage($page) {
		$this->_page = $page;
	}

	function orderBy($orderBy, $order = 'ASC') {
		$this->_orderBy = $orderBy;
		$this->_order = $order;
	}

	function search($select="*",$debug=false) {
		global $inflect;
		$from = '`'.$this->_table.'` as `'.$this->_model.'` ';
		$conditions = '\'1\'=\'1\' ';
		$conditionsChild = '';
		$fromChild = '';
		if ($this->_hO == 1 && isset($this->hasOne)) {
			if($this->_hOModels == null)
				$this->_hOModels = $this->hasOne;
			foreach ($this->_hOModels as $model) {
				$table = strtolower($inflect->pluralize($model));
				$singularAlias = strtolower($model);
				$from .= 'LEFT JOIN `'.$table.'` as `'.$model.'` ';
				$from .= 'ON `'.$this->_model.'`.`'.$singularAlias.'_id` = `'.$model.'`.`id`  ';
			}
		}
		if ($this->_hJoin == 1) {
			$i = 0;
			while($i<count($this->_hParentModels)) {
				$pModels = $this->_hParentModels[$i];
				$cModels = $this->_hChildModels[$i];
				if($this->_model == $pModels) {
					$cTable = strtolower($inflect->pluralize($cModels));
					$from .= 'LEFT JOIN `'.$cTable.'` as `'.$cModels.'` ';
				} else {
					$pTable = strtolower($inflect->pluralize($pModels));
					$from .= 'LEFT JOIN `'.$pTable.'` as `'.$pModels.'` ';
				}
				$from .= 'ON `'.$pModels.'`.`'.'id` = `'.$cModels.'`.`'.$pModels.'_id`  ';
				$i++;
			}
		}
		if ($this->id) {
			$conditions .= ' AND `'.$this->_model.'`.`id` = \''.mysql_real_escape_string($this->id).'\' ';
		}
		if ($this->_extraConditions) {
			$conditions .= $this->_extraConditions;
		}
		if ($this->_groupBy) {
			$conditions .= $this->_groupBy;
		}
		//$conditions = substr($conditions,0,-4);
		if (isset($this->_orderBy)) {
			$conditions .= ' ORDER BY '.$this->_orderBy.' '.$this->_order;
		}
		if (isset($this->_page)) {
			$offset = ($this->_page-1)*$this->_limit;
			$conditions .= ' LIMIT '.$this->_limit.' OFFSET '.$offset;
		}
		$this->_query = "SELECT $select FROM ".$from.' WHERE '.$conditions;
		if($debug)
			die($this->_query);
		$this->_result = mysql_query($this->_query, $this->_dbHandle) ;
		$result = array();
		$table = array();
		$field = array();
		$tempResults = array();
		$numOfFields = mysql_num_fields($this->_result); //or die("Loi:".mysql_error().$this->_query);
		for ($i = 0; $i < $numOfFields; ++$i) {
		    array_push($table,mysql_field_table($this->_result, $i));
		    array_push($field,mysql_field_name($this->_result, $i));
		}
		if (mysql_num_rows($this->_result) > 0 ) {
			while ($row = mysql_fetch_row($this->_result)) {
				for ($i = 0;$i < $numOfFields; ++$i) {
					$tempResults[$table[$i]][$field[$i]] = $row[$i];
				}
				array_push($result,$tempResults);
			}
			if (mysql_num_rows($this->_result) == 1 && $this->id != null) {
				mysql_free_result($this->_result);
				$this->clear();
				return($result[0]);
			} else {
				mysql_free_result($this->_result);
				$this->clear();
				return($result);
			}
		} else {
			mysql_free_result($this->_result);
			$this->clear();
			return $result;
		}
	}

    /** Custom SQL Query **/
	function query($query) {
		global $inflect;
		$this->_result = mysql_query($query, $this->_dbHandle);
		$result = array();
		$tempResults = array();
		$field = array();
		if(substr_count(strtoupper($query),"SELECT")>0) {
			if (mysql_num_rows($this->_result) > 0) {
				$numOfFields = mysql_num_fields($this->_result);
				for ($i = 0; $i < $numOfFields; ++$i) {
					array_push($field,mysql_field_name($this->_result, $i));
				}
				while ($row = mysql_fetch_row($this->_result)) {
					for ($i = 0;$i < $numOfFields; ++$i) {
						$tempResults[$field[$i]] = $row[$i];
					}
					array_push($result,$tempResults);
				}
			}
		}
		if(count($this->_query)>0)
			mysql_free_result($this->_result);
		$this->clear();
		return($result);
	}
	/** Custom SQL Query (Select Table)**/
	function custom($query) {
		global $inflect;
		//die($query);
		$this->_result = mysql_query($query, $this->_dbHandle);
		$result = array();
		$table = array();
		$field = array();
		$tempResults = array();
		if(substr_count(strtoupper($query),"SELECT")>0) {
			if (mysql_num_rows($this->_result) > 0) {
				$numOfFields = mysql_num_fields($this->_result);
				for ($i = 0; $i < $numOfFields; ++$i) {
					array_push($table,mysql_field_table($this->_result, $i));
					array_push($field,mysql_field_name($this->_result, $i));
				}
					while ($row = mysql_fetch_row($this->_result)) {
						for ($i = 0;$i < $numOfFields; ++$i) {
							$table[$i] = ($inflect->singularize($table[$i]));
							$tempResults[$table[$i]][$field[$i]] = $row[$i];
						}
						array_push($result,$tempResults);
					}
			}
		}
		if(count($this->_query)>0)
			mysql_free_result($this->_result);
		$this->clear();
		return($result);
	}
	
    /** Describes a Table **/
	protected function _describe() {
		global $cache;
		$this->_describe = $cache->get('describe'.$this->_table);
		if (!$this->_describe) {
			$this->_describe = array();
			$query = 'DESCRIBE '.$this->_table;
			$this->_result = mysql_query($query, $this->_dbHandle);
			while ($row = mysql_fetch_row($this->_result)) {
				 array_push($this->_describe,$row[0]);
			}
			mysql_free_result($this->_result);
			$cache->set('describe'.$this->_table,$this->_describe);
		}
		foreach ($this->_describe as $field) {
			$this->$field = null;
		}
	}

    /** Delete an Object **/
	function delete() {
		if ($this->id) {
			$query = 'DELETE FROM '.$this->_table.' WHERE `id`=\''.mysql_real_escape_string($this->id).'\'';		
			$this->_result = mysql_query($query, $this->_dbHandle);
			$this->clear();
			if ($this->_result == 0) {
			    /** Error Generation **/
				return -1;
		   }
		} else {
			/** Error Generation **/
			return -1;
		}
	}
	
	/** Saves an Object i.e. Updates/Inserts Query **/
	function save() {
		$query = '';
		if (isset($this->id)) {
			$updates = '';
			foreach ($this->_describe as $field) {
				if (isset($this->$field)) {
					$updates .= '`'.$field.'` = \''.mysql_real_escape_string($this->$field).'\',';
				}
			}
			$updates = substr($updates,0,-1);
			$query = 'UPDATE '.$this->_table.' SET '.$updates.' WHERE `id`=\''.mysql_real_escape_string($this->id).'\'';			
		} else {
			$fields = '';
			$values = '';
			foreach ($this->_describe as $field) {
				if (isset($this->$field)) {
					$fields .= '`'.$field.'`,';
					$values .= '\''.mysql_real_escape_string($this->$field).'\',';
				}
			}
			$values = substr($values,0,-1);
			$fields = substr($fields,0,-1);
			$query = 'INSERT INTO '.$this->_table.' ('.$fields.') VALUES ('.$values.')';
		}
		$this->_result = mysql_query($query, $this->_dbHandle);
		$this->clear();
		if ($this->_result == 0) {
            /** Error Generation **/
			return -1;
        }
	}
	
    /** Insert data **/
	function insert($returnId=false,$debug = false) {
		$query = '';
		$fields = '';
		$values = '';
		foreach ($this->_describe as $field) {
			$fields .= '`'.$field.'`,';
			if(isset($this->$field))
				$values .= '\''.mysql_real_escape_string($this->$field).'\',';
			else 
				$values .= 'null,';
		}
		$values = substr($values,0,-1);
		$fields = substr($fields,0,-1);
		$query = 'INSERT INTO '.$this->_table.' ('.$fields.') VALUES ('.$values.')';
		if($debug==true)
			die($query);
		mysql_query($query, $this->_dbHandle) or die("Error :".mysql_error());
		if($returnId == true) {
			$rs=mysql_query("select @@identity ID", $this->_dbHandle);
			$a_row=mysql_fetch_row($rs);
			$return = $a_row[0];
			$this->clear();
			return $return;
		} else {
			$this->clear();
		}
	}
	function update($where = null) {
		if($where == null) 
			$where = '`id`=\''.mysql_real_escape_string($this->id).'\'';
		$query = '';
		$updates = '';
		foreach ($this->_describe as $field) {
			if (isset($this->$field)) {
				if($this->$field=="") 
					$updates .= '`'.$field.'` = null,';
				else
					$updates .= '`'.$field.'` = \''.mysql_real_escape_string($this->$field).'\',';
			}
		}
		$updates = substr($updates,0,-1);
		$query = 'UPDATE '.$this->_table.' SET '.$updates.' WHERE '.$where;		
		//die($query);
		$this->_result = mysql_query($query, $this->_dbHandle);
		$return = $this->id;
		$this->clear();
		return $return;
	}
	/** Clear All Variables **/
	function clear() {
		foreach($this->_describe as $field) {
			$this->$field = null;
		}

		$this->_orderby = null;
		$this->_extraConditions = null;
		$this->_hO = null;
		$this->_hJoin = null;
		$this->_page = null;
		$this->_order = null;
	}

	/** Pagination Count **/
	function totalPages() {
		if ($this->_query && $this->_limit) {
			$pattern = '/SELECT (.*?) FROM (.*)LIMIT(.*)/i';
			$replacement = 'SELECT COUNT(*) FROM $2';
			$countQuery = preg_replace($pattern, $replacement, $this->_query);
			$this->_result = mysql_query($countQuery, $this->_dbHandle);
			$count = mysql_fetch_row($this->_result);
			$totalPages = ceil($count[0]/$this->_limit);
			return $totalPages;
		} else {
			/* Error Generation Code Here */
			return -1;
		}
	}

    /** Get error string **/
    function getError() {
        return mysql_error($this->_dbHandle);
    }
}
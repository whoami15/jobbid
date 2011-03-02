<?php

class HTML {
	private $js = array();
	function safevalue($val) {
		if(isset($val))
			return $val;
		return "";
	}
	function shortenUrls($data) {
		$data = preg_replace_callback('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', array(get_class($this), '_fetchTinyUrl'), $data);
		return $data;
	}
        function getURLParam() {
             $param = $_SERVER["REQUEST_URI"];
             return $param;
        }
        function FormatMoney($str)
        {
 
            $rs="";
            $dem=0;
            for($i=strlen($str)-1;$i>=0;$i--)
            {
                $dem++;
                if($dem==3 && $i>0)
                {
                    $rs=".".$str[$i].$rs;
                    $dem=0;
                }
                else
                    $rs=$str[$i].$rs;
            }
            return $rs;
        }
        function format_date($date,$format)
        {
			if(isset($date)) {
				$sqldate = strtotime($date);
				return date($format, $sqldate);
			} 
			return "";
        }
		function trimString($str,$maxlen=30) {
			if(strlen($str)<=$maxlen)
				return $str;
			return substr($str,0,$maxlen-10)."...".substr($str,-7);
		}
		function getDaysFromSecond($second)
        {
			if($second<=0) {
				return "Đã hết hạn.";
			} 
			$d = (int)($second/86400);
			$second = $second%86400;
			$h = (int)($second/3600);
			if($d>0) {
				if($h==0)
					return "$d ngày";
				else
					return "$d ngày $h giờ";
			}
			$second = $second%3600;
			$m = (int)($second/60);
			if($h>0) {
				if($m==0)
					return "$h giờ";
				else
					return "$h giờ $m phút";
			}
			$second = $second%60;
			if($m==0)
				return "<span style='color:red'>$second giây</span>";
			return "<span style='color:red'>$m phút $second giây</span>";
        }
		function getTimeFromSecond($second)
        {
			$d = (int)($second/86400);
			$second = $second%86400;
			$h = (int)($second/3600);
			if($d>0) {
				if($h==0)
					return "$d ngày";
				else
					return "$d ngày $h giờ";
			}
			$second = $second%3600;
			$m = (int)($second/60);
			if($h>0) {
				if($m==0)
					return "$h giờ";
				else
					return "$h giờ $m phút";
			}
			$second = $second%60;
			if($m==0)
				return "$second giây";
			return "$m phút $second giây";
        }
        function upper($src)
        {
            return mb_convert_case($src,MB_CASE_UPPER,"utf-8");
        }
        function trimRight($src,$pos,$c)
        {
            $i=strlen($src)-1;
            while($src[$i]!=$c)
            {
                $i--;
            }
            return substr($src, $pos,$i);
        }
	private function _fetchTinyUrl($url) { 
		$ch = curl_init(); 
		$timeout = 5; 
		curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url[0]); 
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout); 
		$data = curl_exec($ch); 
		curl_close($ch); 
		return '<a href="'.$data.'" target = "_blank" >'.$data.'</a>'; 
	}

	function sanitize($data) {
		return mysql_real_escape_string($data);
	}

	function link($text,$path,$prompt = null,$confirmMessage = "Are you sure?") {
		$path = str_replace(' ','-',$path);
		if ($prompt) {
			$data = '<a href="javascript:void(0);" onclick="javascript:jumpTo(\''.BASE_PATH.'/'.$path.'\',\''.$confirmMessage.'\')">'.$text.'</a>';
		} else {
			$data = '<a href="'.BASE_PATH.'/'.$path.'">'.$text.'</a>';	
		}
		return $data;
	}
        function  matchString($strResult,$strKey)
        {
            $strResult=str_replace("\n","<br>", $strResult);
            if (strlen($strKey) == 0) {
                return $strResult;
            }
            for ($i = 0; $i <= strlen($strResult) - strlen($strKey); $i++) {
                $s0 = "";
                if ($i > 0) {
                    $s0 = substr($strResult,0,$i);
                }

                $s1 = substr($strResult,$i, strlen($strKey));
                $s2 = substr($strResult,($i+strlen($strKey)), strlen($strResult));
                $temp1=$this->upper($s1);
                $temp2=$this->upper($strKey);
                if (strcmp($temp1, $temp2) == 0) {
                    $strResult = $s0."<span id=\"mark\" >".$this->upper($s1)."</span>".$this->upper($s2);
                    $i += 24 + strlen($strKey);
                }
            }
            return $strResult;
        }
	function includeJs($fileName) {
		$data = '<script src="'.BASE_PATH.'/js/'.$fileName.'.js"></script>';
		return $data;
	}

	function includeCss($fileName) {
		$data = '<style href="'.BASE_PATH.'/css/'.$fileName.'.css"></script>';
		return $data;
	}
}
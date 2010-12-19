<?php

class ArticleController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = "article";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);
	}
	function beforeAction () {

	}
	function checkLogin($isAjax=false) {
		if(!isset($_SESSION['account'])) {
			if($isAjax == true) {
				die("ERROR_NOTLOGIN");
			} else {
				redirect(BASE_PATH.'/account/login');
				die();
			}
		}
	}
	function checkAdmin($isAjax=false) {
		if($isAjax==false)
			$_SESSION['redirect_url'] = getUrl();
		if(!isset($_SESSION['account']) || $_SESSION["account"]["role"]>1) {
			if($isAjax == true) {
				die("ERROR_NOTLOGIN");
			} else {
				redirect(BASE_PATH.'/admin/login&reason=admin');
				die();
			}
		}
	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	function view($id=null) {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		if($id != null && $id != 0) {
			$this->article->id=$id;
            $article=$this->article->search();
			if(isset($article)) {
				$viewcount = $article["article"]["viewcount"];
				$this->set("article",$article);
				$this->article->id=$id;
				$this->article->viewcount=$viewcount+1;
				$this->article->save();
				$query = "SELECT id,title,alias FROM `articles` as `article` WHERE active=1 AND `article`.`datemodified` < '".$article["article"]["datemodified"]."' order by datemodified desc LIMIT 5 OFFSET 0";
				$lstArticlesOlder = $this->article->custom($query);
				$this->set("lstArticlesOlder",$lstArticlesOlder);
				$this->_template->render();
			}
			
		}
	}
	function getContentById($id=null) {	
		if($id != null && $id != 0) {
			$this->article->id=$id;
            $article=$this->article->search();
			print_r($article['article']['content']);
		}
	}
    function listArticles($ipageindex) {
		$this->checkAdmin(true);
		$this->article->orderBy('datemodified','desc');
		$this->article->setPage($ipageindex);
		$this->article->setLimit(PAGINATE_LIMIT);
		$lstArticles = $this->article->search("id,alias,title,imagedes,contentdes,datemodified,usermodified,viewcount,active");
		$totalPages = $this->article->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstArticles);die();
		$this->set("lstArticles",$lstArticles);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function news($ipageindex=1) {
		if($ipageindex>=1) {
			$offset = ($ipageindex-1)*PAGINATE_LIMIT;
			$query = "SELECT id,alias,title,imagedes,contentdes FROM `articles` as `article` WHERE '1'='1' AND `article`.`active` = '1' ORDER BY `article`.`datemodified` desc LIMIT ".PAGINATE_LIMIT." OFFSET ".$offset;
			$lstArticles = $this->article->custom($query);		
			$this->set("lstArticles",$lstArticles);
			if(count($lstArticles)==PAGINATE_LIMIT) {
				$this->set('hasnext',true);
			}
			if($ipageindex>1) {
				$this->set('hasprev',true);
			}
			$this->set('pageindex',$ipageindex);
			$this->_template->render();
		}
	}
	function activeArticle($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->article->id = $id;
			$this->article->active = 1;
			$this->article->save();
			echo "DONE";
		}
	}
	function unActiveArticle($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->article->id = $id;
			$this->article->active = 0;
			$this->article->save();
			echo "DONE";
		}
	}
	function saveArticle() {
		$this->checkAdmin(true);
		try {
			$id = $_POST["article_id"];
			$title = $_POST["article_title"];
			$alias = $_POST["article_alias"];
			$imagedes = $_POST["article_imagedes"];
			$contentdes = $_POST["article_contentdes"];
			$content = $_POST["article_content"];
			if($id==null) { //insert
				$this->article->id = null;
				$this->article->title = $title;
				$this->article->alias = $alias;
				$this->article->imagedes = $imagedes;
				$this->article->contentdes = $contentdes;
				$this->article->content = $content;
				$this->article->datemodified = GetDateSQL();
				$this->article->usermodified = $_SESSION["account"]["username"];
				$this->article->viewcount = 0;
				$this->article->active = 1;
			} else { //update
				$this->article->id = $id;
				$this->article->title = $title;
				$this->article->alias = $alias;
				$this->article->imagedes = $imagedes;
				$this->article->contentdes = $contentdes;
				$this->article->content = $content;
				$this->article->datemodified = GetDateSQL();
				$this->article->usermodified = $_SESSION["account"]["username"];
			}
			$html = new HTML;
			$value = "{'datemodified':'".$html->format_date($this->article->datemodified,'d/m/Y H:i:s')."','usermodified':'".$this->article->usermodified."'}";
			$this->article->save();	
			print($value);
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}   
	function deleteArticle() {
		$this->checkAdmin(true);
		if(!isset($_GET["id"]))
			die("ERROR_SYSTEM");
		$id = $_GET["id"];
		$this->article->id=$id;
		if($this->article->delete()==-1) {
			echo "ERROR_SYSTEM";
		} else {
			echo "DONE";
		}
	}
	function testwidget() {
		$query = "SELECT id,title,alias FROM `articles` as `article` WHERE active=1 order by datemodified desc LIMIT 5 OFFSET 0";
		$wg_lstArticles = $this->article->custom($query);
		$json = json_encode($wg_lstArticles);
		print_r($json);
	}
	function afterAction() {

	}

}
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
		performAction('webmaster', 'updateStatistics');
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
		//$this->checkLogin();
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
				$this->set('title','Jobbid.vn - '.$article["article"]["title"]);
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
	function danhsachbaiviet($pageindex=1) {
		$_SESSION['redirect_url'] = getUrl();
		$this->article->orderBy('datemodified','desc');
		$this->article->setPage($pageindex);
		$this->article->setLimit(PAGINATE_LIMIT);
		$this->article->where(' and `active`=1');
		$data = $this->article->search('id,alias,title,imagedes,contentdes');
		$totalPages = $this->article->totalPages();
		$ipagesbefore = $pageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $pageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set("lstArticles",$data);
		$this->set('pagesindex',$pageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->set('title','Jobbid.vn - Trao đổi - Chia Sẻ - Thảo Luận');
		$this->_template->render();
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
	/* function testwidget() {
		$query = "SELECT id,title,alias FROM `articles` as `article` WHERE active=1 order by datemodified desc LIMIT 5 OFFSET 0";
		$wg_lstArticles = $this->article->custom($query);
		$json = json_encode($wg_lstArticles);
		print_r($json);
	} */
	function comments($article_id=null,$pageindex=1) {
		if($article_id==null)
			die();
		$this->setModel('comment');
		$this->comment->orderBy('ngaypost','desc');
		$this->comment->setPage($pageindex);
		$this->comment->setLimit(PAGINATE_LIMIT);
		$this->comment->where(" and article_id=$article_id");
		$data = $this->comment->search();
		$totalPages = $this->comment->totalPages();
		$ipagesbefore = $pageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $pageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set("lstComment",$data);
		$this->set('pagesindex',$pageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function afterAction() {

	}

}
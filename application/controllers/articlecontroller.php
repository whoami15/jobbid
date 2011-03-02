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
				$comment_ten = '';
				$comment_url = '';
				if(isset($_SESSION['nhathau'])) {
					$comment_ten = $_SESSION['nhathau']['displayname'];
					$comment_url = BASE_PATH.'/nhathau/xem_ho_so/'.$_SESSION['nhathau']['id'].'/'.$_SESSION['nhathau']['nhathau_alias'];
				}
				$this->set('title','Jobbid.vn - '.$article["article"]["title"]);
				$this->set('description',$article["article"]["contentdes"]);
				$this->set('comment_ten',$comment_ten);
				$this->set('comment_url',$comment_url);
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
			$result = $this->article->custom("SELECT id,title,alias FROM `articles` as `article` WHERE active=1 order by datemodified desc LIMIT 5 OFFSET 0");
			global $cache;
			$data = array();
			foreach($result as $article) {
				array_push($data,array('id'=>$article['article']['id'],'title'=>$article['article']['title'],'alias'=>$article['article']['alias']));
			}
			$cache->set('lastnews',$data);
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
		$this->comment->setLimit(7);
		$this->comment->where(" and article_id=$article_id");
		$data = $this->comment->search('id,ten,url,noidung,UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(ngaypost) as timeofpost');
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
	function doSaveComment() {
		try {
			if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ) ) {
				unset($_SESSION['security_code']);
			} else {
				die("ERROR_SECURITY_CODE");
			}
			$validate = new Validate();
			if($validate->check_submit(1,array("article_id","comment_ten","comment_url","comment_noidung"))==false)
				die('ERROR_SYSTEM');
			$article_id = $_POST["article_id"];
			$ten = $_POST["comment_ten"];
			$url = $_POST["comment_url"];
			if($url==null)
				$url = '#';
			$noidung = $_POST["comment_noidung"];
			if($validate->check_null(array($article_id,$ten,$noidung))==false)
				die('ERROR_SYSTEM');
			$this->setModel('comment');
			$this->comment->id = null;
			$this->comment->ten = $ten;
			$this->comment->url = $url;
			$this->comment->article_id = $article_id;
			$this->comment->noidung = $noidung;
			$this->comment->ngaypost = GetDateSQL();
			$this->comment->insert();
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function doDeleteComment() {
		$this->checkAdmin(true);
		if(!isset($_GET["comment_id"]))
			die("ERROR_SYSTEM");
		$id = $_GET["comment_id"];
		$this->setModel('comment');
		$this->comment->id=$id;
		if($this->comment->delete()==-1) {
			echo "ERROR_SYSTEM";
		} else {
			echo "DONE";
		}
	}
	function afterAction() {

	}

}
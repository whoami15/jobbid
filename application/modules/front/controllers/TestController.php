<?php

class Front_TestController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->_helper->layout->setLayout('test_layout');
    }
	public function indexAction() {
		$this->_helper->layout->disableLayout();
		$cUrl = new Core_Dom_Curl(array(
				'method' => 'GET',
				'header' => array(
						'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
						'Accept-Encoding: gzip, deflate',
						'Accept-Language: en-US,en;q=0.5',
						'Connection: keep-alive',
						'DNT: 1',
						'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:19.0) Gecko/20100101 Firefox/19.0',
						'X-Requested-With: 	XMLHttpRequest'
				)
		));
		$url ='http://hcm.vieclam.24h.com.vn/sinh-vien-lam-them/nhan-vien-kinh-doanh-website-hostingdomain-c46p1id1238556.html';
		$content = $cUrl->getContent($url);
		echo $content;
	}

}


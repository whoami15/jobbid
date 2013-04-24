<?php

class Application_Model_Worker_Fw
{
	protected static $_instance = null;
	var $_header;
	var $_cUrl;
	public static function getInstance($className=__CLASS__){
		//Check instance
		if(empty(self::$_instance)){
			self::$_instance = new $className;
		}
		//Return instance
		return self::$_instance;
	}
	public function __construct(){
		$this->_cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
			'cookie' => 'Cookie: cprelogin=no; cpsession=bamboode%3avXE5mTVeFQdlsl2WG6o6XlR8owCLtnpgWIfr13XvEiew5l91VMWwAmFewgci38B_; langedit=; lang=; webmailsession=center%40bamboodev.us%3aHiTH9yjSvMJSWlUDxGXiErCdKKPraHyQKKzXIaPFF6iuVgOf3sK1TuI__mNEODPF; webmailrelogin=no; roundcube_sessauth=S612075c9da1c428b8c0bb0610fdbc4cc9ef69189'
		));
		 
	}
	public function start() {
		//$content = $this->_cUrl->getContent('http://bamboodev.us:2082');
		//Core_Utils_Log::write($content);die;
		$content = '<form action="doaddfwd.html" id="fwdf" name="fwdf" method="post">

    <h2>Address</h2>
    <table cellspacing="4">
	    
	    
			<tbody><tr>
				<td>Address to Forward: <input type="text" size="25" name="email" id="email">@<select name="domain"><option value="bamboodev.us">bamboodev.us</option></select></td>
				<td><span id="email_error" style="width: 16px; height: 16px;" class="cjt_validation_error" title=""><img width="16" height="16" align="absmiddle" alt="success" src="/cPanel_magic_revision_0/cjt/images/icons/success.png"></span></td>
			</tr>
	    
    </tbody></table>
    <br>
    
    <h2>Destination</h2>
    <div class="formbox">
	
	
    
	
		<input type="radio" checked="checked" value="fwd" id="fwd_radio" name="fwdopt"> <label for="fwd_radio">Forward to email address</label>: <input type="text" size="40" id="fwdemail" name="fwdemail"> <span id="fwdemail_error" style="width: 16px; height: 16px;" class="cjt_validation_error" title=""><img width="16" height="16" align="absmiddle" alt="success" src="/cPanel_magic_revision_0/cjt/images/icons/success.png"></span>
		<br><br>

		
		<input type="radio" id="discard_radio" value="fail" name="fwdopt"> <label for="discard_radio">Discard with error to sender (at SMTP time)</label><br>
		<blockquote>
			Failure Message (seen by sender): <input type="text" value="No such person at this address" size="40" id="failmsgs" name="failmsgs"> <span id="failmsgs_error" style="width: 16px; height: 16px;" class="cjt_validation_error"></span>
		</blockquote>

		<p><span class="action_link" id="toggle_advanced_options"><strong>Advanced Options</strong> »</span></p>
	    <div id="advance" style="display: none;">

            <label><input type="radio" value="system" name="fwdopt" id="fwdsystem_radio"> Forward to a system account</label>: <input type="text" value="bamboode" size="20" name="fwdsystem" id="fwdsystem">
            <span style="vertical-align: middle; width: 16px; height: 16px;" id="fwdsystem_error" class="cjt_validation_error"></span>
            <br><br>
			<input type="radio" value="pipe" id="pipeit" name="fwdopt"> <label for="pipeit">Pipe to a Program:</label><br>
			<blockquote>
				
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr><td><img align="middle" alt="home" src="../images/homeb.gif">/</td><td><!-- UAPI NOTE: if you need to edit this file, STRONGLY consider first doing a "cptt autodir/dirbox.tt",
     and see if it works; and only edit the .tt version -->
<!-- start autodir/dirbox.html -->
<style type="text/css">
#dirmod {position:relative;padding:0em;display:inline;}
#dirautocomplete {position:relative;margin:0;width:100%;}/* set width of widget here*/
#dirinput {position:absolute;width:100%;height:1.6em;}
#dircontainer .yui-ac-content {position:absolute;width:100%;border:1px solid #404040;background:#fff;overflow:hidden;z-index:9050;}
#dircontainer .yui-ac-shadow {position:absolute;margin:.3em;width:100%;background:#a0a0a0;z-index:9049;}
#dircontainer ul {margin: 2px;padding:1px 0;width:99%;}
#dircontainer li {padding:0 5px;margin:0 2px;cursor:default;white-space:nowrap;border:1px solid #ffffff;}
#dircontainer li.yui-ac-highlight {background:#f3f3f3;border:1px solid #cccccc;}
</style>
<script src="/cPanel_magic_revision_1352841119/yui/datasource/datasource.js" type="text/javascript"></script>
<script src="/cPanel_magic_revision_1352841119/yui/autocomplete/autocomplete.js" type="text/javascript"></script>
<script type="text/javascript">
//&lt;![CDATA[
var dirCompleter = function() {
	var oDir;
	var oAutoComp;

	return {
		init: function() {
			oDir = new YAHOO.widget.DS_XHR(CPANEL.security_token + "/frontend/x3/autodir/autocomplete.xml",
			["file","name"]);
			oDir.scriptQueryParam = "path";
			oDir.responseType = YAHOO.widget.DS_XHR.TYPE_XML;
			oDir.maxCacheEntries = 256;
			oDir.scriptQueryAppend = "dirsonly=";

			// Instantiate AutoComplete
			oAutoComp = new YAHOO.widget.AutoComplete(\'pipefwd\',\'dircontainer\', oDir);
			oAutoComp.doBeforeExpandContainer = function(oTextbox, oContainer, sQuery, aResults) {
				var pos = YAHOO.util.Dom.getXY(oTextbox);
				pos[1] += YAHOO.util.Dom.get(oTextbox).offsetHeight;
				YAHOO.util.Dom.setXY(oContainer,pos);
				return true;
			};
		}
	};
}();

YAHOO.util.Event.onDOMReady(dirCompleter.init);
//]]&gt;
</script>
<input type="text" onchange="(this)" id="pipefwd" name="pipefwd" size="30" class="yui-ac-input" autocomplete="off"> <span id="pipefwd_error" style="width: 16px; height: 16px;" class="cjt_validation_error"></span>
<div id="dircontainer" class="yui-ac-container"><div class="yui-ac-content" style="display: none;"><div class="yui-ac-hd" style="display: none;"></div><div class="yui-ac-bd"><ul><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li></ul></div><div class="yui-ac-ft" style="display: none;"></div></div></div>
<!-- end autodir/dirbox.html -->
</td></tr>
				</tbody></table>
				<br>
				When piping to a program, you should enter a path relative to your home directory. If the script requires an interpreter such as Perl or PHP, you should omit the /usr/bin/perl or /usr/bin/php portion. Make sure that your script is executable and has the appropriate <a target="_blank" href="http://en.wikipedia.org/wiki/Hashbang">hashbang</a> at the top of the script. If you do not know how to add the hashbang, just make sure to name your script file with the correct extension and you will be prompted to have the hashbang added automatically.
			</blockquote>
		
			<input type="radio" id="fwdopt_blackhole" value="blackhole" name="fwdopt"> <label for="fwdopt_blackhole">Discard (Not Recommended)</label>
			<br>
			<br>
	    </div>
    
	
    </div><!-- end formbox -->
    
	<br>
    <input type="submit" value="Add Forwarder" id="submit" class="input-button">
</form>';
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$post_data = $doc->find('form')->serializeArray();
		$post_items = array();
		foreach ($post_data as $item) {
			if($item['name'] == 'email') $item['value'] = 'nguyennguyen2023';
			if($item['name'] == 'fwdemail') $item['value'] = 'center@bamboodev.us';
			$post_items[] = $item['name'] . '=' . $item['value'];
		}
		$post_string = implode ('&', $post_items);
		
		//Core_Utils_Log::write($content);die;
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => $post_string,
			'url' => 'bamboodev.us:2082/cpsess8951015559/frontend/x3/mail/doaddfwd.html',
			'cookie' => 'Cookie: cprelogin=no; cpsession=bamboode%3aWgaWW8mvrMRRL62AxGlYk1WNEPW3sQL88QBHU5enCGcPRat7jya3XhlgTACqGoPk; langedit=; lang=; webmailsession=center%40bamboodev.us%3aHiTH9yjSvMJSWlUDxGXiErCdKKPraHyQKKzXIaPFF6iuVgOf3sK1TuI__mNEODPF; webmailrelogin=no; roundcube_sessid=efba901129572bb781095743b1167bb8; roundcube_sessauth=S7a6d1877d55a65993b95f52f477c41f543dad646'
		));
		$result = $cUrl->exec();
		print_r($result);die;
		//$content = $this->_cUrl->getContent('https://plus.123pay.vn/product/tv-lcd-42-sony_63099.html');
		//Core_Utils_Log::write($content);die;
		$vngauth = $result['cookie']['vngauth'];
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => '',
			'cookie' => 'Cookie: uin='.$uin.'; vngauth='.$vngauth.'; acn='.$zingid,
			'url' => 'http://123.vn/luckybox/checkgift/id/1'
		));
		$i = 0;
		while ($i<1) {
			$cUrl->exec();
			$i++;
			sleep(1);
		}
		//$coreEmail = new Core_Email();
		//$coreEmail->send('nclong87@gmail.com', 'Hack complete', 'Hack complete');
		die('OK');
	}
}


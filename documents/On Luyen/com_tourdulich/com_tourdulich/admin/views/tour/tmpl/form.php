<?php defined('_JEXEC') or die('Restricted access');?>
<?php 

JHTML::_('behavior.calendar'); 
if (!JPluginHelper::importPlugin('zoolJoomLibs', 'base')) {
    JError::raiseError(2001, 'Please, install and publish zoolJoomLibs.Base first.');
}
if(!zjl_import('mediaImageChooser')) {
    JError::raiseError(2001, 'Please, install zoolJoomLibs.mediaImageChooser first.');
}
JHTML::_('mediaImageChooser.behavior.all');
JHTML::_('behavior.modal');
$currentSession = JSession::getInstance('none',array());
$missing=$currentSession->get('missing');
$currentSession->clear('missing');
$form=$currentSession->get('saveform');
$currentSession->clear('saveform');
if(!isset($form)) {
    $form=array();
    $form['tentour']=$this->info->tentour;
    $form['giatien']=$this->info->giatien;
    $form['thoigiandi']=$this->info->thoigiandi;
    $form['phuongtien']=$this->info->phuongtien;
    if(isset($this->info->ngaykhoihanh))
        $form['ngaykhoihanh']=FunctionClass::format_date($this->info->ngaykhoihanh,"d/m/Y");
    else
        $form['ngaykhoihanh']="";
    $form['gioithieu']=$this->info->gioithieu;
    $form['nhomtour']=$this->info->nhomtour ? $this->info->nhomtour:0;
    $form['diemden']=$this->info->diemden ? $this->info->diemden:0;
    $form['anhdaidien']=$this->info->anhdaidien;
    $form['hienthi']=$this->info->hienthi;
    $form['loaitour']=$this->loaitour;
    $form['diemxuatphat']=$this->diemxuatphat;
}
?>
<input type="hidden" id="tmp-anhdaidien" value="<?php echo $form['anhdaidien'] ?>" />
<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/system/js/validator.js">
</script>
<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/system/js/ajax.js">
</script>
<form name="adminForm" action="index.php" id="index.php" method="post" >
    <table width="100%">
        <tr>
            <td>
                <?php echo JText::_( 'Tên Tour :' );?>
            </td>
            <td>
                <input  type="text" name="tentour" id="tentour" size="70" maxlength="250" value="<?php echo $form['tentour'];?>" />
                <span class="errorMessage" id="msg_tentour">
                    <?php
                    if(isset($missing['tentour']))
                        echo 'Vui lòng nhập tên tour!';
                    ?>
                </span>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo JText::_( 'Giá tiền :' );?>
            </td>
            <td>
                <input  type="text" name="giatien" id="giatien" size="70" maxlength="250" value="<?php echo $form['giatien'];?>" />
                <span class="errorMessage" id="msg_giatien">
                    <?php
                    if(isset($missing['giatien']))
                        echo 'Vui lòng nhập giá tiền!';
                    ?>
                </span>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo JText::_( 'Thời gian đi :' );?>
            </td>
            <td>
                <input  type="text" name="thoigiandi" id="thoigiandi" size="70" maxlength="250" value="<?php echo $form['thoigiandi'];?>" />
                <span class="errorMessage" id="msg_thoigiandi">
                    <?php
                    if(isset($missing['thoigiandi']))
                        echo 'Vui lòng nhập thời gian đi!';
                    ?>
                </span>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo JText::_( 'Phương tiện :' );?>
            </td>
            <td>
                <input  type="text" name="phuongtien" size="70" maxlength="250" value="<?php echo $form['phuongtien'];?>" />
            </td>
        </tr>
        <tr>
            <td>
                <?php echo JText::_( 'Ngày khởi hành :' );?>
            </td>
            <td>
                <input class="inputbox" type="text" name="ngaykhoihanh" id="ngaykhoihanh" size="70" maxlength="250" value="<?php echo $form['ngaykhoihanh'];?>" />
                <a href="#" onclick="return showCalendar('ngaykhoihanh', '%d/%m/%Y');"><img class="calendar" src="images/blank.png" alt="calendar" /></a>
                <span class="errorMessage" id="msg_ngaykhoihanh">
                    <?php
                    if(isset($missing['ngaykhoihanh']))
                        echo $missing['ngaykhoihanh'];
                    ?>
                </span>
                <br>
                <input type="radio" name="selectcycle" onclick="hangngaycheck();">Hàng ngày<br>
                <input type="radio" name="selectcycle" onclick="hangtuancheck();">Hàng tuần
                <select name="tmphangtuan" onchange="hangtuanselect(this.value)" disabled >
                    <option value="">Chọn ngày</option>
                    <option value="Thứ 2">Thứ 2</option>
                    <option value="Thứ 3">Thứ 3</option>
                    <option value="Thứ 4">Thứ 4</option>
                    <option value="Thứ 5">Thứ 5</option>
                    <option value="Thứ 6">Thứ 6</option>
                    <option value="Thứ 7">Thứ 7</option>
                    <option value="Chủ Nhật">Chủ Nhật</option>
                </select>
                <script language="javascript" type="text/javascript">
                    var boolhangngay=false;
 
                    function hangngaycheck()
                    {
                        boolhangngay=true;
                        document.adminForm.tmphangtuan.disabled=true;
                        document.getElementById("ngaykhoihanh").value="Hàng ngày.";

                        
                    }
                    function hangtuancheck()
                    {
                        document.adminForm.tmphangtuan.disabled=false;
                    }
                    function hangtuanselect(value)
                    {
                        document.getElementById("ngaykhoihanh").value=value+" hàng tuần.";
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo JText::_( 'Chọn loại tour:' );?>
            </td>
            <td>
                <input type='hidden' id='tmp-loaitour' value="<?php echo $form['loaitour'] ?>" />
                <select name="loaitour" id='loaitour' onchange="getDmdiemxuatphat(this.value)">
                    <option value="0" selected>Chọn loại tour</option>
                    <?php
                    foreach($this->lst1 as $loaitour) {
                        echo "<option value='$loaitour->id' selected>$loaitour->tenloaitour</option>";
                    }
                    ?>
                </select>
                <span class="errorMessage" id="msg_loaitour">
                    <?php
                    if(isset($missing['loaitour']))
                        echo 'Vui lòng chọn loại tour!';
                    ?>
                </span>
                <script language="javascript" type="text/javascript">
                <!--
                
                var originalLoaitour= '<?php echo $form['loaitour'] ?>';
                var originalDiemxuatphat='<?php echo $form['diemxuatphat'] ?>';
                var originalNhomtour='<?php echo $form['nhomtour'] ?>';
		var diemxuatphats 			= new Array();	// array in the format [key,value,text]
                <?php	$m = 1;
		foreach($this->lst2 as $diemxuatphat) {
                    $id=$diemxuatphat->id;
                    $tendiadiem=$diemxuatphat->tendiadiem;
                    $loaitour=$diemxuatphat->loaitour;
                    echo "\n	diemxuatphats[".$m++."] = new Array( \"$loaitour\",\"$id\",\"$tendiadiem\" );";
                    
		}
		?>
                var nhomtours 			= new Array();	// array in the format [key,value,text]

                <?php	$m = 0;
		foreach($this->lst3 as $nhomtour) {
                    $id=$nhomtour->id;
                    $tennhomtour=$nhomtour->tennhomtour;
                    $diemxuatphat=$nhomtour->diemxuatphat;
                    echo "\n	nhomtours[".$m++."] = new Array( \"$diemxuatphat\",\"$id\",\"$tennhomtour\" );";

		}
		?>
                </script>

            </td>
        </tr>
        <tr>
            <td>
                <?php echo JText::_( 'Chọn điểm xuất phát:' );?>
            </td>
            <td>
                <script language="javascript" type="text/javascript">		
		writeDynaList( 'class="inputbox" name="diemxuatphat" id="diemxuatphat" size="1" onchange="getNhomtour(this.value);"', diemxuatphats,originalLoaitour, originalLoaitour, originalDiemxuatphat );
		</script>
                <span class="errorMessage" id="msg_diemxuatphat">
                    <?php
                    if(isset($missing['diemxuatphat']))
                        echo 'Vui lòng chọn điểm xuất phát!';
                    ?>
                </span>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo JText::_( 'Chọn nhóm tour:' );?>
            </td>
            <td>
               <script language="javascript" type="text/javascript">
		writeDynaList( 'class="inputbox" name="nhomtour" id="nhomtour" size="1"', nhomtours,originalDiemxuatphat,originalDiemxuatphat, originalNhomtour );
		</script>
                <span class="errorMessage" id="msg_nhomtour">
                    <?php
                    if(isset($missing['nhomtour']))
                        echo 'Vui lòng chọn nhóm tour!';
                    ?>
                </span>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo JText::_( 'Chọn điểm đến:' );?>
            </td>
            <td>
                <input type='hidden' id='tmp-diemden' value="<?php echo $form['diemden'] ?>" />
                <select name="diemden" id='diemden'>
                    <option value="0" selected>Chọn điểm đến</option>
                    <?php
                    foreach($this->lstdiemden as $diemden) {
                        echo "<option value='$diemden->id' selected>$diemden->tendiadiem</option>";
                    }
                    ?>
                </select>
                <span class="errorMessage" id="msg_diemden">
                    <?php
                    if(isset($missing['diemden']))
                        echo 'Vui lòng chọn điểm đến!';
                    ?>
                </span>
            </td>
        </tr>
        
        <?php
        $image_chooser = new mediaImageChooser('anhdaidien', '');
        ?>
        <tr>
            <td>
                <?php echo JText::_( 'Chọn hình ảnh:' ); ?>
            </td>
            <td>
                <?php echo $image_chooser->inputBox();
echo $image_chooser->button(); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left">
                <?php
                echo $image_chooser->imagePreview();
                echo $image_chooser->start();
?>
            </td>

        </tr>
        <tr>
            <td>
                <?php echo JText::_( 'Trạng thái:' );?>
            </td>
            <td>
                <input type='hidden' id='tmp-hienthi' value="<?php echo $form['hienthi'] ?>" />
                <select name="hienthi" id='hienthi'>
                        <option value='1' selected>Hiển thị</option>
			<option value='0'>Ẩn</option>
                </select>
            </td>
        </tr>
    </table>
    <fieldset>
        <legend><span class="infoMessage"> Giới thiệu tour</span></legend>
    <script type="text/javascript" src="../plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
	tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	mode : "exact",
	elements : "gioithieu",
	width : "772px",
	height : "400",

	plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",
	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	// Example content CSS (should be your site CSS)
	content_css : "css/example.css",
	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "js/template_list.js",
	external_link_list_url : "js/link_list.js",
	external_image_list_url : "js/image_list.js",
	media_external_list_url : "js/media_list.js",
	
	// Replace values for the template plugin
	template_replace_values : {
	username : "Some User",
	staffid : "991234"
	}
	});
	</script>
<textarea id="gioithieu" name="gioithieu" style="width:100%; height: 200px;"><?php echo $form['gioithieu'] ?>
</textarea>
    </fieldset>
    <input type="hidden" name="option" value="com_tourdulich" />
    <input type="hidden" name="action" value="tour">
    <input type="hidden" name="id" value="<?php echo $this->info->id; ?>" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="controller" value="tour" />
</form>
<script language="javascript" type="text/javascript">
    document.getElementById("tentour").focus();
    document.getElementById("diemden").value=document.getElementById("tmp-diemden").value;
    document.getElementById("anhdaidien").value=document.getElementById("tmp-anhdaidien").value;
    document.getElementById("hienthi").value=document.getElementById("tmp-hienthi").value;
    document.getElementById("loaitour").value=document.getElementById("tmp-loaitour").value;
    function submitbutton(pressbutton)
    {
        var form = document.adminForm;
        if (pressbutton == 'cancel') {
            submitform( pressbutton );
            return;
        }
        check=true;
        validate('require','tentour');
        validate('require','giatien');
        validate('require','thoigiandi');
        validate('require','ngaykhoihanh');
        validate('requireselect','diemden');
        validate('requireselect','nhomtour');
        validate('requireselect','loaitour');
        validate('requireselect','diemxuatphat');
        if(check==true)
            submitform( pressbutton );
        else
            alert('Form chưa hợp lệ, vui lòng xem lại!');
    }
    function getDmdiemxuatphat(id)
    {
        changeDynaList("diemxuatphat", diemxuatphats, id, 0,0)
        changeDynaList("nhomtour", nhomtours, document.adminForm.diemxuatphat.value, 0,0)
    }
    function getNhomtour(id)
    {
        changeDynaList("nhomtour", nhomtours, id, 0,0)
    }
</script>
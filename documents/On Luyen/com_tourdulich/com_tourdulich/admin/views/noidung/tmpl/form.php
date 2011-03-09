<?php defined('_JEXEC') or die('Restricted access');?>
<?php 
JHTML::_('behavior.modal');
?>
<?php
$currentSession = JSession::getInstance('none',array());
$missing=$currentSession->get('missing');
$currentSession->clear('missing');
$form=$currentSession->get('saveform');
$currentSession->clear('saveform');
if(!isset($form)) {
    $form=array();
    $form['tieude']=$this->info->tieude;
    $form['noidung']=$this->info->noidung;
    $form['published']=$this->info->published;
    $form['thutu']=$this->info->thutu;
    $form['tour_id']=$this->tour_id;
}
?>
<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/system/js/validator.js">
</script>
<form name="adminForm" action="index.php" id="index.php" method="post" >
    <table width="100%">
        <tr>
            <td>
                <?php echo JText::_( 'Tiêu đề :' );?>
            </td>
            <td>
                <input  type="text" name="tieude" id="tieude" size="70" maxlength="250" value="<?php echo $form['tieude'];?>" />
                <span class="errorMessage" id="msg_tieude">
                    <?php
                    if(isset($missing['tieude']))
                        echo 'Vui lòng nhập tiêu đề!';
                    ?>
                </span>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo JText::_( 'Thứ tự hiển thị :' );?>
            </td>
            <td>
                <input  type="text" name="thutu" id="thutu" size="70" maxlength="250" value="<?php echo $form['thutu'];?>" />
                <span class="errorMessage" id="msg_thutu">
                    <?php
                    if(isset($missing['thutu']))
                        echo 'Vui lòng nhập thứ tự hiển thị!';
                    ?>
                </span>
            </td>
        </tr>        
        <tr>
            <td>
                <?php echo JText::_( 'Trạng thái:' );?>
            </td>
            <td>
                <input type='hidden' id='tmp-published' value="<?php echo $form['published'] ?>" />
                <select name="published" id='published'>
                        <option value='1' selected>Hiển thị</option>
						<option value='0'>Ẩn</option>
                </select>
            </td>
        </tr>        
    </table>
    <fieldset>
        <legend><span class="infoMessage"> Nội dung</span></legend>
		<?php
		$editor =& JFactory::getEditor();
        echo $editor->display('noidung', $form['noidung'], '772px', '400', '60', '20', true);
		?>
    </fieldset>
    <input type="hidden" name="option" value="com_tourdulich" />
    <input type="hidden" name="action" value="noidung">
    <input type="hidden" name="id" value="<?php echo $this->info->id; ?>" />
	<input type="hidden" name="tour_id" value="<?php echo $form['tour_id'] ?>" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="controller" value="noidung" />
</form>
<script language="javascript" type="text/javascript">
    document.getElementById("tieude").focus();
    document.getElementById("published").value=document.getElementById("tmp-published").value;
    function submitbutton(pressbutton)
    {
        var form = document.adminForm;
        if (pressbutton == 'cancel') {
            submitform( pressbutton );
            return;
        }
        check=true;
        validate('require','tieude');
        validate('require','thutu');
        if(check==true)
            submitform( pressbutton );
        else
            alert('Form chưa hợp lệ, vui lòng xem lại!');
    }
   
</script>
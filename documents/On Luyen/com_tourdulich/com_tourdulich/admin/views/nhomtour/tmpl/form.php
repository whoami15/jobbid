<?php defined('_JEXEC') or die('Restricted access');?>
<?php
$currentSession = JSession::getInstance('none',array());
$missing=$currentSession->get('missing');
$currentSession->clear('missing');
$form=$currentSession->get('saveform');
$currentSession->clear('saveform');
if(!isset($form)) {
    $form=array();
    $form['tennhomtour']=$this->info->tennhomtour;
    $form['diemxuatphat']=$this->info->diemxuatphat ? $this->info->diemxuatphat:0;
}
?>

<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/system/js/validator.js">
</script>
<form name="adminForm" action="index.php" id="index.php" method="post" >
    <table class="admintable">
        <tr>
            <td>
<?php echo JText::_( 'Tên nhóm tour :' );?>
            </td>
            <td>
                <input  type="text" name="tennhomtour" id="tennhomtour" size="70" maxlength="250" value="<?php echo $form['tennhomtour'];?>" />
                <span class="errorMessage" id="msg_tennhomtour">
                    <?php
                    if(isset($missing['tennhomtour']))
                        echo 'Tên nhóm tour không được bỏ trống!';
                    ?>
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span class="errorMessage" id="msg_diemxuatphat">
<?php
                    if(isset($missing['diemxuatphat']))
                        echo 'Vui lòng chọn 1 giá trị!';
                    ?>
                </span>
            </td>
        </tr>
        <tr>
            <td>
<?php echo JText::_( 'Chọn điểm xuất phát:' );?>
            </td>
            <td>
                <input type='hidden' id='tmp-diemxuatphat' value="<?php echo $form['diemxuatphat'] ?>" />
                <select name="diemxuatphat" id='diemxuatphat'>
                    <option value="0" selected>Chọn điểm xuất phát</option>
                    <?php
                    foreach($this->lstdiemxuatphat as $diemxuatphat) {
                        echo "<option value='$diemxuatphat->id' selected>$diemxuatphat->tendiadiem</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>
    <input type="hidden" name="option" value="com_tourdulich" />
    <input type="hidden" name="action" value="nhomtour">
    <input type="hidden" name="id" value="<?php echo $this->info->id; ?>" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="controller" value="nhomtour" />
</form>
<script language="javascript" type="text/javascript">
    document.getElementById("tennhomtour").focus();
    document.getElementById("diemxuatphat").value=document.getElementById("tmp-diemxuatphat").value;
    function submitbutton(pressbutton)
    {
        var form = document.adminForm;
        if (pressbutton == 'cancel') {
            submitform( pressbutton );
            return;
        }
        check=true;
        validate('require','tennhomtour');
        validate('requireselect','diemxuatphat');
        if(check==true)
            submitform( pressbutton );
        else
            alert('Form chưa hợp lệ, vui lòng xem lại!');
    }
</script>
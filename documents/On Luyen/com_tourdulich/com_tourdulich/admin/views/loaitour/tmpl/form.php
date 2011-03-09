<?php defined('_JEXEC') or die('Restricted access');?>
<?php
$currentSession = JSession::getInstance('none',array());
$missing=$currentSession->get('missing');
$currentSession->clear('missing');
$form=$currentSession->get('saveform');
$currentSession->clear('saveform');
if(!isset($form)) {
    $form=array();
    $form['tenloaitour']=$this->info->tenloaitour;
}
?>

<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/system/js/validator.js">
</script>
<form name="adminForm" action="index.php" id="index.php" method="post" >
    <table class="admintable">
        <tr>
            <td>
<?php echo JText::_( 'Tên loại tour :' );?>
            </td>
            <td>
                <input  type="text" name="tenloaitour" id="tenloaitour" size="70" maxlength="250" value="<?php echo $form['tenloaitour'];?>" />
                <span class="errorMessage" id="msg_tenloaitour">
                    <?php
                    if(isset($missing['tenloaitour']))
                        echo 'Tên loại tour không được bỏ trống!';
                    ?>
                </span>
            </td>
        </tr>       
    </table>
    <input type="hidden" name="option" value="com_tourdulich" />
    <input type="hidden" name="action" value="loaitour">
    <input type="hidden" name="id" value="<?php echo $this->info->id; ?>" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="controller" value="loaitour" />
</form>
<script language="javascript" type="text/javascript">
    document.getElementById("tenloaitour").focus();
    function submitbutton(pressbutton)
    {
        var form = document.adminForm;
        if (pressbutton == 'cancel') {
            submitform( pressbutton );
            return;
        }
        check=true;
        validate('require','tenloaitour');
        if(check==true)
            submitform( pressbutton );
        else
            alert('Form chưa hợp lệ, vui lòng xem lại!');
    }
</script>
<?php defined('_JEXEC') or die('Restricted access');?>
<?php
    $currentSession = JSession::getInstance('none',array());
    $missing=$currentSession->get('missing');
    $currentSession->clear('missing');
    $form=$currentSession->get('saveform');
    $currentSession->clear('saveform');
    if(!isset($form))
    {
        $form=array();
        $form['tendiadiem']=$this->info->tendiadiem;
    }
?>

<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/system/js/validator.js">
</script>
<form name="adminForm" action="index.php" id="index.php" method="post" >
    <table class="admintable">
        <tr>
            <td colspan="2">
                <span class="errorMessage" id="msg_tendiadiem">
                    <?php
                    if(isset($missing['tendiadiem']))
                        echo 'Tên địa điểm không được bỏ trống!';
                    ?>
                </span>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo JText::_( 'Tên địa điểm :' );?>
            </td>
            <td>
                <input  type="text" name="tendiadiem" id="tendiadiem" size="70" maxlength="250" value="<?php echo $form['tendiadiem'];?>" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="option" value="com_tourdulich" />
    <input type="hidden" name="action" value="dmdiemden">
    <input type="hidden" name="id" value="<?php echo $this->info->id; ?>" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="controller" value="dmdiemden" />
</form>
<script language="javascript" type="text/javascript">
    document.getElementById("tendiadiem").focus();
    function submitbutton(pressbutton)
    {
        var form = document.adminForm;
        if (pressbutton == 'cancel') {
            submitform( pressbutton );
            return;
        }
        check=true;
        validate('require','tendiadiem');
        if(check==true)
            submitform( pressbutton );
        else
            alert('Form chưa hợp lệ, vui lòng xem lại!');
    }
</script>
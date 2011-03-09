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
        $form['loaitour']=$this->info->loaitour ? $this->info->loaitour:0;
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
        <tr>
            <td>
                <?php echo JText::_( 'Chọn loại tour:' );?>
            </td>
            <td>
                <input type='hidden' id='tmp-loaitour' value="<?php echo $form['loaitour'] ?>" />
                <select name="loaitour" id='loaitour'>
                    <option value="0" selected>Chọn loại tour</option>
                    <?php
                    foreach($this->lstloaitour as $loaitour) {
                        echo "<option value='$loaitour->id' selected>$loaitour->tenloaitour</option>";
                    }
                    ?>
                </select>
                <span class="errorMessage" id="msg_loaitour">
                    <?php
                    if(isset($missing['loaitour']))
                        echo 'Vui lòng chọn nhóm tour!';
                    ?>
                </span>
            </td>
        </tr>
    </table>
    <input type="hidden" name="option" value="com_tourdulich" />
    <input type="hidden" name="action" value="dmdiemxuatphat">
    <input type="hidden" name="id" value="<?php echo $this->info->id; ?>" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="controller" value="dmdiemxuatphat" />
</form>
<script language="javascript" type="text/javascript">
    document.getElementById("tendiadiem").focus();
    document.getElementById("loaitour").value=document.getElementById("tmp-loaitour").value;
    function submitbutton(pressbutton)
    {
        var form = document.adminForm;
        if (pressbutton == 'cancel') {
            submitform( pressbutton );
            return;
        }
        check=true;
        validate('require','tendiadiem');
        validate('requireselect','loaitour');
        if(check==true)
            submitform( pressbutton );
        else
            alert('Form chưa hợp lệ, vui lòng xem lại!');
    }
</script>
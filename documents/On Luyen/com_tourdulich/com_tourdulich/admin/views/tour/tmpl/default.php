<?php defined('_JEXEC') or die();
JHTML::_('behavior.tooltip');
?>
<style type="text/css">
    .tool-tip {
   float: left;
   background: #ffc;
   border: 1px solid #D4D5AA;
   padding: 5px;
   max-width: 300px;
}
</style>
<form action="index.php?option=com_tourdulich" name="adminForm" method="post">
<div class="editcell">
	<table class="adminlist">
		<thead>
			<tr>
				<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
				</th>
				<th><?php echo JText::_('Tên tour'); ?></th>
                                <th><?php echo JText::_('Hiển thị'); ?></th>
				<th><?php echo JText::_('Giá tiền'); ?></th>				
				<th><?php echo JText::_('Ngày khởi hành'); ?></th>
				<th><?php echo JText::_('Điểm xuất phát'); ?></th>
				<th><?php echo JText::_('Điểm đến'); ?></th>
				<th><?php echo JText::_('Nhóm tour'); ?></th>
                                <th><?php echo JText::_('Loại tour'); ?></th>
			</tr>
		</thead>
	<?php
	$k = 0;
	for($i=0, $n=count($this->items); $i<$n ; $i++)
	{
		$row =&$this->items[$i];
		$checked     = JHTML::_('grid.id',   $i, $row->id );             
		$link             =     JRoute::_( 'index.php?option=com_tourdulich&controller=tour&action=tour&task=manage_content&cid='. $row->id );
		?>
		<tr class="<?php echo "row$k" ?>">
		<td>
		<?php echo $checked; ?>
		</td>
		<td>
                    <span class="editlinktip hasTip" title="<b>Click để thêm nội dung vào Tour</b>">
                    <a href="<?php echo $link; ?>"><?php echo $row->tentour; ?>
                    </a>
                    </span>
                </td>
                <td><?php echo $row->hienthi; ?></td>
		<td><?php echo FunctionClass::FormatMoney($row->giatien); ?> VNĐ</td>
                <td><?php echo $row->ngaykhoihanh; ?></td>
		<td><?php echo $row->diemxuatphat; ?></td>
		<td><?php echo $row->diemden; ?></td>
		<td><?php echo $row->nhomtour; ?></td>
                <td><?php echo $row->tenloaitour; ?></td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>
</div>
<input type="hidden" name="option" value="com_tourdulich" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="action" value="tour">
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="tour" />
</form>
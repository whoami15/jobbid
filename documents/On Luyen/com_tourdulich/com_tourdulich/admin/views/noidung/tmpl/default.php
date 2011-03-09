<?php defined('_JEXEC') or die(); ?>
<form action="index.php?option=com_tourdulich" name="adminForm" method="post">
<div class="editcell">
        <span class="infoMessage"><?php echo JText::_('Danh sách các nội dung của tour:'); ?></span>
	<table class="adminlist">
		<thead>
			<tr>
				<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
				</th>
				<th><?php echo JText::_('Tiêu đề'); ?></th>
				<th><?php echo JText::_('Published'); ?></th>
				<th><?php echo JText::_('Thứ tự'); ?></th>
			</tr>
		</thead>
	<?php
	$k = 0;
	for($i=0, $n=count($this->items); $i<$n ; $i++)
	{
		$row =&$this->items[$i];
		$checked     = JHTML::_('grid.id',   $i, $row->id );             
		$link             =     JRoute::_( 'index.php?option=com_tourdulich&controller=noidung&action=noidung&task=edit&cid[]='. $row->id );
		?>
		<tr class="<?php echo "row$k" ?>">
		<td>
		<?php echo $checked; ?>
		</td>
		<td><a href="<?php echo $link; ?>"><?php echo $row->tieude; ?></a></td>
		<td><?php echo $row->published; ?></td>
		<td><?php echo $row->thutu; ?></td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>
</div>
<input type="hidden" name="option" value="com_tourdulich" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="action" value="noidung">
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="noidung" />
</form>
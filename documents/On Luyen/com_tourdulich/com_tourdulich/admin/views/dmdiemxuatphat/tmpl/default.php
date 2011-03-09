<?php defined('_JEXEC') or die(); ?>
<form action="index.php?option=com_tourdulich" name="adminForm" method="post">
<div class="editcell">
	<table class="adminlist">
		<thead>
			<tr>
				<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
				</th>
				<th><?php echo JText::_('Tên địa điểm'); ?></th>
                                <th><?php echo JText::_('Loại tour'); ?></th>
			</tr>
		</thead>
	<?php
	$k = 0;

	for($i=0, $n=count($this->items); $i<$n ; $i++)
	{
		$row =&$this->items[$i];
                
		$checked     = JHTML::_('grid.id',   $i, $row->id );             
		$link             =     JRoute::_( 'index.php?option=com_tourdulich&controller=dmdiemxuatphat&action=dmdiemxuatphat&task=edit&cid[]='. $row->id );
		?>
		<tr class="<?php echo "row$k" ?>">
		<td>
		<?php echo $checked; ?>
		</td>
		<td><a href="<?php echo $link; ?>"><?php echo $row->tendiadiem; ?></a></td>
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
<input type="hidden" name="action" value="dmdiemxuatphat">
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="dmdiemxuatphat" />
</form>
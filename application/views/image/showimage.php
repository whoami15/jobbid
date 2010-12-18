<table width="802px" id="table_images">
	<thead id="thead_paging">
		<tr>
			<td colspan="11" align="center" bgcolor="white" style="color:black">
				<a class="link" style="padding-right:5px" href='#' onclick="selectpage(1)">Begin</a>
				<?php 
				while($pagesbefore<$pagesindex) {
					echo "<a class='link' href='#' onclick='selectpage($pagesbefore)'>$pagesbefore</a>";
					$pagesbefore++;
				}
				?>
				<span style="font-weight:bold;color:red"><?php echo $pagesindex ?></span>
				<?php 
				while($pagesnext>$pagesindex) {
					$pagesindex++;
					echo "<a class='link' href='#' onclick='selectpage($pagesindex)'>$pagesindex</a>";
				}
				?>
				<a class="link" style="padding-left:5px" href='#' onclick="selectpage(<?php echo $pageend ?>)">...<?php echo $pageend ?></a>			
			</td>
		</tr>
	</thead>
	<tfoot id="tfoot_paging">
		
	</tfoot>
	<tbody>
		<tr>
			<td >
				<div style="height:350px;overflow:auto;">
				<?php
				foreach($lstImage as $image) {
					echo "<div class='image_box' onclick='pasteLink(\"".$image["image"]["fileurl"]."\")'>";
					echo "<div class='title_box'>".$image["image"]["filename"]."</div>";
					echo "<img class='image' src='".$image["image"]["fileurl"]."'/><br/>";
					echo "</div>";
				}
				?>
				</div>
			</td>
		</tr>
	</tbody>
</table>
<script>
	function pasteLink(link) {
		byId("link_image").value=link;
	}
	$(document).ready(function() {
		$("#tfoot_paging").html($("#thead_paging").html());
	});
</script>
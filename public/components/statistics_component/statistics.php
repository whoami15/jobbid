<table class="center" width="100%" border="0" cellspacing="0" cellpadding="3" id="table_statistics"><tr><td align="center"><a href="http://www.drdating.com/" target="_blank"><img src="http://www.website-hit-counters.com/cgi-bin/image.pl?URL=513525-8545" alt="drdating.com" title="drdating.com" style="border:none"/></a></td></tr>
</table>
<!--table class="center" width="100%" border="0" cellspacing="0" cellpadding="3" id="table_statistics"><tr><td align="center">
<div align='center'><a href='http://www.hit-counts.com'><img src='http://www.hit-counts.com/counter.php?t=15&digits=7&ic=3000&cid=795002' border='0' alt='hit counters'></a></div>
</td></tr>
</table-->
<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/webmaster/showStatistic"),
			success : function(data){	
				//alert(data);
				if(data != AJAX_ERROR_SYSTEM) {
					$("#table_statistics").append(data);
				}
			},
			error: function(data){ 
				alert (data);
			}			
		});
	});
</script>
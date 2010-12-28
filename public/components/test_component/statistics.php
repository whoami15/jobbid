<table class="center" width="100%" border="0" cellspacing="0" cellpadding="3" id="table_statistics"><tr><td align="center"><a href="http://www.drdating.com/" target="_blank"><img src="http://www.website-hit-counters.com/cgi-bin/image.pl?URL=513525-8545" alt="drdating.com" title="drdating.com" border="0" ></a></td></tr><tr><td align="center"><font style="font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 9px; color: #330006; text-decoration: none;">  </font></td></tr>
</table>
<script>
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
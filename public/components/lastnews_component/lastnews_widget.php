<style>
#lastnews_widget li {
	padding-bottom:5px;
}
</style>
<div id="lastnews_widget">
<ul style="padding-left:15px">
Loading...
</ul>
</div>
<script>
	$(document).ready(function(){
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/article/testwidget"),
			success : function(data){	
				//alert(data);
				if(data == AJAX_ERROR_SYSTEM) {
					$("#lastnews_widget").html("Load failed!");
				} else {
					$("#lastnews_widget ul").html("");
					var jsonObj = eval( "(" + data + ")" );
					for(i=0;i<jsonObj.length;i++) {
						link = url("/article/view/"+jsonObj[i].article.id+"/"+jsonObj[i].article.alias);
						$("#lastnews_widget ul").append("<li><a class='link' href='"+link+"'>"+jsonObj[i].article.title+"</a></li>");
					}
					
				}
				
			},
			error: function(data){ 
				alert (data);
			}			
		});
	});
</script>
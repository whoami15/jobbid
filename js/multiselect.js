function MultiSelect(btadd,btremove,btaddall,btremoveall,select_left,select_right) {
	btadd = '#'+btadd;
	btremove = '#'+btremove;
	btaddall = '#'+btaddall;
	btremoveall = '#'+btremoveall;
	select_left = '#'+select_left;
	select_right = '#'+select_right;
	
	$(btadd).click(function() {			
		if($(select_left+' option:selected').length == 0) {
			alert('Bạn chưa chọn dòng ở cột bên trái!');
			return false;
		}	
		$(select_right+' option').each(function(){
			this.selected = false;
		});
		return !$(select_left+' option:selected').remove().appendTo(select_right);  
	});  
	$(btremove).click(function() {  
		if($(select_right+' option:selected').length == 0) {
			alert('Bạn chưa chọn dòng ở cột bên phải!');
			return false;
		}	
		return !$(select_right+' option:selected').remove().appendTo(select_left);  
	});  
	$(btaddall).click(function() {  
		return !$(select_left+' option').remove().appendTo(select_right);  
	});  
	$(btremoveall).click(function() {  
		return !$(select_right+' option').remove().appendTo(select_left);  
	}); 
	$(select_left).dblclick(function() {
		$(select_right+' option').each(function(){
			this.selected = false;
		});
		return !$(select_left+' option:selected').remove().appendTo(select_right);  
	});  
	$(select_right).dblclick(function() {			
		return !$(select_right+' option:selected').remove().appendTo(select_left);  
	}); 
}
$(document).ready(function(){	 
	//kriesi_tab('#content','.jquery_tab_title','.jquery_tab'); /*remove this if you dont want to have jquery tabs*/
	//kriesi_navigation(".nav"); /*remove this if you dont want a jquery sidebar menu*/
	kriesi_closeable_divs(".closeable"); /*remove this if you dont want message box to be closeable*/
	//jQuery(".flexy_datepicker, .flexy_datepicker_input").datepicker(); //datepicker input field and box
	//jQuery("#dialog").dialog(); //pop up dialog window on pageopen.
	//jQuery('.richtext').wysiwyg(); //rich text editor for textareas
	});



function kriesi_closeable_divs(element)
{
	$(element).each(function()							  
	{
		$(this).append('<div class="click_to_close"></div>')
	});	
	
	$(".click_to_close").click(function()
	{
		$(this).parent().slideUp(200);	
	});
}

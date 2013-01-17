(function($) {
	$.fn.ThreeDots = function(options) {
		var return_value = this;

		// check for new & valid options
		if ((typeof options == 'object') || (options == undefined)) {
			$.fn.ThreeDots.the_selected = this;

			var return_value = $.fn.ThreeDots.update(options);

		}
		
		return return_value;
	};
	$.fn.ThreeDots.update = function(options) {
		// initialize local variables
		var curr_this, last_word = null;
		var lineh, paddingt, paddingb, innerh, temp_height;
		var curr_text_span, lws; /* last word structure */
		var last_text, three_dots_value, last_del;

		// check for new & valid options
		if ((typeof options == 'object') || (options == undefined)) {

			// then update the settings
			// CURRENTLY, settings are not CONSTRUCTIVE, but merged with the DEFAULTS every time
			$.fn.ThreeDots.c_settings = $.extend({}, $.fn.ThreeDots.settings, options);
			var max_rows = $.fn.ThreeDots.c_settings.max_rows;
			if (max_rows < 1) {
				return $.fn.ThreeDots.the_selected;
			}

			// make sure at least 1 valid delimiter
			var valid_delimiter_exists = false;
			jQuery.each($.fn.ThreeDots.c_settings.valid_delimiters, function(i, curr_del) {
				if (((new String(curr_del)).length == 1)) {
					valid_delimiter_exists = true; 
				}
			});
			if (valid_delimiter_exists == false) {
				return $.fn.ThreeDots.the_selected;
			}
			
			// process all provided objects
			$.fn.ThreeDots.the_selected.each(function() {

				// element-specific code here
				curr_this = $(this);
		
				// obtain the text span
				if ($(curr_this).children('.'+$.fn.ThreeDots.c_settings.text_span_class).length == 0) { 
					// if span doesnt exist, then go to next
					return true;
				}
				curr_text_span = $(curr_this).children('.'+$.fn.ThreeDots.c_settings.text_span_class).get(0);

				// pre-calc fixed components of num_rows
				var nr_fixed = num_rows(curr_this, true);

				// remember where it all began so that we can see if we ended up exactly where we started
				var init_text_span = $(curr_text_span).text();

				// preprocessor
				the_bisector(curr_this, curr_text_span, nr_fixed);
				var init_post_b = $(curr_text_span).text();

				// if the object has been initialized, then user must be calling UPDATE
				// THEREFORE refresh the text area before re-operating
				if ((three_dots_value = $(curr_this).attr('threedots')) != undefined) {
					$(curr_text_span).text(three_dots_value);						
					$(curr_this).children('.'+$.fn.ThreeDots.c_settings.e_span_class).remove();
				}

				last_text = $(curr_text_span).text();
				if (last_text.length <= 0) {
					last_text = '';
				}
				$(curr_this).attr('threedots', init_text_span);

				if (num_rows(curr_this, nr_fixed) > max_rows) {
					// append the ellipsis span & remember the original text
					curr_ellipsis = $(curr_this).append('<span style="white-space:nowrap" class="'	
														+ $.fn.ThreeDots.c_settings.e_span_class + '">'
														+ $.fn.ThreeDots.c_settings.ellipsis_string 
														+ '</span>');
	
					// remove 1 word at a time UNTIL max_rows
					while (num_rows(curr_this, nr_fixed) > max_rows) {
						
						lws = the_last_word($(curr_text_span).text());// HERE
						$(curr_text_span).text(lws.updated_string);
						last_word = lws.word;
						last_del = lws.del;

						if (last_del == null) {
							break;					
						}
					} // while (num_rows(curr_this, nr_fixed) > max_rows)

					// check for super long words
					if (last_word != null) {
						var is_dangling = dangling_ellipsis(curr_this, nr_fixed);

						if ((num_rows(curr_this, nr_fixed) <= max_rows - 1) 
							|| (is_dangling) 
							|| (!$.fn.ThreeDots.c_settings.whole_word)) {

							last_text = $(curr_text_span).text();
							if (lws.del != null) {
								$(curr_text_span).text(last_text + last_del);
							}
									
							if (num_rows(curr_this, nr_fixed) > max_rows) {
								// undo what i just did and stop
								$(curr_text_span).text(last_text);
							} else {
								// keep going
								$(curr_text_span).text($(curr_text_span).text() + last_word);
								
								// break up the last word IFF (1) word is longer than a line, OR (2) whole_word == false
								if ((num_rows(curr_this, nr_fixed) > max_rows + 1) 
									|| (!$.fn.ThreeDots.c_settings.whole_word)
									|| (init_post_b == last_word)
									|| is_dangling) {
									// remove 1 char at a time until it all fits
									while ((num_rows(curr_this, nr_fixed) > max_rows)) {
										if ($(curr_text_span).text().length > 0) {
											$(curr_text_span).text(
												$(curr_text_span).text().substr(0, $(curr_text_span).text().length - 1)
											);
										} else {
											/* 
											 there is no hope for you; you are crazy;
											 either pick a shorter ellipsis_string OR
											 use a wider object --- geeze!
											 */
											break;
										}
									}							
								}
							}
						}
					}
				}	
				
				// if nothing has changed, remove the ellipsis
				if (init_text_span == $($(curr_this).children('.' + $.fn.ThreeDots.c_settings.text_span_class).get(0)).text()) {
					$(curr_this).children('.' + $.fn.ThreeDots.c_settings.e_span_class).remove();
				} else {				
					// only add any title text if the ellipsis is visible
					if (($(curr_this).children('.' + $.fn.ThreeDots.c_settings.e_span_class)).length > 0) {
						if ($.fn.ThreeDots.c_settings.alt_text_t) {
							$(curr_this).children('.' + $.fn.ThreeDots.c_settings.text_span_class).attr('title', init_text_span);
						}
						
						if ($.fn.ThreeDots.c_settings.alt_text_e) {
							$(curr_this).children('.' + $.fn.ThreeDots.c_settings.e_span_class).attr('title', init_text_span);
						}
						
					}
				}
			}); // $.fn.ThreeDots.the_selected.each(function() 
		}

		return $.fn.ThreeDots.the_selected;
	};
	$.fn.ThreeDots.settings = {
		valid_delimiters: 	[' ', ',', '.'],		// what defines the bounds of a word to you?
		ellipsis_string: 	'...',
		max_rows:			2,
		text_span_class:	'ellipsis_text',
		e_span_class:		'threedots_ellipsis',
		whole_word:			true,
		allow_dangle:		false,
		alt_text_e: 		false,					// if true, mouse over of ellipsis displays the full text
		alt_text_t: 		false  					// if true & if ellipsis displayed, mouse over of text displays the full text
	};
	function dangling_ellipsis(obj, nr_fixed){
		if ($.fn.ThreeDots.c_settings.allow_dangle == true) {
			return false; // why do when no doing need be done?
		}

		// initialize variables
		var ellipsis_obj 		= $(obj).children('.'+$.fn.ThreeDots.c_settings.e_span_class).get(0);
		var remember_display 	= $(ellipsis_obj).css('display');
		var num_rows_before 	= num_rows(obj, nr_fixed);

		// temporarily hide ellipsis
		$(ellipsis_obj).css('display','none');
		var num_rows_after 		= num_rows(obj, nr_fixed);

		// restore ellipsis
		$(ellipsis_obj).css('display',remember_display);
		
		if (num_rows_before > num_rows_after) {
			return true; 	// ASSUMPTION: 	removing the ellipsis changed the height
							// 				THEREFORE the ellipsis was on a row all by its lonesome
		} else {
			return false;	// nothing dangling here
		}
	}
	function num_rows(obj, cstate){	
		var the_type = typeof cstate;
	
		if (	(the_type == 'object') 
			||	(the_type == undefined)	) {

			// do the math & return
			return $(obj).height() / cstate.lh;
			
		} else if (the_type == 'boolean') {
			var lineheight	= lineheight_px($(obj));

			return {
				lh: lineheight
			};
		} 
	}
	function the_last_word(str){
		var temp_word_index;
		var v_del = $.fn.ThreeDots.c_settings.valid_delimiters;
		
		// trim the string
		str = jQuery.trim(str);
		
		// initialize variables
		var lastest_word_idx = -1;
		var lastest_word = null;
		var lastest_del = null;

		// for all given delimiters, determine which delimiter results in the smallest word cut
		jQuery.each(v_del, function(i, curr_del){
			if (((new String(curr_del)).length != 1)
				|| (curr_del == null)) {  // implemented to handle IE NULL condition; if only typeof could say CHAR :(
				return false; // INVALID delimiter; must be 1 character in length
			}

			var tmp_word_index = str.lastIndexOf(curr_del);
			if (tmp_word_index != -1) {
				if (tmp_word_index > lastest_word_idx) {
					lastest_word_idx 	= tmp_word_index;
					lastest_word 		= str.substring(lastest_word_idx+1);
					lastest_del			= curr_del;
				}
			}
		});
		
		// return data structure of word reduced string and the last word
		if (lastest_word_idx > 0) {
			return {
				updated_string:	jQuery.trim(str.substring(0, lastest_word_idx/*-1*/)),
				word: 			lastest_word,
				del: 			lastest_del
			};
		} else { // the lastest word
			return {
				updated_string:	'',
				word: 			jQuery.trim(str),
				del: 			null
			};
		}
	}

	function lineheight_px(obj) {
		// shhhh... show
		$(obj).append("<div id='temp_ellipsis_div' style='position:absolute; visibility:hidden'>H</div>");
		// measure
		var temp_height = $('#temp_ellipsis_div').height();
		// cut
		$('#temp_ellipsis_div').remove();

		return temp_height;
	}
	
	function the_bisector(obj, curr_text_span, nr_fixed){
		var init_text = $(curr_text_span).text();
		var curr_text = init_text;
		var max_rows = $.fn.ThreeDots.c_settings.max_rows;
		var front_half, back_half, front_of_back_half, middle, back_middle;
		var start_index;
		
		if (num_rows(obj, nr_fixed) <= max_rows) {
			// do nothing
			return;
		} else {
			// zero in on the solution
			start_index = 0;
			curr_length = curr_text.length;

			curr_middle = Math.floor((curr_length - start_index) / 2);
			front_half = init_text.substring(start_index, start_index+curr_middle);
			back_half = init_text.substring(start_index + curr_middle);
				
			while (curr_middle != 0) {
				$(curr_text_span).text(front_half);
				
				if (num_rows(obj, nr_fixed) <= (max_rows)) {
					// text = text + front half of back-half
					back_middle 		= Math.floor(back_half.length/2);
					front_of_back_half 	= back_half.substring(0, back_middle);
					
					start_index = front_half.length;
					curr_text 	= front_half+front_of_back_half;
					curr_length = curr_text.length;

					$(curr_text_span).text(curr_text);
				} else {
					// text = front half (which it already is)
					curr_text = front_half;
					curr_length = curr_text.length;
				}
				
				curr_middle = Math.floor((curr_length - start_index) / 2);
				front_half = init_text.substring(0, start_index+curr_middle);
				back_half = init_text.substring(start_index + curr_middle);
			}
		}
	}
	
})(jQuery);
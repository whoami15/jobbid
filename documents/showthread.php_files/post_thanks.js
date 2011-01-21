/*=====================================*\
|| ################################### ||
|| # Post Thank You Hack version 6.1 # ||
|| ################################### ||
\*=====================================*/

function post_thanks_give(postid, integrate)
{
	fetch_object('post_thanks_button_' + postid).style.display = 'none';

	if (integrate == true)
	{
		fetch_object('post_groan_button_' + postid).style.display = 'none';
	}
	
	do_thanks_add = new vB_AJAX_Handler(true);
	do_thanks_add.postid = postid;
	do_thanks_add.onreadystatechange(thanks_add_Done);
	do_thanks_add.send('post_thanks.php?do=post_thanks_add&using_ajax=1&p=' + postid);
}
function thanks_add_Done()
{
	if (do_thanks_add.handler.readyState == 4 && do_thanks_add.handler.status == 200)
	{
		fetch_object('post_thanks_box_' + do_thanks_add.postid).innerHTML = do_thanks_add.handler.responseText;
	}
}
function post_thanks_remove_all(postid, integrate)
{
	do_thanks_remove_all = new vB_AJAX_Handler(true)
	do_thanks_remove_all.postid = postid
	do_thanks_remove_all.onreadystatechange(thanks_remove_all_Done)
	do_thanks_remove_all.send('post_thanks.php?do=post_thanks_remove_all&using_ajax=1&p=' + postid)

	fetch_object('post_thanks_button_' + postid).style.display = ''

	if (integrate == true)
	{
		fetch_object('post_groan_button_' + postid).style.display = '';
	}
}
function thanks_remove_all_Done()
{
	if (do_thanks_remove_all.handler.readyState == 4 && do_thanks_remove_all.handler.status == 200)
	{
		fetch_object('post_thanks_box_' + do_thanks_remove_all.postid).innerHTML = do_thanks_remove_all.handler.responseText
	}
}
function post_thanks_remove_user(postid, integrate)
{
	do_thanks_remove_user = new vB_AJAX_Handler(true)
	do_thanks_remove_user.postid = postid
	do_thanks_remove_user.onreadystatechange(thanks_remove_user_Done)
	do_thanks_remove_user.send('post_thanks.php?do=post_thanks_remove_user&using_ajax=1&p=' + postid)

	fetch_object('post_thanks_button_' + postid).style.display = ''

	if (integrate == true)
	{
		fetch_object('post_groan_button_' + postid).style.display = '';
	}	
}
function thanks_remove_user_Done()
{
	if (do_thanks_remove_user.handler.readyState == 4 && do_thanks_remove_user.handler.status == 200)
	{
		fetch_object('post_thanks_box_' + do_thanks_remove_user.postid).innerHTML = do_thanks_remove_user.handler.responseText
	}
}
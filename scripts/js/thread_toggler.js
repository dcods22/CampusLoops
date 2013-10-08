function editPost(varId)
{
	var post = 'post' + varId;
	var edit = 'editpost' + varId;
	var linkedit = 'linkedit' + varId;
	var linkcancel = 'linkcancel' + varId;
	
	var toggler = document.getElementById(post);
	toggler.style.display = 'none';
	toggler = document.getElementById(edit);
	toggler.style.display = 'inline';
	toggler = document.getElementById(linkedit);
	toggler.style.display = 'none';
	toggler = document.getElementById(linkcancel);
	toggler.style.display = 'inline';
}

function cancelEdit(varId)
{
	var post = 'post' + varId;
	var edit = 'editpost' + varId;
	var linkedit = 'linkedit' + varId;
	var linkcancel = 'linkcancel' + varId;
	
	var toggler = document.getElementById(post);
	toggler.style.display = 'inline';
	toggler = document.getElementById(edit);
	toggler.style.display = 'none';
	toggler = document.getElementById(linkedit);
	toggler.style.display = 'inline';
	toggler = document.getElementById(linkcancel);
	toggler.style.display = 'none';
}
function toggleSearch(){
	var toggler = document.getElementById('searchType1');
	var selection = document.getElementById('searchType2');
	var form = document.getElementById('searchForm');
	if(toggler.value == '2'){
		selection.innerHTML = "<option value='1' selected='selected'>First Name</option><option value='2'>Last Name</option><option value='3'>Both Names</option><option value='4'>Email</option>";
	}
	else if(toggler.value == '1'){
		selection.innerHTML = "<option value='1' selected='selected'>Thread Name</option><option value='2'>Posts</option>";
	}
	form.innerHTML = "<input type='text' name='search' placeholder='Search here...' required='required' />";
}

function toggleSearch2(){
	var toggler1 = document.getElementById('searchType1');
	var toggler2 = document.getElementById('searchType2');
	var selection = document.getElementById('searchForm');
	if(toggler1.value == '2'){
		if(toggler2.value == '3'){
			selection.innerHTML = "<input type='text' name='search' placeholder='First Name' required='required' /><br/><input type='text' name='search2' placeholder='Last name' required='required' />";
		}
		else{
			selection.innerHTML = "<input type='text' name='search' placeholder='Search here...' required='required' />"
		}
	}
}

function initSearch()
{
	var toggler = document.getElementById('searchType1');
	var toggler2 = document.getElementById('searchType2');
	toggler.addEventListener('change', toggleSearch);
	toggler2.addEventListener('change', toggleSearch2);
	
}

window.addEventListener('load', initSearch);
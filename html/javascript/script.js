var remote = null;

// -------------------------------------------------
// STANDARD ASPECT SCRIPTS
// -------------------------------------------------
function closeWin()
{
	if (remote && remote.open && !remote.closed) remote.close();
}

function box(w,h)
{
	string="height=" + h + ",width=" + w;
	remote = window.open('','box',string);
	remote.focus();
	return false;
}

function handler(e){
	e = window.event;
	if(e.keyCode != '13'){
		alert('fisk');
	}
}

// -------------------------------------------------
// SEARCH MODULE JAVASCRIPTS
// -------------------------------------------------
function recallQuery(form) {
	form.query.value = form.savedquery.value;
}

function deleteQuery(form) {
	index = form.savedquery.selectedIndex;
	description = form.savedquery.options[index].text;
	var ok = confirm("Delete the saved query '" + description + "'?");
	if (ok == false)
		return;
	form.delete_description.value = description;
	form.delete_query.value = form.savedquery.value;
	document.searchform.submit();
}

function saveQuery(form) {
	var description = prompt("Save '" + form.query.value + "' as?", " ");
	if (description == ' ' || description == null)
		return;
	form.save_query.value = form.query.value;
	form.save_description.value = description;
	document.searchform.submit();
}


// -------------------------------------------------
// To light up buttons in IE. 
// -------------------------------------------------
var i=0;
var ie=(document.all)?1:0;
var ns=(document.layers)?1:0;

function LightOn(what)
{
	if (ie) what.style.backgroundColor = '#eeeeee';
	else return;
}

function LightOff(what)
{
	if (ie) what.style.backgroundColor = '#e3dddd';
	else return;
}

// -------------------------------------------------
// ....
// -------------------------------------------------

var pre;

function ChangeCity() {
	var s = document.getElementById("city_select");
	var c = s.options[s.selectedIndex].value;
	if (pre)
		pre.style.display = "none";
	pre = document.getElementById(c);
	pre.style.display = "block";
}

function addSubData() {
	var s = document.getElementById("city_select");
	var c = s.options[s.selectedIndex].value;

	var search_form = document.getElementById("search-form");
	var sub_form = document.getElementById("sub-form");
	// var list = sub_form.getElementsByTagName("select");
	var city = document.getElementById(c).value;
	var cat = document.getElementById("cat_select").value;

	search_form.children[0].value = city;
	search_form.children[1].value = cat;
}

function openOrg(c) {
	var a = parent.document.getElementById("black-layer");
	var o = parent.document.getElementById("singl-org");

	if (event.button == 0) {
		var t = c.children[0].innerHTML;
		var s = "org=" + t;
		parent.document.cookie = s;
		o.contentWindow.location.reload(true);
		a.style.display = "block";

		var delay = 200;
		setTimeout(function() {
			o.style.display = "block";
		}, delay);

	} else {
		a.style.display = "block";
		if (confirm("Скрыть организацию из списка ?") == true) {
			c.style.display = "none";
			a.style.display = "none";
		} else {
			a.style.display = "none";
		}
	}
}

function closeOrg() {
	var a = parent.document.getElementById("black-layer");
	var o = parent.document.getElementById("singl-org");
	var y = parent.document.getElementById("add-org");

	a.style.display = "none";
	o.style.display = "none";
	y.style.display = "none";
}

function displayAddForm() {
	var a = document.getElementById("black-layer");
	var b = document.getElementById("add-org");
	a.style.display = "block";
	b.style.display = "block";

}
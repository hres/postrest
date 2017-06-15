//js file for producing http requests from submitted form in drug-query.html

//reduce base to what necessary

var base = "https://rest-dev.hres.ca/rest-dev/drug_product?select=*,active_ingredient{ingredient,strength,strength_unit},companies{company_name}";
var query = "";
var items = 25;
var page = 0;

//add to base when available

//,status{*} -> EXISTS/FALSE

function newSearch() {
	window.location.reload();
	window.scrollTo(0,0);
}

//add any form validation
function validate() {
	
	return true;
}

function prepare() {

	if (validate()) {
		var queryKeys = {};
	
		queryKeys.din = document.getElementById("din").value;
		queryKeys.atc = document.getElementById("atc").value;
		
		if (queryKeys.din != "") {
			requestForResourceInitial(queryKeys);
		}
		else if (queryKeys.atc != "") {
			requestForResourceInitial(queryKeys);
		}
		else {
			queryKeys.status = document.getElementById("status").value;
			queryKeys.company = document.getElementById("company").value;
			queryKeys.product = document.getElementById("product").value;
			queryKeys.active = document.getElementById("active").value;
			queryKeys.aig = document.getElementById("aig").value;
			queryKeys.drugClass = document.getElementById("drugClass").value;
			queryKeys.route = document.getElementById("route").value;
			queryKeys.dosage = document.getElementById("dosage").value;
			queryKeys.schedule = document.getElementById("schedule").value;
			
			requestForResourceSecondary(queryKeys);
		}
	}
}

//http post instead of get test URL > 1024
function requestForResourceInitial(keys) {
	
	var drugTable = document.getElementById("drugTable");
	
	if (keys.din != "") {
		query = base + "&drug_identification_number=ilike.*" + keys.din + "*";
		
		query += "&order=brand_name";
		
		$.get(query, function(data) {
			createDrugTable(drugTable, data);
		}, "json");
	}
	else {
		query = base //+ "&therapeutic_class.tc_atc_number=eq." + keys.atc;
		
		query += "&order=brand_name";
		
		$.get(query, function(data) {
			createDrugTable(drugTable, data);
		}, "json")
	}	
}

//http post instead of get test URL > 1024
function requestForResourceSecondary(keys) {

	var drugTable = document.getElementById("drugTable");
	query = base;

	/*if (keys.status != "0") {
		query += "&status.status=ilike.*" + keys.status + "*";
	}*/
	
	/*if (keys.company != "") {
		query += "&company.company_name=ilike.*" + keys.company + "*";
	}*/
	
	if (keys.product != "") {
		query += "&brand_name=ilike.*" + keys.product + "*";
	}
	
	/*if (keys.active != "") {
		query += "&active_ingredient.ingredient=ilike.*" + keys.active + "*";
	}*/
	
	if (keys.aig != "") {
		query += "&ai_group_no=eq." + keys.aig;
	}
	
	if (keys.drugClass != "0") {
		query += "&class=ilike.*" + keys.drugClass + "*";
	}
	
	/*if (keys.route != "0") {
		query += "&route.route_of_administration=in." + keys.route;
	}*/
	
	/*if (keys.dosage != "0") {
		/query += "&pharmaceutical_form.pharmaceutical_form=ilike.*" + keys.dosage + "*";
	}*/
	
	/*if (keys.schedule != "0") {
		query += "&schedule.schedule=ilike.*" + keys.schedule + "*";
	}*/
	
	query += "&order=brand_name";
	
	$.get(query, function(data) {
		createDrugTable(drugTable, data);
	}, "json");
}

// add links to DIN in row generation
// add status instead of null when available
function createDrugTable(table, data) {
	
	if (data.length == 0) {
		document.getElementById("queryMessage").innerHTML = "<em>No results found</em>";
		document.getElementById("fetch").style.display = "none";
	}
	else {
		var rowIndex = (page * items);
		
		if (page == 0) {
			rowIndex++;
		}
	
		var dataIndex = page * items;
		var remaining = data.length - dataIndex;
		var maxDataIndex = 0;
		
		if (remaining < items) {
			maxDataIndex = dataIndex + remaining;
		}
		else {
			maxDataIndex = dataIndex + items;
		}
	
		for (dataIndex; dataIndex < maxDataIndex; dataIndex++) {
			var obj = data[dataIndex];
			//console.log(obj);
			
			var drugRow = table.insertRow(rowIndex + 1);
			var statusCell = drugRow.insertCell(0);
			var dinCell = drugRow.insertCell(1);
			var companyCell = drugRow.insertCell(2);
			var productCell = drugRow.insertCell(3)
			var classCell = drugRow.insertCell(4);
			var activeCell = drugRow.insertCell(5);
			var strenghtCell = drugRow.insertCell(6);
			
			statusCell.innerHTML = "---";
			dinCell.innerHTML = "<a href='./drug-id.html?product=" + obj.drug_identification_number + "'>" + obj.drug_identification_number + "</a>";
			companyCell.innerHTML = obj.companies[0].company_name;
			productCell.innerHTML = obj.brand_name;
			classCell.innerHTML = obj.class;
			activeCell.innerHTML = obj.active_ingredient[0].ingredient;
			strenghtCell.innerHTML = obj.active_ingredient[0].strength + " " + obj.active_ingredient[0].strength_unit;
			
			rowIndex++;
		}
	}
	
	document.getElementById("fetch").innerHTML = "Load More (" + (remaining - items) + " items remaining)";
	document.getElementById("queryResults").style.display = "block";
	document.getElementById("queryFields").style.display = "none";
	
	if (page == 0) {
		table.deleteRow(1);
		window.scrollTo(0,0);
	}
	
	if (remaining <= items) {
		document.getElementById("fetch").style.display = "none";
	}
}

function fetch() {

	page += 1;
	
	var drugTable = document.getElementById("drugTable");
	
	$.get(query, function(data) {
		createDrugTable(drugTable, data);
	}, "json");
}
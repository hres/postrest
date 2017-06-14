//js file for producing http requests from submitted form in drug-query.html

var base = "https://rest-dev.hres.ca/rest-dev/drug_product?select=*,active_ingredient{ingredient,strength,strength_unit},companies{company_name,suite_number,street_name,city_name,province,country,postal_code},therapeutic_class{*},route{*}";

//add to base when available

//,status{*} -> EXISTS/FALSE
//,pharmaceutical_form{*} -> EXISTS/FALSE
//,schedule{*} -> EXISTS/FALSE
//,vet_species{*} -> EXISTS/FALSE

function prepare() {

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

//http post instead of get test URL > 1024
function requestForResourceInitial(keys) {
	
	var drugTable = document.getElementById("drugTable");
	
	if (keys.din != "") {
		var query = base + "&drug_identification_number=eq." + keys.din;
		
		console.log(query);
		
		$.get(query, function(data) {
			createDrugTable(drugTable, data);
		}, "json")
	}
	else {
		var query = base //+ "&therapeutic_class.tc_atc_number=eq." + keys.atc;
		
		console.log(query);
		
		$.get(query, function(data) {
			createDrugTable(drugTable, data);
		}, "json")
	}	
}

//http post instead of get test URL > 1024
function requestForResourceSecondary(keys) {

	var drugTable = document.getElementById("drugTable");
	var query = base;

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
	
	console.log(query);
	
	$.get(query, function(data) {
		createDrugTable(drugTable, data);
	}, "json")
}

function createDrugTable(table, data) {
	
	var rowIndex = 1;
	
	for (var i = 0; i < data.length; i++) {
		var obj = data[i];
		//console.log(obj);
		
		var drugRow = table.insertRow(rowIndex);
		var statusCell = drugRow.insertCell(0);
		var dinCell = drugRow.insertCell(1);
		var companyCell = drugRow.insertCell(2);
		var productCell = drugRow.insertCell(3)
		var classCell = drugRow.insertCell(4);
		var activeCell = drugRow.insertCell(5);
		var strenghtCell = drugRow.insertCell(6);
		
		statusCell.innerHTML = "null";
		dinCell.innerHTML = "<a href='https://www.canada.ca'>" + obj.drug_identification_number + "</a>";
		companyCell.innerHTML = obj.companies[0].company_name;
		productCell.innerHTML = obj.brand_name;
		classCell.innerHTML = obj.class;
		activeCell.innerHTML = obj.active_ingredient[0].ingredient;
		strenghtCell.innerHTML = obj.active_ingredient[0].strength + " " + obj.active_ingredient[0].strength_unit;
		
		rowIndex++;
	}
}
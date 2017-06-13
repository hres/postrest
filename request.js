// js file for producing http requests from submitted form in drug-query.html

var base = "https://rest-dev.hres.ca/rest-dev/drug_product?select=*"

//add to base when available

//%20active_ingredient{ingredient,strength,strength_unit}
//%20companies{company_name,suite_number,street_name,city_name,province,country,postal_code}
//%20status{*}
//%20therapeutic_class{*}
//%20form{*}
//%20route{*}
//%20schedule{*}
//%20veterinary_species{*}

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
		queryKeys.comapny = document.getElementById("company").value;
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
	
	if (keys.din != "") {
		var query = base + "&drug_identification_number=eq." + keys.din;
		
		$.get(query, function(data) {
			console.log(data);
		});
	}
	else {
		var query = base + "&therapeutic_class.tc_atc_number=eq." + keys.atc;
		
		$.get(query, function(data) {
			console.log(data);
		});
	}	
}

//http post instead of get test URL > 1024
function requestForResourceSecondary(keys) {

	var query = base;

	if (keys.status != "0") {
		query += "&status.status=ilike." + keys.status;
	}
	
	if (keys.company != "") {
		query += "&company.company_name=ilike." + keys.comapny;
	}
	
	if (keys.product != "") {
		query += "&brand_name=ilike." + keys.product;
	}
	
	if (keys.active != "") {
		query += "&active_ingredient.ingeredient=ilike." + keys.active;
	}
	
	if (keys.aig != "") {
		query += "&ai_group_no=eq." + keys.aig;
	}
	
	if (keys.drugClass != "0") {
		query += "&class=ilike." + keys.drugClass;
	}
	
	if (keys.route != "0") {
		query += "&route.route_of_administration=ilike." + keys.route;
	}
	
	if (keys.dosage != "0") {
		query += "&form.pharmaceutical_form=ilike." + keys.dosage;
	}
	
	if (keys.schedule != "0") {
		query += "&schedule.schedule=ilike." + keys.schedule;
	}
	
	$.get(query, function(data) {
		console.log(data);
	});
}
//js file for querying and displaying users selected drug

var drug_id = window.location.search.substring(9);
var base = "https://rest-dev.hres.ca/rest-dev/drug_product?select=*,active_ingredient{ingredient,strength,strength_unit},companies{company_name,suite_number,street_name,city_name,province,country,postal_code},therapeutic_class{*},route{*}";

//add to base when available

//,status{*} -> EXISTS/FALSE
//,pharmaceutical_form{*} -> EXISTS/FALSE
//,schedule{*} -> EXISTS/FALSE
//,vet_species{*} -> EXISTS/FALSE

$(document).ready(function() {
	
	console.log(true);
	
	query = base + "&drug_identification_number=eq." + drug_id;
	
	$.get(query, function(data) {
		//console.log(data);
		
		
	});
});

function newSearch() {
	window.location = "./drug-query-en.html";
}
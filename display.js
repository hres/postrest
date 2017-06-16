//js file for querying and displaying users selected drug

var drug_id = window.location.search.substring(9);
var base = "https://rest-dev.hres.ca/rest-dev/drug_product?select=*,active_ingredient{ingredient,strength,strength_unit},companies{company_name,suite_number,street_name,city_name,province,country,postal_code},therapeutic_class{*},route{*}";

//add to base when available

//,status{*} -> EXISTS/FALSE
//,pharmaceutical_form{*} -> EXISTS/FALSE
//,schedule{*} -> EXISTS/FALSE
//,vet_species{*} -> EXISTS/FALSE

$(document).ready(function() {
	
	query = base + "&drug_identification_number=eq." + drug_id;
	
	$.get(query, function(data) {
		var obj = data[0];
		//console.log(obj);
		
		if (data[0].class == "Veterinary") {
			document.getElementById("speciesDiv").style.display = "block";
		}
		
		document.getElementById("status").innerHTML = "---";
		document.getElementById("statusDate").innerHTML = "---";
		document.getElementById("market").innerHTML = "---";
		document.getElementById("product").innerHTML = obj.brand_name;
		document.getElementById("din").innerHTML = obj.drug_identification_number;
		
		var company = document.getElementById("company");
		var c = obj.companies[0];
		company.innerHTML = "<b>" + c.company_name + "</b>";
		
		if (c.suite_number != "") {
			company.innerHTML += "<br>" + c.suite_number;
		}
		
		company.innerHTML += "<br>" + c.street_name + "<br>" + c.city_name + ", " + c.province + "<br>" + c.country + " " + c.postal_code;
		
		document.getElementById("drugClass").innerHTML = obj.class;
		//document.getElementById("species").innerHTML = obj.vet_species.species;
		document.getElementById("dosage").innerHTML = "---";
		document.getElementById("route").innerHTML = obj.route[0].route_of_administration;
		document.getElementById("active").innerHTML = obj.number_of_ais;
		document.getElementById("schedule").innerHTML = "---";
		document.getElementById("ahfs").innerHTML = obj.therapeutic_class[0].tc_ahfs_number + " " + obj.therapeutic_class[0].tc_ahfs;
		document.getElementById("atc").innerHTML = obj.therapeutic_class[0].tc_atc_number + " " + obj.therapeutic_class[0].tc_atc;
		document.getElementById("aig").innerHTML = obj.ai_group_no;
		
		var table = document.getElementById("activeIngredientsTable");
		
		for (var i = 0; i < obj.active_ingredient.length; i++) {
			var ingredientRow = table.insertRow(i + 1);
			
			var activeIngredientCell = ingredientRow.insertCell(0);
			var strengthCell = ingredientRow.insertCell(1);
			
			activeIngredientCell.innerHTML = obj.active_ingredient[i].ingredient;
			strengthCell.innerHTML = obj.active_ingredient[i].strength + " " + obj.active_ingredient[i].strength_unit;
		}
		
		table.deleteRow(-1);
		
		var ingredientRow
	});
});

function newSearch() {
	window.location = "./drug-query-en.html";
}
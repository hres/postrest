//js file for producing http requests from submitted form in drug-query.html

var base = "https://rest-dev.hres.ca/rest-dev/dpd_json3?select=drug_product"
var query = "";
var items = 25;
var page = 0;

function newSearch() {

	window.location.reload();
	window.scrollTo(0,0);
}

function validate() {

	return true;
}

function prepare() {

	if (validate()) {
		var input = document.getElementById("search").value;
		var search = input.split(" ");
		
		requestForResource(search);
	}
}

function requestForResource(search) {
	
	var drugTable = document.getElementById("drugTable");
	
	query = base;

	if(search[0] != "") {
		for(var x = 0; x < search.length; x++) {
		
			query += "&search=@@." + search[x];
		}
	}
	
	query += "&order=drug_code";
	
	//console.log(query);
	
	$.get(query, function(data) {
		createDrugTable(drugTable, data);
	}, "json");
}

function createDrugTable(table, data) {
	
	//console.log(data[0]);
	
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
			
			var obj = data[dataIndex].drug_product;
			
			//console.log(obj);
			
			var drugRow = table.insertRow(rowIndex + 1);
			var statusCell = drugRow.insertCell(0);
			var dinCell = drugRow.insertCell(1);
			var companyCell = drugRow.insertCell(2);
			var productCell = drugRow.insertCell(3)
			var classCell = drugRow.insertCell(4);
			var activeCell = drugRow.insertCell(5);
			var strenghtCell = drugRow.insertCell(6);
			
			for(var x = 0; x < obj.status.length; x++) {
				
				if (obj.status[x].current_status_flag == "Y") {
					statusCell.innerHTML = obj.status[x].status;
				}
			}
			
			dinCell.innerHTML = "<a href='./drug-id.html?product=" + obj.drug_code + "'>" + obj.drug_identification_number + "</a>";
			companyCell.innerHTML = obj.company.company_name;
			productCell.innerHTML = obj.brand_name;
			classCell.innerHTML = obj.class;
			
			var s = 0;
			var i = 0;
			
			for(var x = 0; x < obj.active_ingredients.length; x++) {
				
				if(obj.active_ingredients[x].strength > s) {
					s = obj.active_ingredients[x].strength;
					i = x;
				}
			}
			
			activeCell.innerHTML = obj.active_ingredients[i].ingredient;
			strenghtCell.innerHTML = obj.active_ingredients[i].strength + " " + obj.active_ingredients[i].strength_unit;
			
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

	page++;
	
	var drugTable = document.getElementById("drugTable");
	
	$.get(query, function(data) {
		createDrugTable(drugTable, data);
	}, "json");
}
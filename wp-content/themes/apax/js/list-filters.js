$(document).ready(function() {

	$("#filter_pole, #filter_secteur, #filter_function").each(function() {
		// var width;
		// switch($(this).attr("id")) {
			// case "filter_pole" :
				// width = "250px";
				// break;
			// case "filter_secteur" :
				// width = "216px";
				// break;
			// case "filter_function" :
				// width = "260px";
				// break;
			// default :
				// width = "216px";
				// break;
		// }

		$(this).adakaListMultiple({
			width: "100%",
			txtList: $(this).attr("data-placeholder"),
			flottant : true,
			showNbElementChecked : false,
			firstSelectAll : true
		});

		$(this).change(update_filters).trigger("change");
	});
});

function update_filters() {
	var poles = $("#filter_pole").length==0 ?'' :$("#filter_pole").val();
	var secteurs = $("#filter_secteur").length==0 ?'' :$("#filter_secteur").val();
	var functions = $("#filter_function").length==0 ?'' :$("#filter_function").val();

	$('.grid').isotope({
		filter: function() {
			var found = false;
			var item_poles = $(this).data('poles').split(',').map(function(x){
				return x.trim();
			});
			if(item_poles.indexOf(poles) >= 0)
				found = true;
			if(!found && poles.length != 0)
				return false;

			var found = false;
			if($(this).hasClass(secteurs))
				found = true;
			if(!found && secteurs.length != 0)
				return false;

			var found = false;
			if($(this).hasClass(functions))
				found = true;
			if(!found && functions.length != 0)
				return false;

			return true;
		}
	})
}

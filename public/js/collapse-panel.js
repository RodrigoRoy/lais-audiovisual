$(document).ready(function(){
	// Enable all tooltips in the document
	//$('[data-toggle="tooltip"]').tooltip();
	// Enable all popover in the document
	//$('[data-toggle="popover"]').popover()
	
	// Show all panels heading (development purpose only)
	//$("div.collapse").collapse('show');

	// Show the first panel heading (at least the fist must be showed)
	$("div.collapse").first().collapse('show');

	// Toggle collapse of each panel heading on click
    $(".panel-heading").click(function(){
        $(this).parent(".panel-default").children(".collapse").collapse('toggle');
    });
});
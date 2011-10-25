$(document).ready(function(){
	$("div#sidebar ul:last-child li").hide();
	$("div#sidebar ul:last-child").append('<li id="archiveHover">[...]</li>');
	$("li#archiveHover").hover(
		function() {
		        $("div#sidebar ul:last-child li").show("fast");
		}
	);
});

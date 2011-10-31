$(document).ready(function(){
	$('#sidebar ul:last-child li a').hide();
	$('#sidebar ul:last-child li').click(
		function() {
		        $(this).children('a').fadeToggle();
		}
	);
});

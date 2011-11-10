$(document).ready(function(){
	$('#sidebar ul:eq(2) li a').hide();
	$('#sidebar ul:eq(2) li').click(
		function() {
		        $(this).children('a').fadeToggle();
		}
	);
});

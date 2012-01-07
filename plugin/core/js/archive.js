$(document).ready(function(){
	$('#sidebar ul:eq(2) li .months').hide();
	$('#sidebar ul:eq(2) li').click(
		function() {
			$(this).children('.months').fadeToggle();
		}
	);
});

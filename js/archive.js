$(document).ready(function(){
	$('#sidebar ul:last-child li').hide();
	$('<li>[...]</li>').appendTo('#sidebar ul:last-child')
	.hover(
		function() {
		        $('#sidebar ul:last-child li').show('fast');
		}
	);
});

$(document).ready(function(){
	bbcode();
});

function bbcode() {
	var ta = $('textarea')[0];

	var tags = ['b', 'i', 'u', 's', 'img', 'url', 'youtube', 'block', 'more'];
	var e = $('<div id="bbcode"></div>');
	for(var i in tags)
	{
		$('<input type="button"/>').attr('value', tags[i]).appendTo(e);
	}
	$(e).insertBefore(ta);

	$('#bbcode input').css('margin', 5)
	.hover(
		function() {
			$(this).animate({opacity: 0.5});
		},
		function() {
			$(this).animate({opacity: 1});
		}
	)
	.click(function() {
		var tag = $(this).attr('value');
		var start = '['+tag+']';
		var end = '[/'+tag+']';
		
		var param;
		switch(tag)
		{
			case 'img':
				param = prompt('Enter image URL', 'http://');
				if (param)
					start += param;
				else
					return;
				break;
			case 'youtube':
				param = prompt('Enter youtube ID', '3f7l-Z4NF70');
				if (param)
					start += param;
				else
					return;
				break;
			case 'url':
				param = prompt('Enter URL', 'http://');
				if (param)
					start = '[url=' + param + ']';
				else
					return;
				break;
			case 'more':
				end = '';
				break;
		}

		ta.focus();
		if (typeof ta.selectionStart != 'undefined')
		{
			var startPos = ta.selectionStart;
			var endPos = ta.selectionEnd;
			ta.value = ta.value.substring(0, startPos) + start + ta.value.substring(startPos, endPos) + end + ta.value.substring(endPos, ta.value.length);
		}
		else
		{
			ta.value += start + end;
		}
	});
}

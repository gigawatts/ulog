$(function() {
	bbcode();
});

function bbcode() {
	var ta = $('textarea[name="content"]')[0];
	var bar = $('<div id="bbcode" class="btn-group"></div>');
	$.each(['b', 'i', 'u', 's', 'li', 'img', 'url', 'block'], function (i, tag) {
		$('<input class="btn" type="button"/>').attr('value', tag).appendTo(bar);
	});
	$('<div><form id="imageform" method="post" enctype="multipart/form-data" action="ajaximage.php"><input type="file" name="photoimg" id="photoimg" /> </form></div><div id="preview"></div>').insertBefore(ta);
	$(bar).insertBefore(ta);

function addImage() {
	ta.value += '\n[url=' + document.getElementById("preview").getElementsByTagName("IMG")[0].src + '][img]' + document.getElementById("preview").getElementsByTagName("IMG")[0].src + '[/img][/url]\n';
}

document.getElementById("preview").addEventListener("click", addImage, false);

	$('#bbcode .btn').click(function() {
		var tag = $(this).attr('value');
		var start = '['+tag+']';
		var end = '[/'+tag+']';
		
		var param;
		switch(tag) {
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
		}

		ta.focus();
		if (typeof ta.selectionStart != 'undefined') {
			var startPos = ta.selectionStart;
			var endPos = ta.selectionEnd;
			ta.value = ta.value.substring(0, startPos) + start + ta.value.substring(startPos, endPos) + end + ta.value.substring(endPos, ta.value.length);
		} else {
			ta.value += start + end;
		}
	});
}

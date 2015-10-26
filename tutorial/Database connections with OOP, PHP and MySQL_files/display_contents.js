$(document).ready(function(){

	$('#showHide').click(function(){
		var statue = $('#showHide').attr('class');
		if (statue == "statueHide") {
			$('#showHide').text('Show').attr('class', 'statueShow');
			$('#Menu').hide(500);
		}
		if (statue == "statueShow") {
			$('#showHide').text('Hide').attr('class', 'statueHide');
			$('#Menu').show(500);
		}
		return false;
	});
});

	var sommaire = "<div id='display_contents'><div align='center'>Contents [<a href='#' id='showHide' class='statueHide'>Hide</a>]</div>"; //onclick='showHide(\"Menu\");'
	sommaire += '<div id="Menu">'; //style="display:block;"
	$('h2').each(function(i){
	$(this).prepend('<a name="' + (i+1) + '" style="padding-top: 100px"></a>');
	sommaire += '<a href="#' + (i+1) + '">' + (i+1) + '. ';
	sommaire += $(this).text();
	sommaire += '</a><br />';

	if($('h2:eq(' + i + ')').nextUntil('h2:eq(' + (i+1) + ')', 'h3').length != 0){
		$('h2:eq(' + i + ')').nextUntil('h2:eq(' + (i+1) + ')', 'h3').each(function(j){ //Find the siblings <h3> that follow <h2> up to the next <h2>
			$(this).prepend('<a name="' + (i+1) + (j+1) + '" style="padding-top: 100px"></a>');
			sommaire += '&emsp;<a href="#' + (i+1) + (j+1) + '">' + (i+1) + '.' + (j+1) + '. ';
			sommaire += $(this).text();
			sommaire += '</a><br />';
		});
	}

	});
	sommaire += '</div>';

	$('#displayContents').html(sommaire);
	

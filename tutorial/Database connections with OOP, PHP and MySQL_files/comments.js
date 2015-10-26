$(function() {
	function validEmail(email) {
		var r = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
		return (email.match(r) == null) ? false : true;
	}

	$(".submit").click(function() {
		var currentURL = $(location).attr('href');
		var com_name = $('#com_name').val();
		var com_email = $('#com_email').val();
		var com_text = $('#com_text').val();
		var page_id = $('#page_id').val();
		var member = $('#member').val();
		var avatar = $('#avatar').val();
		var social = $('#social').val();
		var dataFields = {'com_name': com_name, 'com_email': com_email, 'com_text': com_text, 'page_id': page_id, 'member': member, 'avatar': avatar, 'social': social, 'currentURL': currentURL};
		
		if (typeof com_name !== 'undefined') var checkName = $('#com_name').val().length;
		if (typeof com_email !== 'undefined') var checkEmail = validEmail(com_email);
		if(checkName < 3 || checkEmail == false || com_text=='') {
			if (checkName < 3) {
				$('#formGroupName').attr('class', 'form-group has-error'); 
				$('#formGroupName span').text('minimum 4 characters');
			} else {
				$('#formGroupName').attr('class', 'form-group has-success');
				$('#formGroupName span').text('');
			}
			if (checkEmail == false) {
				$('#formGroupEmail').attr('class', 'form-group has-error');
				$('#formGroupEmail span').text('wrong email format');
			} else {
				$('#formGroupEmail').attr('class', 'form-group has-success');
				$('#formGroupEmail span').text('');
			}
			if (com_text=='') {
				$('#formGroupText').attr('class', 'form-group has-error');
				$('#formGroupText span').text('This field can\'t be empty');
			} else {
				$('#formGroupText').attr('class', 'form-group has-success');
				$('#formGroupText span').text('');
			}
		} else {
			$('#newComment').html('<img src="/design/loader.gif" /> Processing...');
			$.ajax({
				type: "POST",
				url: "/ajax/blogcommentajax.php",
				data: dataFields,
				timeout: 3000,
				success: function(dataBack){
					$('#newComment').html(dataBack);
					$('#com_text').val('');
					},
				error: function() {
					$('#newComment').text('Problem!');
				}
			});
		}
		return false;
	});
});
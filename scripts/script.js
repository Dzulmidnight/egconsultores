jQuery('#sbm_go').click(function() {
		var valemail = jQuery("#email").val();
		var emailPattern = /^[a-zA-Z0-9._]+[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/;
		if (!emailPattern.test(valemail)) {
			jQuery('#email_div').addClass('has-error');
		} else {
			var postData = jQuery('#contact_form').serialize();
			jQuery.ajax({
				type : "POST",
				url : "scripts/submit.php",
				data : postData,
				cache : false,
			});

		}
	});
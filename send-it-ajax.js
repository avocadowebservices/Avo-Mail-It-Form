jQuery(document).ready(function($) {
    $('#send-it-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = {
            action: 'send_it_form_submit',
            security: sendItAjax.security,
            name: $('#send-it-name').val(),
            email: $('#send-it-email').val(),
            message: $('#send-it-message').val()
        };

        $.ajax({
            type: 'POST',
            url: sendItAjax.ajaxurl,
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $('#send-it-response').html('<p>Sending...</p>').fadeIn();
            },
            success: function(response) {
                if (response.success) {
                    $('#send-it-response').html('<p style="color: green;">' + response.data + '</p>').fadeIn();
                    $('#send-it-form')[0].reset();
                } else {
                    $('#send-it-response').html('<p style="color: red;">' + response.data + '</p>').fadeIn();
                }
            },
            error: function() {
                $('#send-it-response').html('<p style="color: red;">There was an error processing your request. Please try again.</p>').fadeIn();
            }
        });
    });
});

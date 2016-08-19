$(function() {
    // Get the form.
    var form = $('#ajax-contact');

    // Get the messages div.
    var formMessages = $('#form-messages');

    // TODO: The rest of the code will go here...
});

// Set up an event listener for the contact form.
$(form).submit(function(event) {
    // Stop the browser from submitting the form.
    event.preventDefault();

    // Serialize the form data.
var formData = $(form).serialize();
});

// Submit the form using AJAX.
$.ajax({
    type: 'POST',
    url: $(form).attr('action'),
    data: formData
});

.done(function(response) {
    // Make sure that the formMessages div has the 'success' class.
    $(formMessages).removeClass('error');
    $(formMessages).addClass('success');

    // Set the message text.
    $(formMessages).text(response);

    // Clear the form.
    $('#name').val('');
    $('#email').val('');
    $('#message').val('');
})


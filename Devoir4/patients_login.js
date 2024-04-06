$(document).ready(function() {
    $('#patientLoginForm').submit(function(event) {
        event.preventDefault(); 
        const name = $('#patient_name').val().trim();
        const code = $('#patient_code').val().trim();

        $.ajax({
            type: 'POST',
            url: 'patients.php', 
            data: { name: name, code: code },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else if (data.error) {
                    alert(data.error);
                }
            }            
        });
    });
});

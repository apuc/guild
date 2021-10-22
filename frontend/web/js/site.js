$(document).on("beforeSubmit", "#password-form", function (e) {
    let form = $(this);
    let formData = form.serialize();
    let location = document.location.href;
    location = location.split('=');
    formData = formData.split('=');
    console.log(formData[2]);

    $.ajax({
        url: 'ajax',
        type: 'POST',
        data: {
            id: location[1],
            password: formData[2],
        },
        password: formData[2],
        success: function (response) {
            window.location.replace('index');
        },
        error: function () {
        }
    });

});
$(function(){
    $('#options').change(function(){
        month = $('#options :selected').val();
        history.pushState({}, '', month);
        $.pjax.reload({container:"#reload"});
    })
});

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

$(document).ready(function () {
    $('.generate').on('click', function () {
        $(".custom-input").val(gen_password(8));
    });
});

function gen_password(len){
    var password = "";
    var symbols = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < len; i++){
        password += symbols.charAt(Math.floor(Math.random() * symbols.length));
    }
    return password;
}
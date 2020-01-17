$(function(){
    $('#options').change(function(){
        month = $('#options :selected').val();
        history.pushState({}, '', month);
        $.pjax.reload({container:"#reload"});
    })
});
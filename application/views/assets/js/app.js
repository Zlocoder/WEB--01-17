$(function() {
    $('.filter input, .filter select').change(function() {
        $(this).parents('form:first').submit();
    });
});

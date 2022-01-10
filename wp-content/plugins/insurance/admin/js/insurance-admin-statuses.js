jQuery(document).ready(function($) {
    $('form#formStatuses').submit(function (e) {
        if(disableCheckName == false) {
            $('#statusText').val();
            if (statuses.indexOf($('#statusText').val().trim()) != -1) {
                alert("Статус із такою назвою вже є, введіть іншу.");
                return false;
            }
        }
    });
});
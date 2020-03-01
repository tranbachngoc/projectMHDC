function ActionSort(isAddress)
{
    window.location.href = isAddress;
}
function submit_enter(e) {

    var keycode;
    if (window.event) keycode = window.event.keyCode;
    else if (e) keycode = e.which;
    else return true;

    if (keycode == 13) {

        jQuery('#searchBox').submit();
        return false;
    }
    else
        return true;

}
$(document).ready(function() {
    $('body').on('click', '.js_icon-search-submit', function (event) {
        event.preventDefault();
        jQuery('#searchBox').submit();
    });
});
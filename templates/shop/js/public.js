/**
 * Created by tunghoang on 6/21/2016.
 */
jQuery( document ).ready(function($) {
    $("#btn_sort").click(function () {
        $("#box_search").hide();
        $("#box_sort").slideToggle();
    });
    $("#btn_search").click(function () {
        $("#box_sort").hide();
        $("#box_search").slideToggle();
    });

});
// only number
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
}
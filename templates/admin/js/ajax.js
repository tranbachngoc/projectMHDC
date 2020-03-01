/*BEGIN: Set Enddate*/
function setEndDate(id, endDate, baseUrl, subUrl)
{
    $.ajax({
			   type: "POST",
			   url: baseUrl + "administ/" + subUrl + "/ajax",
			   data: "id=" + id + "&enddate=" + endDate,
			   success: function(msg){
    			     if(!CheckBlank(msg))
                     {
    			         alert(msg);
                     }
                 },
			   error: function(){}
		 	});
}
/*END Set Enddate*/
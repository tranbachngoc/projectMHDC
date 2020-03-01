/*BEGIN: Information*/
function ajaxRequestInformation()
{
    var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
    if(window.ActiveXObject)
    {
        for(var i = 0; i < activexmodes.length; i++)
        {
            try{
                return new ActiveXObject(activexmodes[i]);
            }catch(e){}
        }
    }
    else
    {
        if(window.XMLHttpRequest)
        {
            return new XMLHttpRequest();
        }
        else
        {
            return false;
        }
    }
}

function getInformation(type, baseUrl, token)
{
    baseUrl += 'information';
    var mypostrequest = new ajaxRequestInformation();
    mypostrequest.onreadystatechange = function(){
        if(mypostrequest.readyState == 4)
        {
            if(mypostrequest.status == 200 || window.location.href.indexOf("http") == -1)
            {
                document.getElementById("DivInformation").innerHTML = mypostrequest.responseText;
            }
            else
            {
                alert("An error has occured making the request!");
            }
        }
    };
    var parameters = "type="+ type + "&token=" + token;
    mypostrequest.open("POST", baseUrl, true);
    mypostrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    mypostrequest.send(parameters);
}

function hideInformation() 
{ 
    if(document.getElementById)
    {
        document.getElementById('hideshow').style.visibility = 'hidden'; 
    } 
    else
    { 
        if(document.layers)
        {
            document.hideshow.visibility = 'hidden'; 
        } 
        else
        {
            document.all.hideshow.style.visibility = 'hidden'; 
        } 
    }
    document.getElementById('DivInnerHTML').innerHTML = '';
}

function showInformation(type, baseUrl, token)
{
    document.getElementById('DivInnerHTML').innerHTML = '<div id="DivInformation" style="height:400px; overflow:scroll;"><img src="' + baseUrl + 'templates/home/images/loading.gif" class="image_loading_information"/></div>';
    if(document.getElementById)
    {
        document.getElementById('hideshow').style.visibility = 'visible'; 
    } 
    else
    { 
        if(document.layers)
        {
            document.hideshow.visibility = 'visible'; 
        } 
        else
        {
            document.all.hideshow.style.visibility = 'visible'; 
        } 
    }
    getInformation(type, baseUrl, token);
}
/*END Information*/
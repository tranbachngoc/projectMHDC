function demthoigian(){
	if(milisec <= 0){
		milisec = 10;
		seconds -= 1;
	}
	if(seconds <= -1){
		milisec = 0;
		seconds += 1;
		
	}else{
		milisec -= 1;
		document.getElementById("txtseconds").value= seconds + "." + milisec;
		setTimeout("demthoigian()",100);
		SaveTime(document.getElementById("txtseconds").value);		
		if(seconds + "." + milisec == 0){
			//alert("Đã hết hạn"
			document.getElementById("Showform").style.display="block";
			document.getElementById("ShowSubForm").style.display="block";
			setTimeout(function(){
			SubmitForm();	
			},10);			
			exit();
		}
	}
}
demthoigian();

function SubmitForm()
{
	
 links='http://localhost/banchuan/xuly/xemketqua.php';
  // window.location.href = "index.php?page=xemkq"
 $.ajax( 
  { 
 type:'POST', url:links, data:$('#frmdethi').serialize(), success: 
 function(response) 
  {             
   setTimeout(function()
   {window.location.href = "index.php";},3000); 
  }
    });
  return false;
}

function SaveTime(time)
{
idmade=document.getElementById("idmade").value;
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	
    //document.getElementById("ketquam").innerHTML=xmlhttp.responseText;
    }
  }

}
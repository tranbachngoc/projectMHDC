var offsetfromcursorX=12; //Customize x offset of tooltip
var offsetfromcursorY=10; //Customize y offset of tooltip

var offsetdivfrompointerX=10; //Customize x offset of tooltip DIV relative to pointer image
var offsetdivfrompointerY=14; //Customize y offset of tooltip DIV relative to pointer image. Tip: Set it to (height_of_pointer_image-1).

document.write('<div id="dhtmltooltip" style="display:none;"></div>'); //write out tooltip DIV
//document.write('<img style="display:none;" id="dhtmlpointer" src="http://www.azibai.com/templates/home/images/arrow_tootips.gif">') //write out pointer image

var ie=document.all;
var ns6=document.getElementById && !document.all;
var enabletip=false;
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : "";

var pointerobj=document.all? document.all["dhtmlpointer"] : document.getElementById? document.getElementById("dhtmlpointer") : "";

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}
//Ham Show Tooltip Co Kich Thuoc - width
function ddrivetip(thetext, thewidth, thecolor){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px";
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor;
tipobj.style.border="1px solid #CCCCCC"//Kieu Cua Khung
tipobj.innerHTML=thetext;
enabletip=true;
return false
};
}
//Ham Show Tooltip Voi width = auto - De Show Anh Khi Xem Detail Product Va Ads
function ddrivetip_image(thetext, theborder, thecolor,id){
if (ns6||ie){
tipobj.style.width="auto"//Chieu Rong Cua Hinh La Auto
tipobj.style.border=theborder + "px solid #CCCCCC"//Kieu Cua Khung
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor;
tipobj.innerHTML='<div class="pro_name">'+jQuery('#name-'+id).val()+'</div><div class="pro_cost">Giá: <span style="color:#A80000;font-weight:bold;">'+jQuery('#price-'+id).html()+'</span>&nbsp;&nbsp;<span>(Lượt xem: '+jQuery('#view-'+id).val()+')</span></div><div class="pro_del">Tại gian hàng:<span style="font-weight:bold; color:#2460D7">'+jQuery('#shop-'+id).val()+'</span></div><div class="pro_del">Vị trí:<span style="font-weight:bold;">'+jQuery('#pos-'+id).val()+'</span>&nbsp;&nbsp;Ngày tham gia:<span style="font-weight:bold;">'+jQuery('#date-'+id).val()+'</span></div><div style="text-align:center">'+thetext+'</div>';
enabletip=true;
return false
};;
}

function ddrivetip_image_1($imgurl){
if (ns6||ie){
tipobj.style.width="auto"//Chieu Rong Cua Hinh La Auto
tipobj.style.border="1px solid #CCCCCC"//Kieu Cua Khung
tipobj.style.backgroundColor='#FFFFFF';
tipobj.innerHTML='<img class="my_img" src="'+$imgurl+jQuery('#style_shop_1').val()+'.png"/>';
enabletip=true;
return false
};;
}

function positiontip(e){
if (enabletip){
var nondefaultpos=false;
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var winwidth=ie&&!window.opera? ietruebody().clientWidth : window.innerWidth-20;
var winheight=ie&&!window.opera? ietruebody().clientHeight : window.innerHeight-20;

var rightedge=ie&&!window.opera? winwidth-event.clientX-offsetfromcursorX : winwidth-e.clientX-offsetfromcursorX;
var bottomedge=ie&&!window.opera? winheight-event.clientY-offsetfromcursorY : winheight-e.clientY-offsetfromcursorY;

var leftedge=(offsetfromcursorX<0)? offsetfromcursorX*(-1) : -1000;

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth){
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=curX-tipobj.offsetWidth+"px";
nondefaultpos=true
}
else if (curX<leftedge)
tipobj.style.left="5px";
else{
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetfromcursorX-offsetdivfrompointerX+"px";
pointerobj.style.left=curX+offsetfromcursorX+"px"
}

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight){
tipobj.style.top=curY-tipobj.offsetHeight-offsetfromcursorY+"px";
nondefaultpos=true
}
else{
tipobj.style.top=curY+offsetfromcursorY+offsetdivfrompointerY+"px";
pointerobj.style.top=curY+offsetfromcursorY+"px"
}
tipobj.style.visibility="visible";
if (!nondefaultpos)
pointerobj.style.visibility="visible";
else
pointerobj.style.visibility="hidden"
}
}
function hideddrivetip(){
if (ns6||ie){
enabletip=false;
tipobj.style.visibility="hidden";
pointerobj.style.visibility="hidden";
tipobj.style.left="-1000px";
tipobj.style.backgroundColor='';
tipobj.style.width=''
}
}
document.onmousemove=positiontip;
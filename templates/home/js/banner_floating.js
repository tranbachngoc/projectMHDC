function FloatTopDiv()
{ startLX = ((window.innerWidth -MainContentW)/2)-LeftBoxW-LeftAdjust, startLY = TopAdjust; startRX = ((window.innerWidth -MainContentW)/2)+MainContentW+RightAdjust, startRY = TopAdjust; var d = document; function ml(id)
{ var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id]; el.sP=function(x,y){this.style.left=x + 'px';this.style.top=y + 'px';}; el.x = startRX; el.y = startRY; return el;}
function m2(id)
{ var e2=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id]; e2.sP=function(x,y){this.style.left=x + 'px';this.style.top=y + 'px';}; e2.x = startLX; e2.y = startLY; return e2;}
window.stayTopLeft=function()
{ if (document.documentElement && document.documentElement.scrollTop)
var pY = document.documentElement.scrollTop; else if (document.body)
	var pY = document.body.scrollTop;
	if (document.body.scrollTop > 0) {
		startLY = TopAdjust;
		startRY = TopAdjust;
	} else {
		startLY = TopAdjust;
		startRY = TopAdjust;
	}
	ftlObj.y += (pY + startRY - ftlObj.y) / fSpeed;
	ftlObj.sP(ftlObj.x, ftlObj.y);
	ftlObj2.y += (pY + startLY - ftlObj2.y) / fSpeed;
	ftlObj2.sP(ftlObj2.x, ftlObj2.y);
	setTimeout("stayTopLeft()", 1);
};
	ftlObj = ml("divAdRight"); ftlObj2 = m2("divAdLeft"); stayTopLeft();}
function ShowAdDiv()
{ var objAdDivRight = document.getElementById("divAdRight"); var objAdDivLeft = document.getElementById("divAdLeft"); 
	if (window.innerWidth < (MainContentW+LeftBoxW+RightBoxW))
	{ objAdDivRight.style.display = "none"; objAdDivLeft.style.display = "none";}
	else
	{ 
		FloatTopDiv();
		displayDiv();
	}
}
function displayDiv(){
	var objRight = document.getElementById("divAdRight"); var objLeft = document.getElementById("divAdLeft");
	objRight.style.display = "block"; 
	objLeft.style.display = "block";
}
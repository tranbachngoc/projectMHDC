function CheckEmail(s)
{
	  //neu email co khoang trang
	 if(s.indexOf(" ")>0)
	 	return false;
	 //neu khong co @
	 if(s.indexOf("@")==-1)
	  	return false;
	 //neu khong co dau cham
	 if(s.indexOf(".")==-1)
	  	return false;
	 //neu co 2 dau cham gan nhau
	 if(s.indexOf("..")>0)
	  	return false;
	 //neu email co 2  @
	 if(s.indexOf("@")!=s.lastIndexOf("@"))
	  	return false;
	 //neu @ va dau cham canh nhau								   
	 if((s.indexOf("@.")!=-1)||(s.indexOf(".@")!=-1))
	 	return false;
	 //neu co @ cuoi cung, neu co @ o dau
	 if((s.indexOf("@")==s.length-1)||(s.indexOf(".")==0))
	 	return false;
	 //neu co dau cham cuoi cung
	 //neu co dau cham o dau
	 if((s.indexOf(".")==s.length-1)||(s.indexOf("@")==0))
	 //neu sau @ khong co dau cham, hoac dau cham o truoc 
		 if(s.indexOf("@")>s.indexOf("."))
			return false;
	 var str="0123456789abcdefghikjlmnopqrstuvwxysz-@._";
	 //neu email co ky tu khong thuoc cac ky tu str
	 for(var i=0;i<s.length;i++)
	 {
		  if(str.indexOf(s.charAt(i))==-1)
		  	return false;
	 } 
	 return true;
}
// JavaScript Document
function storeCaret(ftext){
	if (ftext.createTextRange){
		ftext.caretPos = document.selection.createRange().duplicate();
	}
}
function addEmoticons(myEmoticon,id){
	var myArea = document.getElementById(id);
	if(typeof(myArea) == "undefined"){
		alert("You need defined variable 'myArea' !");
		return;
	}
	//crappy browser sniffer
	var isFF = false;
	var textSelected = false;
	var begin,selection,end;
	//Check trinh duyet
	if(navigator.userAgent.toLowerCase().indexOf("firefox") > 0){
		isFF = true;
	}
	 if(navigator.userAgent.toLowerCase().indexOf("chrome") > 0){
  isFF = true;
 }
	//thiet lap thong tin ve textarea
	//var myArea = document.getElementById("dt_description");
	var start_selection = myArea.value.length;
	
	//Neu la FF
	if (isFF == true){
		if (myArea.selectionStart!= undefined){
			start_selection = myArea.selectionStart;
		}
		//set begin end
		begin = myArea.value.substr(0, start_selection);
		selection = 0;
		end = myArea.value.substr(start_selection);
		
		//Luu lai scrollpos
		var scrollpos = myArea.scrollTop;
		
		myArea.value = begin + myEmoticon + end;
		//gan lai con tro
		myArea.setSelectionRange(start_selection + myEmoticon.length,start_selection + myEmoticon.length);
		myArea.scrollTop = scrollpos;
		
		myArea.focus();
		
	}
	else if (document.selection){ //Neu la IE 
		myArea.focus();
		//Lay vi tri con tro
		cursor = document.selection.createRange();
		cursor.text = myEmoticon + cursor.text;	
	}
	//Các loại trình duyệt khác
	else{
			myArea.value+=myEmoticon;
			myArea.focus();
	}
}

function addArticleCode(t,id){
	var myArea = document.getElementById(id);
	if(typeof(myArea) == "undefined"){
		alert("You need defined variable 'myArea' !");
		return;
	}
	//crappy browser sniffer
	var isFF = false;
	var textSelected = false;
	//Check trinh duyet
	if(navigator.userAgent.toLowerCase().indexOf("firefox") > 0){
		isFF = true;
	}
	 if(navigator.userAgent.toLowerCase().indexOf("chrome") > 0){
	  isFF = true;
	 }
	//thiet lap thong tin ve textarea
	//var myArea = document.getElementById("dt_description");
	
	var begin,selection,end;
	if (isFF == true){
		if (myArea.selectionStart!= undefined){
			begin = myArea.value.substr(0, myArea.selectionStart);
			selection = myArea.value.substr(myArea.selectionStart, myArea.selectionEnd - myArea.selectionStart);
			end = myArea.value.substr(myArea.selectionEnd);
			if (selection.length > 0){
				textSelected = true;
			}
		}
	}else{
		//var element = document.getElementById('description_download');
		if( document.selection ){
			// The current selection
			var range = document.selection.createRange();
			// We'll use this as a 'dummy'
			var stored_range = range.duplicate();
			// Kiem tra xem co > 0 hay ko
			if (stored_range.text.length > 0){
				stored_range.moveToElementText(myArea);
				// Now move 'dummy' end point to end point of original range
				stored_range.setEndPoint( 'EndToEnd', range );
				// Now we can calculate start and end points
				myArea.selectionStart = stored_range.text.length - range.text.length;
				myArea.selectionEnd = myArea.selectionStart + range.text.length;
				//set begin - end string
				begin = myArea.value.substr(0, myArea.selectionStart);
				selection = myArea.value.substr(myArea.selectionStart, myArea.selectionEnd - myArea.selectionStart);
				end = myArea.value.substr(myArea.selectionEnd);
				
				textSelected = true;
			}
			//alert(element.selectionStart);
		}
	}
	//neu selected text 
	if(textSelected == true){
		//Luu lai scrollpos
		if (isFF == true) var scrollpos = myArea.scrollTop;
		
		startTag=t;
		endTag = t.replace('[', '[/');
		myArea.value = begin + startTag + selection + endTag + end;
		
		if (isFF == true){
			
			//dinh dang lai vi tri con tro
			myArea.setSelectionRange(begin.length,begin.length);
			myArea.scrollTop = scrollpos;
			
		}
		myArea.focus();
		
	}
	if(textSelected == false){
		alert("Vui lòng chọn chuổi text cần định dạng!");
	}
}

function addLink(id){
	
	var myArea = document.getElementById(id);
	if(typeof(myArea) == "undefined"){
		alert("You need defined variable 'myArea' !");
		return;
	}
	//crappy browser sniffer
	var isFF = false;
	var textSelected = false;
	var begin,selection,end;
	var linkName = "";
	//Check trinh duyet
	if(navigator.userAgent.toLowerCase().indexOf("firefox") > 0){
		isFF = true;
	}
	 if(navigator.userAgent.toLowerCase().indexOf("chrome") > 0){
  isFF = true;
 }
	//thiet lap thong tin ve textarea
	//var myArea = document.getElementById("dt_description");
	var start_selection = myArea.value.length;
	
	//Kiểm tra xem link name có chưa
	//Nếu là FF
	if (isFF == true){
		if (myArea.selectionStart!= undefined){
			selection_text = myArea.value.substr(myArea.selectionStart, myArea.selectionEnd - myArea.selectionStart);
			//Nếu có selection_text thì gán luôn cho linkName
			if (selection_text.length > 0){
				linkName = selection_text;
			}
		}
	}
	else if( document.selection ){
		// The current selection
		var range = document.selection.createRange();
		// We'll use this as a 'dummy'
		var stored_range = range.duplicate();
		// Kiem tra xem co > 0 hay ko
		if (stored_range.text.length > 0){
			linkName = stored_range.text;
		}
	}
	//Kết thúc kiểm tra linkName
	
	//Nếu linkName mà bằng rỗng thi bật popup lên hỏi
	if (linkName == "") linkName = window.prompt("Bạn hãy nhập vào chuỗi text hiển thị cho link", "");
	
	linkURL		= window.prompt("Bạn hãy nhập vào đường link đầy đủ", "http://");
	linkValue	= "";
	if(linkURL != null){
		if(check_url(linkURL) == 1){
			linkValue = (linkName != "") ? "[url=" + linkURL + "]" + linkName + "[/url]" : "[url=" + linkURL + "]" + linkURL + "[/url]";
		}
		else{
			alert("Link bạn nhập không hợp lệ.");
			return false;
		}
	}
	else return false;
	
	//Neu la FF
	if (isFF == true){
		if (myArea.selectionStart!= undefined){
			//Lấy đầu và cuối của selection
			start_selection = myArea.selectionStart;
			end_selection = myArea.selectionEnd;
		}
		//set begin end
		begin = myArea.value.substr(0, start_selection);
		selection = 0;
		end = myArea.value.substr(end_selection);
		
		//Luu lai scrollpos
		var scrollpos	= myArea.scrollTop;
		
		myArea.value	= begin + linkValue + end;
		//gan lai con tro
		myArea.setSelectionRange(start_selection + linkValue.length,start_selection + linkValue.length);
		myArea.scrollTop	= scrollpos;
		
		myArea.focus();
		
	}
	else if (document.selection){ //Neu la IE 
		myArea.focus();
		//Lay vi tri con tro
		cursor = document.selection.createRange();
		cursor.text = linkValue;	
	}
	//Các loại trình duyệt khác
	else{
		myArea.value+=linkValue;
		myArea.focus();
	}
	
}

function check_url(tring){
	var v = new RegExp();
	v.compile("^[A-Za-z]+://[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=:;!~\(\)]+$");
	//v.compile("^[A-Za-z]+://[A-Za-z0-9-_]+\\.[A-Za-z0-9-_~!@\#\$%\&\*\(\)\-+=\/.\<\>:;\"\'\\]+$");
	//v.compile("^[(http|https)]+://[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=]+$");
	//([a-z]+?://){1}([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+\(\)]+)\
	if(!v.test(tring)) return false;
	return true;
}
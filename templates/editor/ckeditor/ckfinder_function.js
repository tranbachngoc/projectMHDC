/**
 *  ckfinder function
 *
 * @package XGO CMS v3.0
 * @subpackage ckfinder
 * @link http://sunsoft.vn
 */

var myWin;
var myFieldName;
var imageElement;
var ckeditoryPath = baseUrl + 'third_party/ckfinder/';

function openCKFinder(fieldName, url, type, win) {	
    tinyMCE.activeEditor.windowManager.open({
    	file: ckeditoryPath+'ckfinder.html?type=Images',
        title : 'CKFinder',
		width: 700,
		height: 500,
		resizable: "yes",
		inline: true,
		close_previous: "no",
		popup_css: false
    }, {
        window : win,
        input : fieldName
    });
    return false;
}

function ckFileBrowser(fieldName, url, type, win) {
	myWin = win;
	myFieldName = fieldName;
	 
    // You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
 
	// The path for the installation of CKFinder (default = "/ckfinder/").
	finder.basePath = ckeditoryPath;
 
	// Name of a function which is called when a file is selected in CKFinder.
	finder.selectActionFunction = SetFileField;
	
	// Additional data to be passed to the selectActionFunction in a second argument.
	// We'll use this feature to pass the Id of a field that will be updated.
	finder.selectActionData = fieldName;
 
	// Launch CKFinder
	finder.popup();
  }

function SetFileField(fileUrl, data){
	console.log(fileUrl);
	$("#"+data.selectActionData).val(fileUrl);
}

function imageManager(element) {
	imageElement = element;
    // You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
 
	// The path for the installation of CKFinder (default = "/ckfinder/").
	finder.basePath = ckeditoryPath;
 
	// Name of a function which is called when a file is selected in CKFinder.
	finder.selectActionFunction = imageManagerSetFileField;
 
	// Additional data to be passed to the selectActionFunction in a second argument.
	// We'll use this feature to pass the Id of a field that will be updated.
	//finder.selectActionData = field_name;
 
	// Launch CKFinder
	finder.popup();
}

function imageManagerSetFileField(fileUrl, data){
	imageElement.val(fileUrl);
}
<?php
	header('Content-Type: application/json');
	define ('SITE_ROOT', realpath(dirname(__FILE__)));

	if (!isset($_FILES['image']) || !isset($_POST['type'])) {
		http_response_code(400);
		echo json_encode(['msg' => 'Missing Params']);
		return;
	}

	$dir_image = isset($_POST['dir_image']) ? $_POST['dir_image'] : date('dmY');
	$type = $_POST['type'];

	$errors= array();
	$file_size =$_FILES['image']['size'];
	$file_tmp =$_FILES['image']['tmp_name'];
	$file_type=$_FILES['image']['type'];
	$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

	$expensions= array("jpeg","jpg","png");

	if(in_array($file_ext, $expensions)=== false){
		$errors="extension not allowed, please choose a JPEG or PNG file.";
	}

	if($file_size > 2097152){
		$errors='File size must be excately 2 MB';
	}

	$file_name = md5(generateRandomString()).'.'.$file_ext;

	if(empty($errors)==true){
		$path = getUploadsRoot($type, $dir_image);
		if (!file_exists($path)) {
			mkdir($path, 0755, true);
		}

		move_uploaded_file($file_tmp, $path.'/'.$file_name);
		echo json_encode(['msg' => 'Success',
			'data' => [
				'image' => $file_name,
				'dir_image' => $dir_image,
				'type' => $type
				]
			]);
	} else{
		http_response_code(400);
		echo json_encode(['msg' => $errors]);
	}

	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function getUploadsRoot($type, $dir_image = null) {
        switch ($type) {
            case 'tintuc':
                return SITE_ROOT . DIRECTORY_SEPARATOR . 'images/tintuc/'.$dir_image;
                break;
            case 'avatar':
                return SITE_ROOT . DIRECTORY_SEPARATOR . 'images/avatar';
                break;
            case 'shop_logos':
                return SITE_ROOT . DIRECTORY_SEPARATOR . 'shop/logos/'.$dir_image;
                break;
            case 'shop_banners':
                return SITE_ROOT . DIRECTORY_SEPARATOR . 'shop/banners/'.$dir_image;
                break;
            default:
                # code...
                break;
        }
    }
?>
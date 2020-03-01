<?php
namespace App\Http\Controllers\Api;

use Anchu\Ftp\Facades\Ftp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Swagger\Util;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\User;
use Lang;
use App\Helpers\Utils;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;
class UtilController extends ApiController {

    /**
     * @SWG\Post(
     *     path="utils/uploads/images",
     *     operationId="uploadsImages",
     *     description="customer upload avatar",
     *     tags={"Utils"},
     *     produces={"multipart/form-data"},
     *     @SWG\Parameter(
     *         name="image",
     *         in="body",
     *         description="image",
     *         required=true,
     *         type="file"
     *     ),
     *     @SWG\Parameter(
     *         name="type",
     *         in="body",
     *         description="type, in:tintuc,avatar,shop_logos,shop_banners,product,staff",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="dir_image",
     *         in="body",
     *         description="dir_image, default dormat date: dmY",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="success"
     *     )
     * )
     */
    public function uploads_backup(Request $req) {
        $validator = Validator::make($req->all(), [
            'image' => 'required|Image',
            'type' => 'required|string|in:tintuc,avatar,shop_logos,shop_banners,product,staff',
            'dir_image' => 'string'
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $dir_image = $req->dir_image ? $req->dir_image : date('dmY');
        // upload path
        $fileName = Utils::randomFilename() . '.' .$req->image->extension(); // renameing image
      
        $pathUpload = Utils::getUploadsRoot($req->type, $dir_image);
        $req->image->move($pathUpload, $fileName);
        if($req->type == 'shop_logos'){
            $image_resize = Image::make($pathUpload . DIRECTORY_SEPARATOR. $fileName);
            $image_resize->resize(120, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize->save($pathUpload . DIRECTORY_SEPARATOR  . $fileName, null);
        }
        if ($req->type == 'avatar') {
           
            $image_resize = Image::make($pathUpload . DIRECTORY_SEPARATOR. $fileName);
            $image_resize->resize(120, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize->save($pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_' . $fileName, null);
        }
        if ($req->type == 'product') {
         
            $image_resize = Image::make($pathUpload . DIRECTORY_SEPARATOR . $fileName);
            $image_resize->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize->save($pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_1_' . $fileName, null);

            $image_resize1 = Image::make($pathUpload . DIRECTORY_SEPARATOR . $fileName);
            $image_resize1->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize1->save($pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_2_' . $fileName, null);
            $image_resize2 = Image::make($pathUpload . DIRECTORY_SEPARATOR . $fileName);
            $image_resize2->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize2->save($pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_3_' . $fileName, null);
        }
        if ($req->type == 'tintuc') {
            $image_resize = Image::make($pathUpload . DIRECTORY_SEPARATOR . $fileName);
            $image_resize->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize->save($pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_1_' . $fileName, null);

            $image_resize1 = Image::make($pathUpload . DIRECTORY_SEPARATOR . $fileName);
            $image_resize1->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize1->save($pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_2_' . $fileName, null);
            $image_resize2 = Image::make($pathUpload . DIRECTORY_SEPARATOR . $fileName);
            $image_resize2->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize2->save($pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_3_' . $fileName, null);
        }

//        $thump1 = 'thumbnail_1_' . $fileName;
//        $thump2 = 'thumbnail_2_' . $fileName;
//        $thump3 = 'thumbnail_3_' . $fileName;
//        $image_resize = Image::make($req->image->getRealPath());
//        $image_resize->resize(100,function ($constraint) {
//            $constraint->aspectRatio();
//        });
//        $image_resize->save($pathUpload .$thump1, null, function ($constraint) {
//            $constraint->aspectRatio();
//        });
//        
//        $image_resize2 = Image::make($req->image->getRealPath());
//
//         $image_resize2->resize(300, function ($constraint) {
//            $constraint->aspectRatio();
//        });
//        $image_resize = Image::make($req->image->getRealPath());
//        $image_resize->resize(600, 300);
//        $image_resize->save($pathUpload .$thump1, null, function ($constraint) {
//            $constraint->aspectRatio();
//        });
        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'image' => $fileName,
                'dir_image' => $dir_image,
                'type' => $req->type
            ]
        ]);
    }

    public function uploads(Request $req) {
        $validator = Validator::make($req->all(), [
            'image' => 'required|Image',
            'type' => 'required|string|in:tintuc,avatar,shop_logos,shop_banners,product,staff',
            'dir_image' => 'string'
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $dir_image = $req->dir_image ? $req->dir_image : date('dmY');
        // upload path
        $fileName = Utils::randomFilename() . '.' .$req->image->extension(); // renameing image

        // FTP path
        $pathUpload = Utils::getUploadsRootFTP($req->type, $dir_image);
        $filePath = $pathUpload.DIRECTORY_SEPARATOR.$fileName;

        //Local Path
        $temp_dir = Utils::getUploadsRoot($req->type, $dir_image);
        $fileTempPath = $temp_dir.DIRECTORY_SEPARATOR.$fileName;

        //Save temp in local
        $req->image->move($temp_dir, $fileName);

        //Save to FTP server
        Utils::uploadFileToFTP($fileTempPath, $filePath);

        if($req->type == 'shop_logos'){
            $image_resize = Image::make($fileTempPath);
            $image_resize->resize(120, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize->save($fileTempPath, null);

            //Save to FTP server
            Utils::uploadFileToFTP($fileTempPath, $filePath);
        }

        if ($req->type == 'avatar') {

            $image_resize = Image::make($fileTempPath);
            $image_resize->resize(120, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            //Save file to local temp dir
            $filePathLocal = $temp_dir . DIRECTORY_SEPARATOR . 'thumbnail_' . $fileName;
            $image_resize->save($filePathLocal, null);

            //Save to FTP server
            $filePathFTP = $pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_' . $fileName;
            Utils::uploadFileToFTP($filePathLocal, $filePathFTP);
            //Delete temp file
            unlink($filePathLocal);
        }

        if ($req->type == 'product') {

            $image_resize = Image::make($fileTempPath);
            $image_resize->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            //Save file to local temp dir
            $filePathLocal = $temp_dir . DIRECTORY_SEPARATOR . 'thumbnail_1_' . $fileName;
            $image_resize->save($filePathLocal, null);
            //Save to FTP server
            $filePathFTP = $pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_1_' . $fileName;
            Utils::uploadFileToFTP($filePathLocal, $filePathFTP);
            unlink($filePathLocal);


            $image_resize1 = Image::make($fileTempPath);
            $image_resize1->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            //Save file to local temp dir
            $filePathLocal = $temp_dir . DIRECTORY_SEPARATOR . 'thumbnail_2_' . $fileName;
            $image_resize1->save($filePathLocal, null);
            //Save to FTP server
            $filePathFTP = $pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_2_' . $fileName;
            Utils::uploadFileToFTP($filePathLocal, $filePathFTP);
            unlink($filePathLocal);


            $image_resize2 = Image::make($fileTempPath);
            $image_resize2->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            //Save file to local temp dir
            $filePathLocal = $temp_dir . DIRECTORY_SEPARATOR . 'thumbnail_3_' . $fileName;
            $image_resize2->save($filePathLocal, null);
            //Save to FTP server
            $filePathFTP = $pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_3_' . $fileName;
            Utils::uploadFileToFTP($filePathLocal, $filePathFTP);
            unlink($filePathLocal);
        }

        if ($req->type == 'tintuc') {

            $image_resize = Image::make($fileTempPath);
            $image_resize->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            //Save file to local temp dir
            $filePathLocal = $temp_dir . DIRECTORY_SEPARATOR . 'thumbnail_1_' . $fileName;
            $image_resize->save($filePathLocal, null);
            //Save to FTP server
            $filePathFTP = $pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_1_' . $fileName;
            Utils::uploadFileToFTP($filePathLocal, $filePathFTP);
            unlink($filePathLocal);


            $image_resize1 = Image::make($fileTempPath);
            $image_resize1->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            //Save file to local temp dir
            $filePathLocal = $temp_dir . DIRECTORY_SEPARATOR . 'thumbnail_2_' . $fileName;
            $image_resize1->save($filePathLocal, null);
            //Save to FTP server
            $filePathFTP = $pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_2_' . $fileName;
            Utils::uploadFileToFTP($filePathLocal, $filePathFTP);
            unlink($filePathLocal);


            $image_resize2 = Image::make($fileTempPath);
            $image_resize2->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            //Save file to local temp dir
            $filePathLocal = $temp_dir . DIRECTORY_SEPARATOR . 'thumbnail_3_' . $fileName;
            $image_resize2->save($filePathLocal, null);
            //Save to FTP server
            $filePathFTP = $pathUpload . DIRECTORY_SEPARATOR . 'thumbnail_3_' . $fileName;
            Utils::uploadFileToFTP($filePathLocal, $filePathFTP);
            unlink($filePathLocal);
        }

        //Delete file Local
        unlink($fileTempPath);

        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'image' => $fileName,
                'dir_image' => $dir_image,
                'type' => $req->type
            ]
        ]);
    }

     /**
     * @SWG\Post(
     *     path="utils/uploads/file",
     *     operationId="uploadFile",
     *     description="customer upload file",
     *     tags={"Utils"},
     *     produces={"multipart/form-data"},
     *     @SWG\Parameter(
     *         name="image",
     *         in="body",
     *         description="file",
     *         required=true,
     *         type="file"
     *     ),
     *     @SWG\Parameter(
     *         name="type",
     *         in="body",
     *         description="type, in:word,excel,pdf",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="dir_image",
     *         in="body",
     *         description="dir_image, default dormat date: dmY",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="success"
     *     )
     * )
     */
    public function uploadsFile_backup(Request $req) {
        $rule = [
            'file'=>[
                'required',
            ],
            'type'=>'required|string|in:word,excel,pdf',
            'dir_image'=>'string'
        ];
         if ($req->type == 'word') {
            $rule['file'][] = 'mimes:docx,doc';
        }
        if ($req->type == 'excel') {
            $rule['file'][] = 'mimes:xlsx,xlsx';
        }
        if ($req->type == 'pdf') {
            $rule['file'][] = 'mimes:pdf';
        }

        $validator = Validator::make($req->all(), $rule);
        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
                ], 422);
        }
        $dir_image = $req->dir_image ? $req->dir_image : date('dmY');
        // upload path
        $fileName = Utils::randomFilename() . '.' . $req->file->extension(); // renameing image

        $pathUpload = Utils::getUploadsRoot($req->type, $dir_image);

        $req->file->move($pathUpload, $fileName);
        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'file' => $fileName,
                'dir_file' => $dir_image,
                'type' => $req->type
            ]
        ]);
    }

    public function uploadsFile(Request $req) {
        $rule = [
            'file'=>[
                'required',
            ],
            'type'=>'required|string|in:word,excel,pdf',
            'dir_image'=>'string'
        ];
        if ($req->type == 'word') {
            $rule['file'][] = 'mimes:docx,doc';
        }
        if ($req->type == 'excel') {
            $rule['file'][] = 'mimes:xlsx,xlsx';
        }
        if ($req->type == 'pdf') {
            $rule['file'][] = 'mimes:pdf';
        }

        $validator = Validator::make($req->all(), $rule);
        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }
        $dir_image = $req->dir_image ? $req->dir_image : date('dmY');
        // upload path
        $fileName = Utils::randomFilename() . '.' . $req->file->extension(); // renameing image

        $pathUpload = Utils::getUploadsRootFTP($req->type, $dir_image);

        Utils::uploadFileToFTP($req->file, $pathUpload.DIRECTORY_SEPARATOR.$fileName);
        return response([
            'msg' => Lang::get('response.success'),
            'data' => [
                'file' => $fileName,
                'dir_file' => $dir_image,
                'type' => $req->type
            ]
        ]);
    }

      /**
     * @SWG\Post(
     *     path="utils/uploads/file",
     *     operationId="uploadFile",
     *     description="customer upload file",
     *     tags={"Utils"},
     *     produces={"multipart/form-data"},
     *     @SWG\Parameter(
     *         name="image",
     *         in="body",
     *         description="file",
     *         required=true,
     *         type="file"
     *     ),
     *     @SWG\Parameter(
     *         name="type",
     *         in="body",
     *         description="type, in:word,excel,pdf",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="dir_image",
     *         in="body",
     *         description="dir_image, default dormat date: dmY",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="success"
     *     )
     * )
     */
    public function GetUserIDFromUsername(Request $req) {
        $facebook = $req->facebookUrl;
 
        $correctURLPattern = '/^https?:\/\/(?:www|m)\.facebook.com\/(?:profile\.php\?id=)?([a-zA-Z0-9\.]+)$/';
        if (!preg_match($correctURLPattern, $facebook, $matches)) {
            return response([
                'msg' => 'Not a valid URL'
                ], 422);
        }
     
        $http = str_replace($matches[1], '', $matches[0]);
        

        // For some reason, changing the user agent does expose the user's UID
        $options = array('http' => array('user_agent' => 'some_obscure_browser'));
        $context = stream_context_create($options);
        $fbsite = file_get_contents($facebook, false, $context);

        // ID is exposed in some piece of JS code, so we'll just extract it
        $fbIDPattern = '/"entity_id":"(\d+)"/';
        if (!preg_match($fbIDPattern, $fbsite, $matches)) {
            return response([
                'msg' => 'Unofficial API is broken or user not found'
                ], 422);
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => ['link'=>$http.$matches[1],'id'=>$matches[1]]
        ]);
    }



}
<?php
namespace App\Helpers;

use Anchu\Ftp\Facades\Ftp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Utils {
    /**
     * generate redis cache key from jwt payload
     *
     * @param array $payload
     * @return string
     */
    public static function createAuthCacheKey($payload) {
        if ($payload['type'] == 'driver') {
            $key = 'DRIVER_';
        } else {
            $key = 'CUSTOMER_';
        }
        return $key . $payload['token'];
    }

    /**
     * Add query string into existing url
     *
     * @param String $url
     * @param String $key
     * @param String $value
     * @return String new url
     */
    public static function addQueryParam($url, $key, $value) {
        $query = $key . '=' . urlencode($value);
        $parsedUrl = parse_url($url);
        if ($parsedUrl['path'] == null) {
           $url .= '/';
        }
        $separator = ($parsedUrl['query'] == NULL) ? '?' : '&';
        return $url . $separator . $query;
    }

    public static function getUploadsRoot($type, $dir_image = null) {
        switch ($type) {
            case 'tintuc':
                return env("UPLOAD_URL") . DIRECTORY_SEPARATOR . 'images/tintuc/' . $dir_image;
                break;
            case 'chat_media':

                return env("UPLOAD_URL") . DIRECTORY_SEPARATOR . '/' . $dir_image;
                break;

            case 'profiles':

                return env("UPLOAD_URL") . DIRECTORY_SEPARATOR . '/' . $dir_image;
                break;

            case 'avatar':
                return env("UPLOAD_URL") . DIRECTORY_SEPARATOR . 'images/avatar';
                break;
            case 'shop_logos':
                return env("UPLOAD_URL") . DIRECTORY_SEPARATOR . 'shop/logos/' . $dir_image;
                break;
            case 'shop_banners':
                return env("UPLOAD_URL") . DIRECTORY_SEPARATOR . 'shop/banners/' . $dir_image;
                break;
            case 'staff':
                return env("UPLOAD_URL") . DIRECTORY_SEPARATOR . 'images/' . $type . '/' . $dir_image;
                break;
            case 'product':
                return env("UPLOAD_URL") . DIRECTORY_SEPARATOR . 'images/product/' . $dir_image;
                break;
            case'word':
                $excelPath = env("UPLOAD_URL") . DIRECTORY_SEPARATOR . 'word';
                if (!is_dir($excelPath)) {
                    mkdir($excelPath, 0755);
                }
                $excelPath = $excelPath . DIRECTORY_SEPARATOR . 'staff';
                if (!is_dir($excelPath)) {
                    mkdir($excelPath, 0755);
                }
                $excelPath = $excelPath . DIRECTORY_SEPARATOR . $dir_image;
                if (!is_dir($excelPath)) {
                    mkdir($excelPath, 0755);
                    // File::append($excelPath.'/index.html', 'contents');
                }
                return env("UPLOAD_URL") . DIRECTORY_SEPARATOR . 'word/staff/' . $dir_image;
                break;
            case'excel':
                $excelPath = env("UPLOAD_URL") . DIRECTORY_SEPARATOR . 'excel';
                if (!is_dir($excelPath)) {
                    mkdir($excelPath, 0755);
                }
                $excelPath = $excelPath . DIRECTORY_SEPARATOR . 'staff';
                if (!is_dir($excelPath)) {
                    mkdir($excelPath, 0755);
                }
                $excelPath = $excelPath . DIRECTORY_SEPARATOR . $dir_image;
                if (!is_dir($excelPath)) {
                    mkdir($excelPath, 0755);
                   // File::append($excelPath.'/index.html', 'contents');
                }
                return $excelPath;
                break;
            case'pdf':
                $excelPath = env("UPLOAD_URL") . DIRECTORY_SEPARATOR . 'pdf';
                if (!is_dir($excelPath)) {
                    mkdir($excelPath, 0755);
                }
                $excelPath = $excelPath . DIRECTORY_SEPARATOR . 'staff';
                if (!is_dir($excelPath)) {
                    mkdir($excelPath, 0755);
                }
                $excelPath = $excelPath . DIRECTORY_SEPARATOR . $dir_image;
                if (!is_dir($excelPath)) {
                    mkdir($excelPath, 0755);
                    // File::append($excelPath.'/index.html', 'contents');
                }
                return env("UPLOAD_URL") . DIRECTORY_SEPARATOR . 'pdf/staff/' . $dir_image;
            default:

                # code...
                break;
        }
    }

    public static function getUploadsRootFTP($type, $dir_image = null) {

        switch ($type) {
            case 'tintuc':

                $path = "images";
                self::makeDirFTP($path);

                $path.= DIRECTORY_SEPARATOR."content";
                self::makeDirFTP($path);

                $path.= DIRECTORY_SEPARATOR.$dir_image;
                self::makeDirFTP($path);

                return $path;

            case 'profiles':

                self::makeDirFTP($dir_image);

                return $dir_image;

            case 'chat_media':

                self::makeDirFTP($dir_image);

                return $dir_image;

            case 'avatar':

                $path = "images";
                self::makeDirFTP($path);

                $path .= DIRECTORY_SEPARATOR."avatar";
                self::makeDirFTP($path);

                return $path;

            case 'shop_logos':

                $path = "shop";
                self::makeDirFTP($path);

                $path .= DIRECTORY_SEPARATOR."logos";
                self::makeDirFTP($path);

                $path .= DIRECTORY_SEPARATOR.$dir_image;
                self::makeDirFTP($path);

                return $path;

            case 'shop_banners':

                $path = "shop";
                self::makeDirFTP($path);

                $path .= DIRECTORY_SEPARATOR."banners";
                self::makeDirFTP($path);

                $path .= DIRECTORY_SEPARATOR.$dir_image;
                self::makeDirFTP($path);

                return $path;

            case 'staff':

                $path = "images";
                self::makeDirFTP($path);

                $path .= DIRECTORY_SEPARATOR.$type;
                self::makeDirFTP($path);

                $path .= DIRECTORY_SEPARATOR.$dir_image;
                self::makeDirFTP($path);

                return $path;

            case 'product':

                $path = "images";
                self::makeDirFTP($path);

                $path .= DIRECTORY_SEPARATOR."product";
                self::makeDirFTP($path);

                $path .= DIRECTORY_SEPARATOR.$dir_image;
                self::makeDirFTP($path);

                return $path;

            case'word':

                $wordPath = 'word';
                self::makeDirFTP($wordPath);

                $wordPath = $wordPath . DIRECTORY_SEPARATOR . 'staff';
                self::makeDirFTP($wordPath);

                $wordPath = $wordPath . DIRECTORY_SEPARATOR . $dir_image;
                self::makeDirFTP($wordPath);

                return $wordPath;

            case'excel':

                $excelPath = 'excel';
                self::makeDirFTP($excelPath);

                $excelPath = $excelPath . DIRECTORY_SEPARATOR . 'staff';
                self::makeDirFTP($excelPath);

                $excelPath = $excelPath . DIRECTORY_SEPARATOR . $dir_image;
                self::makeDirFTP($excelPath);

                return $excelPath;

            case'pdf':
                $excelPath = 'pdf';
                self::makeDirFTP($excelPath);

                $excelPath = $excelPath . DIRECTORY_SEPARATOR . 'staff';
                self::makeDirFTP($excelPath);

                $excelPath = $excelPath . DIRECTORY_SEPARATOR . $dir_image;
                self::makeDirFTP($excelPath);

                return $excelPath;

            default:
                # code...
                break;
        }
    }

    public static function randomFilename() {
        return md5(str_random());
    }


    static function showThumbnail($path = '', $image = '', $thumb = 1, $type = 'product') {
        $image = explode(',', $image);
        if (empty($image[0])) {
            return $image[0];
        }
        $pathThumbnail = env("UPLOAD_URL") . '/images/' . $type . '/' . $path . '/thumbnail_' . $thumb . '_' . $image[0];
        if (file_exists($pathThumbnail)) {
            return 'thumbnail_' . $thumb . '_' . $image[0];
        } else {
            return $image[0];
        }
    }

    public static function getThumnailFromYouUrl($url){
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
        $id = isset($matches[1]) ? $matches[1] : "";
        return "https://img.youtube.com/vi/".$id."/0.jpg";
    }

    public static function makeDirFTP($dir_name) {
        FTP::connection()->makeDir(env('FTP_PATH').DIRECTORY_SEPARATOR.$dir_name);
        FTP::connection()->permission(0777, env('FTP_PATH').DIRECTORY_SEPARATOR.$dir_name);
    }

    public static function uploadFileToFTP($file, $path) {
        FTP::connection()->uploadFile($file, env('FTP_PATH').DIRECTORY_SEPARATOR.$path);
        FTP::connection()->permission(0777, env('FTP_PATH').DIRECTORY_SEPARATOR.$path);
    }

}
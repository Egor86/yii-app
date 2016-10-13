<?php
namespace common\helpers;
ini_set('memory_limit', '-1');


use Yii;
use yii\web\UploadedFile;
use yii\web\HttpException;
use yii\helpers\FileHelper;

class Image
{
    public static function upload(UploadedFile $fileInstance, $alias, $dir = '', $resizeWidth = null, $resizeHeight = null, $resizeCrop = false)
    {
        $fileName = Upload::getUploadPath($dir, $alias) . DIRECTORY_SEPARATOR . Upload::getFileName($fileInstance);

        $uploaded = $resizeWidth
            ? self::copyResizedImage($fileInstance->tempName, $fileName, $resizeWidth, $resizeHeight, $resizeCrop)
            : $fileInstance->saveAs($fileName);

        if (!$uploaded) {
            throw new HttpException(500, 'Cannot upload file "' . $fileName . '". Please check write permissions.');
        }

        return Upload::getLink($fileName, $alias);
    }

    static function thumb($filename, $alias, $width = null, $height = null, $crop = true)
    {
        if ($filename && is_file(($filePath =  $alias . $filename))) {
            $info = pathinfo($filePath);
            $thumbName = $info['filename'] . '-' . md5(filemtime($filePath) . (int)$width . (int)$height . (int)$crop) . '.' . $info['extension'];

            $thumbFile = $info['dirname'] . DIRECTORY_SEPARATOR . $info['filename']. DIRECTORY_SEPARATOR . $thumbName;
            $thumbWebFile =  str_replace($info['basename'], '', $filename) .$info['filename']. '/' . $thumbName;

            if (file_exists($thumbFile)) {
                return $thumbWebFile;
            } elseif (FileHelper::createDirectory(dirname($thumbFile), 0777) && self::copyResizedImage($filePath, $thumbFile, $width, $height, $crop)) {
                return $thumbWebFile;
            }
        }
        return '';
    }

    static function copyResizedImage($inputFile, $outputFile, $width, $height = null, $crop = true)
    {
        if (extension_loaded('gd')) {
            $image = new GD($inputFile);

            if ($height) {
                if ($width && $crop) {
                    $image->cropThumbnail($width, $height);
                } else {
                    $image->resize($width, $height);
                }
            } else {
                $image->resize($width);
            }
            return $image->save($outputFile);
        } elseif (extension_loaded('imagick')) {
            $image = new \Imagick($inputFile);

            if ($height && !$crop) {
                $image->resizeImage($width, $height, \Imagick::FILTER_LANCZOS, 1, true);
            } else {
                $image->resizeImage($width, null, \Imagick::FILTER_LANCZOS, 1);
            }

            if ($height && $crop) {
                $image->cropThumbnailImage($width, $height);
            }

            return $image->writeImage($outputFile);
        } else {
            throw new HttpException(500, 'Please install GD or Imagick extension');
        }
    }
}
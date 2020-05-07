<?php

namespace XoopsModules\Wggallery\Common;

/**
 * SystemFineImUploadHandler class to work with ajaxfineupload.php endpoint
 * to facilitate uploads for the system image manager
 *
 * Do not use or reference this directly from your client-side code.
 * Instead, this should be required via the endpoint.php or endpoint-cors.php
 * file(s).
 *
 * @license   MIT License (MIT)
 * @copyright Copyright (c) 2015-present, Widen Enterprises, Inc.
 * @link      https://github.com/FineUploader/php-traditional-server
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2015-present, Widen Enterprises, Inc.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

use XoopsModules\Wggallery;
use XoopsModules\Wggallery\Constants;

/**
 * Class FineimpuploadHandler
 * @package XoopsModules\Wggallery
 */
class FineimpuploadHandler extends \SystemFineUploadHandler
{
    /**
     * @var int
     */
    private $permUseralbum = 0;
    /**
     * @var int
     */
    private $imageId = 0;
    /**
     * @var string
     */
    private $imageOrigName = null;
    /**
     * @var string
     */
    private $imageName = null;
    /**
     * @var string
     */
    private $imageNameLarge = null;
    /**
     * @var string
     */
    private $imageNicename = null;
    /**
     * @var string
     */
    private $imagePath = null;
    /**
     * @var string
     */
    private $imageNameOrig = null;
    /**
     * @var string
     */
    private $imageMimetype = null;
    /**
     * @var int
     */
    private $imageSize = 0;
    /**
     * @var int
     */
    private $imageWidth = 0;
    /**
     * @var int
     */
    private $imageHeight = 0;
    /**
     * @var string
     */
    private $pathUpload = null;
    /**
     * @var string
     */
    private $exifData = null;
    /**
     * @var string
     */
    private $imageTags = null;

    /**
     * XoopsFineImUploadHandler constructor.
     * @param \stdClass $claims claims passed in JWT header
     */
    public function __construct(\stdClass $claims)
    {
        parent::__construct($claims);
        $this->allowedMimeTypes  = ['image/gif', 'image/jpeg', 'image/png'];
        $this->allowedExtensions = ['gif', 'jpeg', 'jpg', 'png'];
    }

    /**
     * @param $target
     * @param $mimeType
     * @param $uid
     * @return array|bool
     */
    protected function storeUploadedFile($target, $mimeType, $uid)
    {
        require_once XOOPS_ROOT_PATH . '/modules/wggallery/header.php';
        /** @var \XoopsModules\Wggallery\Helper $helper */
        $helper           = \XoopsModules\Wggallery\Helper::getInstance();
        $this->pathUpload = WGGALLERY_UPLOAD_IMAGE_PATH;

        if (Constants::PERM_SUBMITAPPR === $permissionsHandler->permGlobalSubmit()) {
            $this->permUseralbum = Constants::STATE_APPROVAL_VAL;
        } else {
            $this->permUseralbum = Constants::STATE_ONLINE_VAL;
        }

        $pathParts = pathinfo($this->getName());

        $this->imageName      = str_replace('.', '_', uniqid('img', true)) . '.' . mb_strtolower($pathParts['extension']);
        $this->imageNicename  = str_replace(['_', '-'], ' ', $pathParts['filename']);
        $this->imageNameLarge = str_replace('.', '_', uniqid('imgl', true)) . '.' . mb_strtolower($pathParts['extension']);
        $this->imagePath      = $this->pathUpload . '/large/' . $this->imageNameLarge;
        $this->imageNameOrig  = str_replace('.', '_', 'imgo' . hash("md5", uniqid('', true))) . '.' . mb_strtolower($pathParts['extension']);
        $this->imageMimetype  = $_FILES[$this->inputName]['type'];
        $this->imageSize      = $_FILES[$this->inputName]['size'];

        if (!move_uploaded_file($_FILES[$this->inputName]['tmp_name'], $this->imagePath)) {
            return false;
        }

        if ($helper->getConfig('store_original')) {
            $imgPathSaveOrig = $this->pathUpload . '/original/' . $this->imageNameOrig;
            copy($this->imagePath, $imgPathSaveOrig);
        }

        $exif = '';
        if ($helper->getConfig('store_exif')) {
            // read exif from original image
            $this->exifData = $imagesHandler->exifRead($this->imagePath);
        }
        if ('none' !== $helper->getConfig('exif_tags')) {
            if ('' == $exif) {
                // read exif from original image
                $exif = $imagesHandler->exifRead($this->imagePath, false);
            }
            $this->imageTags = $imagesHandler->exifExtractTags($exif, $helper->getConfig('exif_tags'));
        }

        // resize large image
        $imgHandler                = new Wggallery\Resizer();
        $imgHandler->sourceFile    = $this->imagePath;
        $imgHandler->endFile       = $this->imagePath;
        $imgHandler->imageMimetype = $this->imageMimetype;
        $imgHandler->maxWidth      = $helper->getConfig('maxwidth_large');
        $imgHandler->maxHeight     = $helper->getConfig('maxheight_large');
        $ret                       = $imgHandler->resizeImage();
        if (false === $ret) {
            return ['error' => sprintf(_MA_WGGALLERY_FAILSAVEIMG_LARGE, $this->imageNicename)];
        }

        $ret = $this->handleImageDB();
        if (!$ret) {
            return [
                'error' => sprintf(_FAILSAVEIMG, $this->imageNicename),
            ];
        }

        // load watermark settings
        $albumObj  = $albumsHandler->get($this->claims->cat);
        $wmId      = $albumObj->getVar('alb_wmid');
        $wmTargetM = false;
        $wmTargetL = false;
        if ($wmId > 0) {
            $watermarksObj = $watermarksHandler->get($wmId);
            $wmTarget      = $watermarksObj->getVar('wm_target');
            if (Constants::WATERMARK_TARGET_A === $wmTarget || Constants::WATERMARK_TARGET_M === $wmTarget) {
                $wmTargetM = true;
            }
            if (Constants::WATERMARK_TARGET_A === $wmTarget || Constants::WATERMARK_TARGET_L === $wmTarget) {
                $wmTargetL = true;
            }
        }

        // create medium image
        $imgHandler                = new Wggallery\Resizer();
        $imgHandler->sourceFile    = $this->imagePath;
        $imgHandler->endFile       = $this->pathUpload . '/medium/' . $this->imageName;
        $imgHandler->imageMimetype = $this->imageMimetype;
        $imgHandler->maxWidth      = $helper->getConfig('maxwidth_medium');
        $imgHandler->maxHeight     = $helper->getConfig('maxheight_medium');
        $ret                       = $imgHandler->resizeImage();
        if (false === $ret) {
            return ['error' => sprintf(_MA_WGGALLERY_FAILSAVEIMG_MEDIUM, $this->imageNicename)];
        }
        if ('copy' === $ret) {
            copy($this->pathUpload . '/large/' . $this->imageNameLarge, $this->pathUpload . '/medium/' . $this->imageName);
        }

        // create thumb
        $imgHandler->sourceFile    = $this->imagePath;
        $imgHandler->endFile       = $this->pathUpload . '/thumbs/' . $this->imageName;
        $imgHandler->imageMimetype = $this->imageMimetype;
        $imgHandler->maxWidth      = $helper->getConfig('maxwidth_thumbs');
        $imgHandler->maxHeight     = $helper->getConfig('maxheight_thumbs');
        $ret                       = $imgHandler->resizeImage();
        if (false === $ret) {
            return ['error' => sprintf(_MA_WGGALLERY_FAILSAVEIMG_THUMBS, $this->imageNicename)];
        }
        if ('copy' === $ret) {
            copy($this->pathUpload . '/large/' . $this->imageNameLarge, $this->pathUpload . '/thumbs/' . $this->imageName);
        }

        // add watermark to large image
        if ($wmTargetL) {
            $imgWm = $this->pathUpload . '/large/' . $this->imageNameLarge;
            $resWm = $watermarksHandler->watermarkImage($wmId, $imgWm, $imgWm);
            if (true !== $resWm) {
                return ['error' => sprintf(_MA_WGGALLERY_FAILSAVEWM_LARGE, $this->imageNicename, $resWm)];
            }
        }
        // add watermark to medium image
        if ($wmTargetM) {
            $imgWm = $this->pathUpload . '/medium/' . $this->imageName;
            $resWm = $watermarksHandler->watermarkImage($wmId, $imgWm, $imgWm);
            if (true !== $resWm) {
                return ['error' => sprintf(_MA_WGGALLERY_FAILSAVEWM_MEDIUM, $this->imageNicename, $resWm)];
            }
        }
        // send notifications
        $tags                = [];
        $tags['IMAGE_NAME']  = $this->imageNicename;
        $tags['IMAGE_URL']   = XOOPS_URL . '/modules/wggallery/images.php?op=show&img_id=' . $this->imageId . '&amp;alb_id=' . $this->claims->cat;
        $tags['ALBUM_URL']   = XOOPS_URL . '/modules/wggallery/albums.php?op=show&alb_id=' . $this->claims->cat;
        $notificationHandler = xoops_getHandler('notification');
        $mid                 = \XoopsModules\Wggallery\Helper::getMid();
        if (Constants::STATE_APPROVAL_VAL === $this->permUseralbum) {
            $notificationHandler->triggerEvent('global', 0, 'image_approve', $tags, [], $mid);
        } else {
            $notificationHandler->triggerEvent('global', 0, 'image_new_all', $tags, [], $mid);
            $notificationHandler->triggerEvent('albums', $this->claims->cat, 'image_new', $tags, [], $mid);
        }

        return ['success' => true, 'uuid' => $uuid];
    }

    /**
     * @param string $find
     * @param string $replace
     * @param array  $array
     * @return array|string|string[]
     */
    private function recursive_array_replace($find, $replace, $array)
    {
        if (!is_array($array)) {
            return str_replace($find, $replace, $array);
        }

        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[$key] = $this->recursive_array_replace($find, $replace, $value);
        }

        return $newArray;
    }

    /**
     * @return bool
     */
    private function handleImageDB()
    {
        require_once XOOPS_ROOT_PATH . '/modules/wggallery/header.php';

        $helper = \XoopsModules\Wggallery\Helper::getInstance();

        global $xoopsUser;

        $this->getImageDim();

        /** @var \XoopsModules\Wggallery\ImagesHandler $imagesHandler */
        $imagesHandler = $helper->getHandler('Images');
        $imagesObj     = $imagesHandler->create();
        // Set Vars
        $imagesObj->setVar('img_title', $this->imageNicename);
        $imagesObj->setVar('img_desc', '');
        $imagesObj->setVar('img_name', $this->imageName);
        $imagesObj->setVar('img_namelarge', $this->imageNameLarge);
        $imagesObj->setVar('img_nameorig', $this->imageNameOrig);
        $imagesObj->setVar('img_mimetype', $this->imageMimetype);
        $imagesObj->setVar('img_size', $this->imageSize);
        $imagesObj->setVar('img_resx', $this->imageWidth);
        $imagesObj->setVar('img_resy', $this->imageHeight);
        $imagesObj->setVar('img_albid', $this->claims->cat);
        $imagesObj->setVar('img_state', $this->permUseralbum);
        $imagesObj->setVar('img_exif', $this->exifData);
        $imagesObj->setVar('img_tags', $this->imageTags);
        $imagesObj->setVar('img_date', time());
        $imagesObj->setVar('img_submitter', $xoopsUser->id());
        $imagesObj->setVar('img_ip', $_SERVER['REMOTE_ADDR']);
        // Insert Data
        if ($imagesHandler->insert($imagesObj)) {
            $this->imageId = $imagesHandler->getInsertId();

            return true;
        }

        return false;
    }

    /**
     * @return bool|string
     */
    private function getImageDim()
    {
        switch ($this->imageMimetype) {
            case 'image/png':
                $img = imagecreatefrompng($this->imagePath);
                break;
            case 'image/jpeg':
                $img = imagecreatefromjpeg($this->imagePath);
                if (!$img) {
                    $img = imagecreatefromstring(file_get_contents($this->imagePath));
                }
                break;
            case 'image/gif':
                $img = imagecreatefromgif($this->imagePath);
                break;
            default:
                $this->imageWidth  = 0;
                $this->imageHeight = 0;

                return 'Unsupported format';
        }
        $this->imageWidth  = imagesx($img);
        $this->imageHeight = imagesy($img);

        imagedestroy($img);

        return true;
    }

    /**
     * resize image if size exceed given width/height
     * @param string $endfile
     * @param int    $max_width
     * @param int    $max_height
     * @return string|bool
     */
    /*     private function resizeImage_sav($endfile, $max_width, $max_height){
            // check file extension
            switch($this->imageMimetype){
                case'image/png':
                    $img = imagecreatefrompng($this->imagePath);

                break;
                case'image/jpeg':
                    $img = imagecreatefromjpeg($this->imagePath);
                break;
                case'image/gif':
                    $img = imagecreatefromgif($this->imagePath);
                break;
                default:
                    return 'Unsupported format';
            }

            $width = imagesx( $img );
            $height = imagesy( $img );

            if ( $width > $max_width || $height > $max_height) {
                // recalc image size based on max_width/max_height
                if ($width > $height) {
                    if($width < $max_width){
                        $new_width = $width;
                    } else {
                        $new_width = $max_width;
                        $divisor = $width / $new_width;
                        $new_height = floor( $height / $divisor);
                    }
                } else if($height < $max_height){
                    $new_height = $height;
                } else {
                    $new_height =  $max_height;
                    $divisor = $height / $new_height;
                    $new_width = floor( $width / $divisor );
                }

                // Create a new temporary image.
                $tmpimg = imagecreatetruecolor( $new_width, $new_height );
                imagealphablending($tmpimg, false);
                imagesavealpha($tmpimg, true);

                // Copy and resize old image into new image.
                imagecopyresampled( $tmpimg, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                //compressing the file
                switch($this->imageMimetype){
                    case'image/png':
                        imagepng($tmpimg, $endfile, 0);
                    break;
                    case'image/jpeg':
                        imagejpeg($tmpimg, $endfile, 100);
                    break;
                    case'image/gif':
                        imagegif($tmpimg, $endfile);
                    break;
                }

                // release the memory
                imagedestroy($tmpimg);
            } else {
                return 'copy';
            }
            imagedestroy($img);
            return true;
        } */
}

<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgGallery module for xoops
 *
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 * @package        wggallery
 * @since          1.0
 * @min_xoops      2.5.11
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 albums.php 1 Mon 2018-03-19 10:04:50Z XOOPS Project (www.xoops.org) $
 */

use Xmf\Request;
use XoopsModules\Wggallery;
use XoopsModules\Wggallery\Constants;

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wggallery_album_images.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';

$utility = new \XoopsModules\Wggallery\Utility();

$op     = Request::getString('op', 'list');
$albId  = Request::getInt('alb_id');
$albPid = Request::getInt('alb_pid');
$start  = Request::getInt('start');
$limit  = Request::getInt('limit', $helper->getConfig('adminpager'));

if (0 == $permissionsHandler->permGlobalSubmit()) {
    \redirect_header('albums.php', 3, _NOPERM);
}

$uid = $xoopsUser instanceof \XoopsUser ? $xoopsUser->id() : 0;

// Perms Check
if (!$permissionsHandler->permGlobalSubmit()) {
    \redirect_header('albums.php', 3, _NOPERM);
}
if ($albId > 0) {
    $albumsObj = $albumsHandler->get($albId);
    if (!$permissionsHandler->permAlbumEdit($albId, $albumsObj->getVar('alb_submitter'))) {
        \redirect_header('albums.php', 3, _NOPERM);
    }
} else {
    \redirect_header('albums.php', 3, \_CO_WGGALLERY_FORM_ERROR_INVALIDID);
}

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
$GLOBALS['xoTheme']->addStylesheet(\WGGALLERY_URL . '/assets/css/style_default.css');

// add scripts
$GLOBALS['xoTheme']->addScript(\XOOPS_URL . '/modules/wggallery/assets/js/admin.js');

// assign vars
$GLOBALS['xoopsTpl']->assign('wggallery_icon_url_16', \WGGALLERY_ICONS_URL . '16/');
$GLOBALS['xoopsTpl']->assign('wggallery_icon_url_32', \WGGALLERY_ICONS_URL . '/32');
$GLOBALS['xoopsTpl']->assign('wggallery_upload_image_url', \WGGALLERY_UPLOAD_IMAGES_URL);
$GLOBALS['xoopsTpl']->assign('wggallery_url', \WGGALLERY_URL);
$GLOBALS['xoopsTpl']->assign('gallery_target', $helper->getConfig('gallery_target'));
$GLOBALS['xoopsTpl']->assign('show_breadcrumbs', $helper->getConfig('show_breadcrumbs'));

//require_once \XOOPS_ROOT_PATH . '/modules/wggallery/include/imagehandler.php';
$maxwidth = $helper->getConfig('maxwidth_albimage');
if (0 === (int)$maxwidth) {
    $maxwidth = $helper->getConfig('maxwidth');
}
$maxheight = $helper->getConfig('maxheight_albimage');
if (0 === (int)$maxheight) {
    $maxheight = $helper->getConfig('maxheight');
}

switch ($op) {
    case 'creategrid':
        $type   = Request::getInt('type', 4);
        $src[1] = Request::getString('src1');
        $src[2] = Request::getString('src2');
        $src[3] = Request::getString('src3');
        $src[4] = Request::getString('src4');
        $src[5] = Request::getString('src5');
        $src[6] = Request::getString('src6');
        $target = Request::getString('target');
        // replace thumbs dir by dir for medium images
        $src[1] = \str_replace('/thumbs/', '/medium/', $src[1]);
        $src[2] = \str_replace('/thumbs/', '/medium/', $src[2]);
        $src[3] = \str_replace('/thumbs/', '/medium/', $src[3]);
        $src[4] = \str_replace('/thumbs/', '/medium/', $src[4]);
        $src[5] = \str_replace('/thumbs/', '/medium/', $src[5]);
        $src[6] = \str_replace('/thumbs/', '/medium/', $src[6]);

        $images = [];
        for ($i = 1; $i <= 6; $i++) {
            if ('' !== $src[$i]) {
                $file       = \str_replace(\XOOPS_URL, \XOOPS_ROOT_PATH, $src[$i]);
                $images[$i] = ['file' => $file, 'mimetype' => \mime_content_type($file)];
            }
        }

        // create basic image
        $tmp   = \imagecreatetruecolor($maxwidth, $maxheight);
        $imgBg = imagecolorallocate($tmp, 0, 0, 0);
        imagefilledrectangle($tmp, 0, 0, $maxwidth, $maxheight, $imgBg);

        $final = XOOPS_UPLOAD_PATH . '/wggallery/images/temp/' . $target;
        \unlink($final);
        \imagejpeg($tmp, $final);
        \imagedestroy($tmp);

        $imgTemp = XOOPS_UPLOAD_PATH . '/wggallery/images/temp/' . $uid . 'imgTemp';

        $imgHandler = new Wggallery\Resizer();
        if (4 === $type) {
            for ($i = 1; $i <= 4; $i++) {
                \unlink($imgTemp . $i . '.jpg');
                $imgHandler->sourceFile    = $images[$i]['file'];
                $imgHandler->endFile       = $imgTemp . $i . '.jpg';
                $imgHandler->imageMimetype = $images[$i]['mimetype'];
                $imgHandler->maxWidth      = (int)\round($maxwidth / 2 - 1);
                $imgHandler->maxHeight     = (int)\round($maxheight / 2 - 1);
                $imgHandler->jpgQuality    = 90;
                $imgHandler->resizeAndCrop();
            }
            $imgHandler->mergeType = 4;
            $imgHandler->endFile   = $final;
            $imgHandler->maxWidth  = $maxwidth;
            $imgHandler->maxHeight = $maxheight;
            for ($i = 1; $i <= 4; $i++) {
                $imgHandler->sourceFile = $imgTemp . $i . '.jpg';
                $imgHandler->mergePos   = $i;
                $imgHandler->mergeImage();
                \unlink($imgTemp . $i . '.jpg');
            }
        }
        if (6 === $type) {
            for ($i = 1; $i <= 6; $i++) {
                $imgHandler->sourceFile    = $images[$i]['file'];
                $imgHandler->endFile       = $imgTemp . $i . '.jpg';
                $imgHandler->imageMimetype = $images[$i]['mimetype'];
                $imgHandler->maxWidth      = (int)\round($maxwidth / 3 - 1);
                $imgHandler->maxHeight     = (int)\round($maxheight / 2 - 1);
                $imgHandler->resizeAndCrop();
            }
            $imgHandler->mergeType = 6;
            $imgHandler->endFile   = $final;
            $imgHandler->maxWidth  = $maxwidth;
            $imgHandler->maxHeight = $maxheight;
            for ($i = 1; $i <= 6; $i++) {
                $imgHandler->sourceFile = $imgTemp . $i . '.jpg';
                $imgHandler->mergePos   = $i;
                $imgHandler->mergeImage();
                \unlink($imgTemp . $i . '.jpg');
            }
        }

        break;
    case 'cropimage':
        $albState = $albumsObj->getVar('alb_state');
        $albPid   = $albumsObj->getVar('alb_pid');

        $imgTemp              = \WGGALLERY_UPLOAD_IMAGE_PATH . '/temp/album' . $albId . '.jpg';
        $base64_image_content = Request::getString('croppedImage');
        //$ret = move_uploaded_file( $_FILES['croppedImage']['tmp_name'], $imgTemp );
        if (\preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            \file_put_contents($imgTemp, base64_decode(\str_replace($result[1], '', $base64_image_content), true));
        }

        $imgHandler                = new Wggallery\Resizer();
        $imgHandler->sourceFile    = $imgTemp;
        $imgHandler->endFile       = $imgTemp;
        $imgHandler->imageMimetype = 'image/jpeg';
        $imgHandler->maxWidth      = $maxwidth;
        $imgHandler->maxHeight     = $maxheight;
        $ret                       = $imgHandler->resizeImage();
        $savedFilename             = \WGGALLERY_UPLOAD_IMAGE_PATH . '/albums/album' . $albId . '.jpg';
        \unlink($savedFilename);
        break;
    case 'saveAlbumImage':
    case 'saveGrid':
    case 'saveCrop':
        // Set Vars
        if ('saveGrid' === $op || 'saveCrop' === $op) {
            $imgTemp = XOOPS_UPLOAD_PATH . '/wggallery/images/temp/album' . $albId . '.jpg';
            $final   = XOOPS_UPLOAD_PATH . '/wggallery/images/albums/album' . $albId . '.jpg';
            $ret     = \rename($imgTemp, $final);
        }
        if ('saveAlbumImage' === $op) {
            $albumsObj->setVar('alb_imgtype', Constants::ALBUM_IMGCAT_USE_EXIST_VAL);
            $albumsObj->setVar('alb_imgid', Request::getInt('alb_imgid'));
            $albumsObj->setVar('alb_image', '');
        } else {
            $albumsObj->setVar('alb_imgtype', Constants::ALBUM_IMGCAT_USE_UPLOADED_VAL);
            $albumsObj->setVar('alb_imgid', 0);
            $albumsObj->setVar('alb_image', 'album' . $albId . '.jpg');
        }
        $albState = Request::getInt('alb_state');
        if (Constants::PERM_SUBMITAPPR === $permissionsHandler->permGlobalSubmit() && Constants::STATE_OFFLINE_VAL === $albState) {
            $albumsObj->setVar('alb_state', Constants::STATE_APPROVAL_VAL);
        } else {
            $albumsObj->setVar('alb_state', $albState);
        }
        $albumsObj->setVar('alb_submitter', $uid);
        // Insert Data
        if ($albumsHandler->insert($albumsObj)) {
            if (0 === $albPid) {
                $albPid = $albumsObj->getVar('alb_pid');
            }
            \redirect_header('albums.php?op=list' . '&amp;alb_pid=' . $albPid, 2, \_CO_WGGALLERY_FORM_OK);
        }
        $GLOBALS['xoopsTpl']->assign('error', $albumsObj->getHtmlErrors());

        break;
    case 'uploadAlbumImage':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('albums.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Set Vars
        $albumsObj->setVar('alb_imgtype', Constants::ALBUM_IMGCAT_USE_UPLOADED_VAL);
        require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
        $fileName       = $_FILES['attachedfile']['name'];
//        echo "<br>fileName : {$fileName}<hr>";   // JDai - upload
        $imageMimetype  = $_FILES['attachedfile']['type'];
        $uploaderErrors = '';
        $maxwidth       = $helper->getConfig('maxwidth');
        $maxheight      = $helper->getConfig('maxheight');
        $uploader       = new \XoopsMediaUploader(\WGGALLERY_UPLOAD_IMAGE_PATH . '/albums/', $helper->getConfig('mimetypes'), $helper->getConfig('maxsize'), $maxwidth, $maxheight);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $fileName);
            $imgName   = 'album' . $albId . '.' . $extension;
            $uploader->setPrefix($imgName);
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $uploaderErrors = $uploader->getErrors();
            } else {
                $savedFilename = $uploader->getSavedFileName();
                $albumsObj->setVar('alb_image', $savedFilename);
                // resize image
                $maxwidth_albimage = (int)$helper->getConfig('maxwidth_albimage');
                if (0 === $maxwidth) {
                    $maxwidth_albimage = $maxwidth;
                }
                $maxheight_albimage = (int)$helper->getConfig('maxheight_albimage');
                if (0 === $maxheight) {
                    $maxheight_albimage = $maxheight;
                }
                $imgHandler                = new Wggallery\Resizer();
                $imgHandler->sourceFile    = \WGGALLERY_UPLOAD_IMAGE_PATH . '/albums/' . $savedFilename;
                $imgHandler->endFile       = \WGGALLERY_UPLOAD_IMAGE_PATH . '/albums/' . $savedFilename;
                $imgHandler->imageMimetype = $imageMimetype;
                $imgHandler->maxWidth      = $maxwidth_albimage;
                $imgHandler->maxHeight     = $maxheight_albimage;
                $result                    = $imgHandler->resizeImage();
                $albumsObj->setVar('alb_image', $savedFilename);
            }
        } else {
            if ($fileName > '') {
                $uploaderErrors = $uploader->getErrors();
            }
            $albumsObj->setVar('alb_image', Request::getString('alb_image'));
        }
        $albumsObj->setVar('alb_imgid', 0);
        $albState = Request::getInt('alb_state');
        if (Constants::PERM_SUBMITAPPR === $permissionsHandler->permGlobalSubmit() && Constants::STATE_OFFLINE_VAL === $albState) {
            $albumsObj->setVar('alb_state', Constants::STATE_APPROVAL_VAL);
        } else {
            $albumsObj->setVar('alb_state', $albState);
        }
        $albumsObj->setVar('alb_submitter', $uid);
        // Insert Data
        if ($albumsHandler->insert($albumsObj)) {
            if ('' !== $uploaderErrors) {
                \redirect_header('albums.php?op=list&amp;alb_pid=' . $albPid . '&amp;start=' . $start . '&amp;limit=' . $limit, 5, $uploaderErrors);
            } else {
                \redirect_header('albums.php?op=list&amp;alb_pid=' . $albPid . '&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_CO_WGGALLERY_FORM_OK);
            }
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $albumsObj->getHtmlErrors());
        $form = $albumsObj->getFormUploadAlbumimage();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        break;
    case 'imghandler':
    default:
        $GLOBALS['xoTheme']->addStylesheet(\WGGALLERY_URL . '/assets/css/cropper.min.css');
        $GLOBALS['xoTheme']->addScript(\WGGALLERY_URL . '/assets/js/cropper.min.js');
        $GLOBALS['xoTheme']->addScript(\WGGALLERY_URL . '/assets/js/cropper-main.js');

        $GLOBALS['xoopsTpl']->assign('nbModals', [1, 2, 3, 4, 5, 6]);

        $album = $albumsObj->getValuesAlbums();
        $GLOBALS['xoopsTpl']->assign('album', $album);

        // get size of current album image
        list($width, $height, $type, $attr) = \getimagesize($album['image']);
        $GLOBALS['xoopsTpl']->assign('albimage_width', $width);
        $GLOBALS['xoopsTpl']->assign('albimage_height', $height);

        $albImgid  = $albumsObj->getVar('alb_imgid');
        $albImage1 = 'blank.gif';
        if ($albImgid > 0) {
            $imagesObj = $imagesHandler->get($albImgid);
            if (null !== $imagesObj && \is_object($imagesObj)) {
                $albImage1 = $imagesObj->getVar('img_name');
            }
        }
        // Get All Images of this album
        $albumsChilds = [];
        $albumsChilds = \explode('|', $albId . $albumsHandler->getChildsOfCategory($albId));
        $images       = [];
        if (\count($albumsChilds) > 0) {
            foreach ($albumsChilds as $child) {
                $alb_name = '';
                $counter  = 0;
                $crImages = new \CriteriaCompo();
                $crImages->add(new \Criteria('img_albid', $child));
                $crImages->setSort('img_weight');
                $crImages->setOrder('DESC');
                $imagesAll = $imagesHandler->getAll($crImages);
                foreach (\array_keys($imagesAll) as $i) {
                    $counter++;
                    $images[$i] = $imagesAll[$i]->getValuesImages();
                    if ($albImage1 === $images[$i]['img_name']) {
                        $images[$i]['selected'] = 1;
                    }
                    if ('' === $alb_name) {
                        $albums                 = $helper->getHandler('Albums');
                        $alb_name               = $albums->get($child)->getVar('alb_name');
                        $images[$i]['alb_name'] = $alb_name;
                    }
                    $images[$i]['counter'] = $counter;
                }
            }
        }
        if (\count($images) > 0) {
            $GLOBALS['xoopsTpl']->assign('images', $images);
        }

        // get form for upload album image
        $form = $albumsObj->getFormUploadAlbumimage();
        $GLOBALS['xoopsTpl']->assign('form_uploadimage', $form->render());

        // set style of button
        $GLOBALS['xoopsTpl']->assign('btn_style', 'btn-default');

        break;
}

// Breadcrumbs
if ($albPid > 0) {
    $xoBreadcrumbs[] = ['title' => \_CO_WGGALLERY_ALBUMS, 'link' => 'albums.php?op=list'];
    $albumsObjPid    = $albumsHandler->get($albPid);
    $xoBreadcrumbs[] = ['title' => $albumsObjPid->getVar('alb_name')];
    unset($albumsObjPid);
} else {
    $xoBreadcrumbs[] = ['title' => \_CO_WGGALLERY_ALBUMS];
}

$GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));

// Description
$utility::getMetaDescription(\_CO_WGGALLERY_ALBUMS);
$GLOBALS['xoopsTpl']->assign('wggallery_upload_url', \WGGALLERY_UPLOAD_URL);
require __DIR__ . '/footer.php';

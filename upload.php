<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

use Xmf\Request;
/**
 * wgGallery module for xoops
 *
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 * @package        wggallery
 * @since          1.0
 * @min_xoops      2.5.11
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 upload.php 1 Sat 2018-03-17 09:55:45Z XOOPS Project (www.xoops.org) $
 */

use XoopsModules\Wggallery;
use XoopsModules\Wggallery\Constants;
use XoopsModules\Wggallery\Common\FineimpuploadHandler;

require_once __DIR__ . '/header.php';
// \xoops_loadLanguage('admin', 'wggallery');
// It recovered the value of argument op in URL$
$op    = Request::getString('op', 'form');
$albId = Request::getInt('alb_id', 0);

// Template
$GLOBALS['xoopsOption']['template_main'] = 'wggallery_upload.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';

$GLOBALS['xoopsTpl']->assign('wggallery_icon_url_16', \WGGALLERY_ICONS_URL . '16/');
$GLOBALS['xoopsTpl']->assign('show_breadcrumbs', $helper->getConfig('show_breadcrumbs'));
$GLOBALS['xoopsTpl']->assign('displayButtonText', $helper->getConfig('displayButtonText'));

// check permissions
if ($albId > 0) {
    $albumsObj = $albumsHandler->get($albId);
    if (!$permissionsHandler->permAlbumEdit($albId, $albumsObj->getVar('alb_submitter'))) {
        \redirect_header('albums.php', 3, _NOPERM);
    }
    $xoBreadcrumbs[] = ['title' => $albumsObj->getVar('alb_name'), 'link' => \WGGALLERY_URL . '/images.php?op=list&amp;alb_id=' . $albId];
} else {
    if (!$permissionsHandler->permGlobalSubmit()) {
        \redirect_header('albums.php', 3, _NOPERM);
    }
    $albumsObj = $albumsHandler->create();
}

// show form
$form = $albumsObj->getFormUploadToAlbum();
$GLOBALS['xoopsTpl']->assign('form', $form->render());

if ($albId > 0) {
    $GLOBALS['xoopsTpl']->assign('albId', $albId);

    $albumObj = $albumsHandler->get($albId);
    // get config for file type/extenstion
    $fileextions = $helper->getConfig('fileext');
    $mimetypes   = [];
    foreach ($fileextions as $fe) {
        switch ($fe) {
            case 'jpg':
            case 'jpeg':
            case 'jpe':
                $mimetypes['image/jpeg'] = 'image/jpeg';
                break;
            case 'gif':
                $mimetypes['image/gif'] = 'image/gif';
                break;
            case 'png':
                $mimetypes['image/png'] = 'image/png';
                break;
            case 'bmp':
                $mimetypes['image/bmp'] = 'image/bmp';
                break;
            case 'tiff':
            case 'tif':
                $mimetypes['image/tiff'] = 'image/tiff';
                break;
            case 'else':
            default:
                break;
        }
    }

    $allowedfileext = \implode("', '", $fileextions);
    if ('' !== $allowedfileext) {
        $allowedfileext = "'" . $allowedfileext . "'";
    }
    $allowedmimetypes = \implode("', '", $mimetypes);
    if ('' !== $allowedmimetypes) {
        $allowedmimetypes = "'" . $allowedmimetypes . "'";
    }
    $maxSizeMB = ((int)$helper->getConfig('maxsize') / 1048576) . ' '  . \_CO_WGGALLERY_MB . ' (' . $helper->getConfig('maxsize') . ')';
    $GLOBALS['xoopsTpl']->assign('img_maxsizeMB', $maxSizeMB);
    $GLOBALS['xoopsTpl']->assign('img_maxsize', $helper->getConfig('maxsize'));
    $GLOBALS['xoopsTpl']->assign('img_maxwidth', $helper->getConfig('maxwidth'));
    $GLOBALS['xoopsTpl']->assign('img_maxheight', $helper->getConfig('maxheight'));
    $GLOBALS['xoopsTpl']->assign('img_albname', $albumObj->getVar('alb_name'));
    $GLOBALS['xoopsTpl']->assign('allowedfileext', $albumObj->getVar('allowedfileext'));
    $GLOBALS['xoopsTpl']->assign('allowedmimetypes', $albumObj->getVar('allowedmimetypes'));

    $GLOBALS['xoopsTpl']->assign('multiupload', true);
    // Define Stylesheet
    $GLOBALS['xoTheme']->addStylesheet(\XOOPS_URL . '/media/fine-uploader/fine-uploader-new.css');
    $GLOBALS['xoTheme']->addStylesheet(\XOOPS_URL . '/media/fine-uploader/ManuallyTriggerUploads.css');
    $GLOBALS['xoTheme']->addStylesheet(\XOOPS_URL . '/media/font-awesome/css/font-awesome.min.css');
    $GLOBALS['xoTheme']->addStylesheet(\XOOPS_URL . '/modules/system/css/admin.css');
    // Define scripts
    $GLOBALS['xoTheme']->addScript('browse.php?Frameworks/jquery/jquery.js');
    $GLOBALS['xoTheme']->addScript('modules/system/js/admin.js');
    $GLOBALS['xoTheme']->addScript('media/fine-uploader/fine-uploader.js');

    $payload = [
        'aud'     => 'ajaxfineupload.php',
        'cat'     => $albId,
        'uid'     => $xoopsUser instanceof \XoopsUser ? $xoopsUser->id() : 0,
        'handler' => FineimpuploadHandler::class,
        'moddir'  => 'wggallery',
    ];
    $jwt     = \Xmf\Jwt\TokenFactory::build('fineuploader', $payload, 60 * 30); // token good for 30 minutes
    $GLOBALS['xoopsTpl']->assign('jwt', $jwt);
    setcookie('jwt', $jwt);
    $fineup_debug = 'false';
    if (($xoopsUser instanceof \XoopsUser ? $xoopsUser->isAdmin() : false)
        && isset($_REQUEST['FINEUPLOADER_DEBUG'])) {
        $fineup_debug = 'true';
    }
    $GLOBALS['xoopsTpl']->assign('fineup_debug', $fineup_debug);

}

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_CO_WGGALLERY_IMAGES_UPLOAD];
require __DIR__ . '/footer.php';

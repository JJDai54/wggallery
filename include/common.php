<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 */

use XoopsModules\Wggallery;

include \dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = \basename(\dirname(__DIR__));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName); //$capsDirName

/** @var \XoopsDatabase $db */
/** @var \XoopsModules\Wggallery\Helper $helper */
/** @var \XoopsModules\Wggallery\Utility $utility */
$db      = \XoopsDatabaseFactory::getDatabaseConnection();
$debug   = false;
$helper  = \XoopsModules\Wggallery\Helper::getInstance($debug);
$utility = new \XoopsModules\Wggallery\Utility();
//$configurator = new Wggallery\Common\Configurator();

$helper->loadLanguage('common');

$pathIcon16 = \Xmf\Module\Admin::iconUrl('', 16);
$pathIcon32 = \Xmf\Module\Admin::iconUrl('', 32);
if (\is_object($helper->getModule())) {
    $pathModIcon16 = $helper->getModule()->getInfo('modicons16');
    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
}

if (!\defined($moduleDirNameUpper . '_CONSTANTS_DEFINED')) {
    \define($moduleDirNameUpper . '_DIRNAME', \basename(\dirname(__DIR__)));
    \define($moduleDirNameUpper . '_ROOT_PATH', \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/');
    \define($moduleDirNameUpper . '_PATH', \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/');
    \define($moduleDirNameUpper . '_URL', \XOOPS_URL . '/modules/' . $moduleDirName);
    \define($moduleDirNameUpper . '_IMAGE_URL', \constant($moduleDirNameUpper . '_URL') . '/assets/images/');
    \define($moduleDirNameUpper . '_IMAGE_PATH', \constant($moduleDirNameUpper . '_ROOT_PATH') . '/assets/images');
    \define($moduleDirNameUpper . '_ADMIN_URL', \constant($moduleDirNameUpper . '_URL') . '/admin/');
    \define($moduleDirNameUpper . '_ADMIN_PATH', \constant($moduleDirNameUpper . '_ROOT_PATH') . '/admin/');
    \define($moduleDirNameUpper . '_ADMIN', \constant($moduleDirNameUpper . '_URL') . '/admin/index.php');
    //    \define($moduleDirNameUpper . '_AUTHOR_LOGOIMG', \constant($moduleDirNameUpper . '_URL') . '/assets/images/logoModule.png');
    \define($moduleDirNameUpper . '_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . $moduleDirName); // WITHOUT Trailing slash
    \define($moduleDirNameUpper . '_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . $moduleDirName); // WITHOUT Trailing slash
    \define($moduleDirNameUpper . '_AUTHOR_LOGOIMG', $pathIcon32 . '/xoopsmicrobutton.gif');
    \define($moduleDirNameUpper . '_ICONS_URL', \constant($moduleDirNameUpper . '_URL') . '/assets/icons/');
    \define($moduleDirNameUpper . '_UPLOAD_IMAGES_URL', XOOPS_UPLOAD_URL . '/' . $moduleDirName . '/images');
    \define($moduleDirNameUpper . '_UPLOAD_IMAGE_PATH', XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images');
    \define($moduleDirNameUpper . '_UPLOAD_IMAGES_PATH', XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images');
    \define($moduleDirNameUpper . '_UPLOAD_FONTS_PATH', XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/fonts');
    \define($moduleDirNameUpper . '_UPLOAD_BATCH_PATH', XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/batch');
    \define($moduleDirNameUpper . '_UPLOAD_BATCH_URL', XOOPS_UPLOAD_URL . '/' . $moduleDirName . '/batch');
    \define($moduleDirNameUpper . '_CONSTANTS_DEFINED', 1);
}

$localLogo = \WGGALLERY_IMAGE_URL . '/wedega_logo.png';

// Module Information
$copyright = "<a href='https://wedega.com' title='Wedega - Webdesign Gabor' target='_blank'><img src='" . $localLogo . "' alt='Wedega - Webdesign Gabor'></a>";
//require_once \WGGALLERY_PATH . '/include/functions.php';

$icons = [
    'edit'    => "<img src='" . $pathIcon16 . "/edit.png'  alt=" . _EDIT . "' align='middle'>",
    'delete'  => "<img src='" . $pathIcon16 . "/delete.png' alt='" . _DELETE . "' align='middle'>",
    'clone'   => "<img src='" . $pathIcon16 . "/editcopy.png' alt='" . _CLONE . "' align='middle'>",
    'preview' => "<img src='" . $pathIcon16 . "/view.png' alt='" . _PREVIEW . "' align='middle'>",
    'print'   => "<img src='" . $pathIcon16 . "/printer.png' alt='" . _CLONE . "' align='middle'>",
    'pdf'     => "<img src='" . $pathIcon16 . "/pdf.png' alt='" . _CLONE . "' align='middle'>",
    'add'     => "<img src='" . $pathIcon16 . "/add.png' alt='" . _ADD . "' align='middle'>",
    '0'       => "<img src='" . $pathIcon16 . "/0.png' alt='" . 0 . "' align='middle'>",
    '1'       => "<img src='" . $pathIcon16 . "/1.png' alt='" . 1 . "' align='middle'>",
];

$debug = false;

// MyTextSanitizer object
$myts = \MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof \XoopsTpl)) {
    require $GLOBALS['xoops']->path('class/template.php');
    $GLOBALS['xoopsTpl'] = new \XoopsTpl();
}

$GLOBALS['xoopsTpl']->assign('mod_url', \XOOPS_URL . '/modules/' . $moduleDirName);
// Local icons path
if (\is_object($helper->getModule())) {
    $pathModIcon16 = $helper->getModule()->getInfo('modicons16');
    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');

    $GLOBALS['xoopsTpl']->assign('pathModIcon16', \XOOPS_URL . '/modules/' . $moduleDirName . '/' . $pathModIcon16);
    $GLOBALS['xoopsTpl']->assign('pathModIcon32', $pathModIcon32);
}

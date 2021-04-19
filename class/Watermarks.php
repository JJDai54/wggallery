<?php

namespace XoopsModules\Wggallery;

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
 * @min_xoops      2.5.9
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 watermarks.php 1 Thu 2018-11-01 08:54:56Z XOOPS Project (www.xoops.org) $
 */
\defined('\XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Class Object Watermarks
 */
class Watermarks extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('wm_id', \XOBJ_DTYPE_INT);
        $this->initVar('wm_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('wm_type', \XOBJ_DTYPE_INT);
        $this->initVar('wm_position', \XOBJ_DTYPE_INT);
        $this->initVar('wm_marginlr', \XOBJ_DTYPE_INT);
        $this->initVar('wm_margintb', \XOBJ_DTYPE_INT);
        $this->initVar('wm_image', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('wm_text', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('wm_font', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('wm_fontsize', \XOBJ_DTYPE_INT);
        $this->initVar('wm_color', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('wm_usage', \XOBJ_DTYPE_INT);
        $this->initVar('wm_target', \XOBJ_DTYPE_INT);
        $this->initVar('wm_date', \XOBJ_DTYPE_INT);
        $this->initVar('wm_submitter', \XOBJ_DTYPE_INT);
    }

    /**
     * @static function &getInstance
     *
     * @param null
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * The new inserted $Id
     * @return int inserted id
     */
    public function getNewInsertedIdWatermarks()
    {
        $newInsertedId = $GLOBALS['xoopsDB']->getInsertId();

        return $newInsertedId;
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormWatermarks($action = false)
    {
        /** @var \XoopsModules\Wggallery\Helper $helper */
        $helper = \XoopsModules\Wggallery\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Permissions for uploader
        $grouppermHandler = \xoops_getHandler('groupperm');
        $groups           = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : \XOOPS_GROUP_ANONYMOUS;
        if ($GLOBALS['xoopsUser']) {
            if (!$GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid())) {
                $permissionUpload = $grouppermHandler->checkRight('', 32, $groups, $GLOBALS['xoopsModule']->getVar('mid')) ? true : false;
            } else {
                $permissionUpload = true;
            }
        } else {
            $permissionUpload = $grouppermHandler->checkRight('', 32, $groups, $GLOBALS['xoopsModule']->getVar('mid')) ? true : false;
        }
        // Title
        $title = $this->isNew() ? \sprintf(\_CO_WGGALLERY_WATERMARK_ADD) : \sprintf(\_CO_WGGALLERY_WATERMARK_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text WmName
        $form->addElement(new \XoopsFormText(\_CO_WGGALLERY_WATERMARK_NAME, 'wm_name', 50, 255, $this->getVar('wm_name')), true);
        // Watermarks handler
        $watermarksHandler = $helper->getHandler('Watermarks');
        // Form Select Watermarks
        $wmType       = $this->isNew() ? 1 : $this->getVar('wm_type');
        $wmTypeSelect = new \XoopsFormSelect(\_CO_WGGALLERY_WATERMARK_TYPE, 'wm_type', $wmType);
        $wmTypeSelect->addOption(Constants::WATERMARK_TYPETEXT, \_CO_WGGALLERY_WATERMARK_TYPETEXT);
        $wmTypeSelect->addOption(Constants::WATERMARK_TYPEIMAGE, \_CO_WGGALLERY_WATERMARK_TYPEIMAGE);
        $form->addElement($wmTypeSelect);
        // Form Text WmPosition
        $wmPosition       = $this->isNew() ? 1 : $this->getVar('wm_position');
        $wmPositionSelect = new \XoopsFormSelect(\_CO_WGGALLERY_WATERMARK_POSITION, 'wm_position', $wmPosition);
        $wmPositionSelect->addOption(Constants::WATERMARK_POSTOPLEFT, \_CO_WGGALLERY_WATERMARK_POSTOPLEFT);
        $wmPositionSelect->addOption(Constants::WATERMARK_POSTOPRIGHT, \_CO_WGGALLERY_WATERMARK_POSTOPRIGHT);
        $wmPositionSelect->addOption(Constants::WATERMARK_POSTOPCENTER, \_CO_WGGALLERY_WATERMARK_POSTOPCENTER);
        $wmPositionSelect->addOption(Constants::WATERMARK_POSMIDDLELEFT, \_CO_WGGALLERY_WATERMARK_POSMIDDLELEFT);
        $wmPositionSelect->addOption(Constants::WATERMARK_POSMIDDLERIGHT, \_CO_WGGALLERY_WATERMARK_POSMIDDLERIGHT);
        $wmPositionSelect->addOption(Constants::WATERMARK_POSMIDDLECENTER, \_CO_WGGALLERY_WATERMARK_POSMIDDLECENTER);
        $wmPositionSelect->addOption(Constants::WATERMARK_POSBOTTOMLEFT, \_CO_WGGALLERY_WATERMARK_POSBOTTOMLEFT);
        $wmPositionSelect->addOption(Constants::WATERMARK_POSBOTTOMRIGHT, \_CO_WGGALLERY_WATERMARK_POSBOTTOMRIGHT);
        $wmPositionSelect->addOption(Constants::WATERMARK_POSBOTTOMCENTER, \_CO_WGGALLERY_WATERMARK_POSBOTTOMCENTER);
        $form->addElement($wmPositionSelect, true);
        // Form Text WmMargin
        $marginTray = new \XoopsFormElementTray(\_CO_WGGALLERY_WATERMARK_MARGIN, '&nbsp;');
        $wmMarginLR = $this->isNew() ? 0 : $this->getVar('wm_marginlr');
        $marginTray->addElement(new \XoopsFormText(\_CO_WGGALLERY_WATERMARK_MARGINLR, 'wm_marginlr', 10, 255, $wmMarginLR));
        $wmMarginTB = $this->isNew() ? 0 : $this->getVar('wm_margintb');
        $marginTray->addElement(new \XoopsFormText(\_CO_WGGALLERY_WATERMARK_MARGINTB, 'wm_margintb', 10, 255, $wmMarginTB));
        $form->addElement($marginTray);

        // Form Upload Image WmImage
        $getWmImage     = $this->getVar('wm_image');
        $wmImage        = $getWmImage ?: 'blank.gif';
        $imageDirectory = '/uploads/wggallery/images/watermarks';
        $imageTray      = new \XoopsFormElementTray(\_CO_WGGALLERY_WATERMARK_IMAGE, '<br>');
        $imageSelect    = new \XoopsFormSelect(\sprintf(\_CO_WGGALLERY_FORM_IMAGE_PATH, ".{$imageDirectory}/"), 'wm_image', $wmImage, 5);
        $imageArray     = \XoopsLists::getImgListAsArray(\XOOPS_ROOT_PATH . $imageDirectory);
        foreach ($imageArray as $image1) {
            $imageSelect->addOption((string)$image1, $image1);
        }
        $imageSelect->setExtra("onchange='showImgSelected(\"image1\", \"wm_image\", \"" . $imageDirectory . '", "", "' . \XOOPS_URL . "\")'");
        $imageTray->addElement($imageSelect, false);
        $imageTray->addElement(new \XoopsFormLabel('', "<br><img src='" . \XOOPS_URL . '/' . $imageDirectory . '/' . $wmImage . "' name='image1' id='image1' alt='' style='max-width:100px'>"));
        // Form File WmImage
        $fileSelectTray = new \XoopsFormElementTray('', '<br>');
        $fileSelectTray->addElement(new \XoopsFormFile(\_CO_WGGALLERY_FORM_UPLOAD_IMAGE_WATERMARKS, 'attachedfile', $helper->getConfig('maxsize')));
        $fileSelectTray->addElement(new \XoopsFormLabel(''));
        $imageTray->addElement($fileSelectTray);
        $form->addElement($imageTray);
        // Form Text WmText
        $wmText = $this->isNew() ? '© ' : $this->getVar('wm_text');
        $form->addElement(new \XoopsFormText(\_CO_WGGALLERY_WATERMARK_TEXT, 'wm_text', 50, 255, $wmText));
        // Watermarks handler
        $watermarksHandler = $helper->getHandler('Watermarks');
        // Form Select Watermarks
        $wmfontTray   = new \XoopsFormElementTray(\_CO_WGGALLERY_WATERMARK_FONT, '&nbsp;');
        $wm_font      = $this->getVar('wm_font');
        $wmFontSelect = new \XoopsFormSelect(\_CO_WGGALLERY_WATERMARK_FONTFAMILY, 'wm_font', $wm_font);
        $wmFontSelect->addOption('');
        $rep = \WGGALLERY_UPLOAD_FONTS_PATH . '/';
        $dir = \opendir($rep);
        while ($f = \readdir($dir)) {
            if (is_file($rep . $f) && \preg_match('/.*ttf/', \mb_strtolower($f))) {
                $wmFontSelect->addOption($f, mb_substr($f, 0, -4));
            }
        }
        $wmfontTray->addElement($wmFontSelect);
        // Form Text WmFontsize
        $wmFontsize       = $this->isNew() ? 12 : $this->getVar('wm_fontsize');
        $wmFontsizeSelect = new \XoopsFormSelect(\_CO_WGGALLERY_WATERMARK_FONTSIZE, 'wm_fontsize', $wmFontsize);
        for ($i = 1; $i <= 200; $i++) {
            $wmFontsizeSelect->addOption($i, $i);
        }
        $wmfontTray->addElement($wmFontsizeSelect);
        // Form Color Picker WmColor
        $wm_color      = $this->isNew() ? '#000000' : $this->getVar('wm_color');
        $wmColorPicker = new \XoopsFormColorPicker(\_CO_WGGALLERY_WATERMARK_COLOR, 'wm_color', $wm_color);
        $wmfontTray->addElement($wmColorPicker);
        $form->addElement($wmfontTray);

        // Form Select WmUsage
        $wmUsage       = $this->isNew() ? 2 : $this->getVar('wm_usage');
        $wmUsageSelect = new \XoopsFormSelect(\_CO_WGGALLERY_WATERMARK_USAGE, 'wm_usage', $wmUsage);
        $wmUsageSelect->addOption(Constants::WATERMARK_USAGENONE, \_CO_WGGALLERY_WATERMARK_USAGENONE);
        $wmUsageSelect->addOption(Constants::WATERMARK_USAGEALL, \_CO_WGGALLERY_WATERMARK_USAGEALL);
        $wmUsageSelect->addOption(Constants::WATERMARK_USAGESINGLE, \_CO_WGGALLERY_WATERMARK_USAGESINGLE);
        $form->addElement($wmUsageSelect);
        // Form Select WmTarget
        $wmTarget       = $this->isNew() ? 0 : $this->getVar('wm_target');
        $wmTargetSelect = new \XoopsFormRadio(\_CO_WGGALLERY_WATERMARK_TARGET, 'wm_target', $wmTarget);
        $wmTargetSelect->addOption(Constants::WATERMARK_TARGET_A, \_CO_WGGALLERY_WATERMARK_TARGET_A);
        $wmTargetSelect->addOption(Constants::WATERMARK_TARGET_M, \_CO_WGGALLERY_WATERMARK_TARGET_M);
        $wmTargetSelect->addOption(Constants::WATERMARK_TARGET_L, \_CO_WGGALLERY_WATERMARK_TARGET_L);
        $form->addElement($wmTargetSelect, true);
        // Form Text Date Select WmDate
        $wmDate = $this->isNew() ? 0 : $this->getVar('wm_date');
        $form->addElement(new \XoopsFormTextDateSelect(\_CO_WGGALLERY_DATE, 'wm_date', '', $wmDate));
        // Form Select User WmSubmitter
        $form->addElement(new \XoopsFormSelectUser(\_CO_WGGALLERY_SUBMITTER, 'wm_submitter', false, $this->getVar('wm_submitter')));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));

        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param int  $maxDepth
     * @return array
     */
    public function getValuesWatermarks($keys = null, $format = null, $maxDepth = null)
    {
        $helper      = \XoopsModules\Wggallery\Helper::getInstance();
        $ret         = $this->getValues($keys, $format, $maxDepth);
        $ret['id']   = $this->getVar('wm_id');
        $ret['name'] = $this->getVar('wm_name');
        $ret['type'] = $this->getVar('wm_type');
        switch ($this->getVar('wm_type')) {
            case Constants::WATERMARK_TYPETEXT:
                $type_text = \_CO_WGGALLERY_WATERMARK_TYPETEXT;
                break;
            case Constants::WATERMARK_TYPEIMAGE:
                $type_text = \_CO_WGGALLERY_WATERMARK_TYPEIMAGE;
                break;
            case 'default':
            default:
                $type_text = "invalid value 'wm_position'";
                break;
        }
        $ret['type_text'] = $type_text;
        $ret['position']  = $this->getVar('wm_position');
        switch ($this->getVar('wm_position')) {
            case Constants::WATERMARK_POSTOPLEFT:
                $position_text = \_CO_WGGALLERY_WATERMARK_POSTOPLEFT;
                break;
            case Constants::WATERMARK_POSTOPRIGHT:
                $position_text = \_CO_WGGALLERY_WATERMARK_POSTOPRIGHT;
                break;
            case Constants::WATERMARK_POSTOPCENTER:
                $position_text = \_CO_WGGALLERY_WATERMARK_POSTOPCENTER;
                break;
            case Constants::WATERMARK_POSMIDDLELEFT:
                $position_text = \_CO_WGGALLERY_WATERMARK_POSMIDDLELEFT;
                break;
            case Constants::WATERMARK_POSMIDDLERIGHT:
                $position_text = \_CO_WGGALLERY_WATERMARK_POSMIDDLERIGHT;
                break;
            case Constants::WATERMARK_POSMIDDLECENTER:
                $position_text = \_CO_WGGALLERY_WATERMARK_POSMIDDLECENTER;
                break;
            case Constants::WATERMARK_POSBOTTOMLEFT:
                $position_text = \_CO_WGGALLERY_WATERMARK_POSBOTTOMLEFT;
                break;
            case Constants::WATERMARK_POSBOTTOMRIGHT:
                $position_text = \_CO_WGGALLERY_WATERMARK_POSBOTTOMRIGHT;
                break;
            case Constants::WATERMARK_POSBOTTOMCENTER:
                $position_text = \_CO_WGGALLERY_WATERMARK_POSBOTTOMCENTER;
                break;
            case 'default':
            default:
                $position_text = "invalid value 'wm_position'";
                break;
        }
        $ret['position_text'] = $position_text;
        $ret['marginlr']      = $this->getVar('wm_marginlr');
        $ret['margintb']      = $this->getVar('wm_margintb');
        $ret['image']         = $this->getVar('wm_image');
        $ret['text']          = $this->getVar('wm_text');
        $ret['font']          = $this->getVar('wm_font');
        $ret['fontsize']      = $this->getVar('wm_fontsize');
        $ret['color']         = $this->getVar('wm_color');
        $ret['usage']         = $this->getVar('wm_usage');
        switch ($this->getVar('wm_usage')) {
            case Constants::WATERMARK_USAGESINGLE:
                $usage_text = \_CO_WGGALLERY_WATERMARK_USAGESINGLE;
                break;
            case Constants::WATERMARK_USAGEALL:
                $usage_text = \_CO_WGGALLERY_WATERMARK_USAGEALL;
                break;
            case Constants::WATERMARK_USAGENONE:
                $usage_text = \_CO_WGGALLERY_WATERMARK_USAGENONE;
                break;
            case 'default':
            default:
                $usage_text = "invalid value 'wm_usage'";
                break;
        }
        $ret['usage_text'] = $usage_text;
        $ret['target']     = $this->getVar('wm_target');
        switch ($this->getVar('wm_target')) {
            case Constants::WATERMARK_TARGET_A:
                $target_text = \_CO_WGGALLERY_WATERMARK_TARGET_A;
                break;
            case Constants::WATERMARK_TARGET_M:
                $target_text = \_CO_WGGALLERY_WATERMARK_TARGET_M;
                break;
            case Constants::WATERMARK_TARGET_L:
                $target_text = \_CO_WGGALLERY_WATERMARK_TARGET_L;
                break;
            case 'default':
            default:
                $usage_text = "invalid value 'wm_target'";
                break;
        }
        $ret['target_text'] = $target_text;
        $ret['date']        = \formatTimestamp($this->getVar('wm_date'), 's');
        $ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('wm_submitter'));

        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayWatermarks()
    {
        $ret  = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }

        return $ret;
    }
}

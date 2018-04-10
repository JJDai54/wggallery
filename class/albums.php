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
 * @min_xoops      2.5.7
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 albums.php 1 Mon 2018-03-19 10:04:50Z XOOPS Project (www.xoops.org) $
 */
defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object WggalleryAlbums
 */
class WggalleryAlbums extends XoopsObject
{
	/**
	 * Constructor 
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('alb_id', XOBJ_DTYPE_INT);
		$this->initVar('alb_pid', XOBJ_DTYPE_INT);
        $this->initVar('alb_iscat', XOBJ_DTYPE_INT);
		$this->initVar('alb_name', XOBJ_DTYPE_TXTBOX);
		$this->initVar('alb_desc', XOBJ_DTYPE_TXTAREA);
		$this->initVar('alb_weight', XOBJ_DTYPE_INT);
		$this->initVar('alb_image', XOBJ_DTYPE_TXTBOX);
		$this->initVar('alb_imgid', XOBJ_DTYPE_INT);
		$this->initVar('alb_state', XOBJ_DTYPE_INT);
		$this->initVar('alb_allowdownload', XOBJ_DTYPE_INT);
		$this->initVar('alb_date', XOBJ_DTYPE_INT);
		$this->initVar('alb_submitter', XOBJ_DTYPE_INT);
		$this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
	}

	/**
	 * @static function &getInstance
	 *
	 * @param null
	 */
	public static function getInstance()
	{
		static $instance = false;
		if(!$instance) {
			$instance = new self();
		}
	}

	/**
	 * The new inserted $Id
	 * @return inserted id
	 */
	public function getNewInsertedIdAlbums()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

	/**
	 * @public function getForm
	 * @param bool $action
	 * @return XoopsThemeForm
	 */
	public function getFormAlbums($action = false)
	{
		$wggallery = WggalleryHelper::getInstance();
		if(false === $action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		// Title
		$title = $this->isNew() ? sprintf(_CO_WGGALLERY_ALBUM_ADD) : sprintf(_CO_WGGALLERY_ALBUM_EDIT);
		// Get Theme Form
		xoops_load('XoopsFormLoader');
		$form = new XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Table Albums
		$albumsHandler = $wggallery->getHandler('albums');
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('alb_id', $this->getVar('alb_id'), '<>'));
        $criteria->setSort('alb_weight');
        $criteria->setOrder('DESC');
		$albPid = new XoopsFormSelect( _CO_WGGALLERY_ALBUM_PID, 'alb_pid', $this->getVar('alb_pid'));
		$albPid->addOption(0, '&nbsp;');
		$albPid->addOptionArray($albumsHandler->getList($criteria));
		$form->addElement($albPid);
		unset($criteria);
		// Form Text AlbName
		$form->addElement(new XoopsFormText( _CO_WGGALLERY_ALBUM_NAME, 'alb_name', 50, 255, $this->getVar('alb_name') ), true);
		// Form editor AlbDesc
		$editorConfigs = array();
		$editorConfigs['name'] = 'alb_desc';
		$editorConfigs['value'] = $this->getVar('alb_desc', 'e');
		$editorConfigs['rows'] = 5;
		$editorConfigs['cols'] = 40;
		$editorConfigs['width'] = '100%';
		$editorConfigs['height'] = '400px';
		$editorConfigs['editor'] = $wggallery->getConfig('editor');
		$form->addElement(new XoopsFormEditor( _CO_WGGALLERY_ALBUM_DESC, 'alb_desc', $editorConfigs));
		// Form Text AlbWeight
		$albWeight = $this->isNew() ? '0' : $this->getVar('alb_weight');
		$form->addElement(new XoopsFormText( _CO_WGGALLERY_ALBUM_WEIGHT, 'alb_weight', 20, 150, $albWeight ), true);
		
		$form->addElement(new XoopsFormLabel(_CO_WGGALLERY_ALBUM_IMAGE, _CO_WGGALLERY_ALBUM_IMAGE_DESC));
		// Form Table Images
		$imagesHandler = $wggallery->getHandler('images');
		$albImgid = $this->getVar('alb_imgid');
		if (0 < $albImgid) {
			$imagesObj = $imagesHandler->get($albImgid);
			$albImage1 = $imagesObj->getVar('img_name');
		} else {
			$albImage1 = 'blank.gif';
		}
		$imageDirectory = '/uploads/wggallery/images/medium';
		$imageTray1 = new XoopsFormElementTray(_CO_WGGALLERY_ALBUM_USE_EXIST, '<br>' );
		
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('img_albid', $this->getVar('alb_id')));
        $criteria->setSort('img_weight');
        $criteria->setOrder('DESC');
		$albImgidSelect = new XoopsFormSelect( _CO_WGGALLERY_ALBUM_IMGID, 'alb_imgid', $albImgid);
		$albImgidSelect->addOption(0, '&nbsp;');
		$albImgidSelect->addOptionArray($imagesHandler->getList($criteria));
		$albImgidSelect->setExtra("onchange='wgshowImgSelected(\"imagepreview1\", \"alb_imgid\", \"".$imageDirectory."\", \"\", \"".XOOPS_URL."\")'");
		$imageTray1->addElement($albImgidSelect);
		$imageTray1->addElement(new XoopsFormLabel('', "<br><img src='".XOOPS_URL."/".$imageDirectory."/".$albImage1."' name='imagepreview1' id='imagepreview1' alt='' style='max-width:100px' />"));
		$form->addElement($imageTray1);
		
		// Form Upload Image AlbImage
		$getAlbImage = $this->getVar('alb_image');
		$albImage = $getAlbImage ? $getAlbImage : 'blank.gif';
		$imageDirectory = '/uploads/wggallery/images/albums';
		$imageTray2 = new XoopsFormElementTray(_CO_WGGALLERY_ALBUM_USE_UPLOADED, '<br>' );
		$imageSelect = new XoopsFormSelect( sprintf(_CO_WGGALLERY_FORM_IMAGE_PATH, ".{$imageDirectory}/"), 'alb_image', $albImage, 5);
		$imageArray = XoopsLists::getImgListAsArray( XOOPS_ROOT_PATH . $imageDirectory );
		foreach($imageArray as $imagepreview2) {
			$imageSelect->addOption("{$imagepreview2}", $imagepreview2);
		}
		$imageSelect->setExtra("onchange='showImgSelected(\"imagepreview2\", \"alb_image\", \"".$imageDirectory."\", \"\", \"".XOOPS_URL."\")'");
		$imageTray2->addElement($imageSelect, false);
		$imageTray2->addElement(new XoopsFormLabel('', "<br><img src='".XOOPS_URL."/".$imageDirectory."/".$albImage."' name='imagepreview2' id='imagepreview2' alt='' style='max-width:100px' />"));
		// Form File AlbImage
		$fileSelectTray = new XoopsFormElementTray('', '<br>' );
		$fileSelectTray->addElement(new XoopsFormFile( _CO_WGGALLERY_ALBUM_FORM_UPLOAD_IMAGE, 'attachedfile', $wggallery->getConfig('maxsize') ));
		
		$imageTray2->addElement($fileSelectTray);
		$form->addElement($imageTray2);
		unset($criteria);
		// Form Select Albstate
		$albState = $this->isNew() ? 0 : $this->getVar('alb_state');
		$albStateSelect = new XoopsFormSelect( _CO_WGGALLERY_ALBUM_STATE, 'alb_state', $albState);
		$albStateSelect->addOption(WGGALLERY_STATE_OFFLINE_VAL, _CO_WGGALLERY_STATE_OFFLINE);
		$albStateSelect->addOption(WGGALLERY_STATE_ONLINE_VAL, _CO_WGGALLERY_STATE_ONLINE);
		$albStateSelect->addOption(WGGALLERY_STATE_APPROVAL_VAL, _CO_WGGALLERY_STATE_APPROVAL);
		$form->addElement($albStateSelect);
		// Form Select Allowdownload
		$albAllowdownload = $this->isNew() ? 0 : $this->getVar('alb_allowdownload');
		$allowdownloadSelect = new XoopsFormSelect( _CO_WGGALLERY_ALBUM_ALLOWDOWNLOAD, 'alb_allowdownload', $albAllowdownload);
		$allowdownloadSelect->addOption(0, _CO_WGGALLERY_NONE);
		$allowdownloadSelect->addOption(WGGALLERY_DOWNLOAD_MEDIUM, _CO_WGGALLERY_ALBUM_DOWNLOAD_MEDIUM);
		$allowdownloadSelect->addOption(WGGALLERY_DOWNLOAD_LARGE, _CO_WGGALLERY_ALBUM_DOWNLOAD_LARGE);
		$form->addElement($allowdownloadSelect);
		// Permissions
		$memberHandler = xoops_gethandler('member');
		$groupList = $memberHandler->getGroupList();
		$gpermHandler = xoops_gethandler('groupperm');
		$fullList[] = array_keys($groupList);
		if(!$this->isNew()) {
/* 			$groupsIdsApprove = $gpermHandler->getGroupIds('wggallery_approve', $this->getVar('alb_id'), $GLOBALS['xoopsModule']->getVar('mid'));
			$groupsIdsApprove[] = array_values($groupsIdsApprove);
			$groupsCanApproveCheckbox = new XoopsFormCheckBox( _CO_WGGALLERY_PERMS_GL_APPROVE, 'groups_approve[]', $groupsIdsApprove);
			$groupsIdsSubmit = $gpermHandler->getGroupIds('wggallery_submit', $this->getVar('alb_id'), $GLOBALS['xoopsModule']->getVar('mid'));
			$groupsIdsSubmit[] = array_values($groupsIdsSubmit);
			$groupsCanSubmitCheckbox = new XoopsFormCheckBox( _CO_WGGALLERY_PERMS_GL_SUBMIT, 'groups_submit[]', $groupsIdsSubmit); */
			$groupsIdsView = $gpermHandler->getGroupIds('wggallery_view', $this->getVar('alb_id'), $GLOBALS['xoopsModule']->getVar('mid'));
			$groupsIdsView[] = array_values($groupsIdsView);
			$groupsCanViewCheckbox = new XoopsFormCheckBox( _CO_WGGALLERY_PERMS_ALB_VIEW, 'groups_view[]', $groupsIdsView);
			
			$groupsIdsDlLarge = $gpermHandler->getGroupIds('wggallery_dllarge', $this->getVar('alb_id'), $GLOBALS['xoopsModule']->getVar('mid'));
			$groupsIdsDlLarge[] = array_values($groupsIdsDlLarge);
			$groupsCanDlLargeCheckbox = new XoopsFormCheckBox( _CO_WGGALLERY_PERMS_ALB_DLLARGE, 'groups_dllarge[]', $groupsIdsDlLarge);
			
			$groupsIdsDlMedium = $gpermHandler->getGroupIds('wggallery_dlmedium', $this->getVar('alb_id'), $GLOBALS['xoopsModule']->getVar('mid'));
			$groupsIdsDlMedium[] = array_values($groupsIdsDlMedium);
			$groupsCanDlMediumCheckbox = new XoopsFormCheckBox( _CO_WGGALLERY_PERMS_ALB_DLMEDIUM, 'groups_dlmedium[]', $groupsIdsDlMedium);
		} else {
			// $groupsCanApproveCheckbox = new XoopsFormCheckBox( _CO_WGGALLERY_PERMS_GL_APPROVE, 'groups_approve[]', $fullList);
			// $groupsCanSubmitCheckbox = new XoopsFormCheckBox( _CO_WGGALLERY_PERMS_GL_SUBMIT, 'groups_submit[]', $fullList);
			$groupsCanViewCheckbox = new XoopsFormCheckBox( _CO_WGGALLERY_PERMS_ALB_VIEW, 'groups_view[]', $fullList);
			$groupsCanDlLargeCheckbox = new XoopsFormCheckBox( _CO_WGGALLERY_PERMS_ALB_DLLARGE, 'groups_dllarge[]', $fullList);
			$groupsCanDlMediumCheckbox = new XoopsFormCheckBox( _CO_WGGALLERY_PERMS_ALB_DLMEDIUM, 'groups_dlmedium[]', $fullList);
		}
/* 		// To Approve
		$groupsCanApproveCheckbox->addOptionArray($groupList);
		$form->addElement($groupsCanApproveCheckbox);
		// To Submit
		$groupsCanSubmitCheckbox->addOptionArray($groupList);
		$form->addElement($groupsCanSubmitCheckbox); */
		// To View
		$groupsCanViewCheckbox->addOptionArray($groupList);
		$form->addElement($groupsCanViewCheckbox);
		// To Download Large Images
		$groupsCanDlLargeCheckbox->addOptionArray($groupList);
		$form->addElement($groupsCanDlLargeCheckbox);
		// To Download Medium Images
		$groupsCanDlMediumCheckbox->addOptionArray($groupList);
		$form->addElement($groupsCanDlMediumCheckbox);
		// Form Text Date Select AlbDate
		$albDate = $this->isNew() ? 0 : $this->getVar('alb_date');
		$form->addElement(new XoopsFormTextDateSelect( _CO_WGGALLERY_ALBUM_DATE, 'alb_date', '', $albDate ));
		// Form Select User AlbSubmitter
		$form->addElement(new XoopsFormSelectUser( _CO_WGGALLERY_ALBUM_SUBMITTER, 'alb_submitter', false, $this->getVar('alb_submitter') ));
		// To Save
		$form->addElement(new XoopsFormHidden('op', 'save'));
		$form->addElement(new XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
		return $form;
	}

    /**
	 * @public function getForm
	 * @param bool $action
	 * @return XoopsThemeForm
	 */
	public function getFormUploadToAlbum($action = false)
	{
		$wggallery = WggalleryHelper::getInstance();
		if(false === $action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		// Get Theme Form
		xoops_load('XoopsFormLoader');
		$form = new XoopsThemeForm(_CO_WGGALLERY_ALBUM_SELECT_DESC, 'formselalbum', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Table Albums
		$albumsHandler = $wggallery->getHandler('albums');
		$criteria = new CriteriaCompo();
		// Form Select Albums
		$albIdSelect = new XoopsFormSelect( _CO_WGGALLERY_ALBUM_SELECT, 'alb_id', $this->getVar('alb_id'));
        $albIdSelect->setExtra('onchange="submit()"');
		$albIdSelect->addOption(0, '&nbsp;');
		$albIdSelect->addOptionArray($albumsHandler->getList($criteria));
		$form->addElement($albIdSelect);
		unset($criteria);
		
		$form->addElement(new XoopsFormHidden('start', 0));
		$form->addElement(new XoopsFormHidden('limit', 0));

		return $form;
	}
    
	/**
	 * Get Values
	 * @param null $keys 
	 * @param null $format 
	 * @param null$maxDepth 
	 * @return array
	 */
	public function getValuesAlbums($keys = null, $format = null, $maxDepth = null)
	{
		$wggallery = WggalleryHelper::getInstance();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id'] = $this->getVar('alb_id');
		// $albums = $wggallery->getHandler('albums');
		// $albumsObj = $albums->get($this->getVar('alb_pid'));
		$ret['pid'] = $this->getVar('alb_pid');
        $ret['iscat'] = $this->getVar('alb_iscat');
		$ret['name'] = $this->getVar('alb_name');
		$ret['desc'] = $this->getVar('alb_desc', 'n');
		$ret['weight'] = $this->getVar('alb_weight');
		$imagesHandler = $wggallery->getHandler('images');
		if (0 < $this->getVar('alb_imgid')) {
			$imagesObj = $imagesHandler->get($this->getVar('alb_imgid'));
			if (isset($imagesObj) && is_object($imagesObj)) {
				$image = WGGALLERY_UPLOAD_IMAGE_URL . '/medium/' .  $imagesObj->getVar('img_name');
			} else {
				$image = _CO_WGGALLERY_ALBUM_IMAGE_ERRORNOTFOUND;
				$ret['image_err'] = true;
			}
		} else {
			$image = WGGALLERY_UPLOAD_IMAGE_URL . '/albums/' . $this->getVar('alb_image');
		}
		$ret['image'] = $image;
		$ret['nb_images'] = $imagesHandler->getCountImages($this->getVar('alb_id'));
		$ret['state'] = $this->getVar('alb_state');
		$ret['allowdownload'] = $this->getVar('alb_allowdownload');
		$ret['state_text'] = $wggallery->getStateText($this->getVar('alb_state'));
		$ret['date'] = formatTimeStamp($this->getVar('alb_date'), 's');
		$ret['submitter'] = XoopsUser::getUnameFromId($this->getVar('alb_submitter'));
		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayAlbums()
	{
		$ret = array();
		$vars = $this->getVars();
		foreach(array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}

/**
 * Class Object Handler WggalleryAlbums
 */
class WggalleryAlbumsHandler extends XoopsPersistableObjectHandler
{
	/**
	 * Constructor 
	 *
	 * @param null|XoopsDatabase $db
	 */
	public function __construct(XoopsDatabase $db)
	{
		parent::__construct($db, 'wggallery_albums', 'wggalleryalbums', 'alb_id', 'alb_name');
	}

	/**
	 * @param bool $isNew
	 *
	 * @return object
	 */
	public function create($isNew = true)
	{
		return parent::create($isNew);
	}

	/**
	 * retrieve a field
	 *
	 * @param int $i field id
	 * @param null fields
	 * @return mixed reference to the {@link Get} object
	 */
	public function get($i = null, $fields = null)
	{
		return parent::get($i, $fields);
	}

	/**
	 * get inserted id
	 *
	 * @param null
	 * @return integer reference to the {@link Get} object
	 */
	public function getInsertId()
	{
		return $this->db->getInsertId();
	}

	/**
	 * Get Count Albums in the database
	 * @param int    $start 
	 * @param int    $limit 
	 * @param string $sort 
	 * @param string $order 
	 * @return int
	 */
	public function getCountAlbums($start = 0, $limit = 0, $sort = 'alb_id ASC, alb_name', $order = 'ASC')
	{
		$crCountAlbums = new CriteriaCompo();
		$crCountAlbums = $this->getAlbumsCriteria($crCountAlbums, $start, $limit, $sort, $order);
		return parent::getCount($crCountAlbums);
	}

	/**
	 * Get All Albums in the database
	 * @param int    $start 
	 * @param int    $limit 
	 * @param string $sort 
	 * @param string $order 
	 * @return array
	 */
	public function getAllAlbums($start = 0, $limit = 0, $sort = 'alb_id ASC, alb_name', $order = 'ASC')
	{
		$crAllAlbums = new CriteriaCompo();
		$crAllAlbums = $this->getAlbumsCriteria($crAllAlbums, $start, $limit, $sort, $order);
		return parent::getAll($crAllAlbums);
	}

	/**
	 * Get Criteria Albums
	 * @param        $crAlbums
	 * @param int    $start 
	 * @param int    $limit 
	 * @param string $sort 
	 * @param string $order 
	 * @return int
	 */
	private function getAlbumsCriteria($crAlbums, $start, $limit, $sort, $order)
	{
		$crAlbums->setStart( $start );
		$crAlbums->setLimit( $limit );
		$crAlbums->setSort( $sort );
		$crAlbums->setOrder( $order );
		return $crAlbums;
	}
		/**
	 * Get Criteria Albums
	 * @return boolean
	 */
	public function setAlbumIsCat()
	{
		// reset (necessary after deleting)
		$strSQL = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('wggallery_albums') . ' SET ' . $GLOBALS['xoopsDB']->prefix('wggallery_albums') . '.alb_iscat = 0';
		$GLOBALS['xoopsDB']->queryF($strSQL);
		
		// set values new
		$albumsAll = $this->getAllAlbums();
		foreach(array_keys($albumsAll) as $i) {
			$albPid = $albumsAll[$i]->getVar('alb_pid');
			$strSQL = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('wggallery_albums') . ' SET ' . $GLOBALS['xoopsDB']->prefix('wggallery_albums') . '.alb_iscat = 1 WHERE ' . $GLOBALS['xoopsDB']->prefix('wggallery_albums') . '.alb_id = ' . $albPid;
			$GLOBALS['xoopsDB']->query($strSQL);
			
		}
		unset($albumsAll);
		
		return false;
	}
}

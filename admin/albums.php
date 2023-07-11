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
 * @version        $Id: 1.0 albums.php 1 Mon 2018-03-19 10:04:49Z XOOPS Project (www.xoops.org) $
 */

use Xmf\Request;
use XoopsModules\Wggallery;
use XoopsModules\Wggallery\Constants;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op      = Request::getString('op', 'list');
$albId   = Request::getInt('alb_id');
$start   = Request::getInt('start');
$limit   = Request::getInt('limit', $helper->getConfig('adminpager'));
$sort    = Request::getString('sort', 'alb_weight');
$orderby = Request::getString('orderby', 'ASC');

// add scripts
$GLOBALS['xoTheme']->addScript(\XOOPS_URL . '/modules/wggallery/assets/js/admin.js');
$GLOBALS['xoopsTpl']->assign('wggallery_icon_url_16', \WGGALLERY_ICONS_URL . '16/');
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

$sel_coll_id = Request::getInt('sel_coll_id', 0);
$sel_alb_state = Request::getInt('sel_alb_state', Constants::STATE_ALL_VAL, \_CO_WGGALLERY_ALL);
//JJDai : permet de simplifier la liste de paramètres à passer dans le TPL-list
$context = "&start={$start}&limit={$limit}&sel_coll_id={$sel_coll_id}&sel_alb_state={$sel_alb_state}";
//$context = "&start={$start}&limit={$limit}&sel_coll_id={$sel_coll_id}&sel_alb_state={$sel_alb_state}&sort={$sort}&orderby={$orderby}";
// echo "<pre>" . print_r($_GET, true) . "</pre>";
// echo "<hr>context : <br>{$context}<hr>";

switch ($op) {
    case 'list':
    default:
//echo "<pre>" . print_r($_POST, true) . print_r($_GET, true) . "</pre><hr>";
            \xoops_load('XoopsFormLoader');
        // Define Stylesheet
        $templateMain = 'wggallery_admin_albums.tpl';     //JJDai : template d'origine - wggallery_admin_albums_old.tpl
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('albums.php'));
        $adminObject->addItemButton(\_AM_WGGALLERY_ADD_ALBUM, 'albums.php?op=new');
        
        //---------------------------------------------------------------
        // JJDai : Ajout de filtres pour faciliter la gestoni de centaines d'lbums
        // JJDai : liste de selection des collections
        $crAlbums = new \CriteriaCompo();
        $crAlbums->add(new \Criteria('alb_iscoll', 1));
        $colllectionCount = $albumsHandler->getCount($crAlbums);
        if ($colllectionCount > 0) {        
            $collectionSelect = new \XoopsFormSelect(\_CO_WGGALLERY_COLLECTION, 'sel_coll_id', $sel_coll_id);
            $collectionSelect->setExtra('onchange="submit()"');
            $collectionSelect->addOption(0, "(*) " . _CO_WGGALLERY_ALL_ALBUMS);
            $collectionSelect->addOption(-1, "- " .  _CO_WGGALLERY_COLLECTIONS_ROOT);

            $collectionsAll = $albumsHandler->getAll($crAlbums);    
            foreach (\array_keys($collectionsAll) as $i) {
                $albName = _CO_WGGALLERY_COLLECTION . " : " . $collectionsAll[$i]->getVar('alb_name');
                $collectionSelect->addOption($collectionsAll[$i]->getVar('alb_id'), $albName);
            }
        }
        
        unset($crAlbums);
        if($collectionSelect){
          $GLOBALS['xoopsTpl']->assign('sel_coll_id', $sel_coll_id);  
          $GLOBALS['xoopsTpl']->assign('select_collection', $collectionSelect->render());  
        }
              
        //---------------------------------------------------------------
        // JJDai : selection de l'état
        $albStateSelect = new \XoopsFormRadio(\_CO_WGGALLERY_ALBUM_STATE, 'sel_alb_state', $sel_alb_state);
        $albStateSelect->setExtra('onchange="submit()"');
        $albStateSelect->addOption(Constants::STATE_ALL_VAL, \_CO_WGGALLERY_ALL);
        $albStateSelect->addOption(Constants::STATE_OFFLINE_VAL, \_CO_WGGALLERY_STATE_OFFLINE);
        $albStateSelect->addOption(Constants::STATE_ONLINE_VAL, \_CO_WGGALLERY_STATE_ONLINE);
        if (Constants::STATE_APPROVAL_VAL == $sel_alb_state) {
            $albStateSelect->addOption(Constants::STATE_APPROVAL_VAL, \_CO_WGGALLERY_STATE_APPROVAL);
        }
        $GLOBALS['xoopsTpl']->assign('select_state', $albStateSelect->render());        

        $GLOBALS['xoopsTpl']->assign('context', $context);       
         //---------------------------------------------------------------              

        
        if ('approve' === $op) {
            $adminObject->addItemButton(\_AM_WGGALLERY_ALBUMS_LIST, 'albums.php', 'list');
        } else {
            $crAlbums = new \CriteriaCompo();
            $crAlbums->add(new \Criteria('alb_state', Constants::STATE_APPROVAL_VAL));
            $albumsCount = $albumsHandler->getCount($crAlbums);
            if ($albumsCount > 0) {
                $adminObject->addItemButton(\_AM_WGGALLERY_ALBUMS_APPROVE, 'albums.php?op=approve', 'alert');
            }
            unset($crAlbums);
        }
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $crAlbums = new \CriteriaCompo();
        if ('approve' === $op) {
            $crAlbums->add(new \Criteria('alb_state', Constants::STATE_APPROVAL_VAL));
        }
        if ($sel_coll_id > 0) {
            $crAlbums->add(new \Criteria('alb_pid', $sel_coll_id));
        }else if($sel_coll_id < 0){
            $crAlbums->add(new \Criteria('alb_iscoll', 1));
            $crAlbums->add(new \Criteria('alb_pid', 0));
        }
        if ($sel_alb_state >= 0) {
            $crAlbums->add(new \Criteria('alb_state', $sel_alb_state));
        }
        
        $crAlbums->setStart($start);
        $crAlbums->setLimit($limit);
        $crAlbums->setSort($sort);
        $crAlbums->setOrder($orderby);
        $albumsCount = $albumsHandler->getCount($crAlbums);
        $albumsAll   = $albumsHandler->getAll($crAlbums);
        $GLOBALS['xoopsTpl']->assign('albums_count', $albumsCount);
        $GLOBALS['xoopsTpl']->assign('wggallery_url', \WGGALLERY_URL);
        $GLOBALS['xoopsTpl']->assign('wggallery_upload_url', \WGGALLERY_UPLOAD_URL);
        $GLOBALS['xoopsTpl']->assign('start', $start);
        $GLOBALS['xoopsTpl']->assign('limit', $limit);
        // Table view albums
        if ($albumsCount > 0) {
            foreach (\array_keys($albumsAll) as $i) {
                $album    = $albumsAll[$i]->getValuesAlbums();
                $crImages = new \CriteriaCompo();
                $crImages->add(new \Criteria('img_albid', $album['alb_id']));
                $crImages->setSort('img_weight');
                $crImages->setOrder('ASC');
                $album['nb_images'] = $imagesHandler->getCount($crImages);
                $GLOBALS['xoopsTpl']->append('albums_list', $album);
                unset($album);
            }
            // Display Navigation
            if ($albumsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($albumsCount, $limit, $start, 'start', 'op=list&amp;limit=' . $limit . '&amp;sort=' . $sort . '&amp;orderby=' . $orderby);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
            $GLOBALS['xoopsTpl']->assign('use_tags', $helper->getConfig('use_tags'));
            $GLOBALS['xoopsTpl']->assign('use_categories', $helper->getConfig('use_categories'));
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_CO_WGGALLERY_THEREARENT_ALBUMS);
        }

        break;
    case 'new':
        $templateMain = 'wggallery_admin_albums.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('albums.php'));
        $adminObject->addItemButton(\_AM_WGGALLERY_ALBUMS_LIST, 'albums.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $albumsObj = $albumsHandler->create();
        $form      = $albumsObj->getFormAlbums(false, true);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('albums.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($albId)) {
            $albumsObj = $albumsHandler->get($albId);
        } else {
            $albumsObj = $albumsHandler->create();
        }
        $isClone =  Request::getInt('isClone',0);
        // Set Vars
        $albumsObj->setVar('alb_pid', Request::getInt('alb_pid'));
        $albumsObj->setVar('alb_iscoll', Request::getInt('alb_iscoll'));
        $albumsObj->setVar('alb_name', Request::getString('alb_name'));
        $albumsObj->setVar('alb_desc', Request::getString('alb_desc'));
        $albumsObj->setVar('alb_weight', Request::getInt('alb_weight'));
        $albumsObj->setVar('alb_state', Request::getInt('alb_state'));
        $albumsObj->setVar('alb_imgtype', Request::getInt('alb_imgtype'));
        $albumsObj->setVar('alb_image', Request::getString('alb_image'));
        $albumsObj->setVar('alb_imgid', Request::getInt('alb_imgid'));
        $albumsObj->setVar('alb_wmid', Request::getInt('alb_wmid'));
        if ($helper->getConfig('use_categories')) {
            $albumsObj->setVar('alb_cats', serialize(Request::getArray('alb_cats')));
        }
        if ($helper->getConfig('use_tags')) {
            $albumsObj->setVar('alb_tags', Request::getString('alb_tags'));
        }
        $albumDate = date_create_from_format(_SHORTDATESTRING, $_POST['alb_date']);
        $albumsObj->setVar('alb_date', $albumDate->getTimestamp());
        $albumsObj->setVar('alb_submitter', Request::getInt('alb_submitter'));
        if ($isClone){
            $albumsObj->setVar('alb_id', 0);
            $albumsObj->setNew();
        }
        // Insert Data
        if ($albumsHandler->insert($albumsObj)) {
            $newAlbId         = $albumsHandler->getInsertId();
            $permId           = (isset($_REQUEST['alb_id']) && !$isClone) ? $albId : $newAlbId;
            $perm_modid       = $GLOBALS['xoopsModule']->getVar('mid');
            $grouppermHandler = \xoops_getHandler('groupperm');
            // remove all existing rights
            $grouppermHandler->deleteByModule($perm_modid, 'wggallery_view', $permId);
            $grouppermHandler->deleteByModule($perm_modid, 'wggallery_dlfullalb', $permId);
            $grouppermHandler->deleteByModule($perm_modid, 'wggallery_dlimage_large', $permId);
            $grouppermHandler->deleteByModule($perm_modid, 'wggallery_dlimage_medium', $permId);
            // set selected rights new
            // Permission to view
            if (isset($_POST['groups_view'])) {
                foreach ($_POST['groups_view'] as $onegroupId) {
                    $grouppermHandler->addRight('wggallery_view', $permId, $onegroupId, $perm_modid);
                }
            }
            // Permission to download full album
            if(isset($_POST['groups_dlfullalb'])) {
                foreach($_POST['groups_dlfullalb'] as $onegroupId) {
                    $grouppermHandler->addRight('wggallery_dlfullalb', $permId, $onegroupId, $perm_modid);
                }
            }
            // Permission to download large images
            if (isset($_POST['groups_dlimage_large'])) {
                foreach ($_POST['groups_dlimage_large'] as $onegroupId) {
                    $grouppermHandler->addRight('wggallery_dlimage_large', $permId, $onegroupId, $perm_modid);
                }
            }
            // Permission to download medium images
            if (isset($_POST['groups_dlimage_medium'])) {
                foreach ($_POST['groups_dlimage_medium'] as $onegroupId) {
                    $grouppermHandler->addRight('wggallery_dlimage_medium', $permId, $onegroupId, $perm_modid);
                }
            }
            $albumsHandler->setAlbumIsColl();
            \redirect_header('albums.php?op=list' . $context, 2, \_CO_WGGALLERY_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $albumsObj->getHtmlErrors());
        $form = $albumsObj->getFormAlbums();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        break;
    case 'edit':
        $templateMain = 'wggallery_admin_albums.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('albums.php'));
        $adminObject->addItemButton(\_AM_WGGALLERY_ADD_ALBUM, 'albums.php?op=new');
        $adminObject->addItemButton(\_AM_WGGALLERY_ALBUMS_LIST, 'albums.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $albumsObj = $albumsHandler->get($albId);
        $form      = $albumsObj->getFormAlbums(false, true);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        break;
    case 'clone':  // JJDai : ajout du clonage d'un album
        $templateMain = 'wggallery_admin_albums.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('albums.php'));
        $adminObject->addItemButton(\_AM_WGGALLERY_ADD_ALBUM, 'albums.php?op=new');
        $adminObject->addItemButton(\_AM_WGGALLERY_ALBUMS_LIST, 'albums.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $albumsObj = $albumsHandler->get($albId);
        $form      = $albumsObj->getFormAlbums(false, true, true);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        break;
    case 'change_state':
        if (isset($albId)) {
            $albumsObj = $albumsHandler->get($albId);
            $stateOld  = $albumsObj->getVar('alb_state');
            $stateNew  = Request::getInt('alb_state');
            // Set Vars
            $albumsObj->setVar('alb_state', Request::getInt('alb_state'));
            // Insert Data
            if ($albumsHandler->insert($albumsObj)) {
                if (Constants::STATE_APPROVAL_VAL === $stateOld && Constants::STATE_OFFLINE_VAL === $stateNew) {
                    $crImages = new \CriteriaCompo();
                    $crImages->add(new \Criteria('img_albid', $albId));
                    $crImages->add(new \Criteria('img_state', Constants::STATE_APPROVAL_VAL));
                    $imgApprove = $imagesHandler->getCount($crImages);
                    if ($imgApprove > 0) {
                        \redirect_header('images.php?op=approve&amp;alb_id=' . $albId, 2, \_CO_WGGALLERY_FORM_OK_APPROVE);
                    }
                }
                \redirect_header('albums.php?op=list' . $context, 2, \_CO_WGGALLERY_FORM_OK);
            }
            // Get Form
            $GLOBALS['xoopsTpl']->assign('error', $albumsObj->getHtmlErrors());
        }
        break;
    case 'delete':
        $albumsObj = $albumsHandler->get($albId);
        if (!$permissionsHandler->permAlbumEdit($albId, $albumsObj->getVar('alb_submitter'))) {
            \redirect_header('albums.php', 3, _NOPERM);
        }
        if (1 == Request::getInt('ok')) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('albums.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $alb_image = $albumsObj->getVar('alb_image');
            $alb_name  = $albumsObj->getVar('alb_name');
            if ($albumsHandler->delete($albumsObj)) {
                // delete albimage
                if ('blank.gif' !== $alb_image && 'noimage.png' !== $alb_image) {
                    \unlink(\WGGALLERY_UPLOAD_IMAGE_PATH . '/albums/' . $alb_image);
                }
                // delete all images linked to this album
                $crit_img = new \CriteriaCompo();
                $crit_img->add(new \Criteria('img_albid', $albId));
                $imagesAll = $imagesHandler->getAll($crit_img);
                foreach (\array_keys($imagesAll) as $i) {
                    $imagesHandler->unlinkImages($imagesAll[$i]->getVar('img_name'), $imagesAll[$i]->getVar('img_namelarge'));
                    $imagesObj = $imagesHandler->get($imagesAll[$i]->getVar('img_id'));
                    $imagesHandler->delete($imagesObj, true);
                    // delete ratings
                    $ratingsHandler->deleteAllRatings($imagesAll[$i]->getVar('img_id'), 1);
                }
                // send notifications
                $tags                = [];
                $tags['ALBUM_NAME']  = $alb_name;
                $notificationHandler = \xoops_getHandler('notification');
                $notificationHandler->triggerEvent('global', 0, 'album_delete_all', $tags);
                $notificationHandler->triggerEvent('albums', $albId, 'album_delete', $tags);
                // delete all notifications linked to this album
                $notificationHandler->unsubscribeByItem($GLOBALS['xoopsModule']->getVar('mid'), 'albums', $albId);

                \redirect_header('albums.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 3, \_CO_WGGALLERY_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $albumsObj->getHtmlErrors());
            }
        } else {
            xoops_confirm(['ok' => 1, 'alb_id' => $albId, 'op' => 'delete', 'start' => $start, 'limit' => $limit], $_SERVER['REQUEST_URI'], \sprintf(\_CO_WGGALLERY_FORM_SURE_DELETE, $albumsObj->getVar('alb_name')));
            //            $form = $helper->getFormDelete(['ok' => 1, 'alb_id' => $albId, 'op' => 'delete'], \_CO_WGGALLERY_FORM_DELETE, $albumsObj->getVar('alb_name'), \_CO_WGGALLERY_ALBUM_DELETE_DESC);
            //            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
        
    case 'clear_album':  // JJDai ajout de la suppression de toutes les images d'un albums
        $albumsObj = $albumsHandler->get($albId);
        if (!$permissionsHandler->permAlbumEdit($albId, $albumsObj->getVar('alb_submitter'))) {
            \redirect_header('albums.php', 3, _NOPERM);
        }
        
        if (1 == Request::getInt('ok')) {
          $crImages = new \CriteriaCompo();        
          $crImages->add(new \Criteria('img_albid', $albId));        
          $imagesAll = $imagesHandler->getAll($crImages);
          foreach($imagesAll as $imagesObj)  {
            $img_name = $imagesObj->getVar('img_name');
            if ($imagesHandler->delete($imagesObj)) {
                // JJDai - todo gerer les erreurs
                if ($imagesHandler->unlinkImages($img_name, $imagesObj->getVar('img_namelarge'))) {

//                 } else {
//                     $GLOBALS['xoopsTpl']->assign('error', \_CO_WGGALLERY_IMAGE_ERRORUNLINK);
                }
                //\redirect_header('images.php?alb_id=' . $albId, 3, \_CO_WGGALLERY_FORM_DELETE_OK);
            } 
          }
          
            \redirect_header('albums.php?op=list' . $context, 3, \_CO_WGGALLERY_FORM_CLEAR_ALBUM_OK);          
          
        }else{
            $crImages = new \CriteriaCompo();        
            $crImages->add(new \Criteria('img_albid', $albId));        
            $imagesCount = $imagesHandler->getCount($crImages);

            xoops_confirm(['ok' => 1, 'alb_id' => $albId, 'op' => 'clear_album', 'start' => $start, 'limit' => $limit, 'sel_coll_id' => $sel_coll_id, 'sel_alb_state' => $sel_alb_state],
                          $_SERVER['REQUEST_URI'],
                          \sprintf(\_CO_WGGALLERY_FORM_SURE_CLEAR_ALBUM, $imagesCount, $albumsObj->getVar('alb_name')));
            //            $form = $helper->getFormDelete(['ok' => 1, 'alb_id' => $albId, 'op' => 'delete'], \_CO_WGGALLERY_FORM_DELETE, $albumsObj->getVar('alb_name'), \_CO_WGGALLERY_ALBUM_DELETE_DESC);
            //            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        
        break;
        
    case 'set_coll_permissions':  // JJDai : application des permissions d'une collection aux albums de cette collection
        $albumsObj = $albumsHandler->get($albId);
    
        if (1 == Request::getInt('ok')) {
            $crAlbums = new \CriteriaCompo();
            $crAlbums->add(new \Criteria('alb_pid', $albId));
            $albumsAll   = $albumsHandler->getAll($crAlbums);
            // Table des albums de la collection
            $perm_modid = $GLOBALS['xoopsModule']->getVar('mid');
            $grouppermHandler = \xoops_getHandler('groupperm');
                        
            $groupsIdsView        = $grouppermHandler->getGroupIds('wggallery_view', $albId, $perm_modid);
            $groupsIdsView[]      = \array_values($groupsIdsView);
            $groupsIdsDlFullAlb   = $grouppermHandler->getGroupIds('wggallery_dlfullalb', $albId, $perm_modid);
            $groupsIdsDlFullAlb[] = \array_values($groupsIdsDlFullAlb);
            $groupsIdsDlImageL    = $grouppermHandler->getGroupIds('wggallery_dlimage_large', $albId, $perm_modid);
            $groupsIdsDlImageL[]  = \array_values($groupsIdsDlImageL);
            $groupsIdsDlImageM    = $grouppermHandler->getGroupIds('wggallery_dlimage_medium', $albId, $perm_modid);
            $groupsIdsDlImageM[]  = \array_values($groupsIdsDlImageM);

            foreach (\array_keys($albumsAll) as $i) {
                $albChildId =  $albumsAll[$i]->getVar('alb_id');

                $grouppermHandler->deleteByModule($perm_modid, 'wggallery_view', $albChildId);
                $grouppermHandler->deleteByModule($perm_modid, 'wggallery_dlfullalb', $albChildId);
                $grouppermHandler->deleteByModule($perm_modid, 'wggallery_dlimage_large', $albChildId);
                $grouppermHandler->deleteByModule($perm_modid, 'wggallery_dlimage_medium', $albChildId);
                    

                // Permission to view
                foreach ($groupsIdsView as $onegroupId) {
                    $grouppermHandler->addRight('wggallery_view', $albChildId, $onegroupId, $perm_modid);
                }

                // Permission to download full album
                    foreach($groupsIdsDlFullAlb as $onegroupId) {
                        $grouppermHandler->addRight('wggallery_dlfullalb', $albChildId, $onegroupId, $perm_modid);
                }
                
                // Permission to download large images
                foreach ($groupsIdsDlImageL as $onegroupId) {
                    $grouppermHandler->addRight('wggallery_dlimage_large', $albChildId, $onegroupId, $perm_modid);
                }

                // Permission to download medium images
                foreach ($groupsIdsDlImageM as $onegroupId) {
                    $grouppermHandler->addRight('wggallery_dlimage_medium', $albChildId, $onegroupId, $perm_modid);
                }
            }
            \redirect_header('albums.php?op=list' . $context, 3, \_CO_WGGALLERY_SET_COLL_PERM_OK);          
        }else{
          $crAlbums = new \CriteriaCompo();
          $crAlbums->add(new \Criteria('alb_pid', $albId));
          $albumsCount =  $albumsHandler->getCount($crAlbums);
          if ($albumsCount > 0) {
              xoops_confirm(['ok' => 1, 'alb_id' => $albId, 'op' => 'set_coll_permissions', 'start' => $start, 'limit' => $limit, 'sel_coll_id' => $sel_coll_id, 'sel_alb_state' => $sel_alb_state],
                            $_SERVER['REQUEST_URI'], 
                            \sprintf(\_CO_WGGALLERY_SURE_SET_COLL_PERM, $albumsCount, $albumsObj->getVar('alb_name')));
           }
        }
        break;

    case 'update_weight':
        $action = Request::getCmd('action');
        $albId = Request::getInt('albId', 0);
        $albPid = Request::getInt('albPid', 0);
        $albumsHandler->updateWeight($albId, $action);
        \redirect_header('albums.php?op=list&sort=alb_weight&orderby=ASC' . $context, 2, \_AM_WGGALLERY_WEIGHT_UPDATE);        
        break;
        
    case 'update_weight_by_fields':
        $albumsHandler->updatetWeightByFields($sel_coll_id);
        \redirect_header('albums.php?op=list&sort=alb_weight&orderby=ASC' . $context, 2, \_AM_WGGALLERY_WEIGHT_UPDATE);        
        break;
        
    case 'goto_parent':
        $albumsObj = $albumsHandler->get($sel_coll_id);
        $albId = $albumsObj->getVar('alb_pid');  
         
        \redirect_header("albums.php?op=list&sel_coll_id='{$albId}", 0, '');        
        break;
}
require __DIR__ . '/footer.php';

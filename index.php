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
use XoopsModules\Wggallery\Constants;

require __DIR__ . '/header.php';
$pr_album                                = $albumtypesHandler->getPrimaryAlbum();
$GLOBALS['xoopsOption']['template_main'] = 'wggallery_index_' . $pr_album['template'] . '.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';
$start       = Request::getInt('start');
$limit       = Request::getInt('limit', $helper->getConfig('userpager'));
$albPid      = Request::getInt('alb_pid');
$submitterId = Request::getInt('subm_id');

// general template assigns
$GLOBALS['xoopsTpl']->assign('wggallery_url', \WGGALLERY_URL);
$GLOBALS['xoopsTpl']->assign('wggallery_icon_url_16', \WGGALLERY_ICONS_URL . '16/');
$GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));
$GLOBALS['xoopsTpl']->assign('show_breadcrumbs', $helper->getConfig('show_breadcrumbs'));
$GLOBALS['xoopsTpl']->assign('displayButtonText', $helper->getConfig('displayButtonText'));

// assign all album options
$atoptions = unserialize($pr_album['options'], ['allowed_classes' => false]);
foreach ($atoptions as $atoption) {
    $GLOBALS['xoopsTpl']->assign($atoption['name'], $atoption['value']);
    if ('number_cols_album' === $atoption['name']) {
        $number_cols_album = $atoption['value'];
    }
    if ('number_cols_cat' === $atoption['name']) {
        $number_cols_cat = $atoption['value'];
    }
}
// assign gallery options
$GLOBALS['xoopsTpl']->assign('gallery_target', $helper->getConfig('gallery_target'));

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

$pr_gallery = $gallerytypesHandler->getPrimaryGallery();
$gallery = ('none' !== $pr_gallery['template']);


$idxAlblist = (int)$helper->getConfig('idx_alblist');
if ($idxAlblist > 0) { 
    $alTarget = \WGGALLERY_URL . '/images.php?op=list';
    $alThumb = (2 === $idxAlblist);
    if ($gallery) {
        $target = \WGGALLERY_URL . '/gallery.php?op=show';
    }    
    $albumlist = '<ol class="wgg-alblist-ol">';
    $albumlist .= $albumsHandler->getListChildsOfCollectionIndex(0, $alTarget, $alThumb);
    $albumlist .= '</ol>';
    $GLOBALS['xoopsTpl']->assign('albumlist', $albumlist);
}


switch ($pr_album['template']) {
    case 'hovereffectideas':
        $GLOBALS['xoTheme']->addStylesheet(\WGGALLERY_URL . '/assets/albumtypes/hovereffectideas/style.css', null);
        $GLOBALS['xoTheme']->addStylesheet(\WGGALLERY_URL . '/assets/albumtypes/hovereffectideas/fonts/font-awesome-4.2.0/css/font-awesome.min.css', null);
        break;
    case 'simple':
        $GLOBALS['xoTheme']->addStylesheet(\WGGALLERY_URL . '/assets/albumtypes/simple/style.css', null);
        break;
    case 'bcards':
        $GLOBALS['xoTheme']->addStylesheet(\WGGALLERY_URL . '/assets/albumtypes/bcards/style.css', null);
        break;
    case 'default':
    default:
        $GLOBALS['xoTheme']->addStylesheet(\WGGALLERY_URL . '/assets/css/style_default.css', null);
        break;
}

$keywords = [];

// Breadcrumbs
if ($albPid) {
    $xoBreadcrumbs[] = ['title' => \_CO_WGGALLERY_ALBUMS, 'link' => \WGGALLERY_URL . '/'];
    $albumsObj       = $albumsHandler->get($albPid);
    $xoBreadcrumbs[] = ['title' => $albumsObj->getVar('alb_name')];
} else {
    $xoBreadcrumbs[] = ['title' => \_CO_WGGALLERY_ALBUMS];
}
if ($submitterId > 0) {
    $GLOBALS['xoopsTpl']->assign('subm_id', $submitterId);
}

// get all albums which are online
$crAlbums = new \CriteriaCompo();
if ($submitterId > 0) {
    $crAlbums->add(new \Criteria('alb_submitter', $submitterId));
}
$crAlbums->add(new \Criteria('alb_pid', $albPid));
$crAlbums->add(new \Criteria('alb_iscoll', 0));
$crAlbums->add(new \Criteria('alb_state', Constants::STATE_ONLINE_VAL));
$albumsCount = $albumsHandler->getCount($crAlbums);
// read all albums and check for perm to view
$albumsAll   = $albumsHandler->getAll($crAlbums);
$permAlbView = [];
if ($albumsCount > 0) {
    foreach (\array_keys($albumsAll) as $i) {
        if ($permissionsHandler->permAlbumView($albumsAll[$i]->getVar('alb_id')) > 0) {
            $permAlbView[] = $albumsAll[$i]->getVar('alb_id');
        }
        // echo "<br>------------------------------------------------------------";
        // echo "<br>alb_name:" . $albumsAll[$i]->getVar('alb_name');
        // echo "<br>alb_id:" . $albumsAll[$i]->getVar('alb_id');
        // echo "<br>alb_submitter:" . $albumsAll[$i]->getVar('alb_submitter');
        // echo "<br>permAlbumView:" . $permissionsHandler->permAlbumView($albumsAll[$i]->getVar('alb_id'));
        // echo "<br>permAlbumEdit:" . $permissionsHandler->permAlbumEdit($albumsAll[$i]->getVar('alb_id'), $albumsAll[$i]->getVar('alb_submitter'));
        // echo "<br>permAlbumDownload:" . $permissionsHandler->permAlbumDownload($albumsAll[$i]->getVar('alb_id'));
        // echo "<br>permImageDownloadLarge:" . $permissionsHandler->permImageDownloadLarge($albumsAll[$i]->getVar('alb_id'));
        // echo "<br>permImageDownloadMedium:" . $permissionsHandler->permImageDownloadMedium($albumsAll[$i]->getVar('alb_id'));
        // echo "<br>permGlobalSubmit:" . $permissionsHandler->permGlobalSubmit();
    }
}
unset($albumsAll);
unset($crAlbums);
$albumsCount = \count($permAlbView);
if ($albumsCount > 0) {
    $crAlbums = new \CriteriaCompo();
    $crAlbums->add(new \Criteria('alb_id', '(' . \implode(',', $permAlbView) . ')', 'IN'));
    $crAlbums->setSort('alb_weight ASC, alb_date');
    $crAlbums->setOrder('DESC');
    $crAlbums->setStart($start);
    $crAlbums->setLimit($limit);
    $albumsAll = $albumsHandler->getAll($crAlbums);
    unset($permAlbView);

    if ($albumsCount > 0) {
        $counter = 0;
        $albums  = [];
        // Get All Albums
        foreach (\array_keys($albumsAll) as $i) {
            $albums[$i] = $albumsAll[$i]->getValuesAlbums();
            $submitter  = $albumsAll[$i]->getVar('alb_submitter');
            //check permissions
            //$albums[$i]['edit'] = $permissionsHandler->permAlbumEdit($albumsAll[$i]->getVar('alb_id'), $albumsAll[$i]->getVar('alb_submitter'));
            if ($permissionsHandler->permAlbumDownload($albumsAll[$i]->getVar('alb_id'))) {
                $albums[$i]['download'] = true;
            }
            //set indicator for line break
            $counter++;
            if (1 === $counter) {
                $albums[$i]['newrow'] = true;
            }
            if ($number_cols_album == $counter) {
                $albums[$i]['linebreak'] = true;
                $counter                 = 0;
            }
            $keywords[] = $albumsAll[$i]->getVar('alb_name');
        }
        // add linebreak to last album item
        $albums[$i]['linebreak'] = true;

        $GLOBALS['xoopsTpl']->assign('albums', $albums);
        $GLOBALS['xoopsTpl']->assign('alb_pid', $albPid);
        $GLOBALS['xoopsTpl']->assign('gallery', $gallery);
        // $GLOBALS['xoopsTpl']->assign('album_showsubmitter', $helper->getConfig('album_showsubmitter'));
        if ($submitterId > 0) {
            $GLOBALS['xoopsTpl']->assign('index_alb_title', \_CO_WGGALLERY_ALBUMS_TITLE . ': ' . XoopsUser::getUnameFromId($submitter));
        } else {
            $GLOBALS['xoopsTpl']->assign('index_alb_title', \_CO_WGGALLERY_ALBUMS_TITLE);
        }

        unset($albums);
        // Display Navigation
        if ($albumsCount > $limit) {
            require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
            $pagenav = new \XoopsPageNav($albumsCount, $limit, $start, 'start', 'op=list&amp;limit=' . $limit . '&amp;alb_pid=' . $albPid);
            $GLOBALS['xoopsTpl']->assign('pagenav_albums', $pagenav->renderNav());
        }
    }
}

// get all categories which contains albums
$crAlbums = new \CriteriaCompo();
$crAlbums->add(new \Criteria('alb_pid', $albPid));
$crAlbums->add(new \Criteria('alb_iscoll', 1));
$crAlbums->add(new \Criteria('alb_state', Constants::STATE_ONLINE_VAL));
$catsCount = $albumsHandler->getCount($crAlbums);
// read all categories and check for perm to view
$albumsAll   = $albumsHandler->getAll($crAlbums);
$permAlbView = [];
if ($catsCount > 0) {
    foreach (\array_keys($albumsAll) as $i) {
        if ($permissionsHandler->permAlbumView($albumsAll[$i]->getVar('alb_id')) > 0) {
            $permAlbView[] = $albumsAll[$i]->getVar('alb_id');
        }
        // echo "<br>------------------------------------------------------------";
        // echo "<br>alb_name:" . $albumsAll[$i]->getVar('alb_name');
        // echo "<br>alb_id:" . $albumsAll[$i]->getVar('alb_id');
        // echo "<br>alb_submitter:" . $albumsAll[$i]->getVar('alb_submitter');
        // echo "<br>permAlbumView:" . $permissionsHandler->permAlbumView($albumsAll[$i]->getVar('alb_id'));
        // echo "<br>permAlbumEdit:" . $permissionsHandler->permAlbumEdit($albumsAll[$i]->getVar('alb_id'), $albumsAll[$i]->getVar('alb_submitter'));
        // echo "<br>permAlbumDownload:" . $permissionsHandler->permAlbumDownload($albumsAll[$i]->getVar('alb_id'));
        // echo "<br>permImageDownloadLarge:" . $permissionsHandler->permImageDownloadLarge($albumsAll[$i]->getVar('alb_id'));
        // echo "<br>permImageDownloadMedium:" . $permissionsHandler->permImageDownloadMedium($albumsAll[$i]->getVar('alb_id'));
        // echo "<br>permGlobalSubmit:" . $permissionsHandler->permGlobalSubmit();
    }
}
unset($albumsAll);
unset($crAlbums);
$catsCount = \count($permAlbView);
if ($catsCount > 0) {
    $crAlbums = new \CriteriaCompo();
    $crAlbums->add(new \Criteria('alb_id', '(' . \implode(',', $permAlbView) . ')', 'IN'));
    $crAlbums->setSort('alb_weight ASC, alb_date');
    $crAlbums->setOrder('DESC');
    $crAlbums->setStart($start);
    $crAlbums->setLimit($limit);
    $albumsAll = $albumsHandler->getAll($crAlbums);
    unset($permAlbView);

    if ($catsCount > 0) {
        $categories = [];
        $counter    = 0;
        // Get All Albums
        foreach (\array_keys($albumsAll) as $i) {
            $categories[$i] = $albumsAll[$i]->getValuesAlbums();
            // count albums
            $crSubAlbums = new \CriteriaCompo();
            $crSubAlbums->add(new \Criteria('alb_pid', $categories[$i]['alb_id']));
            $nbAlbums                    = $albumsHandler->getCount($crSubAlbums);
            $categories[$i]['nb_albums'] = $nbAlbums;
            //check permissions
            //$categories[$i]['edit'] = $permissionsHandler->permAlbumEdit($albumsAll[$i]->getVar('alb_id'), $albumsAll[$i]->getVar('alb_submitter'));
            //set indicator for line break
            $counter++;
            if (1 === $counter) {
                $categories[$i]['newrow'] = true;
            }
            if ($number_cols_cat == $counter) {
                $categories[$i]['linebreak'] = true;
                $counter                     = 0;
            }
            $keywords[] = $albumsAll[$i]->getVar('alb_name');
        }
        // add linebreak to last album item
        $categories[$i]['linebreak'] = true;

        $GLOBALS['xoopsTpl']->assign('categories', $categories);
        // $GLOBALS['xoopsTpl']->assign('album_showsubmitter', $helper->getConfig('album_showsubmitter'));
        unset($categories);
        if ($submitterId > 0) {
            $GLOBALS['xoopsTpl']->assign('index_cats_title', \_CO_WGGALLERY_COLL_TITLE . ': ' . XoopsUser::getUnameFromId($submitter));
        } else {
            $GLOBALS['xoopsTpl']->assign('index_cats_title', \_CO_WGGALLERY_COLL_TITLE);
        }
        // Display Navigation
        if ($catsCount > $limit) {
            require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
            $pagenav = new \XoopsPageNav($catsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
            $GLOBALS['xoopsTpl']->assign('pagenav_cats', $pagenav->renderNav());
        }
    }
}

if (0 == ($catsCount + $albumsCount)) {
    $GLOBALS['xoopsTpl']->assign('error', \_CO_WGGALLERY_THEREARENT_ALBUMS);
}

// Keywords
$utility::getMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);
// Description
$utility::getMetaDescription(\_CO_WGGALLERY_ALBUMS_DESC);
// $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGGALLERY_URL.'/albums.php');
$GLOBALS['xoopsTpl']->assign('wggallery_upload_url', \WGGALLERY_UPLOAD_URL);
require __DIR__ . '/footer.php';

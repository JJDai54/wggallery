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
 * @min_xoops      2.5.11
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 albums.php 1 Mon 2018-03-19 10:04:50Z XOOPS Project (www.xoops.org) $
 */

use XoopsModules\Wggallery;

\defined('\XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Class Object Handler Albums
 */
class AlbumsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wggallery_albums', Albums::class, 'alb_id', 'alb_name');
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
     * @param int   $i field id
     * @param array $fields
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
     * @return int reference to the {@link Get} object
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
    public function getCountAlbums($start = 0, $limit = 0, $sort = 'alb_weight ASC, alb_date', $order = 'DESC')
    {
        $crCountAlbums = new \CriteriaCompo();
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
    public function getAllAlbums($start = 0, $limit = 0, $sort = 'alb_weight ASC, alb_date', $order = 'DESC')
    {
        $crAllAlbums = new \CriteriaCompo();
        $crAllAlbums = $this->getAlbumsCriteria($crAllAlbums, $start, $limit, $sort, $order);

        return parent::getAll($crAllAlbums);
    }

    /**
     * Get Criteria Albums
     * @param  $crAlbums
     * @param  $start
     * @param  $limit
     * @param  $sort
     * @param  $order
     * @return int
     */
    private function getAlbumsCriteria($crAlbums, $start, $limit, $sort, $order)
    {
        $crAlbums->setStart($start);
        $crAlbums->setLimit($limit);
        $crAlbums->setSort($sort);
        $crAlbums->setOrder($order);

        return $crAlbums;
    }

    /**
     * Get Criteria Albums
     * @return bool
     */
    public function setAlbumIsColl()
    {
        // reset (necessary after deleting)
        $strSQL = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('wggallery_albums') . ' SET ' . $GLOBALS['xoopsDB']->prefix('wggallery_albums') . '.alb_iscoll = 0';
        $GLOBALS['xoopsDB']->queryF($strSQL);

        // set values new
        $albumsAll = $this->getAllAlbums();
        foreach (\array_keys($albumsAll) as $i) {
            $albPid = $albumsAll[$i]->getVar('alb_pid');
            $strSQL = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('wggallery_albums') . ' SET ' . $GLOBALS['xoopsDB']->prefix('wggallery_albums') . '.alb_iscoll = 1 WHERE ' . $GLOBALS['xoopsDB']->prefix('wggallery_albums') . '.alb_id = ' . $albPid;
            $GLOBALS['xoopsDB']->query($strSQL);
        }
        unset($albumsAll);

        return false;
    }

    /**
     * Get all childs of a category
     * @param $albPid
     * @return string
     */
    public function getChildsOfCategory($albPid)
    {
        $childsAll = '';
        $helper        = \XoopsModules\Wggallery\Helper::getInstance();
        $albumsHandler = $helper->getHandler('Albums');
        $crAlbums      = new \CriteriaCompo();
        $crAlbums->add(new \Criteria('alb_pid', $albPid));
        $albumsCount = $albumsHandler->getCount($crAlbums);
        $albumsAll   = $albumsHandler->getAll($crAlbums);
        // Table view albums
        if ($albumsCount > 0) {
            foreach (\array_keys($albumsAll) as $i) {
                // if ( 0 < \count($childsAll) ) {$childsAll .= "#".('' !== $childsAll)."|";}
                $childsAll .= '|' . $albumsAll[$i]->getVar('alb_id');
                $child     = $this->getChildsOfCategory($albumsAll[$i]->getVar('alb_id'));
                if ($child) {
                    $childsAll .= $child;
                }
            }
        }

        return $childsAll;
    }

    /**
     * Get all childs of a category
     * @param $albPid
     * @return bool|string
     */
    public function getListChildsOfCollection($albPid)
    {
        if ($albPid > 0) {
            $childsAll = '<ol>';
        } else {
            $childsAll = '';
        }

        $helper             = \XoopsModules\Wggallery\Helper::getInstance();
        $albumsHandler      = $helper->getHandler('Albums');
        $permissionsHandler = $helper->getHandler('Permissions');
        $crAlbums           = new \CriteriaCompo();
        $crAlbums->add(new \Criteria('alb_pid', $albPid));
        $crAlbums->setSort('alb_weight ASC, alb_date');
        $crAlbums->setOrder('DESC');
        $albumsCount = $albumsHandler->getCount($crAlbums);
        $albumsAll   = $albumsHandler->getAll($crAlbums);
        // Table view albums
        if ($albumsCount > 0) {
            foreach (\array_keys($albumsAll) as $i) {
                if ($permissionsHandler->permAlbumEdit($albumsAll[$i]->getVar('alb_id'), $albumsAll[$i]->getVar('alb_submitter'))) {
                    $child     = $this->getListChildsOfCollection($albumsAll[$i]->getVar('alb_id'));
                    $childsAll .= '<li style="display: list-item;" class="mjs-nestedSortable-branch mjs-nestedSortable-collapsed" id="menuItem_' . $albumsAll[$i]->getVar('alb_id') . '">';

                    $childsAll .= '<div class="menuDiv">';
                    if ($child) {
                        $childsAll .= '<span title="Click to show/hide children" class="disclose ui-icon ui-icon-plusthick"><span>-</span></span>';
                    }
                    $childsAll .= '<span>';
                    $childsAll .= '<span data-id="' . $albumsAll[$i]->getVar('alb_id') . '" class="itemTitle">' . $albumsAll[$i]->getVar('alb_name') . '</span>';
                    $childsAll .= '<span class="pull-right">
                                    <a class="" href="albums.php?op=edit&amp;alb_id=' . $albumsAll[$i]->getVar('alb_id') . '" title="' . \_CO_WGGALLERY_ALBUM_EDIT . '">
                                        <img class="wgg-btn-icon" src="' . \WGGALLERY_ICONS_URL . '/16/edit.png" alt="' . \_CO_WGGALLERY_ALBUM_EDIT . '">
                                    </a></span>';
                    $childsAll .= '</span>';
                    $childsAll .= '</div>';

                    if ($child) {
                        $childsAll .= $child;
                    }
                    $childsAll .= '</li>';
                }
            }
        } else {
            return false;
        }
        if ($albPid > 0) {
            $childsAll .= '</ol>';
        }

        return $childsAll;
    }

    /**
     * Get all childs of a category
     * @param $albPid
     * @param $target
     * @param bool $showThumb
     * @return bool|string
     */
    public function getListChildsOfCollectionIndex($albPid, $target, $showThumb = false)
    {
        if ($albPid > 0) {
            $childsAll = '<ol class="wgg-alblist-ol">';
        } else {
            $childsAll = '';
        }

        $helper             = \XoopsModules\Wggallery\Helper::getInstance();
        $albumsHandler      = $helper->getHandler('Albums');
        $permissionsHandler = $helper->getHandler('Permissions');
        $crAlbums           = new \CriteriaCompo();
        $crAlbums->add(new \Criteria('alb_pid', $albPid));
        $crAlbums->setSort('alb_weight ASC, alb_date');
        $crAlbums->setOrder('DESC');
        $albumsCount = $albumsHandler->getCount($crAlbums);
        $albumsAll   = $albumsHandler->getAll($crAlbums);
        // Table view albums
        if ($albumsCount > 0) {
            foreach (\array_keys($albumsAll) as $i) {
                $album = $albumsAll[$i]->getValuesAlbums();
                if ($permissionsHandler->permAlbumView($album['alb_id'])) {
                    $child     = $this->getListChildsOfCollectionIndex($album['alb_id'], $target, $showThumb);
                    $childsAll .= '<li class="wgg-alblist-li" id="menuItem_' . $album['alb_id'] . '">';

                    $albName = $album['alb_name'];
                    $childsAll .= '<a class="wgg-alblist-link" href="' . $target . '&amp;alb_id=' . $album['alb_id'] . '" title="' . $albName . '">';
                    if ($showThumb) {
                        $childsAll .= '<img class="wgg-alblist-thumb" src="' . $album['image'] . '" alt="' . $albName . '">';
                    }
                    $childsAll .= $albName . '</a>';
                    if ($child) {
                        $childsAll .= $child;
                    }
                    $childsAll .= '</li>';
                }
            }
        } else {
            return false;
        }
        if ($albPid > 0) {
            $childsAll .= '</ol>';
        }

        return $childsAll;
    }

/* ******************************
 * Update weight
 * *********************** */
 function updateWeight($albId, $action, $step = 10){
 global $xoopsDB;
 $table = $this->table;
 $fldWeight = 'alb_weight';
 $fldCollId = 'alb_pid';
 $fldId = 'alb_id';    
 
    //recherche de la collection parent
    $albumObj = $this->get($albId);
    $albCollId = $albumObj->getVar($fldCollId);
//echo "poids {$albId}/{$albCollId} = " . $albumObj->getVar($fldWeight) . "<br>";
    
    $clauseWhere = "WHERE {$fldCollId}={$albCollId}";     
    $clauseOrder = "ORDER BY {$fldWeight},{$fldId}";
 
 
         switch ($action){
            case 'up'; 
              $newValue = "{$fldWeight} = {$fldWeight}-{$step}-1";
              break;

            case 'down'; 
              $newValue = "{$fldWeight} = {$fldWeight}+{$step}+1";
            break;

            case 'first'; 
              $newValue = "{$fldWeight} = -99999";
            break;

            case 'last'; 
              $newValue = "{$fldWeight} = 99999";
              
            default; 
              $newValue = "{$fldWeight} = 88888";
            break;
            
         }
    //defini le poids du premier element
    $firstWeight = $step;
    $sql = "SET @rank={$firstWeight};";
    $result = $xoopsDB->queryf($sql);
    
    //recalcul le poids pour la collection
    $sql = "UPDATE {$table} SET {$fldWeight} = (@rank:=@rank+{$step}) {$clauseWhere} {$clauseOrder};";    
    $result = $xoopsDB->queryf($sql);
    //----------------------------------------------------------
    //affectation de la nouvelle � l'album selectionn�
   // $albumObj->setVar($fldWeight, );
    //$this->insert($albumObj);
     $sql = "UPDATE {$table} SET {$newValue} WHERE alb_id={$albId}"; 
     $xoopsDB->queryf($sql);
//echo "poids {$albId}/{$albCollId} = " . $albumObj->getVar($fldWeight) . "<br>";
    //----------------------------------------------------------
    //recalcul du poids par pas de 10 (par default)
    //$firstWeight = $step;
    $sql = "SET @rank={$firstWeight};";
    $result = $xoopsDB->queryf($sql);

    $sql = "UPDATE {$table} SET {$fldWeight} = (@rank:=@rank+{$step}) {$clauseWhere} {$clauseOrder};";    
    $result = $xoopsDB->queryf($sql);
 }
 
/* ******************************
 * Recilcule le pids des albums d'une collection selon les champs pass� en param�tre
 * *********************** */
 function updatetWeightByFields($albCollId, $sort="alb_name,alb_id", $step = 10){
 global $xoopsDB;
 $table = $this->table;
 $fldWeight = 'alb_weight';
 $fldCollId = 'alb_pid';
 $fldId = 'alb_id';    
 
    
    $clauseWhere = "WHERE {$fldCollId}={$albCollId}";     
    $clauseOrder = "ORDER BY {$sort}";
 
    //defini le poids du premier element
    $firstWeight = $step;
    $sql = "SET @rank={$firstWeight};";
    $result = $xoopsDB->queryf($sql);
    
    //recalcul le poids pour la collection
    $sql = "UPDATE {$table} SET {$fldWeight} = (@rank:=@rank+{$step}) {$clauseWhere} {$clauseOrder};";    
    $result = $xoopsDB->queryf($sql);
    //----------------------------------------------------------
 
 }
    
}

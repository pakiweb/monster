<?php

/* -----------------------------------------------------------------------------------------
   $Id: index.php 1321 2005-10-26 20:55:07Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(default.php,v 1.84 2003/05/07); www.oscommerce.com
   (c) 2003         nextcommerce (default.php,v 1.13 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3                Autor: Mikel Williams | mikel@ladykatcostumes.com
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


include ('includes/application_top.php');
// save belboon url argument in session variable "belboon_id"
if(isset($_GET['belboon']) AND strlen($_GET['belboon'])>1){
    $_SESSION['belboon_id'] = $_GET['belboon'];
}

$referrer = $HTTP_REFERER;
if(strpos($referrer,"ref=tracdelight")!==false) { $_SESSION['tracdelight'] == "aktiv"; }

// create smarty elements

$smarty = new Smarty;

// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// the following cPath references come from application_top.php
$category_depth = 'top';

if (isset ($cPath) && xtc_not_null($cPath)) {
        $categories_products_query = "select count(*) as total from ".TABLE_PRODUCTS_TO_CATEGORIES." where categories_id = '".$current_category_id."'";
        $categories_products_query = xtDBquery($categories_products_query);
        $cateqories_products = xtc_db_fetch_array($categories_products_query, true);
        if ($cateqories_products['total'] > 0) {
                $category_depth = 'products'; // display products
        } else {
                $category_parent_query = "select count(*) as total from ".TABLE_CATEGORIES." where parent_id = '".$current_category_id."'";
                $category_parent_query = xtDBquery($category_parent_query);
                $category_parent = xtc_db_fetch_array($category_parent_query, true);
                if ($category_parent['total'] > 0) {
                        $category_depth = 'nested'; // navigate through the categories
                } else {
                        $category_depth = 'products'; // category has no products, but display the 'no products' message
                }
        }
}



require (DIR_WS_INCLUDES.'header.php');



include (DIR_WS_MODULES.'default.php');
$smarty->assign('language', $_SESSION['language']);

$smarty->caching = 0;
if (!defined(RM))
        $smarty->load_filter('output', 'note');

$smarty->assign('bluegate', $_REQUEST["bluegatemapto"]);
$smarty->assign('linkurl', $_REQUEST["linkurl"]);
$smarty->assign('ishome', 0);


if($_REQUEST["bluegatemapto"] == "category") {
        $query = mysql_query('select * from bluegate_seo_url WHERE categories_id = '.$category['categories_id']);
        $row = mysql_fetch_assoc($query);
        $smarty->assign('cat_url', $row['url_text']);

        $queryMeta = mysql_query("SELECT categories_meta_keywords,
                                                            categories_meta_description,
                                                            categories_meta_title,
                                                            categories_name
                                                            FROM " . TABLE_CATEGORIES_DESCRIPTION . "
                                                            WHERE categories_id='" . $category['categories_id'] . "' and
                                                            language_id='" . $_SESSION['languages_id'] . "'");

        $rowMeta = mysql_fetch_assoc($queryMeta);
        $smarty->assign('cat_meta_title', $rowMeta['categories_meta_title']);

}


if(isset($_REQUEST["bluegatemapto"]) && $_REQUEST["bluegatemapto"] == "category" && $_REQUEST["linkurl"] == "") {
        $smarty->assign('ishome', 1);
        if($_SESSION["customers_status"]["customers_status_name"] == "Admin") {
                        $smarty->display(CURRENT_TEMPLATE.'/index-relaunch.html');
        }else {
                $smarty->display(CURRENT_TEMPLATE.'/index-relaunch.html');
        }


}
else {
        if(isset($_REQUEST["bluegatemapto"]) && $_REQUEST["bluegatemapto"] == "category" && $_REQUEST["linkurl"] != "") {
                $smarty->display(CURRENT_TEMPLATE.'/index-neu.html');
        }
        else
                $smarty->display(CURRENT_TEMPLATE.'/index.html');
}
include ('includes/application_bottom.php');
?>

<?php

/**
 * ECSHOP mobile首页
*/

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');

/* 会员是否登录判断*/

if($_SESSION['user_id']<1){
	Header("Location: user.php");
	exit;
}

/**
 * 广告
 */
//$sql = 'SELECT a.ad_link, a.ad_name,a.start_time,a.end_time,a.ad_code,b.* FROM ecs_ad a LEFT JOIN ecs_ad_position b ON a.position_id=b.position_id WHERE a.enabled = 1';
$sql  = 'SELECT a.ad_id, a.position_id, a.media_type, a.ad_link, a.ad_code, a.ad_name, p.ad_width, ' .
                    'p.ad_height, p.position_style, RAND() AS rnd ' .
                'FROM ' . $ecs->table('ad') . ' AS a '.
                'LEFT JOIN ' . $ecs->table('ad_position') . ' AS p ON a.position_id = p.position_id ' .
                "WHERE enabled = 1 AND start_time <= '" . time() . "' AND end_time >= '" . time() . "' AND a.ad_id IN(5,6,7,8)".
                'ORDER BY a.ad_id,rnd LIMIT 4';

$adarr = $db->getAll($sql);

if(!empty($adarr)){
	foreach ($adarr as $k=>$v){
		$src = (strpos($v['ad_code'], 'http://') === false && strpos($v['ad_code'], 'https://') === false)?DATA_DIR . "/afficheimg/$v[ad_code]" : $v['ad_code'];
		$adarr[$k]['ad_code'] = $v['ad_code'];
	}

}
$smarty->assign('adarr', $adarr);

/**
 * 缤纷好礼
 */
$smarty->assign('cat_goods',       get_cat_goods('1','60')); //获取分类下商品 Add by Jole


$best_goods = get_recommend_goods('best');
$best_num = count($best_goods);
$smarty->assign('best_num' , $best_num);
if ($best_num > 0)
{
    $i = 0;
    foreach  ($best_goods as $key => $best_data)
    {
        $best_goods[$key]['shop_price'] = encode_output($best_data['shop_price']);
        $best_goods[$key]['name'] = encode_output($best_data['name']);
        /*if ($i > 2)
        {
            break;
        }*/
        $i++;
    }
    $smarty->assign('best_goods' , $best_goods);
}

/* 热门商品 */
$hot_goods = get_recommend_goods('hot');
$hot_num = count($hot_goods);
$smarty->assign('hot_num' , $hot_num);
if ($hot_num > 0)
{
    $i = 0;
    foreach  ($hot_goods as $key => $hot_data)
    {
        $hot_goods[$key]['shop_price'] = encode_output($hot_data['shop_price']);
        $hot_goods[$key]['name'] = encode_output($hot_data['name']);
        /*if ($i > 2)
        {
            break;
        }*/
        $i++;
    }
    $smarty->assign('hot_goods' , $hot_goods);
}


$promote_goods = get_promote_goods();
$promote_num = count($promote_goods);
$smarty->assign('promote_num' , $promote_num);
if ($promote_num > 0)
{
    $i = 0;
    foreach ($promote_goods as $key => $promote_data)
    {
        $promote_goods[$key]['shop_price'] = encode_output($promote_data['shop_price']);
        $promote_goods[$key]['name'] = encode_output($promote_data['name']);
        /*if ($i > 2)
        {
            break;
        }*/
        $i++;
    }
    $smarty->assign('promote_goods' , $promote_goods);
}

$pcat_array = get_categories_tree();
foreach ($pcat_array as $key => $pcat_data)
{
    $pcat_array[$key]['name'] = encode_output($pcat_data['name']);
    if ($pcat_data['cat_id'])
    {
        if (count($pcat_data['cat_id']) > 3)
        {
            $pcat_array[$key]['cat_id'] = array_slice($pcat_data['cat_id'], 0, 3);
        }
        foreach ($pcat_array[$key]['cat_id'] as $k => $v)
        {
            $pcat_array[$key]['cat_id'][$k]['name'] = encode_output($v['name']);
        }
    }
}
$smarty->assign('pcat_array' , $pcat_array);
$brands_array = get_brands();
if (!empty($brands_array))
{
    if (count($brands_array) > 3)
    {
        $brands_array = array_slice($brands_array, 0, 10);
    }
    foreach ($brands_array as $key => $brands_data)
    {
        $brands_array[$key]['brand_name'] = encode_output($brands_data['brand_name']);
    }
    $smarty->assign('brand_array', $brands_array);
}

$article_array = $db->GetALLCached("SELECT article_id, title FROM " . $ecs->table("article") . " WHERE cat_id != 0 AND is_open = 1 AND open_type = 0 ORDER BY article_id DESC LIMIT 0,4");
if (!empty($article_array))
{
    foreach ($article_array as $key => $article_data)
    {
        $article_array[$key]['title'] = encode_output($article_data['title']);
    }
    $smarty->assign('article_array', $article_array);
}
if ($_SESSION['user_id'] > 0)
{
    $smarty->assign('user_name', $_SESSION['user_name']);
}

if (!empty($GLOBALS['_CFG']['search_keywords']))
{
    $searchkeywords = explode(',', trim($GLOBALS['_CFG']['search_keywords']));
}
else
{
    $searchkeywords = array();
}
$smarty->assign('searchkeywords', $searchkeywords);

$smarty->assign('wap_logo', $_CFG['wap_logo']);
$smarty->assign('footer', get_footer());
$smarty->assign('header', get_header());
$smarty->display("index.html");

?>

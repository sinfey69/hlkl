<?php

/**
 * ECSHOP mobile首页
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: index.php 15013 2010-03-25 09:31:42Z liuhui $
*/

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');

/* 会员是否登录判断 2014-04-13 add by Jole -- Start -- */

if($_SESSION['user_id']<1){
	Header("Location: user.php");
	exit;
}

/**
 * 缤纷好礼
 */
/**/
$page         = isset($_REQUEST['page'])   && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
$size         = isset($_CFG['page_size'])  && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;
$cat_id       = isset($_REQUEST['cat_id']) && intval($_REQUEST['cat_id']) > 0 ? intval($_REQUEST['cat_id']) : 0;
$integral_max = isset($_REQUEST['integral_max']) && intval($_REQUEST['integral_max']) > 0 ? intval($_REQUEST['integral_max']) : 0;
$integral_min = isset($_REQUEST['integral_min']) && intval($_REQUEST['integral_min']) > 0 ? intval($_REQUEST['integral_min']) : 0;

/* 排序、显示方式以及类型 */
$default_display_type      = $_CFG['show_order_type'] == '0' ? 'list' : ($_CFG['show_order_type'] == '1' ? 'grid' : 'text');
$default_sort_order_method = $_CFG['sort_order_method'] == '0' ? 'DESC' : 'ASC';
$default_sort_order_type   = $_CFG['sort_order_type'] == '0' ? 'goods_id' : ($_CFG['sort_order_type'] == '1' ? 'exchange_integral' : 'last_update');

$sort    = (isset($_REQUEST['sort'])  && in_array(trim(strtolower($_REQUEST['sort'])), array('goods_id', 'exchange_integral', 'last_update'))) ? trim($_REQUEST['sort'])  : $default_sort_order_type;
$order   = (isset($_REQUEST['order']) && in_array(trim(strtoupper($_REQUEST['order'])), array('ASC', 'DESC')))                              ? trim($_REQUEST['order']) : $default_sort_order_method;

$ext = ''; //商品查询条件扩展
$children = get_children($cat_id);

$cat_goods = exchange_get_goods($children, $integral_min, $integral_max, $ext, $size, $page, $sort, $order);
// dump($cat_goods);
// $cat_goods = get_cat_goods('1','60');
// if(!empty($cat_goods)){
// 	foreach ($cat_goods as $ke=>$v){
// 		$cat_goods[$ke]['shop_price'] = str_replace("话费", '', $v['shop_price']);
// 	}
// }
$gnum = count($cat_goods);
$gnum = ceil($gnum/2);

$smarty->assign('gnum',      $gnum); //获取分类下商品 Add by Jole
$smarty->assign('cat_goods',      $cat_goods); //获取分类下商品 Add by Jole

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
$smarty->display("good.html");


function exchange_get_goods($children, $min, $max, $ext, $size, $page, $sort, $order)
{
	$display = $GLOBALS['display'];
	$where = "eg.is_exchange = 1 AND g.is_delete = 0 AND ".
			"($children OR " . get_extension_goods($children) . ')';

	if ($min > 0)
	{
		$where .= " AND eg.exchange_integral >= $min ";
	}

	if ($max > 0)
	{
		$where .= " AND eg.exchange_integral <= $max ";
	}

	/* 获得商品列表 */
	$sql = 'SELECT g.goods_id, g.goods_name, g.goods_name_style, eg.exchange_integral,eg.goods_price, ' .
			'g.goods_type, g.goods_brief, g.goods_thumb , g.goods_img, eg.is_hot ' .
			'FROM ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg, ' .$GLOBALS['ecs']->table('goods') . ' AS g ' .
			"WHERE eg.goods_id = g.goods_id AND $where $ext ORDER BY $sort $order";
	//echo $sql;exit;
	$res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);

	$arr = array();
	while ($row = $GLOBALS['db']->fetchRow($res))
	{
		/* 处理商品水印图片 */
		$watermark_img = '';

		//        if ($row['is_new'] != 0)
			//        {
			//            $watermark_img = "watermark_new_small";
			//        }
			//        elseif ($row['is_best'] != 0)
			//        {
			//            $watermark_img = "watermark_best_small";
			//        }
			//        else
		if ($row['is_hot'] != 0)
		{
			$watermark_img = 'watermark_hot_small';
		}

		if ($watermark_img != '')
		{
			$arr[$row['goods_id']]['watermark_img'] =  $watermark_img;
		}

		$arr[$row['goods_id']]['goods_id']          = $row['goods_id'];
		if($display == 'grid')
		{
			$arr[$row['goods_id']]['goods_name']    = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
		}
		else
		{
			$arr[$row['goods_id']]['goods_name']    = $row['goods_name'];
		}
		$arr[$row['goods_id']]['name']              = $row['goods_name'];
		$arr[$row['goods_id']]['goods_price']              = $row['goods_price'];
		$arr[$row['goods_id']]['goods_brief']       = $row['goods_brief'];
		$arr[$row['goods_id']]['goods_style_name']  = add_style($row['goods_name'],$row['goods_name_style']);
		$arr[$row['goods_id']]['exchange_integral'] = $row['exchange_integral'];
		$arr[$row['goods_id']]['type']              = $row['goods_type'];
		$arr[$row['goods_id']]['goods_thumb']       = get_image_path($row['goods_id'], $row['goods_thumb'], true);
		$arr[$row['goods_id']]['goods_img']         = get_image_path($row['goods_id'], $row['goods_img']);
		$arr[$row['goods_id']]['url']               = build_uri('exchange_goods', array('gid'=>$row['goods_id']), $row['goods_name']);
	}

	return $arr;
}
?>

<?php

/**
 * ECSHOP 商品页
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: testyang $
 * $Id: goods.php 15013 2008-10-23 09:31:42Z testyang $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* 会员是否登录判断 */

if($_SESSION['user_id']<1){
	Header("Location: user.php");
	exit;
}

$goods_id = !empty($_GET['id']) ? intval($_GET['id']) : '';
if($goods_id){
	$sql = "select a.*,b.attr_name from ecs_goods_attr a left join ecs_attribute b on a.attr_id=b.attr_id where goods_id=".$goods_id;
	$goodattr = $db->getAll($sql);
	
	//$goods_info = get_goods_info($goods_id);
	$goods_info = get_exchange_goods_info($goods_id);
}

if(!empty($goodattr)){
	foreach ($goodattr as $k=>$v){		
		$goodattr[$k]['attr_name'] = $v['attr_name']."：";
	}
}
$smarty->assign('goodattr',            $goodattr);                    // 商品的属性
$smarty->assign('pictures',            get_goods_gallery($goods_id));                    // 商品相册


$smarty->assign('goods_id', $goods_id);
$smarty->assign('goods_info', $goods_info);
$smarty->assign('header', get_header());
$smarty->display('goods.html');

/**
 * 获得积分兑换商品的详细信息
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  void
 */
function get_exchange_goods_info($goods_id)
{
	$time = gmtime();
	$sql = 'SELECT g.*, c.measure_unit, b.brand_id, b.brand_name AS goods_brand, eg.exchange_integral, eg.is_exchange,eg.goods_price ' .
			'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
			'LEFT JOIN ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg ON g.goods_id = eg.goods_id ' .
			'LEFT JOIN ' . $GLOBALS['ecs']->table('category') . ' AS c ON g.cat_id = c.cat_id ' .
			'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON g.brand_id = b.brand_id ' .
			"WHERE g.goods_id = '$goods_id' AND g.is_delete = 0 " .
			'GROUP BY g.goods_id';

	$row = $GLOBALS['db']->getRow($sql);
	file_put_contents("bill/lastsql.txt",$sql."\r\n",FILE_APPEND);
	if ($row !== false)
	{
		/* 处理商品水印图片 */
		$watermark_img = '';

		if ($row['is_new'] != 0)
		{
			$watermark_img = "watermark_new";
		}
		elseif ($row['is_best'] != 0)
		{
			$watermark_img = "watermark_best";
		}
		elseif ($row['is_hot'] != 0)
		{
			$watermark_img = 'watermark_hot';
		}

		if ($watermark_img != '')
		{
			$row['watermark_img'] =  $watermark_img;
		}

		/* 修正重量显示 */
		$row['goods_weight']  = (intval($row['goods_weight']) > 0) ?
		$row['goods_weight'] . $GLOBALS['_LANG']['kilogram'] :
		($row['goods_weight'] * 1000) . $GLOBALS['_LANG']['gram'];

		/* 修正上架时间显示 */
		$row['add_time']      = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);

		/* 修正商品图片 */
		$row['goods_img']   = get_image_path($goods_id, $row['goods_img']);
		$row['goods_thumb'] = get_image_path($goods_id, $row['goods_thumb'], true);

		return $row;
	}
	else
	{
		return false;
	}
}

?>
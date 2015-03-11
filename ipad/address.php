<?php

/**
 * ECSHOP 首页文件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: index.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');

$act = isset($_GET['act'])?trim($_GET['act']):"";
if($act == 'add'){
	$did = isset($_POST['did'])?intval($_POST['did']):"";
	$address_id = isset($_POST['address_id'])?intval($_POST['address_id']):"";
	
	if($did>0 && $address_id>0){
		$sql = "UPDATE t_draw SET address_id=".$address_id." WHERE id=".$did;
		$db->query($sql);		
	}
	echo "<script>alert('送货地址添加成功');location.href='index.php';</script>";
	exit;
}
include_once('includes/lib_transaction.php');

$did = isset($_GET['did'])?htmlspecialchars($_GET['did']):"";
$smarty->assign('did', $did);
/*
 * 收货人信息填写界面
*/

if (isset($_REQUEST['direct_shopping']))
{
	$_SESSION['direct_shopping'] = 1;
}

/* 取得国家列表、商店所在国家、商店所在国家的省列表 */
$smarty->assign('country_list',       get_regions());
$smarty->assign('shop_country',       $_CFG['shop_country']);
$smarty->assign('shop_province_list', get_regions(1, $_CFG['shop_country']));

/**
 * 收货地址
 */
$consignee_list = get_consignee_list($_SESSION['user_id']);
$smarty->assign('consignee_list',       $consignee_list);


/* 取得每个收货地址的省市区列表 */
$province_list = array();
$city_list = array();
$district_list = array();
foreach ($consignee_list as $region_id => $consignee)
{
	$consignee['country']  = isset($consignee['country'])  ? intval($consignee['country'])  : 0;
	$consignee['province'] = isset($consignee['province']) ? intval($consignee['province']) : 0;
	$consignee['city']     = isset($consignee['city'])     ? intval($consignee['city'])     : 0;

	$province_list = get_regions(1, $consignee['country']);
	$city_list     = get_regions(2, $consignee['province']);
	$district_list = get_regions(3, $consignee['city']);
}

$smarty->assign('province_list', $province_list);
$smarty->assign('city_list',     $city_list);
$smarty->assign('district_list', $district_list);

$smarty->assign('header', get_header());
$smarty->display("address.html");

?>
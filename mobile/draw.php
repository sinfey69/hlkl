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

/* 会员是否登录判断 2014-04-13 add by Jole -- Start -- */
if($_SESSION['user_id']<1){
	if($_GET['is_ajax']){
		include('includes/cls_json.php');
		$json = new JSON;
		$res['message'] = '请先登录';
		$res['error'] = 1;
		die($json->encode($res));
	}else{
		ecs_header("Location: user.php");
	}
}


if($_POST['act'] == 'address'){
	$address_id = intval($_POST['address_id']);
	$id = intval($_POST['did']);
	$draw_id = intval($_POST['draw_id']);
	if($address_id == 0 || $id == 0 || $draw_id == 0){
        ecs_header("draw.php");
        exit;
	}

	$sql = 'SELECT count(id) FROM t_draw WHERE address_id = 0 AND did= \''.$draw_id.'\' AND id = '.$id.' AND category = 1 AND mobile='.$_SESSION['user_name'];
	if(!$db->getOne($sql)){
        ecs_header("draw.php");
        exit;
	}
	$sql = "UPDATE t_draw SET address_id = '$address_id' WHERE id = '$id' AND did= '$draw_id' AND mobile = '$_SESSION[user_name]'";
	$db->query($sql);
	echo "<script>alert('收货地址设置成功');location='draw.php';</script>";
	exit;
}elseif($_POST['act'] == 'new_address'){
	$id = intval($_POST['did']);
	$draw_id = intval($_POST['draw_id']);
	$sql = 'SELECT count(id) FROM t_draw WHERE address_id = 0 AND did= \''.$draw_id.'\' AND id = '.$id.' AND category = 1 AND mobile='.$_SESSION['user_name'];
	if(!$db->getOne($sql)){
        ecs_header("draw.php");
        exit;
	}
	$consignee = compile_str(trim($_POST['consignee']));
	$mobile = compile_str(make_semiangle(trim($_POST['mobile'])));
	$province = intval($_POST['province']);
	$city = intval($_POST['city']);
	$district = intval($_POST['district']);
	$address = compile_str(trim($_POST['address']));

	$sql = "INSERT INTO ecs_user_address(consignee,mobile,country,province,city,district,address,user_id) values('" . $consignee . "','" . $mobile . "',1," . $province . "," . $city . "," . $district . ",'" . $address . "'," . $_SESSION['user_id'] . ")";
	$db->query($sql);
	$address_id = $db->insert_id();
	$sql = "UPDATE t_draw SET address_id = '$address_id' WHERE did= '$draw_id' AND id = '$id' AND mobile = '$_SESSION[user_name]'";
	$db->query($sql);
	echo "<script>alert('收货地址设置成功');location='draw.php';</script>";
	exit;
}elseif($_POST['act'] == 'query'){
	include('includes/cls_json.php');
	
	/*获取最新一场活动数据*/
	$sql = 'SELECT did FROM ' .$GLOBALS['ecs']->table('exchange_draw'). ' ORDER BY add_time DESC LIMIT 1';
	$draw_id = $GLOBALS['db']->getOne($sql);

	$json = new JSON;
	$list = get_pzd_list($_SESSION['user_name'],$draw_id);
	$smarty->assign('drawlist',$list['list']);
	$smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

	$res['content'] = $smarty->fetch('draw_list.html');
	$res['error'] = 0;
	$res['filter'] = $list['filter'];
	$res['page_count'] = $list['page_count'];

	die($json->encode($res));
}else{

	/*获取最新一场活动数据*/
	$sql = 'SELECT * FROM ' .$GLOBALS['ecs']->table('exchange_draw'). ' ORDER BY add_time DESC LIMIT 1';
	$draw = $GLOBALS['db']->getRow($sql);
	if(empty($draw)){
		echo "<script>alert('暂无活动进行');location='/';</script>";
		exit;
	}
	$draw_id =  $draw['did'];
	$lotteryTitle =  $draw['draw_title'];

	/**
	 * 取出中奖信息
	 */
	$sql = 'SELECT * FROM t_draw WHERE category = 1 AND did = \''.$draw_id.'\' AND category = 1 ORDER BY intime DESC limit 10';
	$draw_list = $db->getAll($sql);
	shuffle($draw_list);
	if(!empty($draw_list)){
		foreach ($draw_list as $k=>$v){		
			$draw_list[$k]['mobile'] = str_replace(substr($v['mobile'], 0,7), '****', $v['mobile']);
			$draw_list[$k]['name'] = $v['name'];
		}
	}
	$smarty->assign('draw_list', $draw_list);
	$smarty->assign('draw', $draw);
	
	$smarty->assign('province_list', get_regions(1, $_CFG['shop_country']));

	$smarty->assign('header', get_header());
	$smarty->display("draw.html");
}

/*
 * 分页查询
 */
function get_pzd_list($mobile,$draw_id){ 

	$sql = "SELECT COUNT(*) FROM t_draw WHERE mobile=".$mobile." AND did='".intval($draw_id)."'";
	
	$filter['record_count'] = $GLOBALS['db']->getOne($sql);  
	$filter = page_and_size($filter);
	  
	/* 获取活动数据 */  
	$sql = "SELECT a.*,b.address,b.consignee,b.province,b.city,b.district,b.mobile as mobile2,b.tel FROM t_draw a LEFT JOIN ecs_user_address b ON a.address_id=b.address_id WHERE a.mobile=".$mobile." AND a.did='".$draw_id."' ORDER BY id DESC LIMIT ".$filter['start'].", ".$filter['page_size']; 
	

	$row = $GLOBALS['db']->getAll($sql);
	foreach($row as $key => $val){
		$province = get_regionsName($val['province']);
		$city = get_regionsName($val['city']);
		$district = get_regionsName($val['district']);
		$row[$key]['province'] = $province;
		$row[$key]['city'] = $city;
		$row[$key]['district'] = $district;
		$row[$key]['intime'] = local_date('Y-m-d H:i:s',$val['intime']);

	}
	$arr = array('list' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	return $arr;  

} 

function page_and_size($filter)
{
    if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
    {
        $filter['page_size'] = intval($_REQUEST['page_size']);
    }
    elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
    {
        $filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
    }
    else
    {
        $filter['page_size'] = 5;
    }

    /* 每页显示 */
    $filter['page'] = (empty($_REQUEST['page']) || intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

    /* page 总数 */
    $filter['page_count'] = (!empty($filter['record_count']) && $filter['record_count'] > 0) ? ceil($filter['record_count'] / $filter['page_size']) : 1;

    /* 边界处理 */
    if ($filter['page'] > $filter['page_count'])
    {
        $filter['page'] = $filter['page_count'];
    }

    $filter['start'] = ($filter['page'] - 1) * $filter['page_size'];

    return $filter;
}

?>
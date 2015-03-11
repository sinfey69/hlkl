<?php

/**
 * ECSHOP 积分抽奖
 * ============================================================================
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$act = isset($_REQUEST['act'])?$_REQUEST['act']:'list';

/*------------------------------------------------------ */
//-- 中奖列表
/*------------------------------------------------------ */
if ($act == 'list')
{

	//获取抽奖活动列表
	$sql = 'SELECT did,draw_title FROM ' .$GLOBALS['ecs']->table('exchange_draw'). ' ORDER BY add_time';
	$draw_list = $GLOBALS['db']->getAll($sql);

	//获取列表信息
	$list = get_pzd_list(1);
	
    $smarty->assign('draw_list',   $draw_list);
    $smarty->assign('list',   $list['list']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);
    
    //后台页面样式
    $smarty->assign('full_page',    1);

    //跳转页面
    assign_query_info();
    $smarty->display('draw_list.htm');
    
/*------------------------------------------------------ */
//-- 分页代码
/*------------------------------------------------------ */  
}elseif ($_REQUEST['act'] == 'query'){ 
	//获取列表信息
	$category = isset($_POST['category'])?intval($_POST['category']):0;
	$mobile = $_POST['mobile'];
	$did = $_POST['did'];
	if($category == 0){
		$cate = 0;
		$tpl = 'draw_nolist.htm';
	}else{
		$cate = 1;
		$tpl = 'draw_list.htm';
	}
	
	$list = get_pzd_list($cate,$mobile,$did);
	
    $smarty->assign('list',   $list['list']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);
	  
	//跳转页面  
	make_json_result($smarty->fetch($tpl),'',array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}
/*------------------------------------------------------ */
//-- 导出excel
/*------------------------------------------------------ */  
elseif ($_REQUEST['act'] == 'export'){ 
	//获取列表信息
	$category = isset($_POST['category'])?intval($_POST['category']):0;
	$mobile = $_POST['mobile'];
	$did = $_POST['did'];
	export_draw_execl($category,$mobile,$did);
	exit();
	
}
/*------------------------------------------------------ */
//-- 删除
/*------------------------------------------------------ */
elseif($act == 'del'){
	$id = isset($_GET['id'])?intval($_GET['id']):0;
	if($id > 0){
		$sql = "DELETE FROM t_draw WHERE id=".$id;
		$db->query($sql);
	}
	ecs_header("Location:draw.php?act=list");
	exit;
	
/*------------------------------------------------------ */
//-- 未中奖列表
/*------------------------------------------------------ */	
}elseif($act == 'nolist'){
	//获取抽奖活动列表
	$sql = 'SELECT did,draw_title FROM ' .$GLOBALS['ecs']->table('exchange_draw'). ' ORDER BY add_time';
	$draw_list = $GLOBALS['db']->getAll($sql);

	$list = get_pzd_list(0);
	
	$smarty->assign('draw_list',   $draw_list);
    $smarty->assign('list',   $list['list']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);
    $smarty->assign('full_page',    1);
	
	$smarty->display('draw_nolist.htm');
}

/*
 * 分页查询
 */
function get_pzd_list($category = 0,$mobile = 0,$did = -1){ 
	$sql = "SELECT COUNT(*) FROM t_draw WHERE category=".$category;
	if(!empty($mobile)){
		$sql .= " AND mobile='".$mobile."'";
	}
	if($did > -1){
		$sql .= " AND did='".$did."'";
	}
	$filter['record_count'] = $GLOBALS['db']->getOne($sql);  
	$filter = page_and_size($filter);
	  
	/* 获取活动数据 */  
	$sql = '';
	$sql = "SELECT a.*,b.address,b.consignee,b.province,b.city,b.district,b.mobile as mobile2,b.tel FROM t_draw a LEFT JOIN ecs_user_address b ON a.address_id=b.address_id WHERE a.category=".$category;
	if(!empty($mobile)){
		$sql .= " AND a.mobile='".$mobile."'";
	}
	if($did > -1){
		$sql .= " AND did='".$did."'";
	}
	$sql .= " ORDER BY id DESC LIMIT ".$filter['start'].", ".$filter['page_size']; 
	
	/* 额外的参数 */
	$filter['category'] = $category;
	$filter['mobile'] = $mobile;
	
	set_filter($filter, $sql);  
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


/**
 * 抽奖结果导出生成execl文件
 */

function export_draw_execl($category = 0,$mobile = 0,$did = -1){ 
	//抽奖结果
    $data_array = array();
		  
	/* 获取活动数据 */  
	$sql = '';
	$sql = "SELECT a.*,b.address,b.consignee,b.province,b.city,b.district,b.mobile as mobile2,b.tel FROM t_draw a LEFT JOIN ecs_user_address b ON a.address_id=b.address_id WHERE a.category=".$category;
	if(!empty($mobile)){
		$sql .= " AND a.mobile='".$mobile."'";
	}
	if($did > -1){
		$sql .= " AND did='".$did."'";
	}
	$sql .= " ORDER BY intime DESC"; 
	
    $data_array = $GLOBALS['db']->getAll($sql);
    if (empty($data_array)) {
        sys_msg('没有数据导出');
    }
    $cols_array[0] = array('活动名称','抽奖人','奖项','收货地址','联系方式','扣除积分','抽奖时间');

    $export_array = array();

    foreach ($data_array as $key => $val) {
		$export_array[$key][] = $val['lotteryTitle'];
		$export_array[$key][] = $val['mobile'];
		$export_array[$key][] = $val['name'];
		$province = get_regionsName($val['province']);
		$city = get_regionsName($val['city']);
		$district = get_regionsName($val['district']);
		$consignee = $province.$city.$district;
		if(!empty($val['consignee'])){
			$consignee .= " (".$val['consignee']." 收) ";
		}
		$export_array[$key][] = $consignee;
		$export_array[$key][] = !empty($val['mobile2']) ? $val['mobile2'] : $val['tel'];
		$export_array[$key][] = $val['deduct'];
		$export_array[$key][] = local_date('Y-m-d H:i:s',$val['intime']);
	}

    $result = array_merge($cols_array, $export_array);
    zip_download($result);
}
?>
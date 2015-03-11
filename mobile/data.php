<?php

/**
 * @author gd 464364696@qq.com
 * @var 大转盘
 */
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$result['code'] = '-1';
/* 会员是否登录判断 2014-04-13 add by Jole -- Start -- */
if($_SESSION['user_id'] < 1){
	$result['prize'] = '请先登录';
	echo json_encode($result);
	exit;
}

/*获取最新一场活动数据*/
$sql = 'SELECT * FROM ' .$GLOBALS['ecs']->table('exchange_draw'). ' ORDER BY add_time DESC LIMIT 1';
$draw = $GLOBALS['db']->getRow($sql);
if(empty($draw)){
	$result['prize'] = '暂无活动进行中';
	echo json_encode($result);
	exit;
}

if(gmtime() < $draw['start_time']){
	$result['prize'] = '活动尚未开始！';
	echo json_encode($result);
	exit;
}

if(gmtime() > $draw['end_time']){
	$result['prize'] = '活动已结束！';
	echo json_encode($result);
	exit;
}

$lotteryTitle = $draw['draw_title'];
$draw_id = $draw['did'];

/*获取奖品*/
$sql = 'SELECT * FROM ' .$GLOBALS['ecs']->table('exchange_draw_prizes').
               ' WHERE did=' .$draw_id;
$prize = $GLOBALS['db']->getAll($sql);
if(empty($prize)){
	$result['prize'] = '暂无活动奖品！';
	echo json_encode($result);
	exit;
}
foreach($prize as $key => $val){
	$val['angle'] = unserialize($val['angle']);
	$val['id'] = $key+1;
	$arr[] = $val;
}
/*获取概率换算比例*/
$pownum = calculate_odds($arr);

foreach($arr as $key => $val){
	$val['odds'] = ($val['odds']/100) * $pownum;
	$prize_arr[] = $val;
}

$TodayTime = local_strtotime(local_date('Y-m-d'));

/**
 * 积分扣取
 */
 $canuse = 0;
$canuse = @get_can_use_winning1($_SESSION['user_name']);
if($canuse > 0){
	$data = update_Winning1($_SESSION['user_name'], $draw['deduct'],$lotteryTitle); 
	if($data != 'true'){
		$result['prize'] = "积分扣取失败，请重试。";
		echo json_encode($result);
		exit;
	}
}else{
	$result['prize'] = "抱歉，您的积分不足。";
	echo json_encode($result);
	exit;
}

$arr = array();
foreach ($prize_arr as $key => $val) { 
    $arr[$val['id']] = $val['odds']; 
}  
$rid = getRand($arr,$pownum); //根据概率获取奖项id 
$res = $prize_arr[$rid-1]; //中奖项 
if($res['is_prize'] == 1){//已中奖
	$is_exceed = false;
	//查询奖品中奖总数
	$Count = get_count_prize($res['pid'],$draw_id);
	if($Count >= $res['count_limit'] && $res['count_limit'] > -1){
		$is_exceed = true;
	}else{
		//查询奖品每日中奖数
		$DayCount = get_prize_today_count($res['pid'],$TodayTime,$draw_id);
		if($DayCount >= $res['day_limit'] && $res['day_limit'] > -1){
			$is_exceed = true;
		}
	}
	if($is_exceed){
		$res = array();
		foreach($prize_arr as $val){
			if($val['is_prize'] == 0 ){
				$res = $val;
			}
		}
	}
}
$min = $max = 0;
if(count($res['angle']) > 1){
	$rand_angle = mt_rand(1,count($res['angle']));
	$min = $res['angle'][$rand_angle -1]['min']; 
	$max = $res['angle'][$rand_angle -1]['max'];
}else{
	$min = $res['angle'][0]['min']; 
	$max = $res['angle'][0]['max'];
}
$result['angle'] = mt_rand($min,$max); //随机生成一个角度
$result['is_real'] = $res['is_real']; //是否实物
$result['is_prize'] = $res['is_prize']; //是否中奖
/**
 *中奖信息插入到数据库
*/	
if($res['is_prize'] == 1){//已中奖
	$result['code'] = 1;
	$result['prize'] = $res['prize_name'];
	$prize_id = $res['pid'];
	$sql = "INSERT INTO t_draw(mobile,name,intime,category,lotteryTitle,did,prize_id,deduct) VALUES(".$_SESSION['user_name'].",'".$res['prize_name']."',".gmtime().",1,'".$lotteryTitle."',".$draw_id.",".$prize_id.",'".$draw['deduct']."')";
	$db->query($sql);
	$did = $db->insert_id();
	$result['did'] = $did;
	if($res['is_real'] == 1){
		/**
		 * 收货地址
		 */
		include_once('includes/lib_transaction.php');
		$consignee_list = get_consignee_list($_SESSION['user_id']);
		$consignee_html = '<script type="text/javascript" src="js/transport.js"></script><script type="text/javascript" src="js/region.js"></script><script type="text/javascript">region.isAdmin = false;</script>';
		if(!empty($consignee_list)){
			foreach ($consignee_list as $region_id => $val){	
				$is_check = $region_id == 0 ? 'checked="checked"' : '';
				$province = get_regionsName($val['province']);
				$city = get_regionsName($val['city']);
				$district = get_regionsName($val['district']);
				$consignee_html .= "<p>
									<input id=\"address_$val[address_id]\" type=\"radio\" name=\"address_id\" value=\"$val[address_id]\" $is_check>
									<label for=\"address_$val[address_id]\">$province&nbsp;&nbsp;$city&nbsp;&nbsp;$district&nbsp;&nbsp;$val[address]&nbsp;&nbsp;$val[consignee]收</label>
									</p>";
			}
		}else{
			$consignee_html .= '<p>暂无地址,请使用新地址</p>';
		}
		$result['draw_id'] = $draw_id;
		$result['consignee'] = $consignee_html;
	}
}else{
	$result['code'] = '0';
	$result['prize'] = $res['prize_name'];
	$prize_id = $res['pid'];
	$res['prize'] = $res['prize_name'];
	$sql = "INSERT INTO t_draw(mobile,name,intime,category,lotteryTitle,did,prize_id,deduct) VALUES(".$_SESSION['user_name'].",'".$res['prize_name']."',".gmtime().",0,'".$lotteryTitle."',".$draw_id.",".$prize_id.",'".$draw['deduct']."')";
	$db->query($sql);	
}
echo json_encode($result); 


function calculate_odds($arr){
	foreach($arr as $key => $val){
		$odds[$key] = $val['odds'];
	}
	$pos = array_search(min($odds), $odds);
	$min = $odds[$pos]/100;
	$dot_num = explode(".",$min);
	if(!empty($dot_num[1])){
		$dotnum = strlen(strval($dot_num[1]));
		$pownum = pow(10,$dotnum);
	}
	return $pownum;
}

function getRand($proArr,$proSum) { 
    $result = '';
    //概率数组循环 
    foreach ($proArr as $key => $proCur) { 
        $randNum = mt_rand(1, $proSum); 
        if ($randNum <= $proCur) { 
            $result = $key; 
            break; 
        } else { 
            $proSum -= $proCur; 
        } 
    } 
    unset ($proArr); 
    return $result; 
} 


//查询奖品今日抽中次数
function get_prize_today_count($prize_id = 0,$today_start = 0,$did = 0){
	$today_end = $today_start + 86400 - 1;
	$sql = "SELECT count(id) FROM t_draw WHERE category = 1 AND intime between  '".$today_start."' AND '". $today_end."' AND prize_id = '".$prize_id."' AND did ='".$did."'";
    return $GLOBALS['db']->getOne($sql);
}

//查询奖品被抽中总次数
function get_count_prize($prize_ids = 0,$did = 0){
	$sql = "SELECT count(id) FROM t_draw WHERE category = 1 AND prize_id IN(".$prize_ids .") AND did ='".$did."'";
	return $GLOBALS['db']->getOne($sql);
}


?>
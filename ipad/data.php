<?php

/**
 * @author gd 464364696@qq.com
 * @var 大转盘
 */
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
	$smarty->caching = true;
}

/**
 * 积分扣取
 */
$lotteryTitle = '0820积分抽大奖话费马上送';
$score = @get_can_use_winning1($_SESSION['user_name']);
if($score > 0){
	@update_Winning1($_SESSION['user_name'], 1,$lotteryTitle); 
}else{
	$result['angle'] = 0;
	$result['prize'] = "抱歉，您的积分不够。";
	echo json_encode($result);
	exit;
}

$prize_arr = array(
    '0' => array('id'=>1,'min'=>1,'max'=>45,'prize'=>'谢谢！努力吧，下次还有机会哦。','v'=>90),//弧度：1°-45°， v=1是中奖率是60
    '1' => array('id'=>2,'min'=>46,'max'=>90,'prize'=>'恭喜你，抽中“Calvin Klein CK太阳镜”','v'=>1), 
    '2' => array('id'=>3,'min'=>91,'max'=>135,'prize'=>'恭喜你，抽中“ME&CITY太阳镜”','v'=>1), 
    '3' => array('id'=>4,'min'=>181,'max'=>215,'prize'=>'谢谢！努力吧，下次还有机会哦。','v'=>90),
    '4' => array('id'=>5,'min'=>226,'max'=>270,'prize'=>'恭喜你，抽中“海伦凯伦时尚太阳镜”','v'=>1),
    '5' => array('id'=>6,'min'=>271,'max'=>314,'prize'=>'恭喜你，抽中“海伦恩潮流太阳镜”','v'=>1),
);

function getRand($proArr) { 
    $result = '';
    //概率数组的总概率精度 
    $proSum = array_sum($proArr);  
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


foreach ($prize_arr as $key => $val) { 
    $arr[$val['id']] = $val['v']; 
}  
$rid = getRand($arr); //根据概率获取奖项id 
$res = $prize_arr[$rid-1]; //中奖项 
$min = $res['min']; 
$max = $res['max']; 
$result['angle'] = mt_rand($min,$max); //随机生成一个角度

if($res['id']!=1 && $res['id']!=4){
	$price = array();
	$price = explode("“", $res['prize']);
	$prize = rtrim($price[1], "”");
	$result['prize'] = $prize;
	
	/**
	 *中奖几率插入到数据库
	 */	
	$sql = "INSERT INTO t_draw(mobile,name,intime) VALUES(".$_SESSION['user_name'].",'".$res['prize']."',".time().")";
	$db->query($sql);
	$did = $db->insert_id();
	$result['did'] = $did;
}else{
	$result['prize'] = $res['prize'];
}
echo json_encode($result); 
?>
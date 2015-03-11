<?php

/**
 * ECSHOP mobile首页
*/

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');

$act = isset($_REQUEST['act'])?$_REQUEST['act']:"";

/* 会员是否登录判断*/

if($_SESSION['user_id']<1){
	Header("Location: user.php");
	exit;
}

/**
 * 广告
 */
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
		$ad_link = str_replace("exchange", "mobile/goods", $v['ad_link']);
		$adarr[$k]['ad_link'] = str_replace("&act=view", "", $ad_link);
	}
}
//dump($adarr);
$smarty->assign('adarr', $adarr);

$smarty->assign('footer', get_footer());
$smarty->assign('header', get_header());
$smarty->display("index.html");

?>

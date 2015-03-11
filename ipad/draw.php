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


//判断是否有ajax请求
$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($act == 'cat_rec')
{
    $rec_array = array(1 => 'best', 2 => 'new', 3 => 'hot');
    $rec_type = !empty($_REQUEST['rec_type']) ? intval($_REQUEST['rec_type']) : '1';
    $cat_id = !empty($_REQUEST['cid']) ? intval($_REQUEST['cid']) : '0';
    include_once('includes/cls_json.php');
    $json = new JSON;
    $result   = array('error' => 0, 'content' => '', 'type' => $rec_type, 'cat_id' => $cat_id);

    $children = get_children($cat_id);
    $smarty->assign($rec_array[$rec_type] . '_goods',      get_category_recommend_goods($rec_array[$rec_type], $children));    // 推荐商品
    $smarty->assign('cat_rec_sign', 1);
    $result['content'] = $smarty->fetch('library/recommend_' . $rec_array[$rec_type] . '.lbi');
    die($json->encode($result));
}

/* 会员是否登录判断 2014-04-13 add by Jole -- Start -- */
if($_SESSION['user_id']<1){
    Header("Location: user.php");
}


/**
 * 取出中奖信息
 */
$sql = 'SELECT * FROM t_draw ORDER BY id DESC LIMIT 30';
$draw = $db->getAll($sql);
if(!empty($draw)){
	foreach ($draw as $k=>$v){		
		$draw[$k]['mobile'] = str_replace(substr($v['mobile'], 0,7), '****', $v['mobile']);
		$mobile = explode("“", $v['name']);
		$draw[$k]['name'] = rtrim($mobile[1], "”");
	}
}

$smarty->assign('draw', $draw);

$smarty->assign('header', get_header());
$smarty->display("draw.html");

?>
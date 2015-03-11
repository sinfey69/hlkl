<?php

/**
 * ECSHOP 支付响应页面
 * ============================================================================
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_payment.php');
require(ROOT_PATH . 'includes/lib_order.php');

$smarty->assign('header', get_header());
/* 支付方式代码 */
$pay_code = !empty($_REQUEST['result']) ? trim($_REQUEST['result']) : '';
//var_dump($_REQUEST);exit;
if($pay_code == 'success'){
	/*
	 * 支付成功以后，更新订单
	 */
	$subject 		= isset($_REQUEST['out_trade_no']) ? trim($_REQUEST['out_trade_no']): '';
	$notify_time 	= isset($_REQUEST['notify_time']) ? strtotime($_REQUEST['notify_time']): time();
	
	$sql = "SELECT p.log_id FROM ".$ecs->table('order_info')." o LEFT JOIN ".$ecs->table('pay_log')." p ON o.order_id=p.order_id WHERE o.order_sn='".$subject."'";
	$log_id = $db->getOne($sql);
	order_paid($log_id);
	$msg = ' 支付成功';
}

//获取首信支付方式
if (empty($pay_code) && !empty($_REQUEST['v_pmode']) && !empty($_REQUEST['v_pstring']))
{
    $pay_code = 'cappay';
}

//获取快钱神州行支付方式
if (empty($pay_code) && ($_REQUEST['ext1'] == 'shenzhou') && ($_REQUEST['ext2'] == 'ecshop'))
{
    $pay_code = 'shenzhou';
}

//获取话费支付方式
if (empty($pay_code) && isset($_REQUEST['mobileId']) && isset($_REQUEST['retCode']) )
{
    $pay_code = 'umpay';
}

if(isset($_GET)){
	$links="";
	foreach($_GET as $key=>$value){
		$links.=$key."=".$value."&";	
	}
	file_put_contents('bill/getdata.txt',"get:".mktime().":".$links."\r\n",FILE_APPEND);
}
if(isset($_POST)){
	$links="";
	foreach($_POST as $key=>$value){
		$links.=$key."=".$value."&";	
	}
	file_put_contents('bill/postdata.txt',"post:".mktime().":".$links."\r\n",FILE_APPEND);
}


/* 参数是否为空 */
if (empty($pay_code))
{
    $msg = $_LANG['pay_not_exist'];
}
else
{
    /* 检查code里面有没有问号 */
    if (strpos($pay_code, '?') !== false)
    {
        $arr1 = explode('?', $pay_code);
        $arr2 = explode('=', $arr1[1]);

        $_REQUEST['code']   = $arr1[0];
        $_REQUEST[$arr2[0]] = $arr2[1];
        $_GET['code']       = $arr1[0];
        $_GET[$arr2[0]]     = $arr2[1];
        $pay_code           = $arr1[0];
    }

    /* 判断是否启用 */
    $sql = "SELECT COUNT(*) FROM " . $ecs->table('payment') . " WHERE pay_code = '$pay_code' AND enabled = 1";
    if ($db->getOne($sql) == 0)
    {
        $msg = $_LANG['pay_disabled'];
    }
    else
    {
        $plugin_file = 'includes/modules/payment/' . $pay_code . '.php';

        /* 检查插件文件是否存在，如果存在则验证支付是否成功，否则则返回失败信息 */
        if (file_exists($plugin_file))
        {
            /* 根据支付方式代码创建支付类的对象并调用其响应操作方法 */
            include_once($plugin_file);

            $payment = new $pay_code();

            $msg     = (@$payment->respond()) ? $_LANG['pay_success'] : $_LANG['pay_fail'];
        }
        else
        {
            $msg = $_LANG['pay_not_exist'];
        }
    }
}

assign_template();
$position = assign_ur_here();
$smarty->assign('page_title', $position['title']);   // 页面标题
$smarty->assign('ur_here',    $position['ur_here']); // 当前位置
$smarty->assign('page_title', $position['title']);   // 页面标题
$smarty->assign('ur_here',    $position['ur_here']); // 当前位置
$smarty->assign('helps',      get_shop_help());      // 网店帮助
if($pay_code=="umpay"){
	$orderId    =   trim($_REQUEST['orderId']);
	//$_SESSION['umpay'.$orderId]
	$smarty->assign('meta',    $_SESSION['umpay'.$orderId]);
}
$smarty->assign('message',    $msg);
$smarty->assign('shop_url',   $ecs->url());

$smarty->display('respond.html');

?>
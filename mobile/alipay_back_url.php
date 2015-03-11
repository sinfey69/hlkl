<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_payment.php');
require(ROOT_PATH . 'includes/lib_order.php');

require_once("payment/alipay.config.php");
require_once("payment/lib/alipay_notify.class.php");

//计算得出通知验证结果

$smarty->assign('header', get_header());

$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	//交易状态
	$result = $_GET['result'];

	if($result == 'success'){ 
		//商户订单号
		$out_trade_no = $_GET['out_trade_no'];
		//支付宝交易号
		$trade_no = $_GET['trade_no'];
		//通知时间
		$notify_time =  gmtime();
		
		$sql = "SELECT p.log_id FROM ".$ecs->table('order_info')." o LEFT JOIN ".$ecs->table('pay_log')." p ON o.order_id=p.order_id WHERE o.order_sn='".$out_trade_no."'";
		$log_id = $db->getOne($sql);
		order_paid($log_id);
		$msg = ' 支付成功';

	}else{
		$msg = ' 支付失败,请重试';
	}
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
    $msg = ' 验证失败,请重试';
}

assign_template();
$position = assign_ur_here();
$smarty->assign('page_title', $position['title']);   // 页面标题
$smarty->assign('ur_here',    $position['ur_here']); // 当前位置
$smarty->assign('page_title', $position['title']);   // 页面标题
$smarty->assign('ur_here',    $position['ur_here']); // 当前位置
$smarty->assign('helps',      get_shop_help());      // 网店帮助

$smarty->assign('message',    $msg);
$smarty->assign('shop_url',   $ecs->url());

$smarty->display('respond.html');

?>
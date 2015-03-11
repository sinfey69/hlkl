<?php

/**
 * ECSHOP 订单
 * 
*/

define('IN_ECS', true);

include_once(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/lib_order.php');

$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

if($_SESSION['user_id']<1){
	ecs_header("Location: user.php");
	exit;
}

$smarty->assign('header', get_header());

/*
 * 添加地址
 */
if($act == 'address')
{
	if(empty($_POST['consignee']))
	{
		echo '收货人姓名不可为空！';
		exit;
	}
	
	if(empty($_POST['mobile']))
	{
		echo '手机号码不可为空！';
		exit;
	}
	
	if(empty($_POST['province']) || empty($_POST['city']))
	{
		echo '配送区域不可为空！';
		exit;
	}

	if(empty($_POST['address']))
	{
		echo '详细地址不可为空！';
		exit;
	}
	
	$consignee 	= compile_str(trim($_POST['consignee']));
	$mobile		= compile_str(make_semiangle(trim($_POST['mobile'])));
	$province	= intval($_POST['province']);
	$city		= intval($_POST['city']);
	$district	= intval($_POST['district']);
	$address	= compile_str(trim($_POST['address']));
	
	$sql = "insert into ecs_user_address(consignee,mobile,country,province,city,district,address,user_id) values('".$consignee."','".$mobile."',1,".$province.",".$city.",".$district.",'".$address."',".$_SESSION['user_id'].")";
	$db->query($sql);
	echo "添加成功";
	exit;
/*
 * ajax获取地址
 */	
}elseif($act == 'get'){
	
	$id = intval($_POST['id'])?intval($_POST['id']):0;

	$sql = "SELECT * FROM ecs_user_address WHERE address_id=".$id;
	$cart = $db->getRow($sql);
	$mobile = $cart['mobile']?$cart['mobile']:$cart['tel'];
	
	echo $cart['address']."|"."(".$cart['consignee'].") 收 ".$mobile;
	exit;

/*
 * 跳转到购买页面
 */
}elseif($act == 'checkout'){

        	include_once('includes/lib_transaction.php');
        	
        	/**
        	 * 取出购物车
        	 */
        	$sql = "SELECT * FROM ecs_cart WHERE user_id=".$_SESSION['user_id'];
        	
        	$list = $db->getAll($sql);
        	$jf 	= 0;
        	$money 	= 0;
        	$num	= 0;
        	
        	if(!empty($list)){
        		foreach ($list as $k=>$v){
        			$img = get_goods_gallery($v['goods_id']);
        			$list[$k]['goods_img'] = $img[0]['img_url'];
        			$jf +=$v['goods_number']*$v['integral'];
        			$money +=$v['goods_number']*$v['goods_price'];
        			$num +=$v['goods_number'];
        		}
        	}

        	$smarty->assign('jf', $jf);
        	$smarty->assign('money', $money);
        	$smarty->assign('num', $num);
        	$smarty->assign('list', $list);
        	

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
            $smarty->assign('buy_type', 1);
            $smarty->assign('province_list', $province_list);
            $smarty->assign('city_list',     $city_list);
            $smarty->assign('district_list', $district_list);
            
            $smarty->display('buy.html');
            exit;
            
/*------------------------------------------------------ */
//-- 完成所有订单操作，提交到数据库
/*------------------------------------------------------ */            
}elseif ($act == 'done'){
	
	require(ROOT_PATH . 'includes/lib_payment.php');
	include_once('includes/lib_clips.php');
	
	$tips = '';
	//配货地址ID
	$address_id = isset($_POST['address_id'])?intval($_POST['address_id']):"";
	if($address_id){
		$sql = "SELECT * FROM ecs_user_address WHERE address_id=".$address_id;
		$consignee = $db->getRow($sql);
	}else{
		echo "<script>alert('非法提交订单');location.href='index.php';</script>";
		exit;
	}
	//留言
	$postscript = htmlspecialchars($_POST['postscript']);
	//付款方式
	$payment 	= intval($_POST['payment'])?intval($_POST['payment']):1;	//默认为支付宝
	
	
	/**
	 * 取出购物车
	 */
	$sql = "SELECT * FROM ecs_cart WHERE user_id=".$_SESSION['user_id'];
	
	$list = $db->getAll($sql);
	$jf 	= 0;
	$money 	= 0;
	$num	= 0;

	/**
	 * 检查库存
	 */
	if(!empty($list)){
		foreach ($list as $k=>$v){
			$img = get_goods_gallery($v['goods_id']);
			$list[$k]['goods_img'] = $img[0]['img_url'];
			$jf +=$v['goods_number']*$v['integral'];
			$money +=$v['goods_number']*$v['goods_price'];
			$num +=$v['goods_number'];
			
			$ifgoods = check_goods($v['goods_id'],$v['goods_number']);
			if(!$ifgoods){
				echo "<script>alert('商品【".$v['goods_name']."-".$v['goods_attr']."】库存不够');</script>";
				exit;
			}
		}
	}else{
		echo "<script>alert('购物车为空');location.href='index.php';</script>";
		exit;
	}
	
	$smarty->assign('jf', $jf);
	$smarty->assign('money', $money);
	$smarty->assign('num', $num);
	$smarty->assign('list', $list);
	
	/* 检查商品库存 */
	/* 如果使用库存，且下订单时减库存，则减少库存 */
// 	if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE)
// 	{
// 		$cart_goods_stock = get_cart_goods();
// 		$_cart_goods_stock = array();
// 		foreach ($cart_goods_stock['goods_list'] as $value)
// 		{
// 			$_cart_goods_stock[$value['rec_id']] = $value['goods_number'];
// 		}
// 		flow_cart_stock($_cart_goods_stock);
// 		unset($cart_goods_stock, $_cart_goods_stock);
// 	}
	
	
	
	$order = array(
			'shipping_id'     => 2,	//物流ID
			'pay_id'          => $payment,
			
			'pack_id'         => isset($_POST['pack']) ? intval($_POST['pack']) : 0,
			'card_id'         => isset($_POST['card']) ? intval($_POST['card']) : 0,
			'card_message'    => isset($_POST['card_message'])?trim($_POST['card_message']):"",
			'surplus'         => isset($_POST['surplus']) ? floatval($_POST['surplus']) : 0.00,
			'integral'        => isset($_POST['integral']) ? intval($_POST['integral']) : 0,
			'bonus_id'        => isset($_POST['bonus']) ? intval($_POST['bonus']) : 0,
			//'need_inv'        => empty($_POST['need_inv']) ? 0 : 1,
			
			'inv_type'        => isset($_POST['inv_type'])?$_POST['inv_type']:"",
			'inv_payee'       => isset($_POST['inv_payee'])?trim($_POST['inv_payee']):"",
			'inv_content'     => isset($_POST['inv_content'])?$_POST['inv_content']:"",
			
			'postscript'      => trim($postscript),
			'how_oos'         => '等待所有商品备齐后再发',
			
			//'need_insure'     => isset($_POST['need_insure']) ? intval($_POST['need_insure']) : 0,
			'user_id'         => $_SESSION['user_id'],
			'add_time'        => gmtime(),
			'order_status'    => OS_UNCONFIRMED,
			'shipping_status' => SS_UNSHIPPED,
			'pay_status'      => PS_UNPAYED,
			'agency_id'       => get_agency_by_regions(array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district']))
	);
	
	/* 扩展信息 */
	if (isset($_SESSION['flow_type']) && intval($_SESSION['flow_type']) != CART_GENERAL_GOODS)
	{
		$order['extension_code'] = $_SESSION['extension_code'];
		$order['extension_id'] = $_SESSION['extension_id'];
	}
	else
	{
		$order['extension_code'] = '';
		$order['extension_id'] = 0;
	}
	
	/* 检查积分余额是否合法 */
	$user_id = $_SESSION['user_id'];
	if ($user_id > 0)
	{
		$user_info = user_info($user_id);
	
		$order['surplus'] = min($order['surplus'], $user_info['user_money'] + $user_info['credit_line']);
		if ($order['surplus'] < 0)
		{
			$order['surplus'] = 0;
		}
	
		// 查询用户有多少积分
		$flow_points = flow_available_points();  // 该订单允许使用的积分
		$user_points = $user_info['pay_points']; // 用户的积分总数
	
		$order['integral'] = min($order['integral'], $user_points, $flow_points);
		if ($order['integral'] < 0)
		{
			$order['integral'] = 0;
		}
	}
	else
	{
		$order['surplus']  = 0;
		$order['integral'] = 0;
	}
	
	
	/* 订单中的商品 */
	$cart_goods = cart_goods(0);
	
	if (empty($cart_goods))
	{
		$tips = '您的购物车中没有商品';
	}

	/* 收货人信息 */
	foreach ($consignee as $key => $value)
	{
		$order[$key] = addslashes($value);
	}
	
	/* 订单中的总额 */
	$total = order_fee($order, $cart_goods, $consignee);

	$order['bonus']        = 0;
	$order['goods_amount'] = $money;	//订单总金额
	$order['discount']     = 0;
	$order['surplus']      = 0;
	$order['tax']          = 0;
	
	
	/* 配送方式 */
	if ($order['shipping_id'] > 0)
	{
		$shipping = shipping_info($order['shipping_id']);
		$order['shipping_name'] = addslashes($shipping['shipping_name']);
	}
	$order['shipping_fee'] = $total['shipping_fee'];
	$order['insure_fee']   = $total['shipping_insure'];
// 	$order['shipping_fee'] = 0;
// 	$order['insure_fee'] =0;
	
	/* 支付方式 */
	if ($order['pay_id'] > 0)
	{
		$payment = payment_info($order['pay_id']);
		$order['pay_name'] = addslashes($payment['pay_name']);
	}
	$order['pay_fee'] = $total['pay_fee'];
	$order['cod_fee'] = $total['cod_fee'];
	
	$order['integral_money']   = $total['integral_money'];
	$order['integral']         = $total['integral'];
	
	if ($order['extension_code'] == 'exchange_goods')
	{
		$order['integral_money']   = 0;
		$order['integral']         = $total['exchange_integral'];
	}
	
	$order['from_ad']          = !empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
	$order['referer']          = !empty($_SESSION['referer']) ? addslashes($_SESSION['referer']) : '';
	
	//$order['order_amount']  = number_format($total['amount'], 2, '.', '');
	$order['order_amount']  = number_format($money, 2, '.', '');
	
	/* 如果全部使用余额支付，检查余额是否足够 */
	if ($payment['pay_code'] == 'balance' && $order['order_amount'] > 0)
	{
		if($order['surplus'] >0) //余额支付里如果输入了一个金额
		{
			$order['order_amount'] = $order['order_amount'] + $order['surplus'];
			$order['surplus'] = 0;
		}
		if ($order['order_amount'] > ($user_info['user_money'] + $user_info['credit_line']))
		{
			$tips = '您的余额不足以支付整个订单，以未付款方式下单';
	
		}
		else
		{
			$order['surplus'] = $order['order_amount'];
			$order['order_amount'] = 0;
		}
	}
	
	/* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
	if ($order['order_amount'] <= 0)
	{
		$order['order_status'] = OS_CONFIRMED;
		$order['confirm_time'] = gmtime();
		$order['pay_status']   = PS_PAYED;
		$order['pay_time']     = gmtime();
		$order['order_amount'] = 0;
	}
	
	$order['integral_money']   = $total['integral_money'];
	$order['integral']         = $total['integral'];
	
	if ($order['extension_code'] == 'exchange_goods')
	{
		$order['integral_money']   = 0;
		$order['integral']         = $total['exchange_integral'];
	}
	
	$order['from_ad']          = !empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
	$order['referer']          = !empty($_SESSION['referer']) ? addslashes($_SESSION['referer']) : '本站';
	
	/* 记录扩展信息 */
	if (0 != CART_GENERAL_GOODS)
	{
		$order['extension_code'] = $_SESSION['extension_code'];
		$order['extension_id'] = $_SESSION['extension_id'];
	}
	
	$affiliate = unserialize($_CFG['affiliate']);
		
	/* 插入订单表 */
	$error_no = 0;
	do
	{
		$order['order_sn'] = get_order_sn(); //获取新订单号
		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), $order, 'INSERT');
	
		$error_no = $GLOBALS['db']->errno();
	
		if ($error_no > 0 && $error_no != 1062)
		{
			die($GLOBALS['db']->errorMsg());
		}
	}
	while ($error_no == 1062); //如果是订单号重复则重新提交数据
	
	/**
	 * 积分扣取
	 */
	$score = @get_can_use_winning1($_SESSION['user_name']);
	if($score > $jf){
		@update_Winning1($_SESSION['user_name'], $jf,$order['order_sn']);
	}else{
		$sql = "DELETE FROM " . $ecs->table('order_info') . " WHERE order_sn='" . $order['order_sn'];
		$db->query($sql);
		echo "<script>alert('抱歉，您的积分不够。');location='index.php';</script>";
		exit;
	}

	$new_order_id = $db->insert_id();
	$order['order_id'] = $new_order_id;
	
	/* 插入订单商品 */
	$sql = "INSERT INTO " . $ecs->table('order_goods') . "( " .
			"order_id, goods_id, goods_name, goods_sn, goods_number, market_price, ".
			"goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id) ".
			" SELECT '$new_order_id', goods_id, goods_name, goods_sn, goods_number, market_price, ".
			"goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id".
			" FROM " .$ecs->table('cart') .
			" WHERE session_id = '".SESS_ID."' AND rec_type =0";
	$db->query($sql);
	
	/* 处理余额、积分、红包 */
	if ($order['user_id'] > 0 && $order['surplus'] > 0)
	{
		log_account_change($order['user_id'], $order['surplus'] * (-1), 0, 0, 0, sprintf('支付订单 %s', $order['order_sn']));
	}
	if ($order['user_id'] > 0 && $order['integral'] > 0)
	{
		log_account_change($order['user_id'], 0, 0, 0, $order['integral'] * (-1), sprintf('支付订单 %s', $order['order_sn']));
	}
	/* 如果使用库存，且下订单时减库存，则减少库存 */
	if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE)
	{
		change_order_goods_storage($order['order_id'], true, SDT_PLACE);
	}
	
	
	/* 清空购物车 */
	clear_cart(0);
	/* 清除缓存，否则买了商品，但是前台页面读取缓存，商品数量不减少 */
	clear_all_files();
	
	
	if(!empty($order['shipping_name']))
	{
		$order['shipping_name']=trim(stripcslashes($order['shipping_name']));
	}
	/* 取得支付信息，生成支付代码 */
	if ($order['order_amount'] > 0)
	{
		$payment = payment_info($order['pay_id']);
	
		include_once('includes/modules/payment/' . $payment['pay_code'] . '.php');
	
		$pay_obj    = new $payment['pay_code'];
		$order['log_id'] = insert_pay_log($new_order_id, $order['order_amount'], PAY_ORDER);
		$pay_online = $pay_obj->get_code($order, unserialize_config($payment['pay_config']));
	
		$order['pay_desc'] = $payment['pay_desc'];
	
		$smarty->assign('pay_online', $pay_online);	//支付按钮
	}
	

	/* 订单信息 */
	$smarty->assign('order',      $order);
	$smarty->assign('total',      $total);
	$smarty->assign('goods_list', $cart_goods);
	$smarty->assign('order_submit_back', sprintf('您可以 %s 或去 %s', '<a href="index.php">返回首页</a>', '<a href="user.php">用户中心</a>')); // 返回提示
	
	unset($_SESSION['flow_consignee']); // 清除session中保存的收货人信息
	unset($_SESSION['flow_order']);
	unset($_SESSION['direct_shopping']);
	
	if ($_SESSION['user_id'] > 0)
	{
		$smarty->assign('user_name', $_SESSION['user_name']);
	}
	$smarty->assign('footer', get_footer());
	$smarty->assign('tips', $tips);
	$smarty->display('order_done.html');
	exit;

/*
 * 获取订单列表
 */
}elseif($act == 'order'){
	require(ROOT_PATH . 'includes/lib_payment.php');
	include_once('includes/lib_clips.php');
	//订单列表
	$sql = "SELECT FROM_UNIXTIME(a.add_time,'%Y-%m-%d') AS add_time,b.order_id,b.goods_name,b.goods_number,b.goods_attr,b.goods_price FROM ecs_order_info a INNER JOIN ecs_order_goods b ON a.order_id=b.order_id WHERE a.user_id=".intval($_SESSION['user_id'])." ORDER BY a.order_id DESC";
	$goods = $db->getAll($sql);

	$sql = "SELECT order_sn,order_id,order_status,shipping_status,pay_status,pay_id,order_amount,add_time FROM ecs_order_info WHERE user_id=".intval($_SESSION['user_id']);

	$orderarr = $db->getAll($sql);
	
	$new_order = array();
	
	if(!empty($orderarr)){
		foreach ($orderarr as $k=>$v){
			$i=0;
					
			if($v['order_status'] == 0 && $v['shipping_status'] == 0 && $v['pay_status'] == 0){
				//$new_order[$k]['paystatus'] = "<font color=red>未支付</font>";
				/* 取得支付信息，生成支付代码 */
// 				if ($v['order_amount'] > 0)
// 				{
					$payment = payment_info($v['pay_id']);
				
					include_once('includes/modules/payment/' . $payment['pay_code'] . '.php');
				
					$pay_obj    = new $payment['pay_code'];
				
					$order['log_id'] = insert_pay_log($v['order_id'], $v['order_amount'], PAY_ORDER);
					$order['order_sn'] = $v['order_sn'];	//订单号
					//$order['order_amount'] = $v['order_amount'];	//总金额
					$order['order_amount'] = 0.01;	//总金额
					$order['add_time'] = $v['add_time'];	//时间
					$pay_online = $pay_obj->get_code($order, unserialize_config($payment['pay_config']));
					$new_order[$k]['paystatus'] = $pay_online;	//支付按钮				
// 				}
				
			}elseif($v['order_status'] == 1 && $v['shipping_status'] == 0 && $v['pay_status'] == 2){
				$new_order[$k]['paystatus'] = "已付款";
			}elseif($v['order_status'] == 2 && $v['shipping_status'] == 0 && $v['pay_status'] == 0){
				$new_order[$k]['paystatus'] = "取消";
			}elseif($v['order_status'] == 1 && $v['shipping_status'] == 0 && $v['pay_status'] == 0){
				$new_order[$k]['paystatus'] = "确认";
			}elseif($v['order_status'] == 1 && $v['shipping_status'] == 3 && $v['pay_status'] == 2){
				$new_order[$k]['paystatus'] = "<font color=green>配货中</font>";
			}elseif($v['order_status'] == 5 && $v['shipping_status'] == 1 && $v['pay_status'] == 2){
				$new_order[$k]['paystatus'] = "已发货";
			}elseif($v['order_status'] == 5 && $v['shipping_status'] == 2 && $v['pay_status'] == 2){
				$new_order[$k]['paystatus'] = "已收货";
			}elseif($v['order_status'] == 4 && $v['shipping_status'] == 0 && $v['pay_status'] == 0){
				$new_order[$k]['paystatus'] = "退货";
			}
			
			$new_order[$k]['order_sn'] 	= $v['order_sn'];
			$new_order[$k]['order_id'] 	= $v['order_id'];
			
			foreach ($goods as $key=>$val){
				if($v['order_id'] == $val['order_id']){
					$i++;					
					$new_order[$k]['goodnum'] 	= $i;
					$new_order[$k]['goods'][] 	= $val;
				}
			}
			unset($i,$order);
		}
	}
	
	//dump($new_order);
	$smarty->assign('order', $new_order);
	$smarty->display('order_list.html');
	exit;
/*
 * 删除订单
 */	
}elseif($act == 'order_del'){
	$check = isset($_POST['check'])?$_POST['check']:'';

	if(!empty($check)){
		foreach ($check as $val){
			$sql = "DELETE FROM ecs_order_info WHERE order_id=".$val;
			$db->query($sql);
			
			$sql = "DELETE FROM ecs_order_goods WHERE order_id=".$val;
			$db->query($sql);
		}
	}
	ecs_header("Location:buy.php?act=order");
	exit;
}

function flow_available_points()
{
	$sql = "SELECT SUM(g.integral * c.goods_number) ".
			"FROM " . $GLOBALS['ecs']->table('cart') . " AS c, " . $GLOBALS['ecs']->table('goods') . " AS g " .
			"WHERE c.session_id = '" . SESS_ID . "' AND c.goods_id = g.goods_id AND c.is_gift = 0 AND g.integral > 0 " .
			"AND c.rec_type = '" . CART_GENERAL_GOODS . "'";

	$val = intval($GLOBALS['db']->getOne($sql));

	return integral_of_value($val);
}

/**
 * 检查订单中商品库存
 *
 * @access  public
 * @param   货物ID   $goods_id
 * @param   获取的数量   $package_num
 *
 * @return  void
 */
function check_goods($goods_id,$package_num){
    /* 检查商品库存 */
    if ($goods_id != '')
    {
        $sql="SELECT goods_number FROM ". $GLOBALS['ecs']->table('goods') . "WHERE goods_id=".$goods_id;
        $goods_number = $GLOBALS['db']->getOne($sql);
        if($package_num > $goods_number){
        	return false;
        }else{
        	return true;
        }
    }
    return false;
}
?>
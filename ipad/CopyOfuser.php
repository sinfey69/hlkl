<?php

/**
 * ECSHOP 用户中心
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: user.php 16643 2009-09-08 07:02:13Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');

$act = isset($_GET['act']) ? $_GET['act'] : '';

$smarty->assign('header', get_header());

/* 用户登陆 */
if ($act == 'do_login')
{
    $user_name = !empty($_POST['username']) ? $_POST['username'] : '';
    $pwd = !empty($_POST['password']) ? $_POST['password'] : '';
    
    
    if (empty($user_name) || empty($pwd))
    {
        $login_faild = 1;
        $smarty->assign('login_faild' , $login_faild);
        $smarty->display('login.html');
        exit;
    }

        if ($user->check_user($user_name, $pwd) > 0)
        {
        	$login_faild = 0;
            $user->set_session($user_name);
            $user->set_cookie($user_name);
            update_user_info();
            //show_user_center();
            ecs_header("Location: user.php");
            exit;
        }
        else
        {
            $login_faild = 1;
            $smarty->assign('login_faild' , $login_faild);
            $smarty->display('login.html');
            exit;
        }

}
elseif ($act == 'edit')
{
	//店 员 号100
	//店员姓名101
	//所属代理商102
	//所属零售商103
	//$sql = "SELECT a.*,b.reg_field_name AS regname FROM ecs_reg_extend_info a INNER JOIN ecs_reg_fields b ON a.reg_field_id=b.id WHERE a.user_id=".$_SESSION['user_id']." AND b.reg_field_id in(100,101,102,103)";
	$sql = "SELECT id,reg_field_name AS regname FROM ecs_reg_fields WHERE id in(100,101,102,103)";
	$reg = $db->getAll($sql);
	if(!empty($reg)){
		foreach ($reg as $k=>$v){
			$sql = "SELECT * FROM ecs_reg_extend_info WHERE user_id=".$_SESSION['user_id']." AND reg_field_id=".$v['id'];
			$extend = $db->getRow($sql);
			if(!empty($extend)){
				$reg[$k]['user_id'] = $extend['user_id'];
				$reg[$k]['reg_field_id'] = $extend['reg_field_id'];
				$reg[$k]['content'] = $extend['content'];
			}else{
				$reg[$k]['user_id'] = $_SESSION['user_id'];
				$reg[$k]['reg_field_id'] = $v['id'];
				$reg[$k]['content'] = '';
			}
		}
	}
	$smarty->assign('reg' , $reg);
	$smarty->display('edit.html');
	exit;	
}
elseif($act == 'edit_content'){
	$uid = intval($_POST['uid']);
	$regid = intval($_POST['reg']);
	$content = htmlspecialchars($_POST['v']);
	$sql = "SELECT * FROM ecs_reg_extend_info WHERE user_id=".$uid." AND reg_field_id=".$regid;
	$extendarr = $db->getRow($sql);
	
	if(empty($extendarr)){
		$sql = "INSERT INTO ecs_reg_extend_info(content,user_id,reg_field_id) VALUES('".$content."',".$uid.",".$regid.")";
		$db->query($sql);
	}else{
		$sql = "UPDATE ecs_reg_extend_info SET content='".$content."' WHERE user_id=".$uid." AND reg_field_id=".$regid;
		$db->query($sql);
	}
	
	exit;
}elseif($act == 'edit_pwdlist'){
	$smarty->display('editpwd.html');
	exit;	
}
elseif($act == 'edit_pwd'){
	
	$old_password = isset($_POST['old_password']) ? trim($_POST['old_password']) : '';
	$new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
	$re_password = isset($_POST['re_password']) ? trim($_POST['re_password']) : '';
	
	if (strlen($new_password) < 6)
	{
		echo "<script>alert('新密码不能少于6位');location.href='user.php?act=edit_pwdlist';</script>";
		exit;
	}
	if($new_password != $re_password){
		echo "<script>alert('密码不一致');location.href='user.php?act=edit_pwdlist';</script>";
		exit;		
	}
	
	$code = '';
	if ($user->check_user($_SESSION['user_name'], $old_password) > 0){
	    if ($user->edit_user(array('username'=> (empty($code) ? $_SESSION['user_name'] : $user_info['user_name']), 'old_password'=>$old_password, 'password'=>$new_password), empty($code) ? 0 : 1))
        {
			$sql="UPDATE ".$ecs->table('users'). "SET `ec_salt`='0' WHERE user_id= '".$_SESSION['user_id']."'";
			$db->query($sql);
            $user->logout();
            ecs_header("Location:user.php?act=login");
            exit;
        }
        else
        {
           ecs_header("Location:user.php?act=edit_pwdlist");
           exit;
        }
	}else{
		echo "<script>alert('旧密码不正确');location.href='user.php?act=edit_pwdlist';</script>";
		exit;		
	}
			
}elseif($act == 'addresslist'){
	include_once('includes/lib_transaction.php');
	
	$id = isset($_GET['id'])?intval($_GET['id']):"";
	if($id){
		$sql = "SELECT * FROM ecs_user_address WHERE address_id=".$id;
		$address = $db->getRow($sql);
		$smarty->assign('address', $address);
	}
	$smarty->assign('address_id', $id);
	
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
		
	$smarty->display('addresslist.html');
	exit;	
}
elseif($act == 'addressedit'){
	$id = isset($_POST['id'])?intval($_POST['id']):"";
	$consignee = isset($_POST['consignee'])?htmlspecialchars($_POST['consignee']):"";
	$mobile = isset($_POST['mobile'])?htmlspecialchars($_POST['mobile']):"";
	$address = isset($_POST['address'])?htmlspecialchars($_POST['address']):"";
	
	if($id){
		$sql = "UPDATE ecs_user_address SET consignee='".$consignee."',mobile='".$mobile."',address='".$address."'  WHERE address_id=".$id;
		$db->query($sql);
	}
	ecs_header("Location:user.php?act=addresslist");
	exit;	
}
elseif($act == 'addressdel'){
	$id = isset($_GET['id'])?intval($_GET['id']):"";
	if($id){
		$sql = "DELETE FROM ecs_user_address WHERE address_id=".$id;
		$db->query($sql);
	}
	ecs_header("Location:user.php?act=addresslist");
	exit;
}
elseif ($act == 'order_list')
{
    $record_count = $db->getOne("SELECT COUNT(*) FROM " .$ecs->table('order_info'). " WHERE user_id = {$_SESSION['user_id']}");
    if ($record_count > 0)
    {
        include_once(ROOT_PATH . 'includes/lib_transaction.php');
        $page_num = '10';
        $page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
        $pages = ceil($record_count / $page_num);

        if ($page <= 0)
        {
            $page = 1;
        }
        if ($pages == 0)
        {
            $pages = 1;
        }
        if ($page > $pages)
        {
            $page = $pages;
        }
        $pagebar = get_wap_pager($record_count, $page_num, $page, 'user.php?act=order_list', 'page');
        $smarty->assign('pagebar' , $pagebar);
        /* 订单状态 */
        $_LANG['os'][OS_UNCONFIRMED] = '未确认';
        $_LANG['os'][OS_CONFIRMED] = '已确认';
        $_LANG['os'][OS_SPLITED] = '已确认';
        $_LANG['os'][OS_SPLITING_PART] = '已确认';
        $_LANG['os'][OS_CANCELED] = '已取消';
        $_LANG['os'][OS_INVALID] = '无效';
        $_LANG['os'][OS_RETURNED] = '退货';

        $_LANG['ss'][SS_UNSHIPPED] = '未发货';
        $_LANG['ss'][SS_PREPARING] = '配货中';
        $_LANG['ss'][SS_SHIPPED] = '已发货';
        $_LANG['ss'][SS_RECEIVED] = '收货确认';
        $_LANG['ss'][SS_SHIPPED_PART] = '已发货(部分商品)';
        $_LANG['ss'][SS_SHIPPED_ING] = '配货中'; // 已分单

        $_LANG['ps'][PS_UNPAYED] = '未付款';
        $_LANG['ps'][PS_PAYING] = '付款中';
        $_LANG['ps'][PS_PAYED] = '已付款';
        $_LANG['cancel'] = '取消订单';
        $_LANG['pay_money'] = '付款';
        $_LANG['view_order'] = '查看订单';
        $_LANG['received'] = '确认收货';
        $_LANG['ss_received'] = '已完成';
        $_LANG['confirm_received'] = '你确认已经收到货物了吗？';
        $_LANG['confirm_cancel'] = '您确认要取消该订单吗？取消后此订单将视为无效订单';

        $orders = get_user_orders($_SESSION['user_id'], $page_num, $page_num * ($page - 1));
        if (!empty($orders))
        {
            foreach ($orders as $key => $val)
            {
                $orders[$key]['total_fee'] = encode_output($val['total_fee']);
            }
        }
        //$merge  = get_user_merge($_SESSION['user_id']);

        $smarty->assign('orders', $orders);
    }
    $smarty->assign('footer', get_footer());
    $smarty->display('order_list.html');
    exit;
}

/* 取消订单 */
elseif ($act == 'cancel_order')
{
    include_once(ROOT_PATH . 'includes/lib_transaction.php');
    include_once(ROOT_PATH . 'includes/lib_order.php');

    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    if (cancel_order($order_id, $_SESSION['user_id']))
    {
        ecs_header("Location: user.php?act=order_list\n");
        exit;
    }
}

/* 确认收货 */
elseif ($act == 'affirm_received')
{
    include_once(ROOT_PATH . 'includes/lib_transaction.php');

    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    $_LANG['buyer'] = '买家';
    if (affirm_received($order_id, $_SESSION['user_id']))
    {
        ecs_header("Location: user.php?act=order_list\n");
        exit;
    }

}

/* 退出会员中心 */
elseif ($act == 'logout')
{
    if (!isset($back_act) && isset($GLOBALS['_SERVER']['HTTP_REFERER']))
    {
        $back_act = strpos($GLOBALS['_SERVER']['HTTP_REFERER'], 'user.php') ? './index.php' : $GLOBALS['_SERVER']['HTTP_REFERER'];
    }

    $user->logout();
    $Loaction = 'index.php';
    ecs_header("Location: $Loaction\n");

}
/* 显示会员注册界面 */
elseif ($act == 'register')
{
    if (!isset($back_act) && isset($GLOBALS['_SERVER']['HTTP_REFERER']))
    {
        $back_act = strpos($GLOBALS['_SERVER']['HTTP_REFERER'], 'user.php') ? './index.php' : $GLOBALS['_SERVER']['HTTP_REFERER'];
    }

    /* 取出注册扩展字段 */
    $sql = 'SELECT * FROM ' . $ecs->table('reg_fields') . ' WHERE type < 2 AND display = 1 ORDER BY dis_order, id';
    $extend_info_list = $db->getAll($sql);
    $smarty->assign('extend_info_list', $extend_info_list);
    /* 密码找回问题 */
    $_LANG['passwd_questions']['friend_birthday'] = '我最好朋友的生日？';
    $_LANG['passwd_questions']['old_address']     = '我儿时居住地的地址？';
    $_LANG['passwd_questions']['motto']           = '我的座右铭是？';
    $_LANG['passwd_questions']['favorite_movie']  = '我最喜爱的电影？';
    $_LANG['passwd_questions']['favorite_song']   = '我最喜爱的歌曲？';
    $_LANG['passwd_questions']['favorite_food']   = '我最喜爱的食物？';
    $_LANG['passwd_questions']['interest']        = '我最大的爱好？';
    $_LANG['passwd_questions']['favorite_novel']  = '我最喜欢的小说？';
    $_LANG['passwd_questions']['favorite_equipe'] = '我最喜欢的运动队？';
    /* 密码提示问题 */
    $smarty->assign('passwd_questions', $_LANG['passwd_questions']);
    $smarty->assign('footer', get_footer());
    $smarty->display('user_passport.html');
}
/* 注册会员的处理 */
elseif ($act == 'act_register')
{
        include_once(ROOT_PATH . 'includes/lib_passport.php');

        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
//         $email    = isset($_POST['email']) ? trim($_POST['email']) : '';
//         $other['msn'] = isset($_POST['extend_field1']) ? $_POST['extend_field1'] : '';
//         $other['qq'] = isset($_POST['extend_field2']) ? $_POST['extend_field2'] : '';
//         $other['office_phone'] = isset($_POST['extend_field3']) ? $_POST['extend_field3'] : '';
//         $other['home_phone'] = isset($_POST['extend_field4']) ? $_POST['extend_field4'] : '';
//         $other['mobile_phone'] = isset($_POST['extend_field5']) ? $_POST['extend_field5'] : '';
//         $sel_question = empty($_POST['sel_question']) ? '' : compile_str($_POST['sel_question']);
//         $passwd_answer = isset($_POST['passwd_answer']) ? compile_str(trim($_POST['passwd_answer'])) : '';

//         $back_act = isset($_POST['back_act']) ? trim($_POST['back_act']) : '';

        if (m_register($username, $password, $email, $other) !== false)
        {
            /*把新注册用户的扩展信息插入数据库*/
            $sql = 'SELECT id FROM ' . $ecs->table('reg_fields') . ' WHERE type = 0 AND display = 1 ORDER BY dis_order, id';   //读出所有自定义扩展字段的id
            $fields_arr = $db->getAll($sql);

            $extend_field_str = '';    //生成扩展字段的内容字符串
            foreach ($fields_arr AS $val)
            {
                $extend_field_index = 'extend_field' . $val['id'];
                if(!empty($_POST[$extend_field_index]))
                {
                    $temp_field_content = strlen($_POST[$extend_field_index]) > 100 ? mb_substr($_POST[$extend_field_index], 0, 99) : $_POST[$extend_field_index];
                    $extend_field_str .= " ('" . $_SESSION['user_id'] . "', '" . $val['id'] . "', '" . compile_str($temp_field_content) . "'),";
                }
            }
            $extend_field_str = substr($extend_field_str, 0, -1);

            if ($extend_field_str)      //插入注册扩展数据
            {
                $sql = 'INSERT INTO '. $ecs->table('reg_extend_info') . ' (`user_id`, `reg_field_id`, `content`) VALUES' . $extend_field_str;
                $db->query($sql);
            }

            /* 写入密码提示问题和答案 */
            if (!empty($passwd_answer) && !empty($sel_question))
            {
                $sql = 'UPDATE ' . $ecs->table('users') . " SET `passwd_question`='$sel_question', `passwd_answer`='$passwd_answer'  WHERE `user_id`='" . $_SESSION['user_id'] . "'";
                $db->query($sql);
            }

            $ucdata = empty($user->ucdata)? "" : $user->ucdata;
            $Loaction = 'index.php';
            ecs_header("Location: $Loaction\n");
        }
}

/* 用户中心 */
else
{
    if ($_SESSION['user_id'] > 0)
    {
        show_user_center();
    }
    else
    {
    	/**
    	 * 取出首页的banner
    	 */
//     	$sql  = 'SELECT a.ad_id, a.position_id, a.media_type, a.ad_link, a.ad_code, a.ad_name, p.ad_width, ' .
//     			'p.ad_height, p.position_style, RAND() AS rnd ' .
//     			'FROM ' . $ecs->table('ad') . ' AS a '.
//     			'LEFT JOIN ' . $ecs->table('ad_position') . ' AS p ON a.position_id = p.position_id ' .
//     			"WHERE enabled = 1 AND start_time <= '" . time() . "' AND end_time >= '" . time() . "' AND a.ad_id IN(1)".
//     			'ORDER BY a.ad_id,rnd LIMIT 1';
    	
//     	$adarr = $db->getAll($sql);
    	
//     	if(!empty($adarr)){
//     		foreach ($adarr as $k=>$v){
//     			$src = (strpos($v['ad_code'], 'http://') === false && strpos($v['ad_code'], 'https://') === false)?DATA_DIR . "/afficheimg/$v[ad_code]" : $v['ad_code'];
//     			$adarr[$k]['ad_code'] = $v['ad_code'];
//     		}
    	
//     	}

//     	$smarty->assign('adarr', $adarr);
        
        $smarty->assign('footer', get_footer());
        $smarty->display('login.html');
    }
}

/**
 * 用户中心显示
 */
function show_user_center()
{
    $best_goods = get_recommend_goods('best');
    if (count($best_goods) > 0)
    {
        foreach  ($best_goods as $key => $best_data)
        {
            $best_goods[$key]['shop_price'] = encode_output($best_data['shop_price']);
            $best_goods[$key]['name'] = encode_output($best_data['name']);
        }
    }
    /**
     * 取出当前用户的积分
     */
    $score = @get_can_use_winning1($_SESSION['user_name']);
    $GLOBALS['smarty']->assign('score', $score);
    
    $GLOBALS['smarty']->assign('best_goods' , $best_goods);
    $GLOBALS['smarty']->assign('footer', get_footer());
    $GLOBALS['smarty']->display('user.html');
}

/**
 * 手机注册
 */
function m_register($username, $password, $email, $other = array())
{
    /* 检查username */
    if (empty($username))
    {
        echo '用户名不能为空';
        $Loaction = 'user.php?act=register';
        ecs_header("Location: $Loaction\n");
        return false;
    }
    if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username))
    {
        echo '用户名错误';
        $Loaction = 'user.php?act=register';
        ecs_header("Location: $Loaction\n");
        return false;
    }

    /* 检查email */
    if (empty($email))
    {
        echo 'email不能为空';
        $Loaction = 'user.php?act=register';
        ecs_header("Location: $Loaction\n");
        return false;
    }
    if(!is_email($email))
    {
        echo 'email错误';
        $Loaction = 'user.php?act=register';
        ecs_header("Location: $Loaction\n");
        return false;
    }

    /* 检查是否和管理员重名 */
    if (admin_registered($username))
    {
        echo '此用户已存在！';
        $Loaction = 'user.php?act=register';
        ecs_header("Location: $Loaction\n");
        return false;
    }

    if (!$GLOBALS['user']->add_user($username, $password, $email))
    {
        echo '注册失败！';
        $Loaction = 'user.php?act=register';
        ecs_header("Location: $Loaction\n");
        //注册失败
        return false;
    }
    else
    {
        //注册成功

        /* 设置成登录状态 */
        $GLOBALS['user']->set_session($username);
        $GLOBALS['user']->set_cookie($username);

     }

        //定义other合法的变量数组
        $other_key_array = array('msn', 'qq', 'office_phone', 'home_phone', 'mobile_phone');
        $update_data['reg_time'] = local_strtotime(local_date('Y-m-d H:i:s'));
        if ($other)
        {
            foreach ($other as $key=>$val)
            {
                //删除非法key值
                if (!in_array($key, $other_key_array))
                {
                    unset($other[$key]);
                }
                else
                {
                    $other[$key] =  htmlspecialchars(trim($val)); //防止用户输入javascript代码
                }
            }
            $update_data = array_merge($update_data, $other);
        }
        $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('users'), $update_data, 'UPDATE', 'user_id = ' . $_SESSION['user_id']);

        update_user_info();      // 更新用户信息

        return true;

}
?>
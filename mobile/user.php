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

}elseif($act == 'getmsg'){
	$id = isset($_GET['id'])?intval($_GET['id']):"";
	$sql = "SELECT * FROM ecs_article WHERE article_id=".$id;
	$article = $db->getRow($sql);
	
	$smarty->assign('article_data' , $article);
	$smarty->display('article.html');
	exit;
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
		$smarty->assign('province_list', get_regions(1, $address['country']));
		$smarty->assign('city_list',    get_regions(2, $address['province']));
		$smarty->assign('district_list', get_regions(3, $address['city']));
		$smarty->assign('address_id', $id);
	}else{
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
		$smarty->assign('province_list', get_regions(1, $_CFG['shop_country']));
		
		/**
		 * 收货地址
		 */
		$consignee_list = get_consignee_list($_SESSION['user_id']);
		
		
		/* 取得每个收货地址的省市区列表 */
		$province_list = array();
		$city_list = array();
		$district_list = array();
		foreach ($consignee_list as $region_id => $consignee)
		{
			//$consignee_list[$region_id]['country_name'] = get_regionsName($consignee['country']);
			$consignee_list[$region_id]['province_name'] = get_regionsName($consignee['province']);
			$consignee_list[$region_id]['city_name'] = get_regionsName($consignee['city']);
			$consignee_list[$region_id]['district_name'] = get_regionsName($consignee['district']);
		}
		$smarty->assign('consignee_list',       $consignee_list);
	}
	$smarty->display('addresslist.html');
	exit;	
}
elseif($act == 'addressedit'){
	$id = isset($_POST['id'])?intval($_POST['id']):"";
	$consignee = isset($_POST['consignee'])?htmlspecialchars($_POST['consignee']):"";
	$mobile = isset($_POST['mobile'])?htmlspecialchars($_POST['mobile']):"";
	$address = isset($_POST['address'])?htmlspecialchars($_POST['address']):"";
	$province = isset($_POST['province'])?intval($_POST['province']):"0";
	$city = isset($_POST['city'])?intval($_POST['city']):"0";
	$district = isset($_POST['district'])?intval($_POST['district']):"0";
	
	if($id){
		$sql = "UPDATE ecs_user_address SET province='".$province."',city='".$city."',district='".$district."',consignee='".$consignee."',mobile='".$mobile."',address='".$address."'  WHERE address_id=".$id;
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
    exit;

/**/    
}elseif($act == 'send'){
	$mobile = isset($_POST['mobile'])?$_POST['mobile']:"";
	
	if(empty($mobile)){
		exit(json_encode(array('msg'=>'手机号码不能为空')));
	}
	
	$preg='/^1[0-9]{10}$/';//简单的方法
	if(!preg_match($preg,$mobile)) {
		exit(json_encode(array('msg'=>'手机号码格式不正确')));
	}
	
	if( check_ccs($mobile)=='true'){
	}else{
		exit(json_encode(array('msg'=>'您不是CSS会员')));
	}
	
	$mobile_code = random(4,1);
	$target = "http://106.ihuyi.com/webservice/sms.php?method=Submit";
	//替换成自己的测试账号,参数顺序和wenservice对应
	
	//exit(json_encode(array('msg'=>strtotime( read_file($mobile))."\r\n".(time()-60) )));
	if(isset($_SESSION['mobile'])){
		//exit(json_encode(array('msg'=> read_file($mobile) )));
		if(strtotime(read_file($mobile))>(time()-60)){
			exit(json_encode(array('msg'=>'获取验证码太过频繁，一分钟之内只能获取一次。')));
		}
	}
	
	$post_data = "account=cf_jzsy&password=".md5('T6tPaR')."&mobile=".$mobile."&content=".rawurlencode("您的验证码是：".$mobile_code."。请不要把验证码泄露给其他人。");
	//密码可以使用明文密码或使用32位MD5加密
	
	$get = Post($post_data, $target);
	$gets =  xml_to_array($get);
	//$_SESSION['wap_mobile_code']=$mobile_code;
	
	write_file($mobile,$get."\r\n".date("Y-m-d H:i:s"));
	
	if($gets['SubmitResult']['code']==2){
		$_SESSION['wap_mobile']=$mobile;
		$_SESSION['wap_mobile_code']=$mobile_code;
		exit(json_encode(array('code'=>2)));
	}else{
		exit(json_encode(array('msg'=>'手机验证码发送失败。')));
	}
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
/* 判断用户是否存在 */
elseif($act == 'ifname'){
	$username = isset($_POST['username']) ? trim($_POST['username']) : '';

	if(empty($username)){
		echo "用户名不能为空";
		exit;
	}else{	
		$sql = "SELECT * FROM ecs_users WHERE user_name='".$username."'";
		$use = $db->getRow($sql);		
		if(!empty($use)){
			echo "用户名已存在";
			exit;
		}
		
		if( check_ccs($username)=='true'){
		}else{
			echo "您不是CSS会员";
			exit;
		}
	}		
	
}
/* 注册会员的处理 */
elseif ($act == 'act_register')
{
        include_once(ROOT_PATH . 'includes/lib_passport.php');

        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $repassword = isset($_POST['repassword']) ? trim($_POST['repassword']) : '';
        $code = isset($_POST['code']) ? trim($_POST['code']) : '';
        $scode = isset($_SESSION['wap_mobile_code'])?$_SESSION['wap_mobile_code']:"";

        if(empty($username)){
        	echo "<script>alert('用户名不能为空');location.href='user.php';</script>";
        	exit;
        }
        
        $sql = "SELECT * FROM ecs_users WHERE user_name='".$username."'";
        $use = $db->getRow($sql);
               
        if(!empty($use)){
        	echo "<script>alert('用户名已存在,忘记密码请致电客服0592-5099915');location.href='user.php';</script>";
        	exit;        	
        }

        if(empty($password)){
        	echo "<script>alert('密码不能为空');location.href='user.php';</script>";
        	exit;
        }

        if(empty($repassword)){
        	echo "<script>alert('重复密码不能为空');location.href='user.php';</script>";
        	exit;
        }

        if(empty($code)){
        	echo "<script>alert('验证码不能为空');location.href='user.php';</script>";
        	exit;
        }
        
		if( check_ccs($username)=='true'){
		}else{
			echo "您不是CSS会员";
			exit;
		}
        if($password != $repassword){
        	echo "<script>alert('密码不相同');location.href='user.php';</script>";
        	exit;
        }
        
        if($code != $scode){
        	echo "<script>alert('验证码不正确');location.href='user.php';</script>";
        	exit;
        }

        
        if (@m_register($username, $password) !== false)
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
//             if (!empty($passwd_answer) && !empty($sel_question))
//             {
//                 $sql = 'UPDATE ' . $ecs->table('users') . " SET `passwd_question`='$sel_question', `passwd_answer`='$passwd_answer'  WHERE `user_id`='" . $_SESSION['user_id'] . "'";
//                 $db->query($sql);
//             }

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
    $canuse = @get_can_use_winning1($_SESSION['user_name']);

    $GLOBALS['smarty']->assign('score', max(0,$canuse));
    
    $GLOBALS['smarty']->assign('best_goods' , $best_goods);
    $GLOBALS['smarty']->assign('footer', get_footer());
    $GLOBALS['smarty']->display('user.html');
}

/**
 * 手机注册
 */
function m_register($username, $password)
{
    /* 检查username */
    if (empty($username))
    {
        echo '用户名不能为空';
        $Loaction = 'user.php';
        ecs_header("Location: $Loaction\n");
        return false;
    }
    if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username))
    {
        echo '用户名错误';
        $Loaction = 'user.php';
        ecs_header("Location: $Loaction\n");
        return false;
    }

    /* 检查是否和管理员重名 */
    if (admin_registered($username))
    {
        echo '此用户已存在！';
        $Loaction = 'user.php';
        ecs_header("Location: $Loaction\n");
        return false;
    }

    if (!$GLOBALS['user']->add_user($username, $password))
    {
        echo "<script>alert('注册失败！');location.href='location.href=user.php';</script>";
		exit;
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
        $other = '';
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

function Post($curlPost,$url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
}
function xml_to_array($xml){
	$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
	if(preg_match_all($reg, $xml, $matches)){
		$count = count($matches[0]);
		for($i = 0; $i < $count; $i++){
		$subxml= $matches[2][$i];
		$key = $matches[1][$i];
			if(preg_match( $reg, $subxml )){
				$arr[$key] = xml_to_array( $subxml );
			}else{
				$arr[$key] = $subxml;
			}
		}
	}
	return $arr;
}
function random($length = 6 , $numeric = 0) {
	PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	if($numeric) {
		$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
	} else {
		$hash = '';
		$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
		$max = strlen($chars) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
	}
	return $hash;
}
function write_file($file_name,$content){
	mkdirs("sms/".date('Ymd'));
	$filename = "sms/".date('Ymd').'/'.$file_name.'.log';
	$Ts=fopen($filename,"a+");
	fputs($Ts,"\r\n".$content);
	fclose($Ts);
}
function mkdirs($dir, $mode = 0777){
	if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
	if (!self::mkdirs(dirname($dir), $mode)) return FALSE;
	return @mkdir($dir, $mode);
}
function read_file($file_name) {
	$content = '';
	$filename = date('Ymd').'/'.$file_name.'.log';
	if(function_exists('file_get_contents')) {
		@$content = file_get_contents($filename);
	} else {
		if(@$fp = fopen($filename, 'r')) {
			@$content = fread($fp, filesize($filename));
			@fclose($fp);
		}
	}
	$content = explode("\r\n",$content);
	return end($content);
}
?>
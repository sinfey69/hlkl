<?php

/**
 * ECSHOP 管理中心积分兑换商品程序文件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author $
 * $Id $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);

/*初始化数据交换对象 */
$exc   = new exchange($ecs->table("exchange_draw"), $db, 'did', 'did');
//$image = new cls_image();

/*------------------------------------------------------ */
//-- 商品列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 权限判断 */
    admin_priv('exchange_draw');

    /* 取得过滤条件 */
    $filter = array();
    $smarty->assign('ur_here',      $_LANG['17_exchange_draw_list']);
    $smarty->assign('action_link',  array('text' => $_LANG['exchange_draw_add'], 'href' => 'exchange_draw.php?act=add'));
    $smarty->assign('full_page',    1);
    $smarty->assign('filter',       $filter);

    $draw_list = get_exchange_list();

    $smarty->assign('draw_list',    $draw_list['arr']);
    $smarty->assign('filter',       $draw_list['filter']);
    $smarty->assign('record_count', $draw_list['record_count']);
    $smarty->assign('page_count',   $draw_list['page_count']);

    $sort_flag  = sort_flag($draw_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('exchange_draw_list.htm');
}

/*------------------------------------------------------ */
//-- 活动翻页，排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    check_authz_json('exchange_draw');

    $draw_list = get_exchange_list();

    $smarty->assign('draw_list',    $draw_list['arr']);
    $smarty->assign('filter',       $draw_list['filter']);
    $smarty->assign('record_count', $draw_list['record_count']);
    $smarty->assign('page_count',   $draw_list['page_count']);

    $sort_flag  = sort_flag($draw_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('exchange_draw_list.htm'), '',
        array('filter' => $draw_list['filter'], 'page_count' => $draw_list['page_count']));
}

/*------------------------------------------------------ */
//-- 添加活动页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add')
{
    include_once(ROOT_PATH . 'includes/fckeditor/fckeditor.php'); // 包含 html editor 类文件
    /* 权限判断 */
    admin_priv('exchange_draw');
    /*初始化*/

    $smarty->assign('ur_here',     $_LANG['exchange_draw_add']);
    $smarty->assign('action_link', array('text' => $_LANG['17_exchange_draw_list'], 'href' => 'exchange_draw.php?act=list'));
    $smarty->assign('form_action', 'insert');
    /* 创建 html editor */
    create_html_editor('draw_desc', '',450);

    assign_query_info();
    $smarty->display('exchange_draw_info.htm');
}

/*------------------------------------------------------ */
//-- 添加活动入库
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'insert')
{
    /* 权限判断 */
    admin_priv('exchange_draw');

    $draw_title = !empty($_POST['draw_title']) ? htmlspecialchars(trim($_POST['draw_title'])) : '';
    $start_time = !empty($_POST['start_time']) ? local_strtotime($_POST['start_time']) : 0;
    $end_time = !empty($_POST['end_time']) ? local_strtotime($_POST['end_time']) : 0;
    $draw_desc = !empty($_POST['draw_desc']) ? $_POST['draw_desc'] : '';
	$deduct = !empty($_POST['deduct']) ? intval($_POST['deduct']) : 1;

    if(empty($draw_title)){
		sys_msg($_LANG['no_draw_title'], 1, array(), false);
	}
	if(empty($start_time) || empty($end_time)){
		sys_msg($_LANG['no_time'], 1, array(), false);
	}
	if($start_time > $end_time){
		sys_msg($_LANG['start_lt_end'], 1, array(), false);
	}
	
	/* 检查图片：如果有错误，检查尺寸是否超过最大值；否则，检查文件类型 */
    if (isset($_FILES['roulette_img']['error'])) // php 4.2 版本才支持 error
    {
        // 最大上传文件大小
        $php_maxsize = ini_get('upload_max_filesize');
        $htm_maxsize = '2M';

        // 手机端转盘图片
        if ($_FILES['roulette_img']['error'] == 0)
        {
            if (!$image->check_img_type($_FILES['roulette_img']['type']))
            {
                sys_msg($_LANG['invalid_roulette_img'], 1, array(), false);
            }
        }
        elseif ($_FILES['roulette_img']['error'] == 1)
        {
            sys_msg(sprintf($_LANG['roulette_img_too_big'], $php_maxsize), 1, array(), false);
        }
        elseif ($_FILES['roulette_img']['error'] == 2)
        {
            sys_msg(sprintf($_LANG['roulette_img_too_big'], $htm_maxsize), 1, array(), false);
        }

        // 背景图
        if (isset($_FILES['background_img']))
        {
            if ($_FILES['background_img']['error'] == 0)
            {
                if (!$image->check_img_type($_FILES['background_img']['type']))
                {
                    sys_msg($_LANG['invalid_background_img'], 1, array(), false);
                }
            }
            elseif ($_FILES['background_img']['error'] == 1)
            {
                sys_msg(sprintf($_LANG['background_too_big'], $php_maxsize), 1, array(), false);
            }
            elseif ($_FILES['background_img']['error'] == 2)
            {
                sys_msg(sprintf($_LANG['background_too_big'], $htm_maxsize), 1, array(), false);
            }
        }

    }
    /* 4.1版本 */
    else
    {
        // 手机端转盘图片
        if ($_FILES['roulette_img']['tmp_name'] != 'none')
        {
            if (!$image->check_img_type($_FILES['roulette_img']['type']))
            {

                sys_msg($_LANG['invalid_roulette_img'], 1, array(), false);
            }
        }

        // 背景图
        if (isset($_FILES['background_img']))
        {
            if ($_FILES['background_img']['tmp_name'] != 'none')
            {
                if (!$image->check_img_type($_FILES['background_img']['type']))
                {
                    sys_msg($_LANG['invalid_background_img'], 1, array(), false);
                }
            }
        }
    }

    $roulette_img        = '';  // 初始化手机端转盘图片
    $background_img      = '';  // 初始化背景图

    // 是否上传手机端转盘图片
    if (isset($_FILES['roulette_img']) && $_FILES['roulette_img']['tmp_name'] != '' && isset($_FILES['roulette_img']['tmp_name']) &&$_FILES['roulette_img']['tmp_name'] != 'none')
    {
        // 上传了，直接使用，原始大小
        $roulette_img = $image->upload_image($_FILES['roulette_img']);
        if ($roulette_img === false)
        {
            sys_msg($image->error_msg(), 1, array(), false);
        }
    }
    else
    {
		sys_msg($_LANG['no_roulette_img'], 1, array(), false);
    }

    // 是否上传背景图
    if (isset($_FILES['background_img']) && $_FILES['background_img']['tmp_name'] != '' && isset($_FILES['background_img']['tmp_name']) &&$_FILES['background_img']['tmp_name'] != 'none')
    {
        // 上传了，直接使用，原始大小
        $background_img = $image->upload_image($_FILES['background_img']);
        if ($background_img === false)
        {
            sys_msg($image->error_msg(), 1, array(), false);
        }
    }
    else
    {
		sys_msg($_LANG['no_background_img'], 1, array(), false);
    }
	
	/*插入数据*/
    $add_time = gmtime();
    $sql = "INSERT INTO ".$ecs->table('exchange_draw')."(draw_title, start_time, end_time, draw_desc,roulette_img,background_img,add_time,deduct) ".
            "VALUES ('$draw_title', '$start_time', '$end_time', '$draw_desc', '$roulette_img', '$background_img', '$add_time','$deduct')";
    $db->query($sql);
	$did = $db->insert_id();
	$link[0]['text'] = $_LANG['view_prize'];
    $link[0]['href'] = 'exchange_draw.php?act=prize_list&did='.$did;
    
	$link[1]['text'] = $_LANG['continue_add'];
    $link[1]['href'] = 'exchange_draw.php?act=add';

    $link[2]['text'] = $_LANG['back_list'];
    $link[2]['href'] = 'exchange_draw.php?act=list';

    admin_log($did,'add','exchange_draw');

    clear_cache_files(); // 清除相关的缓存文件

    sys_msg($_LANG['articleadd_succeed'],0, $link);
}

/*------------------------------------------------------ */
//-- 编辑活动页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'edit')
{
    include_once(ROOT_PATH . 'includes/fckeditor/fckeditor.php'); // 包含 html editor 类文件
    /* 权限判断 */
    admin_priv('exchange_draw');

	/* 取商品数据 */
    $sql = "SELECT * ".
           " FROM " . $ecs->table('exchange_draw') . 
           " WHERE did='$_REQUEST[did]'";
    $draw = $db->GetRow($sql);
	$draw['start_time'] = local_date('Y-m-d H:i',$draw['start_time']);
	$draw['end_time'] = local_date('Y-m-d H:i',$draw['end_time']);
    $smarty->assign('draw',       $draw);
    $smarty->assign('ur_here',     $_LANG['exchange_draw_edit']);
    $smarty->assign('action_link', array('text' => $_LANG['17_exchange_draw_list'], 'href' => 'exchange_draw.php?act=list&' . list_link_postfix()));
    $smarty->assign('form_action', 'update');
    /* 创建 html editor */
    create_html_editor('draw_desc', $draw['draw_desc'],450);

    assign_query_info();
    $smarty->display('exchange_draw_info.htm');
}

/*------------------------------------------------------ */
//-- 编辑活动入库
/*------------------------------------------------------ */
if ($_REQUEST['act'] =='update')
{
    /* 权限判断 */
    admin_priv('exchange_draw');
	$did = intval($_POST['did']);
    $draw_title = !empty($_POST['draw_title']) ? htmlspecialchars(trim($_POST['draw_title'])) : '';
    $start_time = !empty($_POST['start_time']) ? local_strtotime($_POST['start_time']) : 0;
    $end_time = !empty($_POST['end_time']) ? local_strtotime($_POST['end_time']) : 0;
    $draw_desc = !empty($_POST['draw_desc']) ? $_POST['draw_desc'] : '';
	$deduct = !empty($_POST['deduct']) ? intval($_POST['deduct']) : 1;
	if(empty($did)){
		sys_msg($_LANG['no_did'], 1, array(), false);
	}
	if(empty($draw_title)){
		sys_msg($_LANG['no_draw_title'], 1, array(), false);
	}
	if(empty($start_time) || empty($end_time)){
		sys_msg($_LANG['no_time'], 1, array(), false);
	}
	if($start_time > $end_time){
		sys_msg($_LANG['start_lt_end'], 1, array(), false);
	}
    /* 检查图片：如果有错误，检查尺寸是否超过最大值；否则，检查文件类型 */
    if (isset($_FILES['roulette_img']['error'])) // php 4.2 版本才支持 error
    {
        // 最大上传文件大小
        $php_maxsize = ini_get('upload_max_filesize');
        $htm_maxsize = '2M';

        // 手机端转盘图片
        if ($_FILES['roulette_img']['error'] == 0)
        {
            if (!$image->check_img_type($_FILES['roulette_img']['type']))
            {
                sys_msg($_LANG['invalid_roulette_img'], 1, array(), false);
            }
        }
        elseif ($_FILES['roulette_img']['error'] == 1)
        {
            sys_msg(sprintf($_LANG['roulette_img_too_big'], $php_maxsize), 1, array(), false);
        }
        elseif ($_FILES['roulette_img']['error'] == 2)
        {
            sys_msg(sprintf($_LANG['roulette_img_too_big'], $htm_maxsize), 1, array(), false);
        }

        // 背景图
        if (isset($_FILES['background_img']))
        {
            if ($_FILES['background_img']['error'] == 0)
            {
                if (!$image->check_img_type($_FILES['background_img']['type']))
                {
                    sys_msg($_LANG['invalid_background_img'], 1, array(), false);
                }
            }
            elseif ($_FILES['background_img']['error'] == 1)
            {
                sys_msg(sprintf($_LANG['background_too_big'], $php_maxsize), 1, array(), false);
            }
            elseif ($_FILES['background_img']['error'] == 2)
            {
                sys_msg(sprintf($_LANG['background_too_big'], $htm_maxsize), 1, array(), false);
            }
        }

    }
    /* 4.1版本 */
    else
    {
        // 手机端转盘图片
        if ($_FILES['roulette_img']['tmp_name'] != 'none')
        {
            if (!$image->check_img_type($_FILES['roulette_img']['type']))
            {

                sys_msg($_LANG['invalid_roulette_img'], 1, array(), false);
            }
        }

        // 背景图
        if (isset($_FILES['background_img']))
        {
            if ($_FILES['background_img']['tmp_name'] != 'none')
            {
                if (!$image->check_img_type($_FILES['background_img']['type']))
                {
                    sys_msg($_LANG['invalid_background_img'], 1, array(), false);
                }
            }
        }
    }

    $roulette_img        = '';  // 初始化手机端转盘图片
    $background_img      = '';  // 初始化背景图

    // 是否上传手机端转盘图片
    if (isset($_FILES['roulette_img']) && $_FILES['roulette_img']['tmp_name'] != '' && isset($_FILES['roulette_img']['tmp_name']) &&$_FILES['roulette_img']['tmp_name'] != 'none')
    {
        // 上传了，直接使用，原始大小
        $roulette_img = $image->upload_image($_FILES['roulette_img']);
        if ($roulette_img === false)
        {
            sys_msg($image->error_msg(), 1, array(), false);
        }
    }

    // 是否上传背景图
    if (isset($_FILES['background_img']) && $_FILES['background_img']['tmp_name'] != '' && isset($_FILES['background_img']['tmp_name']) &&$_FILES['background_img']['tmp_name'] != 'none')
    {
        // 上传了，直接使用，原始大小
        $background_img = $image->upload_image($_FILES['background_img']);
        if ($background_img === false)
        {
            sys_msg($image->error_msg(), 1, array(), false);
        }
    }

	/* 如果有上传图片，删除原来的商品图 */
	$sql = "SELECT roulette_img,background_img " .
			" FROM " . $ecs->table('exchange_draw') .
			" WHERE did = '$did'";
	$row = $db->getRow($sql);
	if ($roulette_img && $row['roulette_img'] && !goods_parse_url($row['roulette_img']))
	{	
		@unlink(ROOT_PATH . $row['roulette_img']);
	}

	if ($background_img && $row['background_img'] && !goods_parse_url($row['background_img']))
	{
		@unlink(ROOT_PATH . $row['background_img']);
	}

	$sql = "UPDATE " . $ecs->table('exchange_draw') . " SET " .
			"draw_title = '$draw_title', " .
			"start_time = '$start_time', " .
			"end_time = '$end_time', " .
			"draw_desc = '$draw_desc'," .
			"deduct = '$deduct'" ;
	/* 如果有上传图片，需要更新数据库 */
	if ($roulette_img)
	{
		$sql .= ", roulette_img = '$roulette_img'";
	}
	if ($background_img)
	{
		$sql .= ", background_img = '$background_img'";
	}
	$sql .= " WHERE did = '$did' LIMIT 1";
    $db->query($sql);

	$link[0]['text'] = $_LANG['view_prize'];
    $link[0]['href'] = 'exchange_draw.php?act=prize_list&did='.$did;

    $link[1]['text'] = $_LANG['back_list'];
    $link[1]['href'] = 'exchange_draw.php?act=list';

    admin_log($did,'edit','exchange_draw');

    clear_cache_files(); // 清除相关的缓存文件

    sys_msg($_LANG['articleedit_succeed'],0, $link);
}

/*------------------------------------------------------ */
//-- 批量删除活动
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch_remove')
{
    admin_priv('exchange_draw');

    if (!isset($_POST['checkboxes']) || !is_array($_POST['checkboxes']))
    {
        sys_msg($_LANG['no_select_draw'], 1);
    }

    $count = 0;
    foreach ($_POST['checkboxes'] AS $key => $id)
    {
		/* 如果有上传图片，删除原来的商品图 */
		$sql = "SELECT background_img " .
				" FROM " . $ecs->table('exchange_draw') .
				" WHERE did = '$id'";
		$row = $db->getRow($sql);
        if ($exc->drop($id))
        {	/*	
			if ($row['roulette_img'] && !goods_parse_url($row['roulette_img']))
			{	
				@unlink(ROOT_PATH . $row['roulette_img']);
			}
			*/
			if ($row['background_img'] && !goods_parse_url($row['background_img']))
			{
				@unlink(ROOT_PATH . $row['background_img']);
			}
            admin_log($id,'remove','exchange_draw');
			$count++;
			$sql = 'DELETE FROM ' . $ecs->table('exchange_draw_prizes') . " WHERE did= '$id'";
            $db->query($sql);
        }
    }

    $lnk[] = array('text' => $_LANG['back_list'], 'href' => 'exchange_draw.php?act=list');
    sys_msg(sprintf($_LANG['batch_remove_succeed'], $count), 0, $lnk);
}

/*------------------------------------------------------ */
//-- 删除活动
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('exchange_draw');

    $id = intval($_GET['id']);
	
	$sql = "SELECT roulette_img,background_img " .
		" FROM " . $ecs->table('exchange_draw') .
		" WHERE did = '$id'";
	$row = $db->getRow($sql);

    if ($exc->drop($id))
    {	/*
		if ($row['roulette_img'] && !goods_parse_url($row['roulette_img']))
		{	
			@unlink(ROOT_PATH . $row['roulette_img']);
		}*/

		if ($row['background_img'] && !goods_parse_url($row['background_img']))
		{
			@unlink(ROOT_PATH . $row['background_img']);
		}
		$sql = 'DELETE FROM ' . $ecs->table('exchange_draw_prizes') . " WHERE did= '$id'";
        $db->query($sql);
        admin_log($id,'remove','article');
        clear_cache_files();
    }

    $url = 'exchange_draw.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- 奖品列表
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'prize_list')
{
 /* 权限判断 */
    admin_priv('exchange_draw');
    $did = intval($_REQUEST['did']);
	$draw = check_draw($did);

    /* 取得过滤条件 */
    $filter = array();
    $smarty->assign('ur_here',      $_LANG['17_exchange_draw_prize_list'].'['.$draw['draw_title'].']');
    $smarty->assign('action_link',  array('text' => $_LANG['exchange_draw_prize_add'], 'href' => 'exchange_draw.php?act=prize_add&did='.$did));
    $smarty->assign('action_link2',  array('text' => $_LANG['17_exchange_draw_list'], 'href' => 'exchange_draw.php?act=list'));
    $smarty->assign('full_page',    1);
    $smarty->assign('filter',       $filter);

    $prize_list = get_exchange_prize_list();

    $smarty->assign('prize_list',    $prize_list['arr']);
    $smarty->assign('count_odds',    getCountOdds());
    $smarty->assign('filter',       $prize_list['filter']);
    $smarty->assign('record_count', $prize_list['record_count']);
    $smarty->assign('page_count',   $prize_list['page_count']);
    $smarty->assign('did', $did);

    $sort_flag  = sort_flag($prize_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('exchange_draw_prize_list.htm');
}
/*------------------------------------------------------ */
//-- 添加奖品页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'prize_add')
{
    /* 权限判断 */
    admin_priv('exchange_draw');
    /*初始化*/
    $did = intval($_GET['did']);
	$draw = check_draw($did);

	$smarty->assign('ur_here',     $_LANG['exchange_draw_prize_add'].'['.$draw['draw_title'].']');
    $smarty->assign('action_link', array('text' => $_LANG['17_exchange_draw_prize_list'], 'href' => 'exchange_draw.php?act=prize_list&did='.$did));
    $smarty->assign('form_action', 'prize_insert');
    $smarty->assign('did', $did);
    assign_query_info();
    $smarty->display('exchange_draw_prize_info.htm');
}

/*------------------------------------------------------ */
//-- 添加奖品入库
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'prize_insert')
{
    /* 权限判断 */
    admin_priv('exchange_draw');
    
	$did = intval($_POST['did']);
	check_draw($did);

    $prize_name = !empty($_POST['prize_name']) ? htmlspecialchars(trim($_POST['prize_name'])) : '';
    $count_limit = isset($_POST['count_limit']) ? intval($_POST['count_limit']) : -1;
    $day_limit = isset($_POST['day_limit']) ? intval($_POST['day_limit']) : -1;
    $is_real = isset($_POST['is_real']) ? intval($_POST['is_real']) : 0;
    $is_prize = isset($_POST['is_prize']) ? intval($_POST['is_prize']) : 1;
    $odds = isset($_POST['odds']) ? trim($_POST['odds']) : 0;
    $angle_arr = !empty($_POST['angle']) ? explode("\r\n",trim($_POST['angle'])) : '';
	$i = 0;
	if(!empty($angle_arr)){
		foreach($angle_arr as $key => $val){
			$temp = array();
			$temp = explode("-",$val);
			if(count($temp) == 2){
				$angle[$i]['min'] = $temp[0];
				$angle[$i]['max'] = $temp[1];
				$i++;
			}
		}
	}

    if(empty($prize_name) || !isset($count_limit) || empty($angle) || !isset($odds)){
        sys_msg($_LANG['invalid_prize'], 1, array(), false);
    } 
	if($day_limit > $count_limit){
        sys_msg($_LANG['day_lt_count'], 1, array(), false);
	}
	$angle = serialize($angle);

    /*插入数据*/
    $add_time = gmtime();
    $sql = "INSERT INTO ".$ecs->table('exchange_draw_prizes')."(did,prize_name, count_limit, day_limit, is_real,is_prize,angle,odds) ".
            "VALUES ('$did','$prize_name', '$count_limit', '$day_limit', '$is_real', '$is_prize', '$angle','$odds')";
    $db->query($sql);
    $pid = $db->insert_id();

	$link[0]['text'] = $_LANG['continue_prize_add'];
    $link[0]['href'] = 'exchange_draw.php?act=prize_add&did='.$did;

    $link[1]['text'] = $_LANG['back_prize_list'];
    $link[1]['href'] = 'exchange_draw.php?act=prize_list&did='.$did;

    admin_log($pid,'add','exchange_draw_prize');

    clear_cache_files(); // 清除相关的缓存文件

    sys_msg($_LANG['articleadd_succeed'],0, $link);
}
/*------------------------------------------------------ */
//-- 编辑奖品页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'prize_edit')
{
    /* 权限判断 */
    admin_priv('exchange_draw');
	$did = intval($_GET['did']);
	check_draw($did);

	/* 取商品数据 */
    $sql = "SELECT * ".
           " FROM " . $ecs->table('exchange_draw_prizes') . 
           " WHERE pid='$_REQUEST[pid]'";
    $prize = $db->GetRow($sql);
	$angle = unserialize($prize['angle']);
	$prize['angle'] = array();
	foreach($angle as $val){
		$prize['angle'][] = implode('-',$val);
	}
	$prize['angle'] = implode("\r\n",$prize['angle']);
    $smarty->assign('prize',       $prize);
    $smarty->assign('ur_here',     $_LANG['exchange_draw_prize_edit']);
    $smarty->assign('action_link', array('text' => $_LANG['17_exchange_draw_prize_list'], 'href' => 'exchange_draw.php?act=prize_list&did='.$did));
    $smarty->assign('form_action', 'prize_update');
    $smarty->assign('did', $did);

    assign_query_info();
    $smarty->display('exchange_draw_prize_info.htm');
}

/*------------------------------------------------------ */
//-- 编辑奖品入库
/*------------------------------------------------------ */
if ($_REQUEST['act'] =='prize_update')
{
    /* 权限判断 */
    admin_priv('exchange_draw');
	$pid = intval($_POST['pid']);
	if(!$pid){
        ecs_header("Location: exchange_draw.php?act=list\n");
        exit;
    }
	$did = intval($_POST['did']);
	check_draw($did);
    $prize_name = !empty($_POST['prize_name']) ? htmlspecialchars(trim($_POST['prize_name'])) : '';
    $count_limit = isset($_POST['count_limit']) ? intval($_POST['count_limit']) : -1;
    $day_limit = isset($_POST['day_limit']) ? intval($_POST['day_limit']) : -1;
    $is_real = isset($_POST['is_real']) ? intval($_POST['is_real']) : 0;
    $is_prize = isset($_POST['is_prize']) ? intval($_POST['is_prize']) : 1;
    $odds = isset($_POST['odds']) ? trim($_POST['odds']) : 0;
    $angle_arr = !empty($_POST['angle']) ? explode("\r\n",trim($_POST['angle'])) : '';
	$i = 0;
	if(!empty($angle_arr)){
		foreach($angle_arr as $key => $val){
			$temp = array();
			$temp = explode("-",$val);
			if(count($temp) == 2){
				$angle[$i]['min'] = $temp[0];
				$angle[$i]['max'] = $temp[1];
				$i++;
			}
		}
	}
    if(empty($prize_name) || !isset($count_limit) || empty($angle) || !isset($odds)){
        sys_msg($_LANG['invalid_prize'], 1, array(), false);
    } 
	if($day_limit > $count_limit){
        sys_msg($_LANG['day_lt_count'], 1, array(), false);
	}
	$angle = serialize($angle);

	$sql = "UPDATE " . $ecs->table('exchange_draw_prizes') . " SET " .
			"prize_name = '$prize_name', " .
			"count_limit = '$count_limit', " .
			"day_limit = '$day_limit', " .
			"is_real = '$is_real'," .
			"is_prize = '$is_prize'," .
			"angle = '$angle'," .
			"odds = '$odds'" ;

	$sql .= " WHERE did = '$did' AND pid = '$pid' LIMIT 1";
    $db->query($sql);
	
    $link[0]['text'] = $_LANG['back_prize_list'];
    $link[0]['href'] = 'exchange_draw.php?act=prize_list&did='.$did;
	
	$link[1]['text'] = $_LANG['continue_prize_add'];
    $link[1]['href'] = 'exchange_draw.php?act=prize_add&did='.$did;

    admin_log($pid,'edit','exchange_draw_prize');

    clear_cache_files(); // 清除相关的缓存文件

    sys_msg($_LANG['prizeedit_succeed'],0, $link);
}
/*------------------------------------------------------ */
//-- 批量删除奖品
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch_remove_prize')
{
    admin_priv('exchange_draw');

    if (!isset($_POST['checkboxes']) || !is_array($_POST['checkboxes']))
    {
        sys_msg($_LANG['no_select_draw'], 1);
    }
	$did = intval($_POST['did']);
    $count = 0;
    foreach ($_POST['checkboxes'] AS $key => $id)
    {
		$sql = 'DELETE FROM ' . $ecs->table('exchange_draw_prizes') . " WHERE pid= '$id'";
        if ($db->query($sql))
        {		
            admin_log($id,'remove','exchange_draw_prize');
			$count++;
        }
    }

    $lnk[] = array('text' => $_LANG['back_list'], 'href' => 'exchange_draw.php?act=prize_list&did='.$did);
    sys_msg(sprintf($_LANG['batch_remove_prize_succeed'], $count), 0, $lnk);
}

/*------------------------------------------------------ */
//-- 删除奖品
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove_prize')
{
    check_authz_json('exchange_draw');

    $ids = explode('_',($_GET['id']));
	$id = $ids[0];
	$did = $ids[1];
	
	$sql = 'DELETE FROM ' . $ecs->table('exchange_draw_prizes') . " WHERE pid= '$id'";
	if ($db->query($sql))
	{		
		admin_log($id,'remove','exchange_draw_prize');
		clear_cache_files();
	}

	//$url = 'exchange_draw.php?act=prize_list&did='.$did;
    $url = 'exchange_draw.php?act=prize_query&did='.$did . str_replace('act=remove_prize', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}
/*------------------------------------------------------ */
//-- 奖品翻页，排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'prize_query')
{
    check_authz_json('exchange_draw');
    $did = intval($_REQUEST['did']);
	$draw = check_draw($did);
    $prize_list = get_exchange_prize_list();

    $smarty->assign('prize_list',    $prize_list['arr']);
    $smarty->assign('count_odds',    getCountOdds());
    $smarty->assign('filter',       $prize_list['filter']);
    $smarty->assign('record_count', $prize_list['record_count']);
    $smarty->assign('page_count',   $prize_list['page_count']);
    $smarty->assign('did', $did);
    $sort_flag  = sort_flag($prize_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('exchange_draw_prize_list.htm'), '',
        array('filter' => $prize_list['filter'], 'page_count' => $prize_list['page_count']));
}

function check_draw($did){
    $sql = 'SELECT did,draw_title FROM ' .$GLOBALS['ecs']->table('exchange_draw').
               ' WHERE did=' .$did;
    $draw = $GLOBALS['db']->getRow($sql);
    if(!$draw['did']){
        ecs_header("Location: exchange_draw.php?act=list\n");
        exit;
    }
	return $draw;
}
/* 获得活动列表 */
function get_exchange_list()
{
    $result = get_filter();
    if ($result === false)
    {
        $filter = array();
        $filter['keyword']    = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
        }
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'did' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $where = '';
        if (!empty($filter['keyword']))
        {
         $where = " AND draw_title LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
        }

        /* 活动总数 */
       $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('exchange_draw').
               ' WHERE 1' .$where;
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        $filter = page_and_size($filter);

        /* 获取活动数据 */
        $sql = 'SELECT * '.
               'FROM ' .$GLOBALS['ecs']->table('exchange_draw').
               ' WHERE 1' .$where. ' ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];

        $filter['keyword'] = stripslashes($filter['keyword']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $arr = array();
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
		$rows['start_time'] = local_date('Y-m-d H:i',$rows['start_time']);
		$rows['end_time'] = local_date('Y-m-d H:i',$rows['end_time']);
		$rows['add_time'] = local_date('Y-m-d H:i',$rows['add_time']);
        $arr[] = $rows;
    }
    return array('arr' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}
/* 获得奖品列表 */
function get_exchange_prize_list()
{
    $result = get_filter();
    if ($result === false)
    {
        $filter = array();
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'pid' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
        $filter['did'] = intval($_REQUEST['did']);
        $where = '';
        if (!empty($filter['did']))
        {
         $where = " AND did ='" . $filter['did'] . "'";
        }

        /* 奖品总数 */
       $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('exchange_draw_prizes').
               ' WHERE 1' .$where;
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        $filter = page_and_size($filter);

        /* 获取奖品数据 */
        $sql = 'SELECT * '.
               'FROM ' .$GLOBALS['ecs']->table('exchange_draw_prizes').
               ' WHERE 1' .$where. ' ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];

        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $arr = array();
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $rows['angle'] = implode("\r\n",unserialize($rows['angle']));
        $arr[] = $rows;
    }
    return array('arr' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

function getCountOdds(){
	$filter['did'] = intval($_REQUEST['did']);
	$where = '';
	if (!empty($filter['did']))
	{
	 $where = " AND did ='" . $filter['did'] . "'";
	}

	/* 奖品概率总和 */
	$sql = 'SELECT SUM(odds) FROM ' .$GLOBALS['ecs']->table('exchange_draw_prizes').
		   ' WHERE 1' .$where;
	return $GLOBALS['db']->getOne($sql);	
}
/**
 * 检查图片网址是否合法
 *
 * @param string $url 网址
 *
 * @return boolean
 */
function goods_parse_url($url)
{
    $parse_url = @parse_url($url);
    return (!empty($parse_url['scheme']) && !empty($parse_url['host']));
}

?>
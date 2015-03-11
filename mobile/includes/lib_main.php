<?php

/**
 * ECSHOP mobile前台公共函数
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: testyang $
 * $Id: lib_main.php 15013 2008-10-23 09:31:42Z testyang $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/**
 * 对输出编码
 *
 * @access  public
 * @param   string   $str
 * @return  string
 */
function encode_output($str)
{
//    if (EC_CHARSET != 'utf-8')
//    {
//        $str = ecs_iconv(EC_CHARSET, 'utf-8', $str);
//    }
    return htmlspecialchars($str);
}

/**
 * wap分页函数
 *
 * @access      public
 * @param       int     $num        总记录数
 * @param       int     $perpage    每页记录数
 * @param       int     $curr_page  当前页数
 * @param       string  $mpurl      传入的连接地址
 * @param       string  $pvar       分页变量
 */
function get_wap_pager($num, $perpage, $curr_page, $mpurl,$pvar)
{
    $multipage = '';
    if($num > $perpage)
    {
        $page = 2;
        $offset = 1;
        $pages = ceil($num / $perpage);
        $all_pages = $pages;
        $tmp_page = $curr_page;
        $setp = strpos($mpurl, '?') === false ? "?" : '&amp;';
        if($curr_page > 1)
        {
            $multipage .= "<a href=\"$mpurl${setp}${pvar}=".($curr_page-1)."\">上一页</a>";
        }
        $multipage .= $curr_page."/".$pages;
        if(($curr_page++) < $pages)
        {
            $multipage .= "<a href=\"$mpurl${setp}${pvar}=".$curr_page++."\">下一页</a><br/>";
        }
        //$multipage .= $pages > $page ? " ... <a href=\"$mpurl&amp;$pvar=$pages\"> [$pages] &gt;&gt;</a>" : " 页/".$all_pages."页";
        //$url_array = explode("?" , $mpurl);
       // $field_str = "";
       // if (isset($url_array[1]))
       // {
          //  $filed_array = explode("&amp;" , $url_array[1]);
           // if (count($filed_array) > 0)
            //{
             //   foreach ($filed_array AS $data)
              //  {
               //     $value_array = explode("=" , $data);
                //    $field_str .= "<postfield name='".$value_array[0]."' value='".encode_output($value_array[1])."'/>\n";
               // }
           // }
      //  }
        //$multipage .= "跳转到第<input type='text' name='pageno' format='*N' size='4' value='' maxlength='2' emptyok='true' />页<anchor>[GO]<go href='{$url_array[0]}' method='get'>{$field_str}<postfield name='".$pvar."' value='$(pageno)'/></go></anchor>";
        //<postfield name='snid' value='".session_id()."'/>
    }
    return $multipage;
}

/**
 * 返回尾文件
 *
 * @return  string
 */
function get_footer()
{
    if ($_SESSION['user_id'] > 0)
    {
        $footer = "<br/><a href='user.php?act=user_center'>用户中心</a>|<a href='user.php?act=logout'>退出</a>|<a href='javascript:scroll(0,0)' hidefocus='true'>回到顶部</a><br/>Copyright 2009<br/>Powered by ECShop v2.7.2";
    }
    else
    {
        $footer = "<br/><a href='user.php?act=login'>登陆</a>|<a href='user.php?act=register'>免费注册</a>|<a href='javascript:scroll(0,0)' hidefocus='true'>回到顶部</a><br/>Copyright 2009<br/>Powered by ECShop v2.7.2";
    }

    return $footer;
}
/* 2014-04-25 Add by Jole
 */
function get_ccs_result1($mobile){
	$res=array();
	$param = array('tUcode' => '', 'tUpsw' => '', 'tMobile' => '');
	$param['tUcode'] = 'HOLYES88';
	$param['tUpsw'] = 'D188BFF769EC94B540AE12B3A41FEE7C';
	$param['tMobile'] = $mobile;
	$url=CCS_API_URL;
	$cliente = new SoapClient($url);
	$arr=object_array1($cliente->__call('ReadClerkWinning',array("parameters"=>$param)));
	$res= explode(";",$arr['ReadClerkWinningResult']);

	return $res;
}

/**
 * css积分扣除的接口
 * @param $mobile 手机号码
 * @param $win 分数
 * @param $order_sn 订单号
 * 返回true表示修改成功
 */
function update_Winning1($mobile, $win, $order_sn){
	$res=array();
	$param = array('tUcode' => '', 'tUpsw' => '', 'tMobile' => '');
	$param['tUcode'] = 'HOLYES88';
	$param['tUpsw'] = 'D188BFF769EC94B540AE12B3A41FEE7C';
	$param['tMobile'] = $mobile;
	$param['Winning'] = $win;
	$param['OrderNo'] = $order_sn;
	$url= CCS_API_URL;

	$cliente = new SoapClient($url);
	$arr=object_array($cliente->__call('ConvertWinning20',array("parameters"=>$param)));
	//file_put_contents("ConvertWinning.txt",$arr);
	$res= explode(";",$arr['ConvertWinning20Result']);

	return $res[0];
}

/* 2014-04-25 Add by Jole */
function object_array1($array) {
	if(is_object($array)) {
		$array = (array)$array;
	} if(is_array($array)) {
		foreach($array as $key=>$value) {
			$array[$key] = object_array($value);
		}
	}
	return $array;
}

/* 判断是否CCS会员
 2014-04-25 Add by Jole */
function check_ccs1($mobile){
	$check_res = array();
	$check_res = get_ccs_result1($mobile);
	return $check_res[0];
}

/* 获得CCS会员的积分信息
 2014-04-25 Add by Jole */
function get_jf_info1($mobile){
	$arr = array();
	$res= array();
	$arr = get_ccs_result1($mobile);
	$res = (Array)json_decode($arr[1]);
	return $res;
}

/* 获得CCS的店员总积分
 2014-04-25 Add by Jole */
function get_user_winning1($mobile){
	$arr = array();
	$arr = get_jf_info1($mobile);
	return $arr['Winning'];
}

/* 获得CCS的店员总兑换分数
 2014-04-25 Add by Jole */
function get_user_ConvertWinning1($mobile){
	$arr = array();
	$arr = get_jf_info1($mobile);
	return $arr['Convertwinning'];
}

/* 获得CCS会员的可用积分
 2014-04-25 Add by Jole */
function get_can_use_Winning1($mobile){
	$arr = array();
	$arr = get_jf_info1($mobile);
	$canuse = $arr['Winning'] - $arr['Convertwinning'];
	/*未扣除订单积分 Add By SouL_Z 2014-7-30 18:27*/
	$sql = "SELECT sum(integral) FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE order_status IN (" . OS_UNCONFIRMED . "," . OS_CONFIRMED . ", ".OS_SPLITED.") and pay_status = ".PS_PAYED." and is_deduct = 0 and  user_id = '" . $_SESSION['user_id'] . "'";
	$record_count = $GLOBALS['db']->getOne($sql); //已确认已付款未扣除订单积分数
	$residue_jf = max(0,$canuse - $record_count);
	return $residue_jf;
}

/**
 * 返回头部文件
 * @return string
 */
function get_header()
{
	$header = '<!doctype html>
		<html lang="zh-CN">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no" /> 
			<title>海伦凯勒眼镜-手机网站</title>
			<link rel="stylesheet" href="./templates/images/css.css">
			<script src="./templates/js/jquery.js"></script>
			<script src="./templates/js/jQueryRotate.2.2.js"></script>
			<script src="./templates/js/jquery.easing.min.js"></script>
			<script src="../js/common.js"></script>
			<script>
				$(function(){
					$(".main").append("<div class=\"go-top\"></div>");
					$(".go-top").click(function(){
						$("html,body").animate({scrollTop:0},500);
					});	

					$(window).scroll(function(){
						var h = $(document).scrollTop();
						if(h<100){
							$(".go-top").hide();
						}else{
							$(".go-top").show();
						}
					});
				});
			</script>
		</head>
		<div align="left" style="display:none">'.$GLOBALS['_CFG']['stats_code'].'</div>';
	return $header;
}

function dump($str){
	echo "<pre>";
	var_dump($str);
	echo "</pre>";
	exit;
}
?>
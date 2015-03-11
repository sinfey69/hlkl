<?php

/**
 * ECSHOP 商品页
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: testyang $
 * $Id: goods.php 15013 2008-10-23 09:31:42Z testyang $
*/
//exit;
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* 会员是否登录判断 */

if($_SESSION['user_id']<1){
	Header("Location: user.php");
	exit;
}

$smarty->assign('header', get_header());

$goods_id = !empty($_GET['id']) ? intval($_GET['id']) : '';
$act = !empty($_GET['step']) ? $_GET['step'] : '';

/**
 * 添加到购物车
 */
if($act == 'add_to_cart'){
	if($_SESSION['user_id']<1){
		ecs_header("Location: user.php");
		exit;
	}

	$good_id =  isset($_POST['id']) ? intval($_POST['id']) : '';
	$number =  isset($_POST['number']) ? intval($_POST['number']) : '';
	$goods_attr_id = !empty($_POST['attr_id']) ? intval($_POST['attr_id']) : '';
	
	if(!is_numeric($good_id) || intval($good_id) <= 0){
		echo "<script>alert('参数不合法！');location.href='good.php';</script>";	
		exit;		
	}
	
	//取出商品的积分
	$sql = "SELECT integral FROM ".$GLOBALS['ecs']->table('goods')." WHERE goods_id=".$good_id;
	$jf = $db->getOne($sql);
	$jf = $jf*$number;
	
	//当前用户的积分
	$ujf = @get_can_use_winning1($_SESSION['user_name']);
	if($ujf < $jf){
		echo "<script>alert('抱歉，您的积分不够！');location.href='goods.php?id=$good_id';</script>";
		exit;
	}
	
	/* 取得商品信息 */
	/*$sql = "SELECT g.goods_name, g.goods_sn, g.is_on_sale, g.is_real, ".
			"g.market_price, g.shop_price AS org_price, g.promote_price, g.promote_start_date, ".
			"g.promote_end_date, g.goods_weight, g.integral, g.extension_code, ".
			"g.goods_number, g.is_alone_sale, g.is_shipping,g.shop_price,".
			"IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price ".
			" FROM " .$GLOBALS['ecs']->table('goods'). " AS g ".
			" LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
			"ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
			" WHERE g.goods_id = '$good_id'" .
			" AND g.is_delete = 0";
	$goods = $db->getRow($sql);
	*/
	$goods = get_exchange_goods_info($good_id);
//  	dump($goods);
	/* 是否正在销售 */
	if ($goods['is_on_sale'] == 0)
	{
		echo "<script>alert('商品未在销售！');location.href='good.php';</script>";
		exit;		
	}
	
	/* 库存 */
	if ($goods['goods_number'] < $number)
	{
		echo "<script>alert('抱歉，商品的库存不够！');location.href='good.php';</script>";
		exit;
	}

	$sql = "SELECT attr_value FROM " .$GLOBALS['ecs']->table('goods_attr'). " WHERE goods_attr_id = '$goods_attr_id' LIMIT 0, 1";
	$goods_attr = $db->getOne($sql);

	
	/* 初始化要插入购物车的基本件数据 */
	$parent = array(
			'user_id'       => $_SESSION['user_id'],
			'session_id'    => SESS_ID,
			'goods_id'      => $good_id,
			'goods_sn'      => addslashes($goods['goods_sn']),
			'product_id'    => 0,
			'goods_name'    => addslashes($goods['goods_name']),
			'market_price'  => $goods['market_price'],
			'goods_price'  => $goods['goods_price'],
			'integral'      => $goods['exchange_integral'], 
			'goods_attr'    => addslashes($goods_attr),
			'goods_attr_id' => $goods_attr_id,
			'is_real'       => $goods['is_real'],
			'extension_code'=> $goods['extension_code']?$goods['extension_code']:'',
			'is_gift'       => 0,
			'now_buy'       => 1,
			'is_shipping'   => $goods['is_shipping'],
			'rec_type'      => CART_EXCHANGE_GOODS //CART_GENERAL_GOODS
	);
	
	$sql = "SELECT goods_number FROM ecs_cart WHERE goods_attr_id = '$goods_attr_id' AND user_id = '" . $_SESSION['user_id'] . "' AND goods_id=".$good_id;
	$goods_number = $db->getOne($sql);
	/**
	 * 判断购物车有没有同类型的商品，有的话就更新数量，反之就插入数据
	 */
	if($goods_number>0){
		$db->query("update ecs_cart set goods_number=goods_number+".$number." WHERE goods_attr_id = '$goods_attr_id' AND user_id = '" . $_SESSION['user_id'] . "' AND goods_id=".$good_id);
	}else{
		$sql = "insert into ecs_cart(user_id,session_id,goods_id,goods_sn,product_id,goods_name,market_price,integral,goods_attr,goods_attr_id,is_real,extension_code,is_gift,is_shipping,rec_type,goods_number,goods_price,now_buy) 
		values(".$parent['user_id'].",'".$parent['session_id']."',".$parent['goods_id'].",'".$parent['goods_sn']."',0,'".$parent['goods_name']."',".$parent['market_price'].",
		".$parent['integral'].",'".$parent['goods_attr']."','".$parent['goods_attr_id']."',".$parent['is_real'].",'".$parent['extension_code']."',".$parent['is_gift'].",".$parent['is_shipping'].",".$parent['rec_type'].",".$number.",".$parent['goods_price'].",".$parent['now_buy'].")";
		$db->query($sql);
	}
	ecs_header("Location:flow.php");
	exit;

/*
 * 删除购物车
 */
}elseif($act == 'del'){
	$id = intval($_GET['id']);
	if($id){
		$sql = "delete from ecs_cart where rec_id=".$id;
		$db->query($sql);
	}
	ecs_header("Location:flow.php");
	exit;	
/*
 * 更新购物车
 */	
}elseif($act == 'update'){
	include('includes/cls_json.php');
	$json = new JSON;
	$id = $_POST['id'];
	if(!empty($id)){
		if(!is_array($id)){
			$temp = explode(',',$id);
			$id = array();
			$id = $temp;
			unset($temp);
		}
		if(isset($_POST['buy'])){
			$buy = intval($_POST['buy'])?intval($_POST['buy']) : 0;
			$set_arr[] = "now_buy = ".$buy;
		}
		if(isset($_POST['num'])){
			$num = intval($_POST['num'])?intval($_POST['num']) : 0;
			if($num > 0){
                if ($GLOBALS['_CFG']['use_storage'] == 1){
                    $rec_id = implode(',',$id);
                    $sql = "SELECT goods_id,goods_attr_id,goods_number FROM  " .$GLOBALS['ecs']->table('cart')." WHERE rec_id='".$rec_id."' AND user_id = '" . $_SESSION['user_id']."'";
                    $cart = $GLOBALS['db']->getRow($sql);
                    if(!empty($cart)){             
                        $goods = get_exchange_goods_info($cart['goods_id']);
                        //检查：商品购买数量是否大于总库存
                        if ($num > $goods['goods_number'])
                        {
                            $res = array('code'=>'-2','message' => '商品库存不足','data' =>array('id'=>$rec_id,'num'=>$cart['goods_number']));
                            die($json->encode($res));
                        }
                        $spec = explode(',',$cart['goods_attr_id']);
                        /* 如果商品有规格则取规格商品信息 配件除外 */
                        $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('products'). " WHERE goods_id = '$cart[goods_id]' LIMIT 0, 1";
                        $prod = $GLOBALS['db']->getRow($sql);
                        if (is_spec($spec) && !empty($prod))
                        {
                            $product_info = get_products_info($cart['goods_id'], $spec);
                        }
                        //商品存在规格 是货品 检查该货品库存
                        if (is_spec($spec) && !empty($prod))
                        {
                            if (!empty($spec))
                            {
                                /* 取规格的货品库存 */
                                if ($num > $product_info['product_number'])
                                {
                                    $res = array('code'=>'-2','message' => '该规格库存不足','data' =>array('id'=>$rec_id,'num'=>$cart['goods_number']));
                                    die($json->encode($res));
                                }
                            }
                        }       
                    }
                }
                $set_arr[] = 'goods_number='.$num;
			}
		}
		$set = implode(',',$set_arr);

		$sql = "UPDATE ecs_cart SET ".$set." WHERE user_id = '" . $_SESSION['user_id']."' AND rec_id IN (".implode(',',$id).")";
		$db->query($sql);
		$data = get_update_cart();
		$res = array('code'=>'1','message' => '更新成功','data' => $data);
	}else{
		$res = array('code'=>'-1','message' => '更新失败');
	}
	die($json->encode($res));	
	/*
 * 取出购物车
 */	
}else{
	if($_SESSION['user_id']<1){
		Header("Location: user.php");
		exit;
	}
	$sql = "SELECT * FROM ecs_cart WHERE user_id = '" . $_SESSION['user_id'] . "'";
	
	$list = $db->getAll($sql);
	$jf 	= 0;
	$money 	= 0;
	$num	= 0;
	
	if(!empty($list)){
		foreach ($list as $k=>$v){
			$img = get_goods_gallery($v['goods_id']);
			$list[$k]['goods_img'] = $img[0]['img_url'];
			if($v['now_buy']){
				$jf +=$v['goods_number']*$v['integral'];
				$money +=$v['goods_number']*$v['goods_price'];
				$num +=$v['goods_number'];
			}
		}
	}
	
// 	echo $jf.",".$money.",".$num;
// 	dump($list);exit;

	//总积分
	$smarty->assign('jf', $jf);
	//总金额
	$smarty->assign('money', $money);
	//产品的数量
	$smarty->assign('num', $num);
	$smarty->assign('list', $list);
	
	$smarty->display("flow.html");
}

/**
* 获得积分兑换商品的详细信息
*
* @access  public
* @param   integer     $goods_id
* @return  void
*/
function get_exchange_goods_info($goods_id)
{
	$time = gmtime();
	$sql = 'SELECT g.*, c.measure_unit, b.brand_id, b.brand_name AS goods_brand, eg.exchange_integral, eg.is_exchange,eg.goods_price ' .
			'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
			'LEFT JOIN ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg ON g.goods_id = eg.goods_id ' .
			'LEFT JOIN ' . $GLOBALS['ecs']->table('category') . ' AS c ON g.cat_id = c.cat_id ' .
			'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON g.brand_id = b.brand_id ' .
			"WHERE g.goods_id = '$goods_id' AND g.is_delete = 0 " .
			'GROUP BY g.goods_id';
	//echo $sql;exit;
	$row = $GLOBALS['db']->getRow($sql);
	file_put_contents("bill/lastsql.txt",$sql."\r\n",FILE_APPEND);
	if ($row !== false)
	{
		/* 处理商品水印图片 */
		$watermark_img = '';

		if ($row['is_new'] != 0)
		{
			$watermark_img = "watermark_new";
		}
		elseif ($row['is_best'] != 0)
		{
			$watermark_img = "watermark_best";
		}
		elseif ($row['is_hot'] != 0)
		{
			$watermark_img = 'watermark_hot';
		}

		if ($watermark_img != '')
		{
			$row['watermark_img'] =  $watermark_img;
		}

		/* 修正重量显示 */
		$row['goods_weight']  = (intval($row['goods_weight']) > 0) ?
		$row['goods_weight'] . $GLOBALS['_LANG']['kilogram'] :
		($row['goods_weight'] * 1000) . $GLOBALS['_LANG']['gram'];

		/* 修正上架时间显示 */
		$row['add_time']      = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);

		/* 修正商品图片 */
		$row['goods_img']   = get_image_path($goods_id, $row['goods_img']);
		$row['goods_thumb'] = get_image_path($goods_id, $row['goods_thumb'], true);

		return $row;
	}
	else
	{
		return false;
	}
}


/**
 * 获得更新后的购物车数据
 * @return array
 */
function get_update_cart(){
    $sql = "SELECT c.*,eg.exchange_integral,eg.goods_price ,IF(c.parent_id, c.parent_id, c.goods_id) AS pid " .
    " FROM " . $GLOBALS['ecs']->table('cart') . " as c " .
    " LEFT JOIN " . $GLOBALS['ecs']->table('exchange_goods') . " AS eg ".
            "ON eg.goods_id = c.goods_id ".
    " WHERE c.user_id = '" . $_SESSION['user_id'] . "' AND c.rec_type = '" . CART_EXCHANGE_GOODS . "' AND c.now_buy = 1" .
    " ORDER BY pid, c.parent_id";

    $list = $GLOBALS['db']->getAll($sql);
    $data = array('buy_integral_amount' => 0,'buy_goods_amount'=> 0,'buy_goods_count'=> 0);
    if(!empty($list)){
        foreach ($list as $k=>$v){
            //$data['buy_integral_amount'] +=$v['goods_number']*$v['integral'];
            if($v['integral'] > 0){
                $data['buy_integral_amount'] += $v['integral'] * $v['goods_number']; //2041-04-28 Add by Jole
            }else{
                $data['buy_integral_amount'] += $v['exchange_integral'] * $v['goods_number']; //2041-04-28 Add by Jole
            }
            $data['buy_goods_amount'] +=$v['goods_number']*$v['goods_price'];
            $data['buy_goods_count'] +=$v['goods_number'];
        }
    }
    return $data;
}
?>
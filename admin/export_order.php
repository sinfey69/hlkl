<?php

/**
 * ECSHOP 商品销售排行
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: sale_order.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/order.php');
$smarty->assign('lang', $_LANG);

$field_arr = array( '订单号', '购货人', '下单时间', '付款时间', '发货时间', '发货单号', 
                    '订单状态', '支付方式', '订单来源', '商品名称[品牌]', '货号', 
                    '积分数', '价格', '数量', '属性', '收货人', '电话', 
                    '手机', '电子邮件','地址','标志性建筑','最佳送货时间','订单留言'
                );
if (isset($_REQUEST['act']) && ($_REQUEST['act'] == 'export_order_execl'))
{
    /* 检查权限 */
    check_authz_json('sale_order_stats');
    if (strstr($_REQUEST['start_date'], '-') === false)
    {
        $_REQUEST['start_date'] = local_date('Y-m-d', $_REQUEST['start_date']);
        $_REQUEST['end_date'] = local_date('Y-m-d', $_REQUEST['end_date']);
    }
    $field = $_REQUEST['export_field'];
    if(empty($field)){
        sys_msg('请选择需导出字段');
    }
    foreach($field as $val){
        $export_field[$val] = $field_arr[$val];
    }
    export_order_execl($export_field);
    exit;
}
else
{
    /* 权限检查 */
    admin_priv('sale_order_stats');

    /* 时间参数 */
    if (!isset($_REQUEST['start_date']))
    {
        $_REQUEST['start_date'] = local_strtotime('-1 months');
    }
    if (!isset($_REQUEST['end_date']))
    {
        $_REQUEST['end_date'] = local_strtotime('+1 day');
    }
   // $goods_order_data = get_sales_order();

    /* 赋值到模板 */
    $smarty->assign('ur_here',          $_LANG['export_order']);
    $smarty->assign('start_date',       local_date('Y-m-d', $_REQUEST['start_date']));
    $smarty->assign('end_date',         local_date('Y-m-d', $_REQUEST['end_date']));
    $smarty->assign('field_arr',        $field_arr);
    //$smarty->assign('action_link',      array('text' => $_LANG['download_sale_sort'], 'href' => '#download' ));

    /* 显示页面 */
    assign_query_info();
    $smarty->display('export_order.htm');
}



/**
 * 订单导出生成execl文件
 * @param  array $export_field [需导出字段]
 * @return return               [description]
 */
function export_order_execl($export_field = array()) {
    global $_LANG;

    if (empty($export_field)) {
        sys_msg('请选择需导出字段');
    }
	$where = "WHERE g.is_gift = 0";
    $filter['start_time'] = empty($_REQUEST['start_time']) ? '' : (strpos($_REQUEST['start_time'], '-') > 0 ? local_strtotime($_REQUEST['start_time']) : $_REQUEST['start_time']);
    $filter['end_time'] = empty($_REQUEST['end_time']) ? '' : (strpos($_REQUEST['end_time'], '-') > 0 ? local_strtotime($_REQUEST['end_time']) + 86399 : $_REQUEST['end_time']);
    if ($filter['start_time'] && $filter['end_time']) {
            $where .= " AND o.add_time >= '$filter[start_time]' AND o.add_time <= '$filter[end_time]'";
    }
	//订单
    $data_array = array();
    $sql = "SELECT o.order_id,o.order_sn,o.user_id,o.order_status,o.shipping_status,o.pay_status,o.consignee,o.shipping_time,o.pay_time,o.referer,".
			"o.province,o.city,o.district,o.address,o.tel,o.mobile,o.email,o.best_time,o.sign_building,o.pay_name,o.postscript,o.invoice_no,(" . order_amount_field('o.') . ") AS total_fee,".
			"g.goods_id,g.goods_name,g.goods_number,g.product_id,g.goods_price,g.goods_attr,eg.exchange_integral,IFNULL(p.product_sn,g.goods_sn) as goodsSn ".
			"FROM " . $GLOBALS['ecs']->table('order_goods') . " as g LEFT JOIN " . 
			$GLOBALS['ecs']->table('order_info') . " as o ON o.order_id=g.order_id LEFT JOIN " .
			$GLOBALS['ecs']->table('exchange_goods') . " as eg ON eg.goods_id=g.goods_id LEFT JOIN " .
			$GLOBALS['ecs']->table('products') . " as p ON p.product_id=g.product_id " .
			$where . " order by o.add_time desc";
    $data_array = $GLOBALS['db']->getAll($sql);
    if (empty($data_array)) {
        sys_msg('没有数据导出');
    }
    $cols_array = array();
    foreach($export_field as $key => $val){
        $cols_array[0][] = $val;
        $field_array[] = $key;
    }
    $export_array = array();
    foreach ($data_array as $key => $val) {
        $i = 0;
        if(in_array($i,$field_array)){
		  $export_array[$key][] = $val['order_sn'];
        }
        if(in_array(++$i,$field_array)){
    		#获取下单用户名#
    		$sql = "SELECT user_name FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = $val[user_id]";
    		$user_name = $GLOBALS['db']->getOne($sql);
    		$export_array[$key][] = $user_name;
        }
		if(in_array(++$i,$field_array)){
            $export_array[$key][] = local_date('Y-m-d H:i:s',$val['add_time']);
        }
		if(in_array(++$i,$field_array)){
            $export_array[$key][]= !empty($val['pay_time']) ? local_date('Y-m-d H:i:s',$val['pay_time']) : '-';
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= !empty($val['shipping_time']) ? local_date('Y-m-d H:i:s',$val['shipping_time']) : '-';
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= !empty($val['invoice_no']) ? $val['invoice_no'] : '-';
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= strip_tags($_LANG['os'][$val['order_status']]);
        }
        if(in_array(++$i,$field_array)){
        $export_array[$key][]= $val['pay_name'];
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['referer'];
		}

		if(in_array(++$i,$field_array)){
            #获取商品品牌名#
    		$sql = "SELECT b.brand_name FROM " . $GLOBALS['ecs']->table('goods') . " as g LEFT JOIN " . $GLOBALS['ecs']->table('brand') . " as b ON b.brand_id=g.brand_id WHERE g.goods_id = $val[goods_id]";
    		$brand_name = $GLOBALS['db']->getOne($sql);
    		$export_array[$key][]= $val['goods_name']."[".$brand_name."]";
        }
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['goodsSn'];
        }
		if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['exchange_integral'];
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['goods_price'];
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['goods_number'];
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['goods_attr'];
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['consignee'];
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= !empty($val['tel']) ? $val['tel'] : '-';
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= !empty($val['mobile']) ? $val['mobile'] : '-';
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['email'];
		}

        if(in_array(++$i,$field_array)){
            #获取完整配送地址#
    		$province = get_regionsName($val['province']);
    		$city = get_regionsName($val['city']);
    		$district = get_regionsName($val['district']);
    		$export_array[$key][]= $province.$city.$district.$val['address'];
		}

        if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['sign_building'];
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['best_time'];
		}
        if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['postscript'];
        }
    }

    $result = array_merge($cols_array, $export_array);
    zip_download($result);
}
?>
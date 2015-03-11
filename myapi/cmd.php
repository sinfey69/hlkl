<?php

/**
 * ECSHOP 购物流程
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: yehuaixiao $
 * $Id: flow.php 17218 2011-01-24 04:10:41Z yehuaixiao $
 */

define('IN_ECS', true);
unset($result);
require(dirname(__FILE__) . '/../includes/init.php');





	/*	
		//echo $sql;
	$sql = 'SELECT s.shipping_id, s.shipping_code, s.shipping_name, ' .
                's.shipping_desc, s.insure, s.support_cod, a.configure ' .
            'FROM ' . $GLOBALS['ecs']->table('shipping') . ' AS s, ' .
                $GLOBALS['ecs']->table('shipping_area') . ' AS a, ' .
                $GLOBALS['ecs']->table('area_region') . ' AS r ' .
            'WHERE   r.shipping_area_id = a.shipping_area_id AND a.shipping_id = s.shipping_id AND s.enabled = 1 ORDER BY s.shipping_order';
			
		
		//$sql="desc " . $GLOBALS['ecs']->table('member_price');
			
	//echo 	$db->getOne($sql) ;
	
	$sql = "SELECT * FROM " . $ecs->table('order_info').' where order_sn=2014031229526';
        //$col = $db->getOne($sql);
		//var_dump($col);
        //如果商店没有设置商品属性,那么此检索条件是无效的
        if (!empty($col))
        {
            $attr_in = " AND " . db_create_in($col, 'g.goods_id');
        }
		
		//echo $attr_in;
		*/
		
	//$sql="desc " . $GLOBALS['ecs']->table('pay_log');
	

	$sql="select * from ecs_cart order by rec_id desc ";
	//echo $sql;
	 $all = $GLOBALS['db']->getAll($sql);

    foreach ($all AS $key => $row){
		var_dump($row);	
	}
?>
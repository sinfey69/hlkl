<?php

/**
 * ECSHOP ��������
 * ============================================================================
 * ��Ȩ���� 2005-2010 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
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
        //����̵�û��������Ʒ����,��ô�˼�����������Ч��
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
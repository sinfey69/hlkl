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
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/users.php');
$smarty->assign('lang', $_LANG);

$field_arr = array( '会员编号', '手机号', '姓名', '号码归属运营商', '号码归属地', '所属代理商', 
                    '所属零售商', '性别', '出生日期', 'MSN', 'QQ', 
                    '办公电话', '家庭电话', '总积分', '可用积分', '地址', 'E-Mail', '总登录次数', 
                    '最近一次登录时间', '注册日期','交易订单数（笔）','成功订单数（笔）','交易订单额（元）','成功订单额（元）'
                );
if (isset($_REQUEST['act']) && ($_REQUEST['act'] == 'export_members_execl'))
{
    /* 检查权限 */
    check_authz_json('client_flow_stats');
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
    export_member_execl($export_field);
    exit;
}
else
{
    /* 权限检查 */
    admin_priv('client_flow_stats');

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
    $smarty->assign('ur_here',          $_LANG['export_members']);
    $smarty->assign('start_date',       local_date('Y-m-d', $_REQUEST['start_date']));
    $smarty->assign('end_date',         local_date('Y-m-d', $_REQUEST['end_date']));
    $smarty->assign('field_arr',        $field_arr);
    //$smarty->assign('action_link',      array('text' => $_LANG['download_sale_sort'], 'href' => '#download' ));

    /* 显示页面 */
    assign_query_info();
    $smarty->display('export_members.htm');
}



/**
 * 会员导出生成execl文件
 * @param  array $export_field [需导出字段]
 * @return return               [description]
 */
function export_member_execl($export_field = array()) {
    global $_LANG;
	set_time_limit(0);
    if (empty($export_field)) {
        sys_msg('请选择需导出字段');
    }
	//$where = "WHERE g.is_gift = 0";
    $filter['start_time'] = empty($_REQUEST['start_time']) ? '' : (strpos($_REQUEST['start_time'], '-') > 0 ? local_strtotime($_REQUEST['start_time']) : $_REQUEST['start_time']);
    $filter['end_time'] = empty($_REQUEST['end_time']) ? '' : (strpos($_REQUEST['end_time'], '-') > 0 ? local_strtotime($_REQUEST['end_time']) + 86399 : $_REQUEST['end_time']);
    if ($filter['start_time'] && $filter['end_time']) {
            $where .= " WHERE last_login >= '$filter[start_time]' AND last_login <= '$filter[end_time]'";
    }
	//订单
    $data_array = array();
    $sql = "SELECT user_id,user_name,email,sex,birthday,reg_time,last_login,last_ip,visit_count,msn,qq,office_phone,home_phone,mobile_province,mobile_supplier ".
			"FROM " . $GLOBALS['ecs']->table('users') . 
			$where . " order by last_login desc";
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
		$sql =  "SELECT rf.reg_field_name,re.content FROM " . $GLOBALS['ecs']->table('reg_extend_info') . 
				" as re LEFT JOIN " . $GLOBALS['ecs']->table('reg_fields') . " as rf ON rf.id = re.reg_field_id".
				" WHERE re.user_id=$val[user_id]";
		$extend_info = $GLOBALS['db']->getAll($sql);
 
		$i = 0;
        if(in_array($i,$field_array)){
		  $export_array[$key][] = $val['user_id'];
        }

		if(in_array(++$i,$field_array)){
            $export_array[$key][] = $val['user_name'];
        }
		if(in_array(++$i,$field_array)){
			$content = '';
			foreach($extend_info as $v){
				if($v['reg_field_name'] == '店员姓名'){
					$content = $v['content'];
					break;
				}
			}
            $export_array[$key][]= $content;
		}
				
		if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['mobile_supplier'];
		}

		if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['mobile_province'];
		}

		if(in_array(++$i,$field_array)){
			$content = '';
			foreach($extend_info as $v){
				if($v['reg_field_name'] == '所属代理商'){
					$content = $v['content'];
					break;
				}
			}
            $export_array[$key][]= $content;
		}

		if(in_array(++$i,$field_array)){
			$content = '';
			foreach($extend_info as $v){
				if($v['reg_field_name'] == '所属零售商'){
					$content = $v['content'];
					break;
				}
			}
            $export_array[$key][]= $content;
		}

		if(in_array(++$i,$field_array)){
            $export_array[$key][]= $_LANG['sex'][$val['sex']];
		}

		if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['birthday'];
		}
		
		if(in_array(++$i,$field_array)){
           $export_array[$key][]= $val['msn'];
		}

		if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['qq'];
		}

		if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['office_phone'];
		}

		if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['home_phone'];
		}

		if(in_array(++$i,$field_array)){
			$winning = get_user_winning($val['user_name']);
            $export_array[$key][]= $winning;
		}

		if(in_array(++$i,$field_array)){
			$canuse = get_can_use_winning($val['user_name']);
            $export_array[$key][]= max(0,$canuse);
		}

		if(in_array(++$i,$field_array)){
			$content = '';
			foreach($extend_info as $v){
				if($v['reg_field_name'] == '地址'){
					$content = $v['content'];
					break;
				}
			}
            $export_array[$key][]= $content;
		}

		if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['email'];
		}

		if(in_array(++$i,$field_array)){
            $export_array[$key][]= $val['visit_count'];
		}

		if(in_array(++$i,$field_array)){
            $export_array[$key][]= local_date('Y-m-d H:i:s',$val['last_login']);
		}

		if(in_array(++$i,$field_array)){
            $export_array[$key][]= local_date('Y-m-d H:i:s',$val['reg_time']);
		}

		$sql = "SELECT o.order_status,(" . order_amount_field('o.') . ") AS total_fee FROM"  . $GLOBALS['ecs']->table('order_info') . " as o WHERE o.user_id=$val[user_id]";
		$orderList = $GLOBALS['db']->getAll($sql);

		if(in_array(++$i,$field_array)){
            $export_array[$key][]= count($orderList);
		}

		if(in_array(++$i,$field_array)){
			$confirmOrderCount = 0;
			foreach($orderList as $value){
				if($value['order_status'] == OS_CONFIRMED){
					$confirmOrderCount ++;
				}
			}
            $export_array[$key][]= $confirmOrderCount;
		}

		if(in_array(++$i,$field_array)){
			$OrderAmount = 0;
			foreach($orderList as $value){
				$OrderAmount += $value['total_fee'];
			}
            $export_array[$key][]= $OrderAmount;
		}

		if(in_array(++$i,$field_array)){
			$confirmOrderAmount = 0;
			foreach($orderList as $value){
				if($value['order_status'] == OS_CONFIRMED){
					$confirmOrderAmount += $value['total_fee'];
				}
			}
            $export_array[$key][]= $confirmOrderAmount;
		}
	}

    $result = array_merge($cols_array, $export_array);
    zip_download($result);
}
?>
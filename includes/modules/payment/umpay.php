<?php

/**
 * ECSHOP 话费支付插件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: umpay.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

define ("PER_URL","http://211.136.93.20:8081/webpay/spBackPer.do");
define ("MONTH_URL","http://211.136.93.20:8081/webpay/spBackMonth.do");
define ("UMPAY_PAY_URL","http://114.113.159.207:8756/hfwebbusi/pay/page.do");
define ("UMPAY_VIEW_URL","http://211.136.93.20:8081/webpay/spQueryUserRegState.do");
define ("UMPAY_CANCEL_URL","http://211.136.93.20:8081/webpay/spCancelUserRegInfo.do");
define ("UMPAY_AMOUNT_URL","http://211.136.93.20:8081/webpay/spDayTransBill.do");

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/umpay.php';

if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* 代码 */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'umpay_desc';

    /* 是否货到付款 */
    $modules[$i]['is_cod']  = '0';

    /* 是否支持在线支付 */
    $modules[$i]['is_online']  = '1';

    /* 作者 */
    $modules[$i]['author']  = 'SOSHOW.ORG';

    /* 网址 */
    $modules[$i]['website'] = 'http://www.soshow.org';

    /* 版本号 */
    $modules[$i]['version'] = '3.0';

    /* 配置信息 */
    $modules[$i]['config']  = array(
        array('name' => 'merId',           'type' => 'text',   'value' => ''),
        array('name' => 'goodsId',         'type' => 'text',   'value' => ''),			
        array('name' => 'amtType',         'type' => 'text',   'value' => ''),
        array('name' => 'bankType',        'type' => 'text',   'value' => ''),
        array('name' => 'version',         'type' => 'text',   'value' => ''),
	);

    return;
}

function ssl_sign($data,$priv_key_file){
    if(!$priv_key_file){$priv_key_file =ROOT_PATH ."includes/modules/paykey/testMer.key.pem";}
    if(!file_exists($priv_key_file)){
        echo "key_file is not exists!\n";
        return FALSE;
    }
    //error_log($data,3,'/tmp/datastring');
    $fp = fopen($priv_key_file, "rb");

    $priv_key = fread($fp, 8192);

    @fclose($fp);
    $pkeyid = openssl_get_privatekey($priv_key);

    if(!is_resource($pkeyid)){echo "not a resource \n " ; return FALSE;}
    // compute signature

    @openssl_sign($data, $signature, $pkeyid);

    // free the key from memory
    @openssl_free_key($pkeyid);
    return base64_encode($signature);
  } 
  
function ssl_verify($data,$signature,$cert_file){
    if(!$cert_file){$cert_file =ROOT_PATH ."includes/modules/paykey/testUmpay.cert.pem"; }
    if(!File_exists($cert_file)){
        echo "cert_file is not exists!\n";
        return FALSE;
    }
    //echo $signature;
    $signature = base64_decode($signature);
    //echo $signature;
    $fp = fopen($cert_file, "r");
    $cert = fread($fp, 8192);
    fclose($fp);
    //echo $data."<br>".$signature."<br>".$cert_file."<br>" ;//exit;
    $pubkeyid = openssl_get_publickey($cert);
    if(!is_resource($pubkeyid)){
        return FALSE;
    }
    $ok = openssl_verify($data,$signature,$pubkeyid);
    @openssl_free_key($pubkeyid);
    if ($ok == 1) {
        //echo "sucessful!";
        return TRUE;
    } elseif ($ok == 0) {
        echo "fail!!!";
        return FALSE;
    } else {
        return FALSE;
    }
    return FALSE;
   }



/**
 * 类
 */
class umpay
{
    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function umpay()
    {

    }


    function __construct()
    {
        $this->umpay();
    }

    /**
     * 提交函数
     */
    function get_code($order, $payment)
    {
		
		
       //商户号
	   $merId = $payment['merId'];
	   //商品号
	   $goodsId = $payment['goodsId'];
       //商品信息
       //$goodsInf = $_REQUEST['goodsInf'];
       //手机号
	   $mobileId = $_SESSION['user_name']; 
	   //$mobileId ="13859980678"; 
	   //订单号
	   $orderId = $order['order_sn'];
       //商户下单日期
	   $merDate = date('Ymd',$order['add_time']);
       //金额
       $amount = $order['order_amount']*100;
	   //$amount =100;
       //金额类型
       $amtType = $payment['amtType'];
       //银行类型
       $bankType = $payment['bankType'];
	   //网银Id
	   //$gateId = $_REQUEST['gateId'];
	   //返回商户URL
	   $retUrl = $GLOBALS['ecs']->url() . 'respond.php';
	   //支付通知URL
	   $notifyUrl = "";//return_url(basename(__FILE__, '.php'));
       //商户私有信息
       $merPriv = $order['log_id'];
       //扩展信息
       $expand = '';
       //版本号
       $version = $payment['version'];
       //$payAddr = $_REQUEST['payAddr'];

	   //按照手机钱包商户接入规范2.2V的5.1.1.1的格式组装字符串
       $paramNew="";  	
	   $paramNew =$paramNew . "merId=" . trim($merId,"\x00..\x1F");
		$paramNew =$paramNew . "&goodsId=" . trim($goodsId,"\x00..\x1F");
		$paramNew =$paramNew . "&goodsInf=" .trim($goodsInf,"\x00..\x1F");
		$paramNew =$paramNew . "&mobileId=" . trim($mobileId,"\x00..\x1F");
		$paramNew =$paramNew . "&orderId=" . trim($orderId,"\x00..\x1F");
		$paramNew =$paramNew . "&merDate=" . trim($merDate,"\x00..\x1F");
		$paramNew =$paramNew . "&amount=" . trim($amount,"\x00..\x1F");
		$paramNew =$paramNew . "&amtType=" . trim($amtType,"\x00..\x1F"); 
		$paramNew =$paramNew . "&bankType=" . trim($bankType,"\x00..\x1F");
		$paramNew =$paramNew . "&gateId=" . trim($gateId,"\x00..\x1F");
		$paramNew =$paramNew . "&retUrl=" . trim($retUrl,"\x00..\x1F");
		$paramNew =$paramNew . "&notifyUrl=" . trim($notifyUrl,"\x00..\x1F");   
		$paramNew =$paramNew . "&merPriv=" . trim($merPriv,"\x00..\x1F");  
		$paramNew =$paramNew . "&expand=" . trim($expand,"\x00..\x1F"); 
		$paramNew =$paramNew . "&version=" . trim($version,"\x00..\x1F");

       $pemSignNew = ssl_sign($paramNew,$priv_key_file);

		//http://114.113.159.207:8756/hfwebbusi/
	   $def_url  = '<form style="text-align:center;" action="http://payment.umpay.com/hfwebbusi/pay/page.do" method="get" target="_blank">';
	   $def_url .= "<input type='hidden' name='merId' value='". $merId ."' />";
	   $def_url .= "<input type='hidden' name='goodsId' value='". $goodsId ."' />"; 
	   $def_url .= "<input type='hidden' name='goodsInf' value='". $goodsInf ."' />"; 
		
	   $def_url .= "<input type='hidden' name='mobileId' value='". $mobileId ."' />"; 
	   $def_url .= "<input type='hidden' name='orderId' value='". $orderId . "' />"; 
	   $def_url .= "<input type='hidden' name='merDate' value='". $merDate ."' />"; 
	   $def_url .= "<input type='hidden' name='amount' value='". $amount ."' />"; 
	   $def_url .= "<input type='hidden' name='amtType' value='". $amtType ."' />"; 
	   $def_url .= "<input type='hidden' name='bankType' value='". $bankType ."' />";
		$def_url .= "<input type='hidden' name='gateId' value='". $gateId ."' />";

	   $def_url .= "<input type='hidden' name='retUrl' value='". $retUrl ."' />";
	   $def_url .= "<input type='hidden' name='notifyUrl' value='". $notifyUrl ."' />";
	   $def_url .= "<input type='hidden' name='merPriv' value='". $merPriv ."' />";
	   $def_url .= "<input type='hidden' name='expand' value='". $expand ."' />";
                  //"<input type='hidden' name='gateId' value='". $gateId ."' />";
                  //"<input type='hidden' name='retUrl' value='". $retUrl ."' />";
                  //"<input type='hidden' name='notifyUrl' value='". $notifyUrl ."' />";
                  //"<input type='hidden' name='merPriv' value='". $merPriv ."' />";
                  //"<input type='hidden' name='expand' value='". $expand ."' />";
	   $def_url .= "<input type='hidden' name='version' value='". $version ."' />";
	   $def_url .= "<input type='hidden' name='sign' value='". $pemSignNew ."' />";
	   $def_url .= "<input type='submit' name='sbmt' value='确认支付' />";
	   $def_url .= "</form>";

       return $def_url;
    }

    /**
     * 处理函数
     */
    function respond()
    {
		//echo "respond";
        $payment  = get_payment("umpay");
         
        $merId      =   trim($_REQUEST['merId']);
        $goodsId    =   trim($_REQUEST['goodsId']);
        $orderId    =   trim($_REQUEST['orderId']);
        $merDate    =   trim($_REQUEST['merDate']);
        $payDate    =   trim($_REQUEST['payDate']);
        $amount     =   trim($_REQUEST['amount']);
        $amtType    =   trim($_REQUEST['amtType']);
        $bankType   =   trim($_REQUEST['bankType']);
        $mobileId   =   trim($_REQUEST['mobileId']);
        $transType  =   trim($_REQUEST['transType']);
        $settleDate =   trim($_REQUEST['settleDate']);
        $merPriv    =   trim($_REQUEST['merPriv']);
        $expand    =   trim($_REQUEST['expand']);
		
        $retCode    =   trim($_REQUEST['retCode']);
        $version    =   trim($_REQUEST['version']);
        
        $paramNew    =   '';
		/*
		$paramNew =$paramNew . "merId=" . trim($merId,"\x00..\x1F");
	   $paramNew =$paramNew . "&goodsId=" . trim($goodsId,"\x00..\x1F");
	   $paramNew =$paramNew . "&mobileId=" . trim($mobileId,"\x00..\x1F");
	   $paramNew =$paramNew . "&orderId=" . trim($orderId,"\x00..\x1F");
	   $paramNew =$paramNew . "&merDate=" . trim($merDate,"\x00..\x1F");
	   $paramNew =$paramNew . "&amount=" . trim($amount,"\x00..\x1F");
       $paramNew =$paramNew . "&amtType=" . trim($amtType,"\x00..\x1F"); 
       $paramNew =$paramNew . "&bankType=" . trim($bankType,"\x00..\x1F");
       $paramNew =$paramNew . "&retUrl=" . trim($retUrl,"\x00..\x1F");
       $paramNew =$paramNew . "&merPriv=" . trim($merPriv,"\x00..\x1F");  
       $paramNew =$paramNew . "&expand=" . trim($expand,"\x00..\x1F"); 
       $paramNew =$paramNew . "&version=" . trim($version,"\x00..\x1F");
		*/
	$paramNew =	$paramNew . "merId=" . trim($merId,"\x00..\x1F");
	$paramNew =	$paramNew . "&goodsId=" . trim($goodsId,"\x00..\x1F");
	$paramNew =	$paramNew . "&orderId=" . trim($orderId,"\x00..\x1F");
	$paramNew =	$paramNew . "&merDate=" . trim($merDate,"\x00..\x1F");
	$paramNew =	$paramNew . "&payDate=" . trim($payDate,"\x00..\x1F");
	$paramNew =	$paramNew . "&amount=" . trim($amount,"\x00..\x1F");
	$paramNew = $paramNew . "&amtType=" . trim($amtType,"\x00..\x1F");   
	$paramNew = $paramNew . "&bankType=" . trim($bankType,"\x00..\x1F");
	$paramNew =	$paramNew .	"&mobileId=" . trim($mobileId,"\x00..\x1F");
	$paramNew = $paramNew . "&transType=" . trim($transType,"\x00..\x1F");
	$paramNew = $paramNew . "&settleDate=" . trim($settleDate,"\x00..\x1F"); 
	$paramNew = $paramNew . "&merPriv=" . trim($merPriv,"\x00..\x1F");
	$paramNew = $paramNew . "&retCode=". trim($retCode,"\x00..\x1F");  
	$paramNew = $paramNew . "&version=". trim($version,"\x00..\x1F");
         
        
        /**
         * 校验签名
         *         
        **/
		//echo $_REQUEST['sign'];
        $signNew =   ssl_verify($paramNew,trim($_REQUEST['sign'])); 
       //echo $signNew;         
       
		//校验签名 判断状态
        if ($signNew && $retCode == '0000')
        {
			//修改订单状态
            order_paid($merPriv);
			
			$retCode="0000";
			$retMsg="ture";
			$ret_signtext="" . $merId . "|" . $goodsId . "|" . $orderId . "|" . $merDate . "|" . $retCode . "|" .$retMsg . "|" . $version;
			$ret_sign=ssl_sign($ret_signtext,$priv_key_file);
			$ret_signtext=$ret_signtext . "|" . $ret_sign;
			$_SESSION['umpay'.$orderId]=$ret_signtext;

            return true;
            
        }
        else
        {
			$retCode="1111";
			$retMsg="false";
			$ret_signtext="" . $merId . "|" . $goodsId . "|" . $orderId . "|" . $merDate . "|" . $retCode . "|" .$retMsg . "|" . $version;
			$ret_sign=ssl_sign($ret_signtext,$priv_key_file);
			$ret_signtext=$ret_signtext . "|" . $ret_sign;
			$_SESSION['umpay'.$orderId]=$ret_signtext;

            return false;
            
        }
    }
	
	
	function transBill($payment){
		//商户号
		$merId = $payment['merId'];
		//支付日期
		$payDate = $_REQUEST['payDate'];
		//银行编号
		$gateId = $_REQUEST['gateId'];
		//版本
		$version = $payment['version'];
		
		$url = "merId=" . $merId . "&payDate=" . $payDate . "&gateId=" . $gateId . "&version=" . $version;
		//签名
		$sign=ssl_sign($url,$priv_key_file);
		
		$def_url=@"<form style=\"text-align:center;\"  action=\"http://payment.umpay.com/hfwebbusi/bill/trans.dl\" method=\"post\">
		<h2><b>交易数据对帐信息：</b></h2>	
		<TABLE width=\"100%\" >
		<tr><td width=\"139\">SP平台代码：</td><td><input type=text NAME=\"merId\" value=\"". $merId."\"></td></tr>
		<tr><td width=\"139\">支付日期</td><td><input type=text NAME=\"payDate\" value=\"". $payDate."\"></td></tr>
		<tr><td width=\"139\">银行编号</td><td><input type=text NAME=\"gateId\" value=\"". $gateId."\" ></td></tr>
		<tr><td width=\"139\">版本号</td><td><input type=text NAME=\"version\" value=\"" .$version."\" ></td></tr>
		<tr><td width=\"139\">签名数据L</td><td><input type=text NAME=\"sign\" value=\"". $sign."\"></td></tr>
		<tr><td width=\"139\"><input type=submit name=\"submitbutton\" value=\"取交易文件\"></td><td></td></tr>
		</TABLE>
		</form>";
		
		return $def_url;

	}

}

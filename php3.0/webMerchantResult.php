<!-- 
	===============================================================
				�������� �̻�web �¶��� ��ʾ���뿪��ģ��
				����: �¾���
				����:2005-10-21
		
		��ģ���ṩ����phpҳ��WEB��վ��֧��������֧��ģʽ.
	
	
	     ���յ�DirectBack.php���ݹ����Ĳ�������װ���ַ�����
	     ����ǩ����Ȼ�����ݴ��ݵ�http://211.154.41.244/webpay/spGW.do
	     ��ַ��ȥ�������Ϳ��Ը�����ʾ�������ص�֧������
	
	
	     ��������
	     1�����ղ���
	     2������ǩ��
		���������ʽ��μ� �ֻ�Ǯ���̻�����淶�ĵ�2.2 ��5.1.1.1
	===============================================================

 -->
<?php include("umpayHead.php");?>

<!--------------------------------------------->
<!--1�����ղ���                                     -->
<!--------------------------------------------->	
<?php
	//�̻���
	$merId = $_REQUEST['merId'];
	//��Ʒ��
	$goodsId = $_REQUEST['goodsId'];
	//��Ʒ��Ϣ
	$goodsInf = $_REQUEST['goodsInf'];
	//�ֻ���
	$mobileId = $_REQUEST['mobileId'];
	//������
	$orderId = $_REQUEST['orderId'];
	//�̻��µ�����
	$merDate = $_REQUEST['merDate'];
	//���
	$amount = $_REQUEST['amount'];
	//�������
	$amtType = $_REQUEST['amtType'];
	//��������
	$bankType = $_REQUEST['bankType'];
	//����Id
	$gateId = $_REQUEST['gateId'];
	//�����̻�URL
	$retUrl = $_REQUEST['retUrl'];
	//֧��֪ͨURL
	$notifyUrl = $_REQUEST['notifyUrl'];
	//�̻�˽����Ϣ
	$merPriv = $_REQUEST['merPriv'];
	//��չ��Ϣ
	$expand = $_REQUEST['expand'];
	//�汾��
	$version = $_REQUEST['version'];
?>
<!--------------------------------------------->
<!--2������ǩ��                                     -->
<!--------------------------------------------->
<?php	
	//�����ֻ�Ǯ���̻�����淶2.2V��5.1.1.1�ĸ�ʽ��װ�ַ���
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
	
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GB18030">
<title>���������̻�web���ֻ�Ǯ��ƽ̨�ύ�����ο�����</title>
</head>
<body>
<?php
//var_dump($_POST);
	
	foreach($_POST as $key=>$value){
		if($value){
		//echo $key."=".$value."&";	
		}
	}
?>

<form action="http://payment.umpay.com/hfwebbusi/pay/page.do" method="get">
<tr><td><input type="text" name="merId" value="<?php echo $merId;?>"></td></tr>
<tr><td><input type="text" name="goodsId" value="<?php echo $goodsId;?>"> </td></tr>
<tr><td><input type="text" name="goodsInf" value="<?php echo $goodsInf;?>"> </td></tr>
<tr><td><input type="text" name="mobileId" value="<?php echo $mobileId;?>"> </td></tr>
<tr><td><input type="text" name="orderId" value="<?php echo $orderId;?>"> </td></tr>
<tr><td><input type="text" name="merDate" value="<?php echo $merDate;?>"> </td></tr>
<tr><td><input type="text" name="amount" value="<?php echo $amount;?>"></td></tr>
<tr><td><input type="text" name="amtType" value="<?php echo $amtType;?>"> </td></tr>
<tr><td><input type="text" name="bankType" value="<?php echo $bankType;?>"> </td></tr>
<tr><td><input type="text" name="gateId" value="<?php echo $gateId;?>"> </td></tr>
<!--<tr><td><input type="text" name="retUrl" value="<?php echo urlencode($retUrl);?>"></td></tr>-->
<tr><td><input type="text" name="retUrl" value="<?php echo $retUrl;?>"></td></tr>
<tr><td><input type="text" name="notifyUrl" value="<?php echo $notifyUrl;?>"></td></tr>
<tr><td><input type="text" name="merPriv" value="<?php echo $merPriv;?>"> </td></tr>
<tr><td><input type="text" name="expand" value="<?php echo $expand;?>"> </td></tr>
<tr><td><input type="text" name="version" value="<?php echo $version;?>"> </td></tr>
<tr><td><input type="text" name="sign" value="<?php echo $pemSignNew;?>"> </td></tr>

<tr><td><input	type=submit name=sbmt value="���� or ����"></td></tr>
</form>
</body>
</html> 

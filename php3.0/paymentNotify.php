<!-- 
	===============================================================
				�������� �̻�web �¶��� ��ʾ���뿪��ģ��
				����:  �¾���
				����:2006-09-14
		
		��ģ���ṩ����PHPҳ��WEB��վ����֧�����֪ͨ������.
	
	     ��֧��������ɺ��ֻ�Ǯ���ĺ�̨ҵ�����������
	     ��ҳ�������������ݹ�������ҳ����յ�����ʱ������Ҫ
	     ����һ����ʽ��װ���ַ�����Ȼ�������ǩ.��ǩ��Ϻ�
	     ������Ӧ�Ĵ����������ֻ�Ǯ���̻�����淶2.2�ĵ�
	     ��5.2.2������Ӧ
	
	     ��������
	     1�����ղ���
	     2��������Ӧ����
	     3����ǩ
	     4���̻���֧���������
	     5������ǩ��
	     6����װ��Ӧ��������
		���������ʽ��μ� �ֻ�Ǯ���̻�����淶�ĵ�2.2 ��5.2
	===============================================================

 -->
<?php include("umpayHead.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!--------------------------------------------->
<!--1�����ղ���                              -->
<!--------------------------------------------->
<?php
  //�̻�����
  $merId = $_REQUEST['merId'];
  //��Ʒ��Ʒ
  $goodsId = $_REQUEST['goodsId'];
  //������
  $orderId = $_REQUEST['orderId'];
  //�̻��µ�����
  $merDate = $_REQUEST['merDate'];
  //֧������
  $payDate = $_REQUEST['payDate']
  //���
  $amount = $_REQUEST['amount'];
  //�������
  $amtType = $_REQUEST['amtType'];
  //��������
  $bankType = $_REQUEST['bankType'];
  //�ֻ���
  $mobileId = $_REQUEST['mobileId'];
  //��������
  $transType = $_REQUEST['transType'];
  //��������
  $settleDate = $_REQUEST['settleDate'];
  //�̻�˽����Ϣ
  $merPriv = $_REQUEST['merPriv'];
  //������
  $retCode = $_REQUEST['retCode'];
  //�汾
  $version = $_REQUEST['version'];
  //ǩ��
  $sign = $_REQUEST['sign'];
?>
<!--------------------------------------------->
<!--2��������Ӧ����                          -->
<!--------------------------------------------->
<?php
  //������
  $ret_retcode="";
  //֧������
  $retMsg="";
?>
<!--------------------------------------------->
<!--3����ǩ                                  -->
<!--------------------------------------------->
<?php
  //������װǩ���ַ���
//�����ֻ�Ǯ���̻�����淶2.2V��5.1.2.1��װ�ַ�����������ǩ
	$paramNew="";  
	$paramNew =	$paramNew . 	"merId=" . trim($merId,"\x00..\x1F");
	$paramNew =	$paramNew . 	"&goodsId=" . trim($goodsId,"\x00..\x1F");
	$paramNew =	$paramNew . 	"&orderId=" . trim($orderId,"\x00..\x1F");
	$paramNew =	$paramNew . 	"&merDate=" . trim($merDate,"\x00..\x1F");
	$paramNew =	$paramNew . 	"&payDate=" . trim($payDate,"\x00..\x1F");
	$paramNew =	$paramNew . 	"&amount=" . trim($amount,"\x00..\x1F");
	$paramNew = $paramNew . "&amtType=" . trim($amtType,"\x00..\x1F");   
	$paramNew = $paramNew . "&bankType=" . trim($bankType,"\x00..\x1F");
	$paramNew =	$paramNew .	"&mobileId=" . trim($mobileId,"\x00..\x1F");
	$paramNew = $paramNew . "&transType=" . trim($transType,"\x00..\x1F");
	$paramNew = $paramNew . "&settleDate=" . trim($settleDate,"\x00..\x1F"); 
	$paramNew = $paramNew . "&merPriv=" . trim($merPriv,"\x00..\x1F");
	$paramNew = $paramNew . "&retCode=". trim($retCode,"\x00..\x1F");  
	$paramNew = $paramNew . "&version=". trim($version,"\x00..\x1F");
	
//��ǩ
$result=ssl_verify($paramNew,$sign,$certfile);
  if(!$result)
  {
	  //�̻��ڴ˴�����ص���ǩʧ�ܵĴ������ʧ��˵���в������Ŀͻ����ڷ���֧�����֪ͨ
	  //��ǩʧ�ܺ󣬷������Ȼ�ǲ��ɹ���
		$sing_result = "��ǩʧ��,ǩ��ԭ��:"+url+"ǩ������:"+sign+"<br/>";
		$retMsg="��ǩʧ��,�绰4006125880";
		$retCode="1111";
  }else
  {
	  
  
?>
<!--------------------------------------------->
<!--4���̻���֧���������                    -->
<!--------------------------------------------->
<?php
//�̻��ڴ˴���֧���������ϸ����
//�̻����Ը��ݴ���֧�����������������������Ƿ�Ϊ0000,�ɹ�Ϊ0000,ʧ��Ϊ1111
//ʧ����Ҫ����
        $sing_result="��ǩ�ɹ�";

     //if (����֧������ɹ�) {
        $retCode="0000";
        $description="֧���ɹ����绰4006125880";
   }
?>
<!--------------------------------------------->
<!--5������ǩ��                              -->
<!--------------------------------------------->
<?php
  //��װ��Ҫǩ���ķ����ַ�������Ҫ�����ĵ�2.2��5.2.2����װ
                         //������          //��������    //�̻���  //������ˮ��
  $ret_signtext="" . $merId . "|" . $goodsId . "|" . $orderId . "|" . $merDate . "|" . $retCode . "|" $retMsg . "|" . $version;
  //����ǩ��
  $ret_sign=ssl_sign($ret_signtext,$priv_key_file);
?>
<!--------------------------------------------->
<!--6����װ��Ӧ��������                      -->
<!--------------------------------------------->
<?php
  //��Ӧ���ַ���
  $ret_signtext=$ret_signtext . "|" . $ret_sign;
?>
<html><head>
<!-- ���������Ӧ�ֻ�Ǯ��ҵ��ƽ̨����Ϣ -->
<META NAME="MobilePayPlatform" CONTENT="<?php echo $ret_signtext ?>">
<title></title>
</head>
<body>
</body>
</html>

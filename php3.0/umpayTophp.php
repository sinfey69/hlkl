<!-- 
	===============================================================
				�������� �̻�web �¶��� ��ʾ���뿪��ģ��
				����:  �¾���
				����:2005-09-14
		
		��ģ���ṩ����PHPҳ��WEB��վ�����ֻ�Ǯ��ҵ��ƽ̨��������������.
	    
	      �̻����յ������ֻ�Ǯ��ҵ��ƽ̨�����Ķ���֮�����Ȱ��հ���
	      �ֻ�Ǯ���̻�����淶2.2V�ĵ���5.1.2.1�ĸ�ʽ��װ���ַ�����Ȼ��
	      ��֤ǩ����Ȼ����ݽ��յ��Ĳ�������ص���ҵҵ����������
	      �ĵ���5.1.2.2�ĸ�ʽ��װ���ַ�����������ǩ������Ӧ�ֻ�Ǯ��ҵ��ƽ̨������
	    
	     ��������
	     1�����ղ���
	     2��������Ӧ����
	     3����ǩ
	     4���̻���������
	     5������ǩ��
	     6����װ��Ӧ��������
		���������ʽ��μ� �ֻ�Ǯ���̻�����淶�ĵ�2.2 ��5.1.2
	===============================================================
-->
<?php include("umpayHead.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<!--------------------------------------------->
<!--1�����ղ���                              -->
<!--------------------------------------------->	
<?php
//�̻�����
$merId = $_REQUEST['merId'];
//��Ʒ��
$goodsId = $_REQUEST['goodsId']; 
//��Ʒ����
$goodsInf = $_REQUEST['goodsInf'];
//�ֻ���
$mobileId = $_REQUEST['mobileId'];
//�������
$amtType = $_REQUEST['amtType'];
//��������
$bankType = $_REQUEST['bankType'];
//�汾�� 
$version = $_REQUEST['version'];
//��Ʒ����
$sign = $_REQUEST['sign'];
?>
<!--------------------------------------------->
<!--2��������Ӧ����                          -->
<!--------------------------------------------->
<?php
//֧��֪ͨ��ַ
$notifyUrl="";
//������
$retCode="";
//֧���������Ҫ�̻������Լ��Ĳ�Ʒȷ�����Ĵ�С,������̻�Ҫ��ɵ���Ҫ������
$amount=0;
//�����ţ������Ҫ�̻������Լ���ϵͳȷ����
$orderId="200510100";
//�̻��µ�����
$merDate=date("Ymd")
$merPriv = "";
$expand = "";
$retMsg = "";
?>
<!--------------------------------------------->
<!--3����ǩ                                   -->
<!--------------------------------------------->
<?php
//������װǩ���ַ���
//�����ֻ�Ǯ���̻�����淶2.2V��5.1.2.1��װ�ַ�����������ǩ
        $paramNew="";  
	$paramNew =$paramNew . "merId=" . trim($merId,"\x00..\x1F");
	$paramNew =$paramNew . "&goodsId=" . trim($goodsId,"\x00..\x1F");
        if(!empty(goodsInf)){
        $paramNew =$paramNew . "&goodsInf=" . trim($goodsInf,"\x00..\x1F");
         }
        if(!empty(mobileId)){
        $paramNew =$paramNew . "&mobileId=" . trim($mobileId,"\x00..\x1F");
        }
        $paramNew = $paramNew . "&amtType=" . trim($amtType,"\x00..\x1F");   
        $paramNew = $paramNew . "&bankType=" . trim($bankType,"\x00..\x1F);
        $paramNew = $paramNew . "&version=". trim($version,"\x00..\x1F");
//��ǩ
$result=ssl_verify($paramNew,$sign,$certfile);

?>
<!--------------------------------------------->
<!--4���̻���������                          -->
<!--------------------------------------------->
<?php
     if($result){
     }
     if($PRODUCTID=="999701")
     {
	   //���²�Ʒ
        $amount=500;
	$retCode="0000";
	$orderId="999701";
     }
     else if ($PRODUCTID=="010")
	 {
		$retCode="0000";
		$orderId="" . mt_rand(100000,999999);
		$amount=100;
	 }
     else{    
       $ret_amount=0;
       $ret_code="0002";
      }
?>
<!--------------------------------------------->
<!--5������ǩ��                                     -->
<!--------------------------------------------->
<?php
$ret_signtext = $merId . "|" . $goodsId . "|" . $orderId . "|" . $merDate . "|" . $amount . "|" . $notifyUrl . "|" . $merPriv . "|" . $expand . $retCode . "|" . $retMsg . "|" . $version;
//����ǩ��
$ret_sign=ssl_sign(ret_signtext);
?>
<!--------------------------------------------->
<!--6����װ��Ӧ��������                       -->
<!--------------------------------------------->
<?php
//��װ��Ӧ�ַ���
$ret_signtext=$ret_signtext . "|" . $ret_sign;
?>
<title>���������̻�</title>
</head>
<!-- ���������Ӧ�ֻ�Ǯ��ҵ��ƽ̨����Ϣ -->
<META NAME="MobilePayPlatform" CONTENT="<?php echo $ret_signtext;?>"><body></body></html>

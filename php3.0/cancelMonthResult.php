<!-- 
    ===============================================================
				�������� �̻�web �¶��� ��ʾ���뿪��ģ��
				����:�¾���
				����:2006-09-14
		
		��ģ���ṩ����PHPҳ��WEB��վ��ȡ���û����µķ���.
	       
	     ���յ�monthCancel.php�������Ĳ�������װ���ַ�����
	     Ȼ������ǩ�����ٽ��������ݵ�
	     http://211.154.41.244/webpay/spCancelUserRegInfo.do
	     ��������
	     1�����ղ���
	     2������ǩ��
		���������ʽ��μ� �ֻ�Ǯ���̻�����淶�ĵ�2.2 ��5.5.1
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
        //��Ʒ����
        $goodsId = $_REQUEST['goodsId'];
        //�汾��
	$version = $_REQUEST['version'];
        //�ֻ�����
	$mobileId = $_REQUEST['mobileId'];
?>
<!--------------------------------------------->
<!--2������ǩ��                                     -->
<!--------------------------------------------->
<?
     //�ֻ�Ǯ���̻�����淶2.2V��5.5.1��װ�ַ���������ǩ��
     $sign="merId=" . $merId . "&goodsId=" . $goodsId . "&mobileId=" . $mobileId . "&version=" . $version;
     echo $sign;
     //����ǩ��
     $SIGN=ssl_sign($sign,$priv_key_file);
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GB18030">
<title>���������̻�web���ֻ�Ǯ��ƽ̨�ύ��ѯ�û����·���Ĳο�����</title>
</head>
<body>
<h2><b>��ѯ�û����·���</b></h2>
<form action="<?php echo UMPAY_CANCEL_URL;?>" method="post">
<tr><td><input type="text" name="merId"	value="<?php echo $merId;?>"> </td></tr>
<tr><td><input type="text" name="goodsId" value="<?php echo $goodsId;?>"></td></tr>
<tr><td><input type="text" name="mobileId" value="<?php echo $mobileId;?>"> </td></tr>
<tr><td><input type="text" name="version" value="<?php echo $version;?>"></td></tr>
<tr><td><input type="text" name="sign" value="<?php echo $sign;?>"> </td></tr>
<tr><td><input type=submit name=sbmt value="�ύ"></td></tr>
</form>
</body>
</html> 

<!-- 
 -->
<?php include("umpayHead.php");?>
<!--------------------------------------------->
<!--1�����ղ���                              -->
<!--------------------------------------------->
<?php        
        //�̻���
	$merId = $_REQUEST['merId'];
        //ע������
	$cancelDate = $_REQUEST['cancelDate'];
        //�汾
        $version = $_REQUEST['version'];
?>
<!--------------------------------------------->
<!--2������ǩ��                              -->
<!--------------------------------------------->
<?php
			//�ֻ�Ǯ���̻�����淶3.1V��5.11��װ�ַ���������ǩ��
			$url = "merId=" . $merId . "&cancelDate=" . $cancelDate . "&version=" . $version;
			//ǩ��
			$sign=ssl_sign($url,$priv_key_file);

?>
<body bgcolor="#f2f2f2" text="#666666" topmargin="0" marginheight="0">
<hr>
<form action="<?php echo UMPAY_AMOUNT_URL;?>" method="post">
<h2><b>�������ݶ�����Ϣ��</b></h2>	
<TABLE width="100%" >
<tr><td width="139">SPƽ̨���룺</td><td><input type=text NAME="merId" value="<?php echo $merId;?>"></td></tr>
<tr><td width="139">ע������</td><td><input type=text NAME="cancelDate" value="<?php echo $cancelDate;?>"></td></tr>
<tr><td width="139">�汾��</td><td><input type=text NAME="gateId" value="<?php echo $gateId;?>" ></td></tr>
<tr><td width="139">ǩ������L</td><td><input type=text NAME="sign" value="<?php echo $sign;?>"></td></tr>

<tr><td width="139"><input type=submit name="submitbutton" value="ȡ�����ļ�" size=></td><td></td></tr>
</TABLE>
</form>
</body>
</html>

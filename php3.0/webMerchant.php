<!--'===============================================================-->
<!--'			�������� �̻�web �¶��� ��ʾ���뿪��ģ��-->
<!--'			����: �¾���-->
<!--'			����:2006 09 14-->
<!--'	-->
<!--'	��ģ���ṩ����phpҳ��WEB��վ�����ֻ�Ǯ��ƽ̨�¶���������(ͳһ֧��ҳ��).-->
<!--'-->
<!--'===============================================================-->

<?php
 $rdpwd=mt_rand(100000,999999);
 $date=date("Ymd");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GB18030">
<title>���������̻�web�¶����ο�����(ͳһ֧��ҳ��)</title>
</head>
<body>
<form method="post" action="webMerchantResult.php">
<table>
        <tr>
		<td>�̻���</td>
		<td><input type=text name="merId" value="7154"></td>	 
	</tr>
	<tr>
		<td>��Ʒ��</td>
		<td><input type=text name="goodsId" value="001"></td>	 
	</tr>
	<tr>
		<td>��Ʒ��Ϣ</td>
		<td><input type=text name="goodsInf" value=""></td>	 
	</tr>
	<tr>
		<td>�ֻ���</td>
		<td><input type=text name="mobileId" value="13656006542"></td>	 
	</tr>
	<tr>
		<td>������</td>
		<td><input type=text name="orderId" value="2014050505834"></td>	 
	</tr>
	<tr>
		<td>�µ�����</td>
		<td><input type=text name="merDate" value="<?php echo $date;?>"></td>	 
	</tr>
	<tr>
		<td>���</td>
		<td><input type=text name="amount" value="1000"></td>	 
	</tr>
	<tr>
		<td>�������</td>
		<td><select name="amtType">
			<option value="01">�����</option>
			<option value="02" selected>����</option>
			<option value="03">����</option>
		</select></td>	 
	</tr>
	<tr>
		<td>����</td>
		<td><select name="bankType">
		    <option value="">����Ĭ�Ͽգ���</option>
			<option value="1">���п�</option>
			<option value="2">����</option>
			<option value="3">����</option>
			<option value="4">����</option>
			<option value="5">Ԥ���ʻ�</option>			 
		</select></td>	 
	</tr>
	<tr>
		<td>��������</td>
		<td><select name="gateId">
		    <option value="">����Ĭ�Ͽգ���</option>
			<option value="0400">��������</option>
			<option value="0500">ũҵ����</option>		 
		</select></td>	 
	</tr>
	<tr>
		<td>ҳ�淵�ص�ַ</td>
		<td><input type=text name="retUrl" value="http://keller.soshow.org/php3.0/return_url.php"></td>	 
	</tr>
	<tr>
		<td>���֪ͨ��ַ</td>
		<td><input type=text name="notifyUrl" value=""></td>	 
	</tr>
	<tr>
		<td>�̻�˽����Ϣ</td>
		<td><input type=text name="merPriv" value="test"></td>	 
	</tr>
        <tr>
         <td><input type="hidden" name="expand" value="mer"></td>
        </tr>
        <tr>
         <td><input type="hidden" name="gateId" value=""></td>
        </tr>
	<tr>
		<td>�汾��</td>
		<td><input type=text name="version" value="3.0"></td>	 
	</tr>
	<tr>
		<td>ǩ��</td>
		<td><input type=text name="sign" value="ahyfdshfshf"></td>	 
	</tr>
	<tr>
		<td colspan=2 align=center><input type=submit value="�ύ����"></td>
		<td></td>
	</tr>
</table>
</form>
</body>
</html>

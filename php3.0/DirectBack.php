<!--'===============================================================-->
<!--'			�������� �̻�web �¶��� ��ʾ���뿪��ģ��-->
<!--'			����: �¾���-->
<!--'			����:2006 09 14-->
<!--'	-->
<!--'	��ģ���ṩ����phpҳ��WEB��վ�����ֻ�Ǯ��ƽ̨�¶���������.-->
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
<title>���������̻�web�¶����ο�����(��ֱ̨����ʽ)</title>
</head>
<body>
<form method=POST action="DirectBackResult.php">
<table>
	<tr>
		<td>�̻���</td>
		<td><input type=text name="merId" value=""></td>

		</select></td>
	</tr>
	<tr>
		<td>��Ʒ��</td>
		<td><input type=text name="goodsId" value=""></td>
	</tr>
	<tr>
		<td>��Ʒ����</td>
		<td><input type=text name=goodsInf value=""></td>
	</tr>			
        <tr>
		<td>�ֻ���</td>
		<td><input type=text name=mobileId value=""></td>
	</tr>
        <tr>
               <td>������</td>
               <td><input type=text name="orderId" value=""></td>
        </tr>
        <tr>
		<td>�̻��µ�����</td>
		<td><input type=text name=merDate value="<?php echo $date;?>"></td>
	</tr>
	<tr>
		<td>���</td>
		<td><input type=text name=amount value=""></td>
	</tr>
	<tr>
		<td>�������</td>
		<td><input type=text name=amtType value=""></td>
	</tr>
	<tr>
		<td>�ֻ���</td>
		<td><input type=text name=MOBILEID value=""></td>
	</tr>
	<tr>
		<td>�����</td>
		<td><input type=text name=RDPWD value="<?php echo $rdpwd;?>"></td>
	</tr>
	<tr>
		<td>��Ʒ����</td>
		<td>
		<textarea name=REMARK rows=3 cols=50 maxlength=256>
		php�Ĳ�����Ʒ
		</textarea>
		</td>
	</tr>	
	<tr>
		<td colspan=2 align=center><input type=submit value="�ύ����"></td>
		<td></td>
	</tr>


</table>
</form>
</body>
</html>

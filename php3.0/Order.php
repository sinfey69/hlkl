<?php
 $date=date("Ymd");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GB18030">
<title>���������̻�web�¶����ο�����</title>
</head>
<body>
<form method=POST action="OrderResult.php">
<table>
    <tr>
         <td>�̻��ţ�</td>
         <td><input type=text NAME="merId" value=""></td>
    </tr>
    <tr>
        <td>��Ʒ�ţ�</td>
    	<td><input type=text NAME="goodsId" value=""></td>
    </tr>
    <tr>
    	<td>��Ʒ��Ϣ��</td>
	<td><input type=text NAME="goodsInf" value=""></td>
    </tr>
    <tr>
    	<td>�ֻ��ţ�</td>
	<td><input type=text NAME="mobileId" value=""></td>
    </tr>
    <tr>
    	<td>�����ţ�</td>
	<td><input type=text NAME="orderId" value=""></td>
    </tr>
    <tr>
	<td>�̻��µ�����</td>
	<td><input type=text name=merDate value="<?php echo $date;?>"></td>
    </tr>
    <tr>
    	<td>��</td>
	<td><input type=text NAME="amount" value=""></td>
    </tr>
    <tr>
    	<td>������ͣ�</td>	
	<td><input type=text NAME="amtType" value=""></td>
    </tr>
    <tr>
    	<td>�������ͣ�</td>
	<td><input type=text NAME="transType" value=""></td>
    </tr>
    <tr>
    	<td>�������ͣ�</td>
	<td><input type=text NAME="gateId" value=""></td>
    </tr>
    <tr>
    	<td>ǰ̨���׽��֪ͨ��ַ��</td>
	<td><input type=text NAME="retUrl" value=""></td>
    </tr>
    <tr>
    	<td>��̨���׽��֪ͨ��ַ��</td>	
	<td><input type=text NAME="notifyUrl" value=""></td>
    </tr>
    <tr>
    	<td>�̻�˽����Ϣ��</td>
	<td><input type=text NAME="merPriv" value=""></td>
    </tr>
    <tr>
    	<td>�汾�ţ�</td>
	<td><input type=text NAME="version" value=""></td>
    </tr>
     <tr>
    	<td>ǩ����</td>
	<td><input type=text NAME="sign" value=""></td>
    </tr>
    <tr>
	<td colspan=2 align=center><input type=submit value="�ύ����"></td>
	<td></td>
   </tr>
</table>
</form>
</body>
</html>

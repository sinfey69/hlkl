
<!--    '==========================================================-->
<!--	'			�������� �̻�web �¶��� ��ʾ���뿪��ģ��               -->
<!--	'			����:�¾���                                           -->
<!--	'			����:2006 09 14                                 -->
<!--	'	                                                       -->
<!--	'	��ģ���ṩ����JSPҳ��WEB��վ�����·����̻���վ���й��������.    -->
<!--	'                                                          -->
<!--	'       ���յ����ݹ����Ĳ���������װ���ַ�                          -->
<!--	'       ������֤ǩ��                                               -->
<!--	'                                                          -->
<!--	'	���������ʽ��μ� �ֻ�Ǯ���̻������ĵ�2.2 �������               -->
<!--	'==========================================================-->
<?php include("umpayHead.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?php
//������
$RETCODE = $_REQUEST['RETCODE'];
//�̻�����
$SPID = $_REQUEST['SPID'];
//������
$ORDERID = $_REQUEST['ORDERID'];
//���
$AMOUNT = $_REQUEST['AMOUNT'];
//����
$DATETIME = $_REQUEST['DATETIME'];
//�ֻ�����
$MOBILEID = $_REQUEST['MOBILEID'];
//�����
$RDPWD = $_REQUEST['RDPWD'];
//ǩ��
$SIGN = $_REQUEST['SIGN'];
$hh_result="";
$url="";
//�����ֻ�Ǯ���̻�����淶2.2V��5.3��װ�ַ�����������ǩ
$url="RETCODE=" . $RETCODE . "&SPID=" . $SPID . "&ORDERID=" . $ORDERID . "&AMOUNT=" . $AMOUNT . "&DATETIME=" . $DATETIME . "&MOBILEID=" . $MOBILEID . "&RDPWD=" . $RDPWD . "";

$result=ssl_verify($url,$sign,$certfile);

if(result)
{
	//����صĳɹ�����
	//�����Ҫ���̻�������
	//������̻�Ҫ������Ҫ�Ĺ���
	$hh_result="��ǩ�ɹ�";
}else
{
    //����صĲ��ɹ��Ĵ���
    //�����Ҫ���̻�������
    //������̻�Ҫ������Ҫ�Ĺ���
	$hh_result="��ǩʧ��";
}

?>
<title>�����������·����̻���վ���й��������</title>
</head>
<body>
<table><tr><td><?php echo $hh_result;?></td></tr></table>
</body>
</html>

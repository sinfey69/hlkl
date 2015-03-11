<?php
define('IN_ECS', true);
unset($result);
require(dirname(__FILE__) . '/../includes/init.php');


if($_POST['leadExcel'] == "true")
{
    $filename = $_FILES['inputExcel']['name'];
    $tmp_name = $_FILES['inputExcel']['tmp_name'];
    $msg = uploadFile($filename,$tmp_name);
    echo $msg;
}

/*判断用户是否存在*/
function insert_users($u,&$new,&$old)
{
	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('users')." where user_name='$u[user_name]'";
	//return $sql;
    $col = $GLOBALS['db']->getOne($sql);
	
	if (empty($col)){
		//$pass=substr($u['user_name'],5,11);
		$password=md5(md5($u['password'])."4020");
		$sql = 'INSERT INTO ' .$GLOBALS['ecs']->table('users').
			   ' (user_name, sex, mobile_phone, password, ec_salt,reg_time)'.
				" VALUES ('$u[user_name]', $u[sex], '$u[user_name]', '$password', '4020',$u[reg_time])";
		$new.=$u['user_name']." 密码 ".$u['password']."\r\n";		
		//file_put_contents("user_passtext.txt",$u['user_name']." 密码 ".$u['password']."\r\n",FILE_APPEND);
		//return $sql;
		$GLOBALS['db']->query($sql);
		
		return $GLOBALS['db']->insert_id();
	}else{
		$old.=$u['user_name']."\r\n";	
		//file_put_contents("ishave.txt",$u['user_name']."\r\n",FILE_APPEND);
		return $col;
	}
	
}
/*添加用户扩展信息*/
function insert_users_info($user_id,$info){
	$sql = 'SELECT id FROM ' . $GLOBALS['ecs']->table('reg_fields') . ' WHERE type = 0 AND display = 1 ORDER BY dis_order, id';   //读出所有扩展字段的id
    $fields_arr = $GLOBALS['db']->getAll($sql);

    foreach ($fields_arr AS $val)       //循环更新扩展用户信息
    {
        //$extend_field_index = 'extend_field' . $val['id'];
        if(!empty($info[$val['id']]))
        {
            $temp_field_content = $info[$val['id']];
			
            $sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('reg_extend_info') . "  WHERE reg_field_id = '$val[id]' AND user_id = '$user_id'";
            if ($GLOBALS['db']->getOne($sql))      //如果之前没有记录，则插入
            {
                $sql = 'UPDATE ' . $GLOBALS['ecs']->table('reg_extend_info') . " SET content = '$temp_field_content' WHERE reg_field_id = '$val[id]' AND user_id = '$user_id'";
            }
            else
            {
                $sql = 'INSERT INTO '. $GLOBALS['ecs']->table('reg_extend_info') . " (`user_id`, `reg_field_id`, `content`) VALUES ('$user_id', '$val[id]', '$temp_field_content')";
            }
            $GLOBALS['db']->query($sql);
        }
    }	
}

//uploadFile()


//导入Excel文件
function uploadFile($file,$filetempname) 
{
	$oldname=date("ymdHis");//substr($file,0,-4);
	set_time_limit(0);
    //自己设置的上传文件存放路径
    $filePath = 'upFile/';
    $str = "";   
    //下面的路径按照你PHPExcel的路径来修改
    require_once './PHPExcel/PHPExcel.php';
    require_once './PHPExcel/PHPExcel/IOFactory.php';
    require_once './PHPExcel/PHPExcel/Reader/Excel5.php';

    //注意设置时区
    $time=date("y-m-d-H-i-s");//去当前上传的时间 
    //获取上传文件的扩展名
    $extend=strrchr ($file,'.');
    //上传后的文件名
    $name=$time.$extend;
    $uploadfile=$filePath.$name;//上传后的文件名地址 
	echo $uploadfile;
    //move_uploaded_file() 函数将上传的文件移动到新位置。若成功，则返回 true，否则返回 false。
    $result=move_uploaded_file($filetempname,$uploadfile);//假如上传到当前目录下
    //echo $result;
    if($result) //如果上传文件成功，就执行导入excel操作
    {
        
        $objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format 
        $objPHPExcel = $objReader->load($uploadfile); 
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow();           //取得总行数 
        $highestColumn = $sheet->getHighestColumn(); //取得总列数
        
        /* 第一种方法

        //循环读取excel文件,读取一条,插入一条
        for($j=1;$j<=$highestRow;$j++)                        //从第一行开始读取数据
        { 
            for($k='A';$k<=$highestColumn;$k++)            //从A列读取数据
            { 
                //
                这种方法简单，但有不妥，以'\\'合并为数组，再分割\\为字段值插入到数据库
                实测在excel中，如果某单元格的值包含了\\导入的数据会为空        
                //
                $str .=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'\\';//读取单元格
            } 
            //echo $str; die();
            //explode:函数把字符串分割为数组。
            $strs = explode("\\",$str);
            $sql = "INSERT INTO te(`1`, `2`, `3`, `4`, `5`) VALUES (
            '{$strs[0]}',
            '{$strs[1]}',
            '{$strs[2]}',
            '{$strs[3]}',
            '{$strs[4]}')";
            //die($sql);
            if(!mysql_query($sql))
            {
                return false;
                echo 'sql语句有误';
            }
            $str = "";
        }  
        unlink($uploadfile); //删除上传的excel文件
        $msg = "导入成功！";
        */

        /* 第二种方法*/
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); 
        echo 'highestRow='.$highestRow;
        echo "<br>";
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
        echo 'highestColumnIndex='.$highestColumnIndex;
        echo "<br>";
		flush();
        $headtitle=array();
		
		file_put_contents("user_pass".$oldname.".txt",date("Y-m-d H:i:s")."\r\n",FILE_APPEND);
		file_put_contents("ishave".$oldname.".txt",date("Y-m-d H:i:s")."\r\n",FILE_APPEND);
		$new=$old="";
		
        for ($row = 1;$row <= $highestRow;$row++) 
        {
			//sleep(5);
			//ob_flush();
            $strs=array();
            //注意highestColumnIndex的列数索引从0开始
            for ($col = 0;$col < 8;$col++)
            {
                $strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
			if($strs[2]=="男"){
				$sex=1;
			}elseif($strs[2]=="女"){
				$sex=2;
			}else{
				$sex=0;
			}
			//var_dump($strs);
			//150309	韩晓春	男	13361075589		HK山东代理商	济南宝明斋	277651	

			$user=array("100"=>$strs[0],"101"=>$strs[1],"sex"=>$sex,"user_name"=>$strs[3],"104"=>$strs[4],"102"=>$strs[5],"103"=>$strs[6],"password"=>$strs[7],"reg_time"=>time());
			$lastid=insert_users($user,$new,$old);
			//echo $lastid;
		
			if($lastid!==false){
				insert_users_info($lastid,$user);
				echo "第".$row."条数据成功。";
				echo "<br />";
				
			}
			
			flush();
			/**/
			//echo json_encode($user);
			
			/*
			
			
            $sql = "INSERT INTO te(`1`, `2`, `3`, `4`, `5`) VALUES (
            '{$strs[0]}',
            '{$strs[1]}',
            '{$strs[2]}',
            '{$strs[3]}',
            '{$strs[4]}')";
            //die($sql);
            if(!mysql_query($sql))
            {
                return false;
                echo 'sql语句有误';
            }
			*/
        }
		file_put_contents("user_pass".$oldname.".txt",$new,FILE_APPEND);
		file_put_contents("ishave".$oldname.".txt",$old,FILE_APPEND);

    }
    else
    {
       $msg = "导入失败！";
    } 
    return $msg;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data">
<input name="inputExcel" type="file" />
<input name="leadExcel" type="hidden" value="true" />
<input name="上传" type="submit" />
</form>

</body>
</html>
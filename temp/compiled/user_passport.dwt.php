<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>


<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />


<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,user.js,transport.js')); ?>
<body>
<?php if (! ( ( $this->_var['action'] == 'login' ) || ( $this->_var['action'] == 'register' ) || ( $this->_var['action'] == 'get_password' ) )): ?>
<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="block1 box" style="width:1097px;">
 <div id="ur_here">
  <?php echo $this->fetch('library/ur_here.lbi'); ?>
  </div>
</div>

<div class="blank"></div>
<?php else: ?>
<?php if ($this->_var['stats_code']): ?>
	<div align="left" style="display:none"><?php echo $this->_var['stats_code']; ?></div>
<?php endif; ?>
</script>
<?php endif; ?>

<?php if (( $this->_var['action'] == 'login' ) || ( $this->_var['action'] == 'register' ) || ( $this->_var['action'] == 'get_password' )): ?>
<div id="bg" style="position:absolute; top:0px; left:0px; z-index:-999;"><img src="themes/helen_keller/images/bg.jpg" alt="HIGH" /></div> 
<?php endif; ?>
<?php if ($this->_var['action'] == 'login'): ?>
<div style="position:absolute;width:414px;right:50%;height:500px;top:30%;margin-top:-180px;margin-right:-20px;background:url(themes/helen_keller/images/login_bg.gif) no-repeat;z-index:2;">
<?php elseif ($this->_var['action'] == 'register'): ?>
<div style="position:absolute;width:414px;right:50%;height:500px;top:30%;margin-top:-180px;margin-right:-20px;background:url(themes/helen_keller/images/reg_bg.gif) no-repeat;z-index:2;">
<?php elseif ($this->_var['action'] == 'get_password'): ?>
<div style="position:absolute;width:414px;right:50%;height:500px;top:30%;margin-top:-180px;margin-right:-20px;background:url(themes/helen_keller/images/get_password.gif) no-repeat;z-index:2;">
<?php endif; ?>

 
 <?php if ($this->_var['action'] == 'login'): ?>
 <div style="display:block;width:200px;height:180px; position:relative;left:27px;top:152px;z-index:3;">
  <form action="user.php" method="post" name="loginForm" id="loginForm" onSubmit="return userLogin()">
   <div style="display:block;width:100%;height:24px;padding:5px 0;">
      <input type="text" name="username" class="inputBg" size="8" style="border:none;background:none;position:relative;left:16px;top:-3px;width:180px;height:27px;line-height:27px;vertical-align:middle;" />
   </div>
   <div class="blank"></div>
   <div style="display:block;width:100%;height:24px;padding:5px 0;">
      <input type="password" name="password" class="inputBg" size="8" style="border:none;background:none;position:relative;left:17px;top:-1px;_top:-24px;width:180px;height:27px;line-height:27px;vertical-align:middle;" />  
   </div>
   <div class="blank"></div>
   <div style="display:block;width:100%;height:24px;padding-left:15px;">
      <a href="user.php?act=get_password"><span class="fl" style="display:block;width:50px;height:24px;margin-right:15px;border:none;"></span></a>
      <a href="#"><span class="fl" style="display:block;width:55px;height:24px;border:none;"></span></a>
   </div>
   <div class="blank"></div>
   <div style="display:block;width:100%;height:36px;margin-top:30px;">
     <span class="fl" style="display:block;width:75px;height:30px;margin-right:16px;"><input type="submit" value="" style="display:block;width:100%;height:30px;border:none;background:none;cursor:pointer;" /></span>
     <span class="fl" style="display:block;width:85px;height:30px;"><input type="button" value="" onclick="window.location.href = 'user.php?act=register';" style="display:block;width:100%;height:30px;border:none;background:none;cursor:pointer;" /><input type="hidden" name="act" value="act_login" /></span>
   </div>
  </form>
 </div>
 <?php endif; ?>
 


<?php if ($this->_var['action'] == 'register'): ?>
    <?php if ($this->_var['shop_reg_closed'] == 1): ?>
        <div class="f1 f5" align="center" style="margin-top:24px;font-size:18px;"><?php echo $this->_var['lang']['shop_register_closed']; ?></div>
<?php else: ?>
    <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
  <div class="usBox_2 clearfix" style="width:480px;position:relative;left:96px;top:112px;">  
    <form action="user.php" method="post" name="formUser" onsubmit="return register();">
		<style>
		input{width: 180px; border: 0px; background: none;height: 24px; line-height: 24px;}
		table td{padding: 0px; height: 33px;}
		</style>
      <table width="100%"  border="0" align="left" cellpadding="5" cellspacing="3">
        <tr>
          <td width="10%" align="right"><?php if (0): ?><?php echo $this->_var['lang']['label_username']; ?><?php endif; ?></td>
          <td width="90%">
          <input name="username" type="text" id="username" onblur="is_registered(this.value);" class="inputBg" />
            <span id="username_notice" style="color:#FF0000"></span>
          </td>
        </tr>
	<?php if (0): ?>
        <tr>
          <td align="right"><?php echo $this->_var['lang']['label_email']; ?></td>
          <td>
          <input name="email" type="text" size="23" id="email" onblur="checkEmail(this.value);"  class="inputBg"/>
            <span id="email_notice" style="color:#FF0000"> *</span>
          </td>
        </tr>
        <?php endif; ?>
        <tr>
          <td align="right"><?php if (0): ?><?php echo $this->_var['lang']['label_password']; ?><?php endif; ?></td>
          <td>
          <input name="password" type="password" id="password1" onblur="check_password(this.value);" onkeyup="checkIntensity(this.value)" class="inputBg" style="margin-top:2px;" />
            <span style="color:#FF0000" id="password_notice"></span>
          </td>
        </tr>
	<?php if (0): ?>
        <tr>
          <td align="right"><?php echo $this->_var['lang']['label_password_intensity']; ?></td>
          <td>
            <table width="145" border="0" cellspacing="0" cellpadding="1">
              <tr align="center">
                <td width="33%" id="pwd_lower"><?php echo $this->_var['lang']['pwd_lower']; ?></td>
                <td width="33%" id="pwd_middle"><?php echo $this->_var['lang']['pwd_middle']; ?></td>
                <td width="33%" id="pwd_high"><?php echo $this->_var['lang']['pwd_high']; ?></td>
              </tr>
            </table>
          </td>
        </tr>
        <?php endif; ?>
        <tr>
          <td align="right"><?php if (0): ?><?php echo $this->_var['lang']['label_confirm_password']; ?><?php endif; ?></td>
          <td>
          <input name="confirm_password" type="password" id="conform_password" onblur="check_conform_password(this.value);"  class="inputBg" style="margin-top:3px;"/>
            <span style="color:#FF0000" id="conform_password_notice"></span>
          </td>
        </tr>
        <?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?>
	<?php if ($this->_var['field']['id'] == 6): ?>
        <tr style=" display: none">
          <td align="right"><?php echo $this->_var['lang']['passwd_question']; ?></td>
          <td>
          <select name='sel_question'>
	  <option value='0'><?php echo $this->_var['lang']['sel_question']; ?></option>
	  <?php echo $this->html_options(array('options'=>$this->_var['passwd_questions'])); ?>
	  </select>
          </td>
        </tr>
        <tr style="display:none;">
          <td align="right" <?php if ($this->_var['field']['is_need']): ?>id="passwd_quesetion"<?php endif; ?>><?php echo $this->_var['lang']['passwd_answer']; ?></td>
          <td>
	  <input name="passwd_answer" type="text" size="25" class="inputBg" maxlengt='20'/><?php if ($this->_var['field']['is_need']): ?><span style="color:#FF0000"> *</span><?php endif; ?>
          </td>
        </tr>
	<?php else: ?>
        <tr style="display:none;">
          <td align="right" <?php if ($this->_var['field']['is_need']): ?>id="extend_field<?php echo $this->_var['field']['id']; ?>i"<?php endif; ?>><?php echo $this->_var['field']['reg_field_name']; ?>
          <td>
          <input name="extend_field<?php echo $this->_var['field']['id']; ?>" id="extend_field<?php echo $this->_var['field']['id']; ?>" type="text" size="25" class="inputBg" /><?php if ($this->_var['field']['is_need']): ?><span style="color:#FF0000"> *</span><?php endif; ?>
          </td>
        </tr>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <tr>
          <td>&nbsp;</td>
          <td style="padding-top: 5px;">
          <input name="mobile_code" id="mobile_code" type="text" class="inputBg" ><?php if ($this->_var['field']['is_need']): ?><span style="color:#FF0000"> *</span><?php endif; ?>
          </td>
        </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><input id="zphone" type="button" onclick="sendSms();" style="width:140px;height:24px;position:relative;left:32px; top:-2px;background:none;border:none;cursor:pointer;"></td>
	</tr>
        <script>var mobile_field='username';</script>
        <script type="text/javascript" src="sms/sms.js"></script>
      <?php if ($this->_var['enabled_captcha']): ?>
      <tr style="display:none">
      <td align="right"><?php echo $this->_var['lang']['comment_captcha']; ?></td>
      <td><input type="text" size="8" name="captcha" class="inputBg" />
      <img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?'+Math.random()" /> </td>
      </tr>
      <?php endif; ?>
        <tr style="display: none;">
          <td>&nbsp;</td>
          <td><label>
            <input name="agreement" type="checkbox" value="1" checked="checked" />
            <?php echo $this->_var['lang']['agreement']; ?></label></td>
        </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left">
              <div class="btns">
		  <input name="Submit" type="submit" value="" style="width:90px;height:48px;border:none;position:relative;left:-20px;top:6px;background:none;cursor:pointer;"/>
		  <input name="exit" type="button" onclick="window.location.href='/'" style="width:90px;height:48px;border:none;position:relative;left:-20px;top:6px;background:none;cursor:pointer;"/>
		  <input name="act" type="hidden" value="act_register" >
		  <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
	      </div>
          </td>
        </tr>
        <tr style="display:none;">
          <td colspan="2">&nbsp;</td>
        </tr>
	<?php if (0): ?>
        <tr>
          <td>&nbsp;</td>
          <td class="actionSub">
          <a href="user.php?act=login"><?php echo $this->_var['lang']['want_login']; ?></a><br />
          <a href="user.php?act=get_password"><?php echo $this->_var['lang']['forgot_password']; ?></a>
          </td>
        </tr>
        <?php endif; ?>
      </table>
    </form>
  </div>
   <?php endif; ?>
<?php endif; ?>


    <?php if ($this->_var['action'] == 'get_password'): ?>
    <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,jquery-1.7.2.min.js')); ?>
    <script type="text/javascript">
    <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

    </script>
	 <div style="display:block;width:200px;height:180px; position:relative;left:18px;top:168px;z-index:3;">
  <form action="user.php" method="post" name="loginForm" id="loginForm" onSubmit="return userLogin()">
   <div style="display:block;width:100%;height:24px;padding:5px 0;">
	<input style="border:none;background:none;position:relative;left:25px;top:-18px;width:180px;height:25px;line-height:25px;vertical-align:middle;" name="username" id="username" type="text" size="30" class="inputBg" />  </div>
   <div class="blank"></div>
   <div style="display:block;width:100%;height:24px;padding:5px 0;">
      <input type="text" name="sms_code" class="inputBg" maxlength="6" style="border:none;background:none;position:relative;left:25px;top:-17px;_top:-21px;width:104px;height:25px;line-height:25px;vertical-align:middle;" />
	  <input type="button" id="sendcode" value="获取验证码" title="点击获取验证码" style="border:none;cursor: pointer;height: 25px;width: 74px;position:relative;left:25px;top:-15px;_top:-22px;">
   </div>
   <div class="blank"></div>
   <div style="display:block;width:100%;height:24px;padding:6px 0;padding-left:30px;">
      <a href="user.php?act=get_password"><span class="fl" style="display:block;width:50px;height:24px;margin-right:10px;border:none;"></span></a>
      <a href="#"><span class="fl" style="display:block;width:50px;height:24px;border:none;"></span></a>
   </div>
   <div style="display:block;width:100%;height:36px;">
     <span class="fl" style="display:block;width:90px;height:38px;margin-right:5px;">
		<input type="submit" name="submit" value="" style="display:block;width:100%;height:38px;border:none;background:none;cursor:pointer;" />
	</span>
     <span class="fl" style="display:block;width:90px;height:38px;">
		<input type="button" value="" onclick="window.location.href = 'user.php';" style="display:block;width:100%;height:38px;border:none;background:none;cursor:pointer;" />
		<input type="hidden" name="act" value="get_password" />
	</span>
   </div>
  </form>
 </div>
 <script type="text/javascript">
    $("#sendcode").click(function(){ 
		var username = $('#username').val();
		Ajax.call('sms/sms.php?act=send_code', '&mobile=' + username, SendResult, 'POST', 'JSON');
    });

	function SendResult(result){
		alert(result.msg);
		if(result.code == 2){
			DisableEnable($("#sendcode"));
		}
	}

	var time=60;
	function DisableEnable(objid){
		if(time<=0){
				objid.val('发送验证码');
				objid.removeAttr("disabled");
				time=60;
				return true;
		}else{
				objid.attr("disabled","true");
				objid.val("等待" + time + "秒");
				setTimeout(function() {DisableEnable(objid)} ,1000);
		}
		time-=1; 
	}

    </script>

<?php endif; ?>


<?php if (( $this->_var['action'] == 'login' ) || ( $this->_var['action'] == 'register' ) || ( $this->_var['action'] == 'get_password' )): ?>
</div>
<div id="back" style="position:relative;text-align:center;">
  <img src="themes/helen_keller/images/background.jpg" />
  <div style="display:block;background:url(themes/helen_keller/images/logo.png) no-repeat; width:171px; height:37px; float:left;position:absolute;top:20px;left:20px;"></div>
  <div style="display:block;background:url(themes/helen_keller/images/ambassador.png) no-repeat; width:96px; height:13px; float:right; position:absolute; bottom:20px; right:20px;"></div>
</div>
<script type="text/javascript"> 
var imgWidth = 1716;
var imgHeight = 1060;
function autosize(){ 
    // 获取窗口宽度 
    if (window.innerWidth) 
        winWidth = window.innerWidth; 
    else if ((document.body) && (document.body.clientWidth)) 
        winWidth = document.body.clientWidth; 
    // 获取窗口高度 
    if (window.innerHeight) 
       winHeight = window.innerHeight; 
    else if ((document.body) && (document.body.clientHeight)) 
       winHeight = document.body.clientHeight; 
    // 通过深入 Document 内部对 body 进行检测，获取窗口大小 
    if (document.documentElement && document.documentElement.clientHeight && document.documentElement.clientWidth) 
    { 
       winHeight = document.documentElement.clientHeight; 
       winWidth = document.documentElement.clientWidth; 
    } 

	var bgImg = document.getElementById('bg').getElementsByTagName('img')[0];
	    bgImg.width = winWidth;
	    bgImg.height= winHeight; 
	var backImg = document.getElementById('back').getElementsByTagName('img')[0];
	    backImg.height = winHeight;
		backImg.width = parseInt(winHeight * imgWidth / imgHeight);
}   
window.onLoad = autosize();
window.onResize = autosize();
</script>
<?php endif; ?>






    <?php if ($this->_var['action'] == 'qpassword_name'): ?>
     <div class="block1">
<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.php" method="post">
        <br />
        <table width="70%" border="0" align="center">
          <tr>
            <td colspan="2" align="center"><strong><?php echo $this->_var['lang']['get_question_username']; ?></strong></td>
          </tr>
          <tr>
            <td width="29%" align="right"><?php echo $this->_var['lang']['username']; ?></td>
            <td width="61%"><input name="user_name" type="text" size="30" class="inputBg" /></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="hidden" name="act" value="get_passwd_question" />
              <input type="submit" name="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="bnt_blue" style="border:none;" />
              <input name="button" type="button" onclick="history.back()" value="<?php echo $this->_var['lang']['back_page_up']; ?>" style="border:none;" class="bnt_blue_1" />
	    </td>
          </tr>
        </table>
        <br />
      </form>
  </div>
</div>
</div>
<?php endif; ?>



    <?php if ($this->_var['action'] == 'get_passwd_question'): ?>
     <div class="block">
<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.php" method="post">
        <br />
        <table width="70%" border="0" align="center">
          <tr>
            <td colspan="2" align="center"><strong><?php echo $this->_var['lang']['input_answer']; ?></strong></td>
          </tr>
          <tr>
            <td width="29%" align="right"><?php echo $this->_var['lang']['passwd_question']; ?>：</td>
            <td width="61%"><?php echo $this->_var['passwd_question']; ?></td>
          </tr>
          <tr>
            <td align="right"><?php echo $this->_var['lang']['passwd_answer']; ?>：</td>
            <td><input name="passwd_answer" type="text" size="20" class="inputBg" /></td>
          </tr>
          <?php if ($this->_var['enabled_captcha']): ?>
          <tr>
            <td align="right"><?php echo $this->_var['lang']['comment_captcha']; ?></td>
            <td><input type="text" size="8" name="captcha" class="inputBg" />
            <img src="captcha.php?is_login=1&<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?is_login=1&'+Math.random()" /> </td>
          </tr>
          <?php endif; ?>
          <tr>
            <td></td>
            <td><input type="hidden" name="act" value="check_answer" />
              <input type="submit" name="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="bnt_blue" style="border:none;" />
              <input name="button" type="button" onclick="history.back()" value="<?php echo $this->_var['lang']['back_page_up']; ?>" style="border:none;" class="bnt_blue_1" />
	    </td>
          </tr>
        </table>
        <br />
      </form>
  </div>
</div>
</div>
<?php endif; ?>

<?php if ($this->_var['action'] == 'reset_password'): ?>
    <script type="text/javascript">
    <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
     <div class="block">
<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.php" method="post" name="getPassword2" onSubmit="return submitPwd()">
      <br />
      <table width="80%" border="0" align="center">
        <tr>
          <td><?php echo $this->_var['lang']['new_password']; ?></td>
          <td><input name="new_password" type="password" size="25" class="inputBg" /></td>
        </tr>
        <tr>
          <td><?php echo $this->_var['lang']['confirm_password']; ?>:</td>
          <td><input name="confirm_password" type="password" size="25"  class="inputBg"/></td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input type="hidden" name="act" value="act_edit_password" />
            <input type="hidden" name="uid" value="<?php echo $this->_var['uid']; ?>" />
            <input type="hidden" name="code" value="<?php echo $this->_var['code']; ?>" />
            <input type="submit" name="submit" value="<?php echo $this->_var['lang']['confirm_submit']; ?>" />
          </td>
        </tr>
      </table>
      <br />
    </form>
  </div>
</div>
</div>
<?php endif; ?>


<?php if (! ( ( $this->_var['action'] == 'login' ) || ( $this->_var['action'] == 'register' ) || ( $this->_var['action'] == 'get_password' ) )): ?>
<div class="blank"></div>

<?php endif; ?>
</body>
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
<?php $_from = $this->_var['lang']['passport_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var username_exist = "<?php echo $this->_var['lang']['username_exist']; ?>";
</script>
</html>

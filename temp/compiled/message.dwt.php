<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<?php if ($this->_var['auto_redirect']): ?>
<meta http-equiv="refresh" content="3;URL=<?php echo $this->_var['message']['back_url']; ?>" />
<?php endif; ?>

<title><?php echo $this->_var['page_title']; ?></title>

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
<script type="text/javascript" src="themes/helen_keller/js/action.js"></script>
</head>
<body>


<?php if ($this->_var['_SESSION'] [ 'user_id' ] > 0): ?>
	<?php echo $this->fetch('library/page_header.lbi'); ?>
	<div class="block1 clearfix">
	   <?php echo $this->fetch('library/ur_here.lbi'); ?>
	</div>
 <?php endif; ?>


<div class="block1 clearfix">
  <div class="mod1 blank" id="messages" style="height:390px;">
	<span class="lt"></span><span class="lb"></span><span class="rt"></span><span class="rb"></span>
	<h1 class="mod1tit"  style=" border-top: 1px #ccc solid"><?php echo $this->_var['lang']['system_info']; ?></h1>
	<div class="mod1con">
			<div class="tips" style=" border: none"><?php echo $this->_var['message']['content']; ?></div>
		  <div class="tc" style="padding-bottom:20px;">
			<?php if ($this->_var['message']['url_info']): ?>
			<?php $_from = $this->_var['message']['url_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('info', 'url');if (count($_from)):
    foreach ($_from AS $this->_var['info'] => $this->_var['url']):
?>
			 <p><a href="<?php echo $this->_var['url']; ?>"><?php echo $this->_var['info']; ?></a></p>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		 <?php endif; ?>
			</div>
		</div>
	</div>
	<script type="text/javascript">divheight("messages");</script>
</div>
<?php if ($this->_var['_SESSION'] [ 'user_id' ] > 0): ?>
	
	<?php echo $this->fetch('library/help.lbi'); ?>
	<?php echo $this->fetch('library/page_footer.lbi'); ?>
<?php endif; ?>
</body>
</html>

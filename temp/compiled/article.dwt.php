<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
<script type="text/javascript" src="themes/helen_keller/js/action.js"></script>
<style>
.ur_here{width:760px;}
</style>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="blank"></div>
<div class="block1">
   <?php echo $this->fetch('library/ur_here.lbi'); ?>
</div>
<div class="blank"></div>
<div class="block1 clearfix">
	<div id="articleLeft" class="fl">
	<?php if ($this->_var['related_goods']): ?>
	<div class="mod1 mod2 blank" id="articleRelated" style="padding-bottom:10px;">
	<span class="lt"></span><span class="lb"></span><span class="rt"></span><span class="rb"></span>
	<h1 class="mod2tit"><?php echo $this->_var['lang']['releate_goods']; ?></h1>
	<div class="mod2con" >
		<?php $_from = $this->_var['related_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'releated_goods_data');if (count($_from)):
    foreach ($_from AS $this->_var['releated_goods_data']):
?>
	    <ul class="attribute" >
      <li>
       <a href="<?php echo $this->_var['releated_goods_data']['url']; ?>" class="fl" style=" line-height: 25px;"><img src="<?php echo $this->_var['releated_goods_data']['goods_thumb']; ?>" alt="<?php echo $this->_var['releated_goods_data']['goods_name']; ?>" align="left" /></a>
			<p class="fl" style="width:110px;"> <a href="<?php echo $this->_var['releated_goods_data']['url']; ?>" title="<?php echo $this->_var['releated_goods_data']['goods_name']; ?>"><?php echo $this->_var['releated_goods_data']['short_name']; ?></a><br />
			 <?php if ($this->_var['releated_goods_data']['promote_price'] != 0): ?>
			 <?php echo $this->_var['lang']['promote_price']; ?><b class="f1"><?php echo $this->_var['releated_goods_data']['formated_promote_price']; ?></b><br />
			 <?php else: ?>
			 <?php echo $this->_var['lang']['shop_price']; ?><b class="f1"><?php echo $this->_var['releated_goods_data']['shop_price']; ?></b></p>
			 <?php endif; ?>
      </li>
     </ul>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	 </div>
	</div>
	<script type="text/javascript">divheight("articleRelated");</script>
	<?php endif; ?> 
	
	<?php echo $this->fetch('library/helpleft.lbi'); ?>
  
	</div>


  <div id="articleRight" class="fr" >
	 <div class="articleBox">
	  <h1 class="articleTit tc"><?php echo htmlspecialchars($this->_var['article']['title']); ?></h1>
	  <div class="author tc"> 
		  <?php echo htmlspecialchars($this->_var['article']['author']); ?> / <?php echo $this->_var['article']['add_time']; ?>
		  <div class="articleSize">[<a href="javascript:articleSize('16','30')">大</a>] [<a href="javascript:articleSize('14','24')">中</a>] [<a href="javascript:articleSize('12','21')">小</a>]</div>
	  </div>
      <div style="border-top: #efefef solid 1px;"><div>
		<?php if ($this->_var['article']['content']): ?>
		<div id="article" class="word">
		 <?php echo $this->_var['article']['content']; ?>
		</div> 
		<?php endif; ?>
		<?php if ($this->_var['article']['open_type'] == 2 || $this->_var['article']['open_type'] == 1): ?>
			<div class="tr"><a href="<?php echo $this->_var['article']['file_url']; ?>" target="_blank"><u><?php echo $this->_var['lang']['relative_file']; ?></u></a></div>
		<?php endif; ?>
		 <div class="articlePrev">
			
			<span style="margin-right:350px;">
            	 <?php echo $this->_var['lang']['next_article']; ?>：
				 <?php if ($this->_var['next_article']): ?>
				 <a href="<?php echo $this->_var['next_article']['url']; ?>"><?php echo $this->_var['next_article']['title']; ?></a>
				 <?php else: ?>
				 Empty！
				 <?php endif; ?>
                 
            </span>
			 
             <span style="">
				<?php echo $this->_var['lang']['prev_article']; ?>：
				<?php if ($this->_var['prev_article']): ?>
				<a href="<?php echo $this->_var['prev_article']['url']; ?>"><?php echo $this->_var['prev_article']['title']; ?></a>
				<?php else: ?>
				 Empty！
				<?php endif; ?>
             </span>
		 </div>
	</div>	

	</div>

</div>
</div>
</div>
<div class="blank"></div>
<!--<div style="background:url(themes/helen_keller/images/footbg.gif) repeat-x left top; padding-top:20px;">-->
<?php echo $this->fetch('library/help.lbi'); ?>
</div>
<?php if ($this->_var['img_links'] || $this->_var['txt_links']): ?>
<div class="block blank" >
  <div class="mod1 mod2" id="links" style=" border:1px #ccc solid">
	 <span class="lt"></span><span class="lb"></span><span class="rt"></span><span class="rb"></span>
	  <div class="links clearfix">

       
        <p>
        <a href="http://www.68ecshop.com/" target="_blank" title="<?php echo $this->_var['link']['name']; ?>" class="linkTxt">ecshop</a>
            <a href="http://www.68ecshop.com/" target="_blank" title="<?php echo $this->_var['link']['name']; ?>" class="linkTxt">68ecshop模板</a>
            <a href="http://chajian.68ecshop.com/" target="_blank" title="<?php echo $this->_var['link']['name']; ?>" class="linkTxt"></a>
			<?php if ($this->_var['txt_links']): ?>
			<?php $_from = $this->_var['txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
			<a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>" class="linkTxt"><?php echo $this->_var['link']['name']; ?></a>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			<?php endif; ?>
            
            
       </p>
		</div>
  </div>
<script type="text/javascript">divheight("links");</script>	
</div> 
<?php endif; ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>

</body>
</html>

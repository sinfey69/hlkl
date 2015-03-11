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
<script type="text/javascript" src="themes/helen_keller/js/mzp-packed-me.js"></script>
<script type="text/javascript" src="themes/helen_keller/js/action.js"></script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="block1 clearfix">
<?php echo $this->fetch('library/ur_here.lbi'); ?>
</div>
<div class="block1">
   <div class="clearfix">
       <div class="goodsimgbox fl">
	  <div id="focuscont">
             <?php if ($this->_var['pictures']): ?>
			 <?php $_from = $this->_var['pictures']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'picture');$this->_foreach['picture'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['picture']['total'] > 0):
    foreach ($_from AS $this->_var['picture']):
        $this->_foreach['picture']['iteration']++;
?>
			 <?php if ($this->_foreach['picture']['iteration'] == 1): ?>
               <a style="" href="<?php echo $this->_var['picture']['img_url']; ?>" id="zoom1" class="MagicZoom MagicThumb" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>">
                  <img src="<?php echo $this->_var['picture']['img_url']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" width="450px" height="352px" style="border:1px solid #d2d0d0"/>
               </a>
			   <?php endif; ?>
			    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>   
             <?php else: ?>
                  <img src="<?php echo $this->_var['goods']['goods_img']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>"/>
             <?php endif; ?>
	  </div>

          <?php if ($this->_var['pictures']): ?>
          <div class="picture" id="imglist">
			<?php $_from = $this->_var['pictures']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'picture');$this->_foreach['picture'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['picture']['total'] > 0):
    foreach ($_from AS $this->_var['picture']):
        $this->_foreach['picture']['iteration']++;
?>
               <a href="<?php echo $this->_var['picture']['img_url']; ?>" rel="zoom1" rev="<?php echo $this->_var['picture']['img_url']; ?>" title="">
                 <img src="<?php if ($this->_var['picture']['thumb_url']): ?><?php echo $this->_var['picture']['thumb_url']; ?><?php else: ?><?php echo $this->_var['picture']['img_url']; ?><?php endif; ?>" alt="<?php echo $this->_var['goods']['goods_name']; ?>" <?php if ($this->_foreach['picture']['iteration'] == 1): ?>class="onbg"<?php else: ?>class="autobg"<?php endif; ?> /></a>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                        
          </div>  
          <script type="text/javascript">
	     mypicBg();
          </script>
          <?php endif; ?>
      </div>
      <div class="goodstxtbox fr" style=" margin-right:15px; _margin-left: 20px; padding-top: 8px;">
	 <h4 class="goodName">
	  <?php echo $this->_var['goods']['goods_style_name']; ?>
	  <div class="prev" style=" display: none">
            <?php if ($this->_var['prev_good']): ?>
              <a href="<?php echo $this->_var['prev_good']['url']; ?>" style="color:#CCC; font-size:12px;">上一个</a>
            <?php endif; ?>
            <?php if ($this->_var['next_good']): ?>
              <a href="<?php echo $this->_var['next_good']['url']; ?>" style="color:#CCC; font-size:12px;">下一个</a>
            <?php endif; ?>
          </div>
	 </h4>
	 <form action="exchange.php?act=buy" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY">

        <?php if ($this->_var['cfg']['show_goodssn']): ?>
	<div class="Goodpromotion" style="float:left; width:500px;">
        <?php echo $this->_var['lang']['goods_sn']; ?><?php echo $this->_var['goods']['goods_sn']; ?>
	</div>
        <?php endif; ?>

        <?php if ($this->_var['goods']['goods_brand'] != "" && $this->_var['cfg']['show_brand']): ?>
	<div class="Goodpromotion" style="float:left; width:500px;">
        <?php echo $this->_var['lang']['goods_brand']; ?><a href="<?php echo $this->_var['goods']['goods_brand_url']; ?>" ><?php echo $this->_var['goods']['goods_brand']; ?></a>
	</div>
        <?php endif; ?>

        <?php if ($this->_var['cfg']['show_goodsweight']): ?>
	<div class="Goodpromotion" style="float:left; width:500px;">
        <?php echo $this->_var['lang']['goods_weight']; ?><?php echo $this->_var['goods']['goods_weight']; ?>
	</div>
        <?php endif; ?>
	<div class="Goodpromotion" style="float:left; width:500px;">
        <?php echo $this->_var['lang']['exchange_integral']; ?><font class="shop" color="red"><?php echo $this->_var['goods']['goods_price']; ?>话费+<?php echo $this->_var['goods']['exchange_integral']; ?>积分</font>
	</div>

        
        <?php $_from = $this->_var['specification']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('spec_key', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec_key'] => $this->_var['spec']):
?>
        <?php echo $this->_var['spec']['name']; ?>:<br />
        <?php if ($this->_var['cfg']['goodsattr_style'] == 1): ?>
        <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
        <label for="spec_value_<?php echo $this->_var['value']['id']; ?>">
        <input type="radio" name="spec_<?php echo $this->_var['spec_key']; ?>" value="<?php echo $this->_var['value']['id']; ?>" id="spec_value_<?php echo $this->_var['value']['id']; ?>" <?php if ($this->_var['key'] == 0): ?>checked<?php endif; ?> />
        <?php echo $this->_var['value']['label']; ?> </label><br />
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php else: ?>
        <select name="spec_<?php echo $this->_var['spec_key']; ?>" class="TextInput">
          <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
          <option label="<?php echo $this->_var['value']['label']; ?>" value="<?php echo $this->_var['value']['id']; ?>"><?php echo $this->_var['value']['label']; ?> </option>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </select>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        
        <input type="hidden" name="goods_id" value="<?php echo $this->_var['goods']['goods_id']; ?>" />
<br />

        <input type="submit" value=" " class="convert"/>
	<input type="button" onclick="addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" value=" " class="addToCart"/>
	
	
    </form>
     
        	</div>
	</div>
<?php if (! empty ( $this->_var['surpluslist'] )): ?>
  <div class="creditsexe">
    <div class="creditit clearfix">
      <ul class="clearfix">
        <li class="seletit">剩下积分还可兑换</li>
      </ul>
    </div>
    <div class="creditcon clearfix">
      <div class="selecon">
	  	<?php $_from = $this->_var['surpluslist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
        <dl>
          <dt class="clearfix">
            <a href="<?php echo $this->_var['list']['url']; ?>" title="<?php echo $this->_var['list']['name']; ?>">
              <img src="<?php echo $this->_var['list']['goods_thumb']; ?>" alt="<?php echo $this->_var['list']['name']; ?>" title="<?php echo $this->_var['list']['name']; ?>" />
            </a>
           </dt>
          <dd>
            <strong><?php echo $this->_var['list']['exchange_integral']; ?></strong><span>积分 + </span><strong><?php echo $this->_var['list']['goods_price']; ?></strong><span>话费</span>
            <p><?php echo $this->_var['list']['name']; ?></p>
          </dd>
        </dl>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
	<div class="infotit clearfix" id="com_b">
	    <h2><span class="l"></span><span class="r"></span><?php echo $this->_var['lang']['feed_goods_desc']; ?></h2>
		  <h2 class="h2bg"><span class="l"></span><span class="r"></span><?php echo $this->_var['lang']['goods_attr']; ?></h2>


			<h2 class="h2bg"><span class="l"></span><span class="r"></span><?php echo $this->_var['lang']['releate_goods']; ?></h2>
			<h2 class="h2bg"><span class="l"></span><span class="r"></span><?php echo $this->_var['lang']['shopping_and_other']; ?></h2>
			<h2 class="h2bg"><span class="l"></span><span class="r"></span>购买记录</h2>
	</div>
	 <div class="tagcontent" id="com_v"></div>
	 <div id="com_h">
		   <blockquote>
        <?php echo $this->_var['goods']['goods_desc']; ?>
       </blockquote>
			 <blockquote>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
        <?php $_from = $this->_var['properties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'property_group');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['property_group']):
?>
        <tr>
          <th colspan="2" bgcolor="#FFFFFF"><?php echo htmlspecialchars($this->_var['key']); ?></th>
        </tr>
        <?php $_from = $this->_var['property_group']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'property');if (count($_from)):
    foreach ($_from AS $this->_var['property']):
?>
        <tr>
          <td bgcolor="#FFFFFF" align="left" width="30%" class="f1">[<?php echo htmlspecialchars($this->_var['property']['name']); ?>]</td>
          <td bgcolor="#FFFFFF" align="left" width="70%"><?php echo $this->_var['property']['value']; ?></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       </table>
       </blockquote>

       <blockquote>
	   <?php echo $this->fetch('library/goods_related.lbi'); ?>
       </blockquote>
       <blockquote>
	   <?php echo $this->fetch('library/bought_goods.lbi'); ?>
       </blockquote>
       <blockquote>
           <?php echo $this->fetch('library/bought_note_guide.lbi'); ?>
       </blockquote>
       </div>
	<script type="text/javascript">reg("com");</script>
	 
	 <?php echo $this->fetch('library/comments.lbi'); ?>
	 

    </div>



<?php echo $this->fetch('library/help.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">

onload = function()
{
  fixpng();
}

</script>
</html>

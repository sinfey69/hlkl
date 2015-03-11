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
<?php if ($this->_var['cat_style']): ?>
<script type="text/javascript" src="themes/helen_keller/js/jquery1.11.js"></script>
<link href="<?php echo $this->_var['cat_style']; ?>" rel="stylesheet" type="text/css" />
<?php endif; ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,compare.js')); ?>
<script type="text/javascript" src="themes/helen_keller/js/action.js"></script>
<script type="text/javascript" src="themes/helen_keller/js/scrollpic.js"></script>
<script type="text/javascript" src="themes/helen_keller/js/roll.js"></script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="block1 clearfix" style="width:1097px;">
   <?php echo $this->fetch('library/ur_here.lbi'); ?>
</div>
<script>
$(document).scroll(function(){
	var t = parseInt($(document).scrollTop());
	if(t < 170){
		t = 170;
	}
	if(t > $(document).height() - $('.sideBar').height() - 260){
		t = $(document).height() - $('.sideBar').height() - 260;
	}
	$('.sideBar').css('top', t +'px');
});
</script>
<div class="gift clearfix">
	<div class="pageBodyCont clearfix">
	    <div class="fl sideBar" style="position:absolute;">
                <span class="userIcon mt30"><em></em><img src="themes/helen_keller/images/pic/userIcon.jpg" /></span>
                <ul class="leftNav">
                    <li class="leftNav_top"></li>
                    <li class="current"><a href="#">首页</a></li>
                    <li class="space"><a href="#index_title02">缤纷好礼</a></li>
                    <li><a href="#">超值好劵</a></li>
                    <li class="space"><a href="#">积分抽奖</a></li>
                    <li><a href="#index_title01">积分聚划算</a></li>
                    <li class="space"><a href="user.php">个人中心</a></li>
                    <li class="leftNav_btm"></li>
                </ul>
                <span class="qrCode"><a href="#"><img src="themes/helen_keller/images/qrCode01.jpg" /><br />手机微商城</a></span>
                <span class="qrCode"><a href="#"><img src="themes/helen_keller/images/qrCode02.jpg" /><br />官方微信</a></span>
            </div>
		<div class="gift-main clearfix">
			<div class="gift-list clearfix">
				<ul class="gift-info clearfix">
				<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
					<?php if ($this->_var['goods']['goods_id']): ?>
					<li>
						<a target="_blank" href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" alt="" title="<?php echo $this->_var['goods']['goods_name']; ?>" /></a>
						<p><a target="_blank" href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>"><?php echo $this->_var['goods']['name']; ?></a></p>
						<div class="clearfix"><span><em><?php echo $this->_var['goods']['exchange_integral']; ?></em>积分+<em><?php echo $this->_var['goods']['goods_price']; ?></em>话费</span><a target="_blank" href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>">立即换购</a></div>
					</li>
					<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>
	<?php echo $this->fetch('library/pages.lbi'); ?>
			</div>
			<div class="gift-look">

				<dl>
					<dt>分类查找</dt>
					<?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
					<dd><span><?php echo htmlspecialchars($this->_var['cat']['name']); ?></span>
						<div>
						<a href="binfen.php?cid=<?php echo $this->_var['cat']['id']; ?>">全部</a>
						<?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['childs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['childs']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['childs']['iteration']++;
?>
							<a href="binfen.php?cid=<?php echo $this->_var['child']['id']; ?>" title="<?php echo htmlspecialchars($this->_var['child']['name']); ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						</div>
					</dd>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</dl>
				<div class="creditsexe clearfix">
					<ul class="credit-tit clearfix">
						<?php if (! empty ( $this->_var['surpluslist'] )): ?>
						  <li class="seletit">剩下积分还可兑换</li>
						  <li>你可能会喜欢的宝贝</li>
						<?php else: ?>
						  <li class="seletit">你可能会喜欢的宝贝</li>
						<?php endif; ?>
					</ul>
					<div class="credit-main">
						<?php if (! empty ( $this->_var['surpluslist'] )): ?>
						<ul class="clearfix credited">
							<?php $_from = $this->_var['surpluslist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
							<li>
								<a target="_blank" href="<?php echo $this->_var['list']['url']; ?>" title="<?php echo $this->_var['list']['name']; ?>"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>" alt="<?php echo $this->_var['list']['name']; ?>" title="<?php echo $this->_var['list']['name']; ?>" /></a>
								<span><em><?php echo $this->_var['list']['exchange_integral']; ?></em>积分+<em><?php echo $this->_var['list']['goods_price']; ?></em>话费</span>
								<p><a target="_blank" href="<?php echo $this->_var['list']['url']; ?>" title="<?php echo $this->_var['list']['name']; ?>"><?php echo $this->_var['list']['name']; ?></a></p>
							</li>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						</ul>
						<?php endif; ?>
						<ul class="clearfix <?php if (empty ( $this->_var['surpluslist'] )): ?>credited<?php endif; ?>">
							<?php $_from = $this->_var['maybe_like']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'like');if (count($_from)):
    foreach ($_from AS $this->_var['like']):
?>
							<li>
								 <a target="_blank" href="<?php echo $this->_var['like']['url']; ?>" title="<?php echo $this->_var['like']['name']; ?>"><img src="<?php echo $this->_var['like']['thumb']; ?>" alt="<?php echo $this->_var['like']['name']; ?>" title="<?php echo $this->_var['like']['name']; ?>" /></a>
								<span><em><?php echo $this->_var['like']['exchange_integral']; ?></em>积分+<em><?php echo $this->_var['like']['goods_price']; ?></em>话费</span>
								<p><a target="_blank" href="<?php echo $this->_var['like']['url']; ?>" title="<?php echo $this->_var['like']['name']; ?>"><?php echo $this->_var['like']['name']; ?></a></p>
							</li>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->fetch('library/help.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">

// 点击分类查找，内容隐藏/显示
$('.gift-look dd span').click(function(){
	$(this).parent().toggleClass('dd-seled');
	$(this).siblings('div').toggleClass('a-seled');
});

//积分切换与喜欢的宝贝的tab切换
$('.credit-tit > li').click(function(){
	$(this).addClass('seletit');
	$(this).siblings().removeClass('seletit');
  	$('.credit-main > ul').eq($(this).index()).addClass('credited').siblings().removeClass('credited');
})
</script>
</html>

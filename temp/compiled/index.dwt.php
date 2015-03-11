
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<title><?php echo $this->_var['page_title']; ?></title>




<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,index.js,user.js,transport.js,jquery-1.7.2.min.js')); ?>
<script type="text/javascript" src="themes/helen_keller/js/action.js"></script>
<script type="text/javascript" src="themes/helen_keller/js/scrollpic.js"></script>
<script type="text/javascript" src="themes/helen_keller/js/roll.js"></script>
<script>
var $m = jQuery.noConflict(); 
$m(document).scroll(function(){
	var t = parseInt($m(document).scrollTop());
	if(t < 650){
		t = 650;
	}
	if(t > $m(document).height() - $m('.sideBar').height() - 260){
		t = $m(document).height() - $m('.sideBar').height() - 260;
	}
	$m('.sideBar').css('top', t +'px');
});
</script>
</head>
<body>
<div class="clearfix">
   <?php echo $this->fetch('library/page_header.lbi'); ?>
</div>
<div class="pageBody index">
   
   <div class="clearfix" style="width:1662px;margin: 0 auto;height:536px;overflow:hidden;">
		<ul id="slidebur">
			<?php $_from = $this->_var['ad_main']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
?>
				<li id="c<?php echo $this->_var['key']; ?>" style="background:url(./data/afficheimg/<?php echo $this->_var['ad']['ad_code']; ?>) no-repeat;width:1662px;height:536px;"></li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
   </div>
   <script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
   <script type="text/javascript">
   	function slideMove(){ 	
		var picTimer;
		var index = 0;	
		var len = $("#slidebur li").length;

		picTimer=setInterval(function() {
					$("#slidebur li").hide();
					$("#c"+index).show();
					index++;
					if(index == len) {index = 0;}
				},5000); 
	}
   </script>
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
            <div class="fr mainBody">
                <h3 class="clearfix"><em class="fr">限时抢购，数量有限，售完提前下架</em><span id="index_title01" class="index_title01"></span></h3>
                
                <div class="index_ads clearfix">
                    <span class="fl">
                        
<?php $this->assign('ads_id','5'); ?><?php $this->assign('ads_num','0'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>


<?php $this->assign('ads_id','6'); ?><?php $this->assign('ads_num','0'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>

                    </span>
                    <span class="fr">
                        
<?php $this->assign('ads_id','2'); ?><?php $this->assign('ads_num','0'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>

                    </span>
                </div>
                <div class="index_ads clearfix">
                    <span class="fl">
                        
<?php $this->assign('ads_id','7'); ?><?php $this->assign('ads_num','0'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>


<?php $this->assign('ads_id','8'); ?><?php $this->assign('ads_num','0'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>

                    </span>
                    <span class="fr">
<?php $this->assign('ads_id','3'); ?><?php $this->assign('ads_num','0'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>
</span>
                </div>
                <div class="index_ads mb10">

<?php $this->assign('ads_id','4'); ?><?php $this->assign('ads_num','0'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>

                </div>
          
                <div class="clearfix" style="margin-bottom:10px;"><h3><em class="fr">更多优惠、更多惊喜、更多好礼</em><span id="index_title02" class="index_title02"></span></h3></div>
          
                <div class="indexPro clearfix">
		<div class="box">
	          <?php $_from = $this->_var['cat_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                    <div class="proBox">
		       <div class="proImg"><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_img']; ?>" /></a></div>
		       <div class="proName" title="<?php echo $this->_var['goods']['name']; ?>"><?php echo $this->_var['goods']['name']; ?></div>
		       <div class="proPri">
		         <span class="fl"><font color="#ce2625" size="4" style="font-weight:bold;"><?php echo $this->_var['goods']['exchange_integral']; ?></font><?php echo $this->_var['points_name']; ?>+<font color="#ce2625" size="4" style="font-weight:bold;"><?php echo $this->_var['goods']['goods_price']; ?></font>话费</span>
			 <span class="fr"><a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)">立刻换购</a></span>
		       </div>
		    </div>
		  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		  </div>
	        </div>
            </div>
   </div>
</div>
<?php echo $this->fetch('library/right.lbi'); ?>
<div class="blank"></div>
<?php echo $this->fetch('library/help.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>

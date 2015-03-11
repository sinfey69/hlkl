<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,shopping_flow.js')); ?>
<script type="text/javascript" src="themes/helen_keller/js/action.js"></script>

</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="block1 clearfix">
<?php echo $this->fetch('library/ur_here.lbi'); ?>
</div>

<div class="block1" style="min-height:480px;">
<?php if ($this->_var['step'] == "cart"): ?>
<div class="flow clearfix">
	<div class="flow-steps clearfix">
		<dl>
			<dt class="flow-sele-dt"><em class="flow-sele-em">1</em></dt>
			<dd class="flow-sele-dd">1.我的购物车</dd>
		</dl>
		<dl>
			<dt><em>2</em></dt>
			<dd>2.填写核对订单信息</dd>
		</dl>
		<dl>
			<dt><em>3</em></dt>
			<dd>3.成功提交订单</dd>
		</dl>
		<dl>
			<dt><em>4</em></dt>
			<dd>4.确认收货</dd>
		</dl>
		<dl>
			<dt><em>5</em></dt>
			<dd>5.评价</dd>
		</dl>
	</div>
</div>
<div class="shopcart">
	<form action="">
		<ul class="cart-tit">
			<li class="th-chk clearfix">
				<em></em>全选
			</li>
			<li class="th-item"><?php echo $this->_var['lang']['goods_name']; ?></li>
			<li class="th-info"><?php echo $this->_var['lang']['goods_attr']; ?></li>
			<li class="th-price"><?php echo $this->_var['lang']['unit_price']; ?></li>
			<li class="th-amount"><?php echo $this->_var['lang']['number']; ?></li>
			<li class="th-op"><?php echo $this->_var['lang']['handle']; ?></li>
		</ul>
		<div class="cart-con clearfix">
		<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
			<ul class="cart-order">
				<li class="td-chk clearfix">
					<em name="<?php echo $this->_var['goods']['rec_id']; ?>" data-id="<?php echo $this->_var['goods']['rec_id']; ?>" <?php if ($this->_var['goods']['now_buy']): ?>class="selcbx-on"<?php endif; ?>></em>
				</li>
				<li class="td-item">
					<?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?>
					<?php if ($this->_var['show_goods_thumb'] == 1): ?>
						<a href="exchange.php?id=<?php echo $this->_var['goods']['goods_id']; ?>&act=view" target="_blank"><?php echo $this->_var['goods']['goods_name']; ?></a>
					<?php elseif ($this->_var['show_goods_thumb'] == 2): ?>
						<a href="exchange.php?id=<?php echo $this->_var['goods']['goods_id']; ?>&act=view" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" border="0" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" /></a>
					<?php else: ?>
						<a href="exchange.php?id=<?php echo $this->_var['goods']['goods_id']; ?>&act=view" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" border="0" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" /><p><?php echo $this->_var['goods']['goods_name']; ?></p></a>
					<?php endif; ?>
					<?php if ($this->_var['goods']['parent_id'] > 0): ?>
					<span style="color:#FF0000">（<?php echo $this->_var['lang']['accessories']; ?>）</span>
					<?php endif; ?>
					<?php if ($this->_var['goods']['is_gift'] > 0): ?>
					<span style="color:#FF0000">（<?php echo $this->_var['lang']['largess']; ?>）</span>
					<?php endif; ?>
					<?php elseif ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] == 'package_buy'): ?>
					<a href="javascript:void(0)" onclick="setSuitShow(<?php echo $this->_var['goods']['goods_id']; ?>)" class="f6"><?php echo $this->_var['goods']['goods_name']; ?><span style="color:#FF0000;">（<?php echo $this->_var['lang']['remark_package']; ?>）</span></a> <img src="themes/helen_keller/images/package.gif" />
					<div id="suit_<?php echo $this->_var['goods']['goods_id']; ?>" style="display:none;">
							<?php $_from = $this->_var['goods']['package_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'package_goods_list');if (count($_from)):
    foreach ($_from AS $this->_var['package_goods_list']):
?>
								<a href="goods.php?id=<?php echo $this->_var['package_goods_list']['goods_id']; ?>" target="_blank" class="f6"><?php echo $this->_var['package_goods_list']['goods_name']; ?></a><br />
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</div>
				<?php else: ?>
				<?php echo $this->_var['goods']['goods_name']; ?>
				<?php endif; ?>
				</li>
				<li class="td-info">
					<div class="sel-info">
						<?php $_from = $this->_var['goods']['spe']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'spe');if (count($_from)):
    foreach ($_from AS $this->_var['spe']):
?>
						<ul class="sel-option">
							<?php $_from = $this->_var['spe']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'v');if (count($_from)):
    foreach ($_from AS $this->_var['v']):
?>
							<li attr-id="<?php echo $this->_var['v']['id']; ?>" title="<?php echo $this->_var['spe']['name']; ?>：<?php echo $this->_var['v']['label']; ?>"><?php echo $this->_var['spe']['name']; ?>：<?php echo $this->_var['v']['label']; ?></li>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						</ul>
						<em></em>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</div>
				</li>
				<li class="td-price"><?php echo $this->_var['goods']['exchange_integral']; ?><?php echo $this->_var['points_name']; ?>+<?php echo $this->_var['goods']['goods_price']; ?></li>
				<li class="td-amount">
					<div class="item-amount">
					<?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['is_gift'] == 0 && $this->_var['goods']['parent_id'] == 0): ?>
					<a href="javascript:void(0);" title="" class="amount-minus">-</a>
						<input id="goods_number_<?php echo $this->_var['goods']['rec_id']; ?>" type="text" value="<?php echo $this->_var['goods']['goods_number']; ?>" size="4" >
					<a href="javascript:void(0);" title="" class="amount-plus">+</a>
					<?php else: ?>
						<?php echo $this->_var['goods']['goods_number']; ?>
					<?php endif; ?>
					</div>
				</li>
				<li class="td-op">
					<?php if ($_SESSION['user_id'] > 0): ?>
					<a href="location.href='flow.php?step=drop_to_collect&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>'; " ><?php echo $this->_var['lang']['drop_to_collect']; ?></a>
					<?php endif; ?>
					<a href="javascript:if (confirm('<?php echo $this->_var['lang']['drop_goods_confirm']; ?>')) location.href='flow.php?step=drop_goods&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>'; " ><?php echo $this->_var['lang']['drop']; ?></a>

				</li>
			</ul>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>

		<ul class="cart-accounts clearfix">
			<li class="acc-chk">
				<em></em>全选
			</li>
			<li class="acc-del">删除</li>
			<li class="acc-buy"><a href="binfen.php" title="继续购买">继续购买</a></li>
			<li class="acc-sel">已选商品: <strong><?php echo $this->_var['total']['buy_goods_count']; ?></strong> 件</li>
			<li class="acc-inte">合计积分: <strong><?php echo $this->_var['total']['buy_integral_amount']; ?></strong> 分</li>
			<li class="acc-tele">合计话费: <strong><?php echo $this->_var['total']['buy_goods_amount']; ?></strong> 元</li>
			<li class="acc-sum"><a href="flow.php?step=checkout" title="去结算">去结算 &gt;</a></li>
		</ul>
	</form>
</div>
<div class="creditsexe credit-bottom">
	<div class="creditit clearfix">
	    <ul class="clearfix">
		<?php if (! empty ( $this->_var['surpluslist'] )): ?>
	      <li class="seletit">剩下积分还可兑换</li>
		  <li>你可能会喜欢的宝贝</li>
		<?php else: ?>
	      <li class="seletit">你可能会喜欢的宝贝</li>
		<?php endif; ?>
	    </ul>
	    <div class="creadit-hint">
	    	除去以上所花积分，您当前还剩<em><?php echo $this->_var['residue_integral']; ?></em>积分，可以继续购物
	    </div>
    </div>
    <div class="creditcon clearfix">
	<?php if (! empty ( $this->_var['surpluslist'] )): ?>
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
	  <?php endif; ?>
      <div <?php if (empty ( $this->_var['surpluslist'] )): ?>class="selecon"<?php endif; ?>>
		<?php $_from = $this->_var['maybe_like']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'like');if (count($_from)):
    foreach ($_from AS $this->_var['like']):
?>
        <dl>
          <dt class="clearfix">
            <a href="<?php echo $this->_var['like']['url']; ?>" title="<?php echo $this->_var['like']['name']; ?>">
              <img src="<?php echo $this->_var['like']['thumb']; ?>" alt="<?php echo $this->_var['like']['name']; ?>" title="<?php echo $this->_var['like']['name']; ?>" />
            </a>
           </dt>
          <dd>
            <strong><?php echo $this->_var['like']['exchange_integral']; ?></strong><span>积分 + </span><strong><?php echo $this->_var['like']['goods_price']; ?></strong><span>话费</span>
            <p><?php echo $this->_var['like']['name']; ?></p>
          </dd>
        </dl>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </div>
    </div>
 </div>
 <?php if ($_SESSION['user_id'] > 0): ?>
 <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js')); ?>
 <script type="text/javascript" charset="utf-8">
	function collect_to_flow(goodsId)
	{
		var goods        = new Object();
		var spec_arr     = new Array();
		var fittings_arr = new Array();
		var number       = 1;
		goods.spec     = spec_arr;
		goods.goods_id = goodsId;
		goods.number   = number;
		goods.parent   = 0;
		Ajax.call('flow.php?step=add_to_cart', 'goods=' + goods.toJSONString(), collect_to_flow_response, 'POST', 'JSON');
	}
	function collect_to_flow_response(result)
        {
          if (result.error > 0)
          {
            // 如果需要缺货登记，跳转
            if (result.error == 2)
            {
              if (confirm(result.message))
              {
                location.href = 'user.php?act=add_booking&id=' + result.goods_id;
              }
            }
            else if (result.error == 6)
            {
              openSpeDiv(result.message, result.goods_id);
            }
            else
            {
              alert(result.message);
            }
          }
          else
          {
            location.href = 'flow.php';
          }
        }
</script>

<?php endif; ?>
<script type="text/javascript">
$(function() {
	window.__Object_toJSONString = Object.prototype.toJSONString;
	delete Object.prototype.toJSONString;
});

// 实现推荐商品功能：剩余积分可兑换的商品推荐，进行tab切换
var clickTab = function(){
	$('.creditit li').click(function(){
	   $(this).addClass('seletit').siblings().removeClass('seletit');
	   $('.creditcon div').eq($(this).index()).addClass('selecon').siblings().removeClass('selecon');
	})
}
clickTab();

//鼠标移入，出现下拉框效果
$(".sel-option").hover(function(){
	var selOptionLen = $(this).find('li').length;
	$(this).css({
		'overflow':'visible',
		'background':'#F7F7F7'
	})
	$(this).stop().animate({
		'height' : 26 * selOptionLen + 'px'
	})
},function(){
	$(this).css({
		'overflow':'hidden'
	})
	$(this).stop().animate({
		"height":"26px"
	})
});


//实现点击ul中并选中li在div中显示
$('.sel-option li').click(function(){
  $(this).prependTo($(this).parent());
  $(this).parent().css({'overflow':'hidden'});
  $(this).parent().stop().animate({'height':"26px"},300);
  var spec = $(this).attr('attr-id');
  var rec_id = $(this).parent().parent().parent().siblings('.td-chk').children().eq(0).attr('data-id');
  Ajax.call('flow.php?step=update_attr', 'id=' + rec_id+'&spec='+spec, accounts, 'POST', 'JSON');
})

//点击减，商品数量减一
var amoutInput;
$('.amount-minus').click(function(){
	amoutInput = $(this).siblings('input');
	var amountNow = parseInt(amoutInput.val());
	if(amountNow == 1) {
		$(this).css({'disabled':'true',cursor: "not-allowed"});
	}
	else {
		var Obj = $(this).parent().parent().siblings('.td-chk').children().eq(0);
		var rec_id = new Array();
		rec_id = Obj.attr('data-id');
		var buy = (Obj.hasClass('selcbx-on').toString() == 'false') ? 0 : 1;
		amountNow--;
		amoutInput.val(amountNow);
		updateBuy(rec_id,buy,amountNow);
	}

})

//点击加，商品数量加一
$('.amount-plus').click(function(){
	amoutInput = $(this).siblings('input');
	var amountNow = parseInt(amoutInput.val());
	var Obj = $(this).parent().parent().siblings('.td-chk').children().eq(0);
	var rec_id = new Array();
	rec_id = Obj.attr('data-id');
	var buy = (Obj.hasClass('selcbx-on').toString() == 'false') ? 0 : 1;
	amountNow++;
	amoutInput.val(amountNow);
	$(this).siblings('a').css({cursor: "pointer"});
	updateBuy(rec_id,buy,amountNow);
})

//实现让用户输入数字
$('.item-amount input').blur(function(){
	var strInput = $(this).val();
	var reg = /^[1-9]\d*$/;
	if(!reg.exec(strInput)) {
		strInput = 1;
	}
	$(this).val(strInput);
	var rec_id = new Array();
	var Obj = $(this).parent().parent().siblings('.td-chk').children().eq(0);
	rec_id = Obj.attr('data-id');
	var buy = (Obj.hasClass('selcbx-on').toString() == 'false') ? 0 : 1;
	updateBuy(rec_id,buy,strInput);
})

//购物车实现勾选功能
//全选功能
function allSelcet(elem){
	$(elem).eq(0).click(function(){
		var hasBoolen = $(this).find('em').hasClass('selcbx-on').toString();
		var buy = (hasBoolen == 'false') ? 1 : 0;
		if(hasBoolen == 'false') {
			$(this).find('em').addClass('selcbx-on');
			$('.th-chk em').addClass('selcbx-on');
			$('.td-chk em').addClass('selcbx-on');
			$('.acc-chk em').addClass('selcbx-on');
		} else {
			$(this).find('em').removeClass('selcbx-on');
			$('.th-chk em').removeClass('selcbx-on');
			$('.td-chk em').removeClass('selcbx-on');
			$('.acc-chk em').removeClass('selcbx-on');
		}
		var rec_id = new Array();
		$('.td-chk em').each(function(index){
			rec_id[rec_id.length] = $(this).attr('data-id');
		}); 
		updateBuy(rec_id,buy,0);
	}) 
}
allSelcet('.cart-tit li');//前面的全选
allSelcet('.cart-accounts li');//后面的全选

//点击每一个子项
$('.td-chk em').click(function(){
	var hasBoolen = $(this).hasClass('selcbx-on').toString();
	var rec_id = new Array();
	rec_id = $(this).attr('data-id');
	var buy = (hasBoolen == 'false') ? 1 : 0;

	if(hasBoolen == 'false') {
		$(this).addClass('selcbx-on');
	}else {
		$(this).removeClass('selcbx-on');
		$('.cart-tit .th-chk em').removeClass('selcbx-on');
		$('.cart-accounts .acc-chk em').removeClass('selcbx-on');
	}
	updateBuy(rec_id,buy,0);
})
$('.acc-del').click(function(){
	if (confirm('<?php echo $this->_var['lang']['drop_goods_confirm']; ?>')){
		var rec_ids = new Array();
		$('.td-chk em').each(function(index){
			if($(this).hasClass('selcbx-on').toString() == 'true'){

				rec_ids[rec_ids.length] = $(this).attr('data-id');
			}
		}); 	
		if(rec_ids.length > 0){		
			Ajax.call('flow.php?step=batch_drop_goods', 'ids=' + rec_ids, accounts, 'POST', 'JSON');
		}
	}
})
function updateBuy(rec_id,buy,num){
	Ajax.call('flow.php?step=update_cart', 'id=' + rec_id+'&buy='+buy+'&num='+num, accounts, 'POST', 'JSON');
}

function accounts(result){
	if(result.code == 1){
		$('.acc-sel strong').html(result.data.buy_goods_count);
		$('.acc-inte strong').html(result.data.buy_integral_amount);
		$('.acc-tele strong').html(result.data.buy_goods_amount);
		$('.creadit-hint em').html(result.data.residue_integral);
	}else if(result.code == -2){
		alert(result.message);
		$('#goods_number_'+result.data.id).val(result.data.num);
	}else if(result.code == -3){
		alert(result.message);
		window.location.href="flow.php?step=cart";
	}else if(result.code == 777){
		window.location.href="flow.php?step=cart";
	}
}
</script>
<?php endif; ?>


<?php if ($this->_var['step'] == "consignee"): ?>

<div class="blank"></div>
<?php echo $this->smarty_insert_scripts(array('files'=>'region.js,utils.js')); ?>
<script type="text/javascript">
	region.isAdmin = false;
	<?php $_from = $this->_var['lang']['flow_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
	var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

	
	onload = function() {
		if (!document.all)
		{
			document.forms['theForm'].reset();
		}
	}
	
</script>

<?php $_from = $this->_var['consignee_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('sn', 'consignee');if (count($_from)):
    foreach ($_from AS $this->_var['sn'] => $this->_var['consignee']):
?>
<form action="flow.php" method="post" name="theForm" id="theForm" onsubmit="return checkConsignee(this)">
<?php echo $this->fetch('library/consignee.lbi'); ?>
</form>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>

<?php if ($this->_var['step'] == "checkout"): ?>
<div class="flow clearfix">
	<div class="flow-steps clearfix">
		<dl>
			<dt><em>1</em></dt>
			<dd>1.我的购物车</dd>
		</dl>
		<dl>
			<dt class="flow-sele-dt"><em class="flow-sele-em">2</em></dt>
			<dd class="flow-sele-dd">2.填写核对订单信息</dd>
		</dl>
		<dl>
			<dt><em>3</em></dt>
			<dd>3.成功提交订单</dd>
		</dl>
		<dl>
			<dt><em>4</em></dt>
			<dd>4.确认收货</dd>
		</dl>
		<dl>
			<dt><em>5</em></dt>
			<dd>5.评价</dd>
		</dl>
	</div>
</div>
<div class="deteaddress" id="ECS_ADDRESSLIST">
	<?php echo $this->fetch('library/checkout_address.lbi'); ?>
</div>
<div class="deteinfo">
	<h3>确定订单信息：</h3>
	<form action="flow.php" method="post" name="theForm" id="theForm" onsubmit="return checkOrderForm(this)">
	<script type="text/javascript">
	var flow_no_payment = "<?php echo $this->_var['lang']['flow_no_payment']; ?>";
	var flow_no_shipping = "<?php echo $this->_var['lang']['flow_no_shipping']; ?>";
	</script>
		<div style="display:none">
			<?php if ($this->_var['total']['real_goods_count'] != 0): ?>
				<?php $_from = $this->_var['shipping_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shipping');if (count($_from)):
    foreach ($_from AS $this->_var['shipping']):
?>
				<input name="shipping" type="radio" value="<?php echo $this->_var['shipping']['shipping_id']; ?>" <?php if (($this->_foreach['iteration']['iteration'] <= 1)): ?>checked="true"<?php endif; ?> supportCod="<?php echo $this->_var['shipping']['support_cod']; ?>" insure="<?php echo $this->_var['shipping']['insure']; ?>" onclick="selectShipping(this)" /><?php echo $this->_var['shipping']['shipping_name']; ?>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			<?php else: ?>
			<input name = "shipping" type="radio" value = "-1" checked="checked"/>
			<?php endif; ?>
		</div>	
		<div id="" class="deteinfo-tab">
			<ul id="" class="detetit">
				<li class="deti-treasure">商品</li>
				<li class="deti-price">单价</li>
				<li class="deti-amount"><?php echo $this->_var['lang']['number']; ?></li>
				<li class="deti-integ">积分小计</li>
				<li class="deti-call">话费小计</li>
			</ul>
			<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
			<ul id="" class="detecon clearfix">
				<li class="deco-treasure">
					<dl class="clearfix">
						<?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] == 'package_buy'): ?>
						<dt>
							<a href="#" title="图片">
								<img src="themes/helen_keller/images/shop_item0.jpg" alt="图片" title="图片" />
							</a>
						</dt>
						<dd>
							<p><a href="javascript:void(0)" onclick="setSuitShow(<?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['goods_name']; ?><span style="color:#FF0000;">（<?php echo $this->_var['lang']['remark_package']; ?>）</span></a></p>
							<span><?php echo nl2br($this->_var['goods']['goods_attr']); ?></span>
							<div id="suit_<?php echo $this->_var['goods']['goods_id']; ?>" style="display:none">
									<?php $_from = $this->_var['goods']['package_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'package_goods_list');if (count($_from)):
    foreach ($_from AS $this->_var['package_goods_list']):
?>
							<a href="exchange.php?id=<?php echo $this->_var['package_goods_list']['goods_id']; ?>&act=view" target="_blank"><?php echo $this->_var['package_goods_list']['goods_name']; ?></a><br />
									<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							</div>
						</dd>
						<?php else: ?>
						<dt>
							<a href="exchange.php?id=<?php echo $this->_var['goods']['goods_id']; ?>&act=view"  title="<?php echo $this->_var['goods']['goods_name']; ?>">
								<img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" alt="<?php echo $this->_var['goods']['goods_name']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>" />
							</a>
						</dt>
						<dd>
							<p>
								<?php echo $this->_var['goods']['goods_name']; ?>
								<?php if ($this->_var['goods']['parent_id'] > 0): ?>
								<span style="color:#FF0000">（<?php echo $this->_var['lang']['accessories']; ?>）</span>
								<?php elseif ($this->_var['goods']['is_gift']): ?>
								<span style="color:#FF0000">（<?php echo $this->_var['lang']['largess']; ?>）</span>
								<?php endif; ?>
							</p>
							<span><?php echo nl2br($this->_var['goods']['goods_attr']); ?></span>
						</dd>
						<?php endif; ?>
					</dl>
				</li>
				<li class="deco-price"><?php echo $this->_var['goods']['integral']; ?>积分+<?php echo $this->_var['goods']['goods_price']; ?>元话费</li>
				<li class="deco-amount"><?php echo $this->_var['goods']['goods_number']; ?></li>
				<li class="deco-integ"><?php echo $this->_var['goods']['jfsubtotal']; ?>积分</li>
				<li class="deco-call"><?php echo $this->_var['goods']['subtotal']; ?>元话费</li>
			</ul>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			<div class="detemess ">
				<p>留言：<input type="textarea" name="postscript" id="postscript"/></p>
				<!-- <span>快递费：0.00元</span> -->
			</div>
			
		</div>
		<div class="detepayment clearfix" style="float: left;">
			<div class="dete-pay-le">
				<span>选择您的支付方式：</span>
				<?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>
				
				<label for="payment_<?php echo $this->_var['payment']['pay_id']; ?>" <?php if ($this->_var['payment']['pay_code'] == 'alipay'): ?>class="detalipay"<?php elseif ($this->_var['payment']['pay_code'] == 'umpay'): ?>class="dettel"<?php endif; ?>>
					<input id="payment_<?php echo $this->_var['payment']['pay_id']; ?>" type="radio" name="payment" value="<?php echo $this->_var['payment']['pay_id']; ?>" <?php if ($this->_var['order']['pay_id'] == $this->_var['payment']['pay_id']): ?>checked<?php endif; ?> isCod="<?php echo $this->_var['payment']['is_cod']; ?>" onclick="selectPayment(this)" <?php if ($this->_var['cod_disabled'] && $this->_var['payment']['is_cod'] == "1"): ?>disabled="true"<?php endif; ?>/>
					<em></em>
				</label>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
		</div>
		<div style="display:none;">
			<?php if ($this->_var['how_oos_list']): ?>
				<?php $_from = $this->_var['how_oos_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('how_oos_id', 'how_oos_name');if (count($_from)):
    foreach ($_from AS $this->_var['how_oos_id'] => $this->_var['how_oos_name']):
?>
				<label>
					<input name="how_oos" type="radio" value="<?php echo $this->_var['how_oos_id']; ?>" <?php if ($this->_var['order']['how_oos'] == $this->_var['how_oos_id']): ?>checked<?php endif; ?> onclick="changeOOS(this)" />
					<?php echo $this->_var['how_oos_name']; ?>
				</label>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			<?php endif; ?>
		</div>
		<div id="ECS_ORDERTOTAL">
		<?php echo $this->fetch('library/order_total.lbi'); ?>
		</div>
	</form>
</div>
<?php endif; ?>

<?php if ($this->_var['step'] == "done"): ?>
<div class="blank"></div>

<div class="orderSuccess">
 <div class="order_sn tc"><?php echo $this->_var['lang']['remember_order_number']; ?>：<font class="a"><?php echo $this->_var['order']['order_sn']; ?></font></div>
 <div class="shipping_name">
	<?php echo $this->_var['lang']['select_payment']; ?>： <strong><?php echo $this->_var['order']['pay_name']; ?></strong>。<br />
	<?php echo $this->_var['lang']['order_amount']; ?>： <strong class="f1"><?php echo $this->_var['total']['amount_formated']; ?></strong><br />
	&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_var['order']['pay_desc']; ?><br />
	<?php if ($this->_var['pay_online']): ?>
   <?php echo $this->_var['pay_online']; ?>
 <?php endif; ?>
 </div>
 <?php if ($this->_var['virtual_card']): ?>
 <div class="shipping_name">
 <?php $_from = $this->_var['virtual_card']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vgoods');if (count($_from)):
    foreach ($_from AS $this->_var['vgoods']):
?>
	<font class="f14b"><?php echo $this->_var['vgoods']['goods_name']; ?></font><br />
		<?php $_from = $this->_var['vgoods']['info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'card');if (count($_from)):
    foreach ($_from AS $this->_var['card']):
?>
			<?php if ($this->_var['card']['card_sn']): ?>
			<strong><?php echo $this->_var['lang']['card_sn']; ?>：</strong><font class="f1"><?php echo $this->_var['card']['card_sn']; ?></font><br />
			<?php endif; ?>
			<?php if ($this->_var['card']['card_password']): ?>
			<strong><?php echo $this->_var['lang']['card_password']; ?>：</strong><font class="f1"><?php echo $this->_var['card']['card_password']; ?></font><br />
			<?php endif; ?>
			<?php if ($this->_var['card']['end_date']): ?>
			<strong><?php echo $this->_var['lang']['end_date']; ?>：</strong><?php echo $this->_var['card']['end_date']; ?><br />
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </div>
 <?php endif; ?>
	<p>现在，<?php echo $this->_var['order_submit_back']; ?></p>
</div>
<?php endif; ?>


<?php if ($this->_var['step'] == "login"): ?>
<div class="blank"></div>
<?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,user.js')); ?>
<script type="text/javascript">
<?php $_from = $this->_var['lang']['flow_login_register']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
	var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>


function checkLoginForm(frm) {
	if (Utils.isEmpty(frm.elements['username'].value)) {
		alert(username_not_null);
		return false;
	}

	if (Utils.isEmpty(frm.elements['password'].value)) {
		alert(password_not_null);
		return false;
	}

	return true;
}

function checkSignupForm(frm) {
	if (Utils.isEmpty(frm.elements['username'].value)) {
		alert(username_not_null);
		return false;
	}

	if (Utils.trim(frm.elements['username'].value).match(/^\s*$|^c:\\con\\con$|[%,\'\*\"\s\t\<\>\&\\]/))
	{
		alert(username_invalid);
		return false;
	}

	if (Utils.isEmpty(frm.elements['email'].value)) {
		alert(email_not_null);
		return false;
	}

	if (!Utils.isEmail(frm.elements['email'].value)) {
		alert(email_invalid);
		return false;
	}

	if (Utils.isEmpty(frm.elements['password'].value)) {
		alert(password_not_null);
		return false;
	}

	if (frm.elements['password'].value.length < 6) {
		alert(password_lt_six);
		return false;
	}

	if (frm.elements['password'].value != frm.elements['confirm_password'].value) {
		alert(password_not_same);
		return false;
	}
	return true;
}

</script>

<div class="clearfix">
 <div class="step_login fl">
  <h4>用户登录</h4>
	<form action="flow.php?step=login" method="post" name="loginForm" id="loginForm" onsubmit="return checkLoginForm(this)">
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
					<tr>
						<td width="30%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['username']; ?></td>
						<td width="70%" bgcolor="#ffffff"><input name="username" type="text" class="InputBorder" id="username" /></td>
					</tr>
					<tr>
						<td align="right" bgcolor="#ffffff" valign="top"><?php echo $this->_var['lang']['password']; ?></td>
						<td bgcolor="#ffffff">
						<input name="password" class="InputBorder" type="password" />
						<a href="#blank" onclick="pwTips()"><?php echo $this->_var['lang']['get_password']; ?>？</a><br />
						<div class="close" id="tips">
						<span title="关闭" id="tipsClose" onclick=" pwTipsClose()"></span>
						如果您忘记了密码，可以通过下面两种方式找回：<br />
						1. <a href="user.php?act=qpassword_name"><?php echo $this->_var['lang']['get_password_by_question']; ?></a><br />
						2. <a href="user.php?act=get_password"><?php echo $this->_var['lang']['get_password_by_mail']; ?></a>
						</div>
						<script type="text/javascript">
						function pwTips(){
						document.getElementById("tips").style.display = "block";
						}
						function pwTipsClose(){
						document.getElementById("tips").style.display = "none";
						}
						</script>
						</td>
					</tr>
					<?php if ($this->_var['enabled_login_captcha']): ?>
					<tr>
						<td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['comment_captcha']; ?></td>
						<td bgcolor="#ffffff"><input type="text" size="8" name="captcha" class="InputBorder" />
						<img src="captcha.php?is_login=1&<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onclick="this.src='captcha.php?is_login=1&'+Math.random()" /> </td>
					</tr>
					<?php endif; ?>
					<tr>
						<td align="right" bgcolor="#ffffff">&nbsp;</td>
						<td bgcolor="#ffffff"><input type="checkbox" value="1" name="remember" id="remember" /><label for="remember"><?php echo $this->_var['lang']['remember']; ?></label></td>
          </tr>
					<tr>
						<td colspan="2" align="center" bgcolor="#ffffff">
								<input type="submit" class="bnt_number2" name="login" value="<?php echo $this->_var['lang']['forthwith_login']; ?>" />
								<?php if ($this->_var['anonymous_buy'] == 1): ?>
								<input type="button" class="bnt_number10" value="<?php echo $this->_var['lang']['direct_shopping']; ?>" onclick="location.href='flow.php?step=consignee&amp;direct_shopping=1'" />
								<?php endif; ?>
								<input name="act" type="hidden" value="signin" />
						</td>
					</tr>
		</table>
	</form>
 </div>
 <div class="step_login fr">
 <h4 class="h4bg">用户注册</h4>
<form action="flow.php?step=login" method="post" name="formUser" id="registerForm" onsubmit="return checkSignupForm(this)">
	 <table width="100%" border="0" cellpadding="5" cellspacing="0" >
			<tr>
				<td bgcolor="#ffffff" align="right" width="25%"><?php echo $this->_var['lang']['username']; ?></td>
				<td bgcolor="#ffffff"><input name="username" type="text" class="InputBorder" id="username" onblur="is_registered(this.value);" /><br />
<span id="username_notice" style="color:#FF0000"></span></td>
			</tr>
			<tr>
				<td bgcolor="#ffffff" align="right"><?php echo $this->_var['lang']['email_address']; ?></td>
				<td bgcolor="#ffffff"><input name="email" type="text" class="InputBorder" id="email" onblur="checkEmail(this.value);" /><br />
<span id="email_notice" style="color:#FF0000"></span></td>
			</tr>
			<tr>
				<td bgcolor="#ffffff" align="right"><?php echo $this->_var['lang']['password']; ?></td>
				<td bgcolor="#ffffff"><input name="password" class="InputBorder" type="password" id="password1" onblur="check_password(this.value);" onkeyup="checkIntensity(this.value)" /><br />
<span style="color:#FF0000" id="password_notice"></span></td>
			</tr>
			<tr>
				<td bgcolor="#ffffff" align="right"><?php echo $this->_var['lang']['confirm_password']; ?></td>
				<td bgcolor="#ffffff"><input name="confirm_password" class="InputBorder" type="password" id="confirm_password" onblur="check_conform_password(this.value);" /><br />
<span style="color:#FF0000" id="conform_password_notice"></span></td>
			</tr>
			<?php if ($this->_var['enabled_register_captcha']): ?>
			<tr>
				<td bgcolor="#ffffff" align="right"><?php echo $this->_var['lang']['comment_captcha']; ?>:</td>
				<td bgcolor="#ffffff"><input type="text" size="8" name="captcha" class="InputBorder" />
				<img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onclick="this.src='captcha.php?'+Math.random()" /> </td>
			</tr>
			<?php endif; ?>
			<tr>
				<td colspan="2" bgcolor="#ffffff" align="center">
						<input type="submit" name="Submit" class="bnt_number6" value="<?php echo $this->_var['lang']['forthwith_register']; ?>" />
						<input name="act" type="hidden" value="signup" />
				</td>
			</tr>
		</table>
	</form>
 </div>
</div>

<?php endif; ?>
</div>



</div>


<?php echo $this->fetch('library/help.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
<?php $_from = $this->_var['lang']['passport_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var username_exist = "<?php echo $this->_var['lang']['username_exist']; ?>";
var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
</script>
</html>

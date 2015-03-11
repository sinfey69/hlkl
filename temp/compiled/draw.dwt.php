<!DOCTYPE HTML>
<html>
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>


<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />


<?php echo $this->smarty_insert_scripts(array('files'=>'jquery-1.7.2.min.js')); ?>

<style>
.ur_here{width:780px;}

#rightDemo li{color:#333333; font-size:13px;width:257px;line-height:23px;height:23px;opacity:1;}
#rightDemo {width:257px; padding:10px;position:absolute; left:154px; top:242px;}
.rightBox{overflow: hidden;height:300px;}
</style>

</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="block1 clearfix" style="width:1097px;">
   <?php echo $this->fetch('library/ur_here.lbi'); ?>
</div>
<div class="blank"></div>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.js,jQueryRotate.2.2.js,jquery.easing.min.js,lottery.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'listtable.js')); ?>


<style>
.sure,.select{left: 350px;position: absolute;top: 250px;width: 374px;}
.sure .s-up{background: none repeat scroll 0 0 #BCAB71;border: 4px solid #FFFFFF;border-radius: 5px;color: #000000;font-size: 22px;font-weight: bold;height: 80px;line-height: 80px;opacity: 0.85;text-align: center;width: 374px;}
.select{opacity: 0.95;text-align: center;background: none repeat scroll 0 0 #BCAB71;border: 4px solid #FFFFFF;border-radius: 5px;color: #000000;font-size: 16px;height:auto;width: 700px;}
.select table {width:100%;padding: 10px;text-align: center;}
.select th {font-size:20px;font-weight: bold;}
.select td {height:30px;padding: 10px 10px 0px 10px;line-height: 20px;}
.sure .s-down{background: none repeat scroll 0 0 #BCAB71;opacity: 0.85;width: 374px;height: 70px;margin-top: 4px;border: 4px solid #FFFFFF;border-radius: 5px;text-align: center;padding-top: 10px;}
.sure .s-botton{bottom: 0;height: 60px;left: 90px;position: absolute;top: 120px;}
.sure .s-botton span{padding: 0 20px;}

.botton1{cursor: pointer;width: 80px;height: 40px;background: #a72104;border: 2px solid #FFFFFF;border-radius: 5px;opacity: 1;color: #FFFFFF;font-size: 20px;text-align: center;font-weight: bold;}
.botton2{cursor: pointer;width: 80px;height: 40px;background: #bbac7a;border: 2px solid #FFFFFF;border-radius: 5px;opacity: 1;color: #FFFFFF;font-size: 20px;text-align: center;font-weight: bold;}

.get{top: 172px;left: 245px;background: none repeat scroll 0 0 #BCAB71;border: 4px solid #FFFFFF;border-radius: 5px;box-shadow: 2px 2px 10px #969696;min-height: 178px;opacity: 0.85;position: absolute;text-align: center;width: 574px;}
.get .g-b{color: #0360F5;font-size: 36px;line-height: 36px;padding-top: 15px;}
.get .g-c{color: #000000;line-height: 14px;font-size: 14px;padding: 15px 0;text-align: left;margin-left:50px;}
.g-c span{font-weight: bold;display: block;}
.g-c span,.g-c p{margin-bottom: 5px;}

.start{background: url(themes/helen_keller/images/start.png) no-repeat;height: 212px;left: 712px;position: absolute;top: 275px;width: 111px;cursor: pointer;}
td{vertical-align: middle;}
</style>

<div class="block1 clearfix" style="width:1097px;margin-bottom:20px;">
	<div style="position:relative;width:1097px;height:640px;background:url('<?php echo $this->_var['draw']['background_img']; ?>')">
		<div class="start"></div>
		<div id="rightDemo">
            <ul id="rightBox" class="rightBox">
				<?php if (! empty ( $this->_var['draw'] )): ?>
            	<?php $_from = $this->_var['draw_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
                	<li>用户<?php echo $this->_var['item']['mobile']; ?>抽中<?php echo $this->_var['item']['name']; ?></li>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				<?php else: ?>
				暂无中奖名单
				<?php endif; ?>
            </ul>
			<p style="padding-top: 5px;margin-left: 60px;"><a style="font-size: 14px;font-weight: bold;" id="show_select" href="javascript:void(0);">查看我的抽奖记录</a></p>
         </div>
         
        <div class="sure" style="display:none;">
        	<div class="s-up"><?php echo $this->_var['draw']['deduct']; ?>积分获得一次抽奖机会</div>
            <div class="s-down"></div>
            <div class="s-botton"><input type="button" value="确定" class="botton1" id="startbtn"/><span></span><input id="close_sure" type="button" value="退出" class="botton2"/></div>
        </div>
        <div class="select" style="display:none;">
			<div id="listDiv">
				<table>
					<tr>
						<th colspan="3">我的中奖情况</th>
					</tr>
					<tr>
						<td width="150px">抽奖时间</td>
						<td width="150px">奖项</td>
						<td width="250px">收货地址</td>
					</tr>
					<tr>
						<td colspan="3">加载中...</td>
					</tr>
				</table>
			</div>
			<div class="s-botton" style="padding-bottom: 10px;"><input type="button" value="关闭" id="close_select" class="botton2"/></div>
        </div>
	     <div class="get" style="display:none;">
	        <div class="g-b"></div>
	        <div class="g-c">
				<span>请选择您的收货地址</span>
				<form method="post" action="draw.php">
					<div id="address_list"></div>
					<input type="submit" value="提交">
					<input type="hidden" name="did" class="did" value=''>
					<input type="hidden" name="draw_id"  class="draw_id" value="" />
					<input type="hidden" name="act" value='address'>
				</form>
			</div>
			<div class="g-c" style="padding-top: 0px;">
				<span>使用新地址</span>
				<form method="post" action="draw.php" >
				<div>
					<table>
						<tr>
							<td align="right" width="70">收货人</td>
							<td><input class="txt2" type="text" id="consignee" name="consignee" value="<?php echo $this->_var['address']['consignee']; ?>"/></td>                             
						</tr>
						<tr>
							<td align="right">手机号码</td>
							<td><input class="txt2" type="text" id="mobile" name="mobile" value="<?php if ($this->_var['address']['mobile'] != ''): ?><?php echo $this->_var['address']['mobile']; ?><?php else: ?><?php echo $this->_var['address']['tel']; ?><?php endif; ?>" /></td>
						</tr>
						
						<tr>
							<td align="right">区域</td>
							<td>
								<select name="province" class="txt2" id="selProvinces" onchange="region.changed(this, 2, 'selCities')" >
								<option value="0">---请选择省---</option>
								<?php $_from = $this->_var['province_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
								<option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['province']['region_id'] == $this->_var['address']['province']): ?>selected<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							  </select>
								<select name="city" class="txt2" id="selCities" onchange="region.changed(this, 3, 'selDistricts')" style="display: none;">
									<option value="0">---请选择市---</option>
								  </select><select name="district" class="txt2" id="selDistricts" style="display: none;">
									<option value="0">---请选择区---</option>
								  </select>
							</td>
						</tr>
						
						<tr>
							 <td align="right">详细地址</td>
							 <td><input class="txt2" type="text" id="address" name="address" value="" size="50"/></td>
						</tr>
					</table>

				</div>
				<input type="submit" value="保存并使用新地址" onclick="return CheckForm();">
				<input type="hidden" name="did" class="did" value="">
				<input type="hidden" name="draw_id"  class="draw_id" value="" />
				<input type="hidden" name="act" value="new_address">
	        </form>
			</div>
	    </div>       
		<div style="position: absolute;bottom: 0;right: 5px;" class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more">分享到：</a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网">人人网</a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a></div>
		<script>
			$(function() {
				window.__Object_toJSONString = Object.prototype.toJSONString;
				delete Object.prototype.toJSONString;
			});
			window._bd_share_config = {
				"common": {
					"bdSnsKey": {},
					"bdText": "",
					"bdMini": "2",
					"bdMiniList": false,
					"bdPic": "",
					"bdStyle": "1",
					"bdSize": "16"
				},
				"share": {
					"bdSize": 16
				}
			};
			with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~ ( - new Date() / 36e5)];
		</script>
	</div>
	
	<div class="draw-info">
		<?php echo $this->_var['draw']['draw_desc']; ?>
	</div>
	
</div>


<?php echo $this->fetch('library/help.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>

<script type="text/javascript">
<?php $_from = $this->_var['lang']['clips_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

function CheckForm(){
	var consignee = $('#consignee').val();
	var mobile = $('#mobile').val();
	var Districts = $('#selDistricts').val();
	var address = $('#address').val();
	if(consignee == '' || mobile == '' || Districts < 1 || address == ''){
		alert('新地址信息请填写完整');
		return false;
	}else{

		return true;
	}
}
</script>
</html>
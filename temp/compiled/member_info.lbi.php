<?php if ($this->_var['user_info']): ?>
<b class="username">会员：<?php echo $this->_var['user_info']['username']; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $this->_var['lang']['hello']; ?>，<?php echo $this->_var['lang']['welcome_to']; ?><?php echo $this->_var['shop_name']; ?>！</b>&nbsp;&nbsp;
<?php echo $this->_var['user_info']['jf']; ?>&nbsp;&nbsp;
<a href="user.php?act=logout" style="color:#535353;"><?php echo $this->_var['lang']['user_logout']; ?></a>&nbsp;
<?php else: ?>
<?php echo $this->_var['lang']['welcome']; ?> <a  href="user.php" style="color: #535353">登录</a>&nbsp;|&nbsp;  
<a style="margin-right:10px;color: #535353" href="user.php?act=register">注册</a>&nbsp;
<?php endif; ?>
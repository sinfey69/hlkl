<div class="userMenu1 clearfix">
	  <span <?php if ($this->_var['action'] == 'default'): ?>class="curs"<?php endif; ?>><a href="user.php" <?php if ($this->_var['action'] == 'default'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_welcome']; ?></a></span>
	  <span <?php if ($this->_var['action'] == 'bonus'): ?>class="curs"<?php endif; ?>><a href="user.php?act=bonus" <?php if ($this->_var['action'] == 'bonus'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_bonus']; ?></a></span>
	  <span <?php if ($this->_var['action'] == 'profile'): ?>class="curs"<?php endif; ?>><a href="user.php?act=profile" <?php if ($this->_var['action'] == 'profile'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_profile']; ?></a></span>
	  <span <?php if ($this->_var['action'] == 'account_log'): ?>class="curs"<?php endif; ?>><a href="user.php?act=account_log" <?php if ($this->_var['action'] == 'account_log'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_user_surplus']; ?></a></span>
	  <span <?php if ($this->_var['action'] == 'order_list' || $this->_var['action'] == 'order_detail'): ?>class="curs"<?php endif; ?>><a href="user.php?act=order_list" <?php if ($this->_var['action'] == 'order_list' || $this->_var['action'] == 'order_detail'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_order']; ?></a></span>
	  <span <?php if ($this->_var['action'] == 'address_list'): ?>class="curs"<?php endif; ?>><a href="user.php?act=address_list" <?php if ($this->_var['action'] == 'address_list'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_address']; ?></a></span>
	  <!--<span><a href="user.php?act=collection_list"<?php if ($this->_var['action'] == 'collection_list'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_collection']; ?></a></span>-->
	  <!--<span><a href="user.php?act=message_list"<?php if ($this->_var['action'] == 'message_list'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_message']; ?></a></span>-->
	  <!--<span><a href="user.php?act=tag_list"<?php if ($this->_var['action'] == 'tag_list'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_tag']; ?></a></span>-->
	  <!--<span><a href="user.php?act=booking_list"<?php if ($this->_var['action'] == 'booking_list' || $this->_var['action'] == 'add_booking'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_booking']; ?></a></span>-->
	  <?php if ($this->_var['affiliate']['on'] == 1 && 0): ?>
	     <span><a href="user.php?act=affiliate"<?php if ($this->_var['action'] == 'affiliate'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_affiliate']; ?></a></span>
	  <?php endif; ?>
	  <!--<span><a href="user.php?act=comment_list"<?php if ($this->_var['action'] == 'comment_list'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_comment']; ?></a></span>-->
	  <!--<span><a href="user.php?act=group_buy"><?php echo $this->_var['lang']['label_group_buy']; ?></a></span>-->
	  <span <?php if ($this->_var['action'] == 'track_packages'): ?>class="curs"<?php endif; ?>><a href="user.php?act=track_packages" <?php if ($this->_var['action'] == 'track_packages'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_track_packages']; ?></a></span>
	  <?php if ($this->_var['show_transform_points']): ?>
	     <span><a href="user.php?act=transform_points"<?php if ($this->_var['action'] == 'transform_points'): ?>class="curs"<?php endif; ?>> <?php echo $this->_var['lang']['label_transform_points']; ?></a></span>
	  <?php endif; ?>
</div>
<div class="blank"></div>
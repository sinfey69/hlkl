<!-- $Id: exchange_goods_info.htm 15544 2009-01-09 01:54:28Z zblikai $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,selectzone.js,validator.js')); ?>
<!-- start draw form -->
<div class="tab-div">
<form action="exchange_draw.php" method="post" name="PrizeForm">
  <table width="90%" id="general-table">
    <tr>
      <td class="label"><?php echo $this->_var['lang']['prize_name']; ?>：</td>
      <td><input type="text" name="prize_name" maxlength="60" size="20" value="<?php echo $this->_var['prize']['prize_name']; ?>" /><?php echo $this->_var['lang']['require_field']; ?></td>
    </tr>
    <tr>
      <td class="label"><?php echo $this->_var['lang']['count_limit']; ?>：</td>
      <td><input type="text" name="count_limit" maxlength="10" size="10" value="<?php echo $this->_var['prize']['count_limit']; ?>" /><?php echo $this->_var['lang']['require_field']; ?>
	   	 &nbsp;<span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:inline" <?php else: ?> style="display:none" <?php endif; ?> id="noticepackagePrice"><?php echo $this->_var['lang']['notice_limit']; ?></span>
	  </td>
    </tr>
    <tr>
      <td class="label"><?php echo $this->_var['lang']['day_limit']; ?>：</td>
      <td><input type="text" name="day_limit" maxlength="10" size="10" value="<?php echo $this->_var['prize']['day_limit']; ?>" /><?php echo $this->_var['lang']['require_field']; ?>
	   	 &nbsp;<span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:inline" <?php else: ?> style="display:none" <?php endif; ?> id="noticepackagePrice"><?php echo $this->_var['lang']['notice_limit']; ?></span>
	  </td>
    </tr>
    <tr>
      <td class="label"><?php echo $this->_var['lang']['is_real']; ?>：</td>
      <td>
		<?php if ($this->_var['prize']): ?>
		<input name="is_real" type="radio" value="1" <?php if ($this->_var['prize']['is_real'] == 1): ?>checked="checked"<?php endif; ?>>是<input name="is_real" type="radio" value="0" <?php if ($this->_var['prize']['is_real'] == 0): ?>checked="checked"<?php endif; ?>>否
		<?php else: ?>
		<input name="is_real" type="radio" value="1"  checked="checked">是<input name="is_real" type="radio" value="0">否
		<?php endif; ?>
	  </td>
    </tr>
    <tr>
      <td class="label"><?php echo $this->_var['lang']['is_prize']; ?>：</td>
      <td>
		<?php if ($this->_var['prize']): ?>
		<input name="is_prize" type="radio" value="1" <?php if ($this->_var['prize']['is_prize'] == 1): ?>checked="checked"<?php endif; ?>>是<input name="is_prize" type="radio" value="0" <?php if ($this->_var['prize']['is_prize'] == 0): ?>checked="checked"<?php endif; ?>>否
		<?php else: ?>
		<input name="is_prize" type="radio" value="1" checked="checked">是<input name="is_prize" type="radio" value="0">否
		<?php endif; ?>
	   	 &nbsp;<span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:inline" <?php else: ?> style="display:none" <?php endif; ?> id="noticepackagePrice"><?php echo $this->_var['lang']['notice_prize']; ?></span>
	  </td>
    </tr>
    <tr>
      <td class="label"><?php echo $this->_var['lang']['angle']; ?>：</td>
      <td><textarea name="angle" cols="20" rows="5"><?php echo $this->_var['prize']['angle']; ?></textarea><?php echo $this->_var['lang']['require_field']; ?>
		  <br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="noticepackagePrice"><?php echo $this->_var['lang']['notice_angle']; ?></span>
	  </td>
    </tr>
	<tr>
      <td class="label"><?php echo $this->_var['lang']['odds']; ?>：</td>
      <td>
		<input type="text" name="odds" maxlength="10" size="10" value="<?php echo $this->_var['prize']['odds']; ?>" />%&nbsp;<?php echo $this->_var['lang']['require_field']; ?>
     	&nbsp;<span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:inline" <?php else: ?> style="display:none" <?php endif; ?> id="noticepackagePrice"><?php echo $this->_var['lang']['notice_odds']; ?></span>
	  </td>
    </tr>

</table>

  <div class="button-div">
    <input type="hidden" name="pid" value="<?php echo $this->_var['prize']['pid']; ?>" />
    <input type="hidden" name="did" value="<?php echo $this->_var['did']; ?>" />
	<input type="hidden" name="act" value="<?php echo $this->_var['form_action']; ?>" />
    <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button"  />
    <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />
  </div>
</form>
</div>
<!-- end goods form -->
<?php echo $this->fetch('pagefooter.htm'); ?>
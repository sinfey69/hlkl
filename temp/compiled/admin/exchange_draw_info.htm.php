<!-- $Id: exchange_goods_info.htm 15544 2009-01-09 01:54:28Z zblikai $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,selectzone.js,validator.js')); ?>
<script type="text/javascript" src="../js/calendar.php?lang=<?php echo $this->_var['cfg_lang']; ?>"></script>
<link href="../js/calendar/calendar.css" rel="stylesheet" type="text/css" />

<!-- start draw form -->
<div class="tab-div">
<form enctype="multipart/form-data" action="exchange_draw.php" method="post" name="DrawForm" onsubmit="return validate();">
  <table width="90%" id="general-table">
    <tr>
      <td class="label"><?php echo $this->_var['lang']['lab_draw_title']; ?></td>
      <td><input type="text" name="draw_title" maxlength="60" size="20" value="<?php echo $this->_var['draw']['draw_title']; ?>" /><?php echo $this->_var['lang']['require_field']; ?></td>
    </tr>
    <tr>
      <td class="narrow-label"><?php echo $this->_var['lang']['lab_draw_time']; ?></td>
      <td>
	      <input name="start_time" type="text" id="start_time" size="17" value='<?php echo $this->_var['draw']['start_time']; ?>' readonly="readonly" /><input name="selbtn1" type="button" id="selbtn1" onclick="return showCalendar('start_time', '%Y-%m-%d %H:%M', 24, false, 'selbtn1');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/> - <input name="end_time" type="text" id="end_time" size="17" value='<?php echo $this->_var['draw']['end_time']; ?>' readonly="readonly" /><input name="selbtn2" type="button" id="selbtn2" onclick="return showCalendar('end_time', '%Y-%m-%d %H:%M', 24, false, 'selbtn2');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/>
			<?php echo $this->_var['lang']['require_field']; ?>
	  </td>
    </tr>
	<tr>
		<td class="label"><?php echo $this->_var['lang']['lab_roulette_img']; ?></td>
		<td>
		  <input type="file" name="roulette_img" size="35" />
		  <?php if ($this->_var['draw']['roulette_img']): ?>
			<a href="../<?php echo $this->_var['draw']['roulette_img']; ?>" target="_blank"><img src="images/yes.gif" border="0" /></a>
		  <?php else: ?>
			<img src="images/no.gif" />
		  <?php endif; ?>
		  <?php echo $this->_var['lang']['require_field']; ?>
		</td>
	</tr>
	<tr>
		<td class="label"><?php echo $this->_var['lang']['lab_background_img']; ?></td>
		<td>
		  <input type="file" name="background_img" size="35" />
		  <?php if ($this->_var['draw']['background_img']): ?>
			<a href="../<?php echo $this->_var['draw']['background_img']; ?>" target="_blank"><img src="images/yes.gif" border="0" /></a>
		  <?php else: ?>
			<img src="images/no.gif" />
		  <?php endif; ?>
		  <?php echo $this->_var['lang']['require_field']; ?>
		</td>
	</tr>
	<tr>
      <td class="label"><?php echo $this->_var['lang']['lab_draw_deduct']; ?></td>
      <td><input type="text" name="deduct" maxlength="5" size="5" value="<?php echo $this->_var['draw']['deduct']; ?>" /><?php echo $this->_var['lang']['exchange_unit']; ?><?php echo $this->_var['lang']['require_field']; ?></td>
    </tr>
	<tr>
		<td class="label"><?php echo $this->_var['lang']['lab_draw_desc']; ?></td>
        <td><?php echo $this->_var['FCKeditor']; ?></td>
	</tr>
</table>

  <div class="button-div">
    <input type="hidden" name="did" value="<?php echo $this->_var['draw']['did']; ?>" />
    <input type="hidden" name="act" value="<?php echo $this->_var['form_action']; ?>" />
    <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button"  />
    <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />
  </div>
</form>
</div>
<!-- end goods form -->
<script type="Text/Javascript" language="JavaScript">
function validate()
{
	validator = new Validator("DrawForm");
    validator.islt('start_time', 'end_time', '活动开始时间不能大于结束时间');
    return validator.passed();
}
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<!-- $Id: exchange_draw_list.htm $ -->
<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js,../js/transport.js')); ?>

<form method="POST" action="exchange_draw.php?act=batch_remove_prize" name="listForm">
<!-- start cat list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

<table cellspacing='1' cellpadding='3' id='list-table'>
  <tr>
    <th>
		<input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox">
		<a href="javascript:listTable.sort('pid'); "><?php echo $this->_var['lang']['pid']; ?></a><?php echo $this->_var['sort_pid']; ?>
	</th>
    <th><a href="javascript:listTable.sort('prize_name'); "><?php echo $this->_var['lang']['prize_name']; ?></a><?php echo $this->_var['sort_prize_name']; ?></th>
    <th><a href="javascript:listTable.sort('count_limit'); "><?php echo $this->_var['lang']['count_limit']; ?></a><?php echo $this->_var['sort_count_limit']; ?></th>
    <th><a href="javascript:listTable.sort('day_limit'); "><?php echo $this->_var['lang']['day_limit']; ?></a><?php echo $this->_var['sort_day_limit']; ?></th>
    <th><a href="javascript:listTable.sort('is_real'); "><?php echo $this->_var['lang']['is_real']; ?></a><?php echo $this->_var['sort_is_real']; ?></th>
    <th><a href="javascript:listTable.sort('is_prize'); "><?php echo $this->_var['lang']['is_prize']; ?></a><?php echo $this->_var['sort_is_prize']; ?></th>
    <th><?php echo $this->_var['lang']['odds']; ?><font color="red">(<?php echo $this->_var['count_odds']; ?>%)</font></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['prize_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
  <tr>
    <td><span><input name="checkboxes[]" type="checkbox" value="<?php echo $this->_var['list']['pid']; ?>"/><?php echo $this->_var['list']['pid']; ?></span></td>
    <td class="first-cell"><span><?php echo htmlspecialchars($this->_var['list']['prize_name']); ?></span></td>
    <td align="center"><span><?php if ($this->_var['list']['count_limit'] == - 1): ?><?php echo $this->_var['lang']['no_limit']; ?><?php else: ?><?php echo $this->_var['list']['count_limit']; ?><?php endif; ?></span></td>
    <td align="center"><span><?php if ($this->_var['list']['day_limit'] == - 1): ?><?php echo $this->_var['lang']['no_limit']; ?><?php else: ?><?php echo $this->_var['list']['day_limit']; ?><?php endif; ?></span></td>
    <td align="center"><span><?php if ($this->_var['list']['is_real']): ?><?php echo $this->_var['lang']['yes']; ?><?php else: ?><?php echo $this->_var['lang']['no']; ?><?php endif; ?></span></td>
    <td align="center"><span><?php if ($this->_var['list']['is_prize']): ?><?php echo $this->_var['lang']['yes']; ?><?php else: ?><?php echo $this->_var['lang']['no']; ?><?php endif; ?></span></td>
    <td align="center"><span><?php echo $this->_var['list']['odds']; ?>%</span></td>
    <td align="center" nowrap="true"><span>
      <a href="exchange_draw.php?act=prize_edit&pid=<?php echo $this->_var['list']['pid']; ?>&did=<?php echo $this->_var['did']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" border="0" height="16" width="16" /></a>&nbsp;
      <a href="javascript:;" onclick="listTable.remove('<?php echo $this->_var['list']['pid']; ?>_<?php echo $this->_var['did']; ?>', '<?php echo $this->_var['lang']['drop_prize_confirm']; ?>','remove_prize')" title="<?php echo $this->_var['lang']['remove']; ?>"><img src="images/icon_drop.gif" border="0" height="16" width="16"></a></span>
    </td>
   </tr>
   <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="8"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td colspan="2">
		<input type="submit" class="button" id="btnSubmit" value="<?php echo $this->_var['lang']['button_remove']; ?>" disabled="true" />
		<input type="hidden" name="did" value="<?php echo $this->_var['did']; ?>" />
	</td>
    <td align="right" nowrap="true" colspan="8"><?php echo $this->fetch('page.htm'); ?></td>
  </tr>
</table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end cat list -->
<script type="text/javascript" language="JavaScript">
  listTable.query = 'prize_query';
  listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
  listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

  <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
  listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>

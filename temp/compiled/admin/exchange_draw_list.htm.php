<!-- $Id: exchange_draw_list.htm $ -->
<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js,../js/transport.js')); ?>

<div class="form-div">
  <form action="javascript:searchArticle()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <?php echo $this->_var['lang']['keywords']; ?> <input type="text" name="keyword" id="keyword" />
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<form method="POST" action="exchange_draw.php?act=batch_remove" name="listForm">
<!-- start cat list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

<table cellspacing='1' cellpadding='3' id='list-table'>
  <tr>
    <th>
		<input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox">
		<a href="javascript:listTable.sort('did'); "><?php echo $this->_var['lang']['did']; ?></a><?php echo $this->_var['sort_did']; ?>
	</th>
    <th><a href="javascript:listTable.sort('draw_title'); "><?php echo $this->_var['lang']['draw_title']; ?></a><?php echo $this->_var['sort_draw_title']; ?></th>
    <th><a href="javascript:listTable.sort('start_time'); "><?php echo $this->_var['lang']['start_time']; ?></a><?php echo $this->_var['sort_start_time']; ?></th>
    <th><a href="javascript:listTable.sort('end_time'); "><?php echo $this->_var['lang']['end_time']; ?></a><?php echo $this->_var['sort_end_time']; ?></th>
    <th><a href="javascript:listTable.sort('deduct'); "><?php echo $this->_var['lang']['deduct']; ?></a><?php echo $this->_var['sort_deduct']; ?></th>
    <th><a href="javascript:listTable.sort('add_time'); "><?php echo $this->_var['lang']['add_time']; ?></a><?php echo $this->_var['sort_add_time']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['draw_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
  <tr>
    <td><span><input name="checkboxes[]" type="checkbox" value="<?php echo $this->_var['list']['did']; ?>"/><?php echo $this->_var['list']['did']; ?></span></td>
    <td class="first-cell"><span><?php echo htmlspecialchars($this->_var['list']['draw_title']); ?></span></td>
    <td align="center"><span><?php echo $this->_var['list']['start_time']; ?></span></td>
    <td align="center"><span><?php echo $this->_var['list']['end_time']; ?></span></td>
    <td align="center"><span><?php echo $this->_var['list']['deduct']; ?><?php echo $this->_var['lang']['exchange_unit']; ?></span></td>
    <td align="center"><span><?php echo $this->_var['list']['add_time']; ?></span></td>
    <td align="center" nowrap="true"><span>
      <a href="exchange_draw.php?did=<?php echo $this->_var['list']['did']; ?>&act=prize_list" title="<?php echo $this->_var['lang']['view_prize']; ?>"><img src="images/icon_docs.gif" border="0" height="16" width="16" /></a>&nbsp;
      <a href="exchange_draw.php?act=edit&did=<?php echo $this->_var['list']['did']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" border="0" height="16" width="16" /></a>&nbsp;
      <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['list']['did']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>"><img src="images/icon_drop.gif" border="0" height="16" width="16"></a></span>
    </td>
   </tr>
   <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="7"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td colspan="2"><input type="submit" class="button" id="btnSubmit" value="<?php echo $this->_var['lang']['button_remove']; ?>" disabled="true" /></td>
    <td align="right" nowrap="true" colspan="8"><?php echo $this->fetch('page.htm'); ?></td>
  </tr>
</table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end cat list -->
<script type="text/javascript" language="JavaScript">
  listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
  listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

  <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
  listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  

 /* 搜索文章 */
 function searchArticle()
 {
    listTable.filter.keyword = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
    listTable.filter.page = 1;
    listTable.loadList();
 }
 
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>

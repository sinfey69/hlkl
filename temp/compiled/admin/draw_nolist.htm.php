<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div">
<a href="draw.php?act=list">中奖信息列表</a>&nbsp;&nbsp;&nbsp;
<a href="draw.php?act=nolist" style="color: black;font-weight: bold;">未中奖信息列表</a>
</div>
<div class="form-div">
  <form action="javascript:searchMobile()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    抽奖手机号 <input type="text" name="mobile" id="mobile" />
	抽奖活动<select name="did">
		<option value="-1">-请选择-</option>
		<option value="0">未分类活动</option>
		<?php $_from = $this->_var['draw_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list_0_74584900_1419425149');if (count($_from)):
    foreach ($_from AS $this->_var['list_0_74584900_1419425149']):
?>
		<option value="<?php echo $this->_var['list_0_74584900_1419425149']['did']; ?>"><?php echo $this->_var['list_0_74584900_1419425149']['draw_title']; ?></option>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</select>
    <input type="submit" name="search" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
	<input type="button" onclick="draw_export();" name="export" value="导出" class="button" />
	</form>
	<form method="post" action="" name="exportForm">
		<input type="hidden" name="mobile" value="" />
		<input type="hidden" name="did" value="" />
		<input type="hidden" name="category" value="0" />
		<input type="hidden" name="act" value="export" />
  </form></div>
<form method="post" action="" name="listForm" onsubmit="return confirmSubmit(this)">
  <!-- start goods list -->
  <div class="list-div" id="listDiv">
<?php endif; ?>
<table cellpadding="3" cellspacing="1">
  <tr>
    <th>抽奖手机号</th>
	<th>活动</th>
	<th>扣除积分</th>
	<th>抽奖时间</th>
	<th>操作</th>
  <tr>
  <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'draw');if (count($_from)):
    foreach ($_from AS $this->_var['draw']):
?>
  <tr>
    <td style="text-align:center;"><?php echo $this->_var['draw']['mobile']; ?></td>
    <td style="text-align:center;"><?php echo $this->_var['draw']['lotteryTitle']; ?></td>
    <td style="text-align:center;"><font color="red"><?php echo $this->_var['draw']['deduct']; ?></font></td>
    <td style="text-align:center;"><?php echo $this->_var['draw']['intime']; ?></td>
    <td style="text-align:center;"><a href="javascript:delmsg(<?php echo $this->_var['draw']['id']; ?>);" title="删除">删除</a></td>
  </tr>
  <?php endforeach; else: ?>
  <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<!-- end goods list -->

<!-- 分页 -->
<table id="page-table" cellspacing="0">
  <tr>
    <td align="right" nowrap="true">
    <?php echo $this->fetch('page.htm'); ?>
    </td>
  </tr>
</table>

<?php if ($this->_var['full_page']): ?>
</div>
</form>
<script>
	function delmsg(id){
		if(confirm('你确定要删除吗')){
			location.href='draw.php?act=del&id='+id;
		}
	}
	function draw_export(){
		document.forms['exportForm'].elements['mobile'].value = document.forms['searchForm'].elements['mobile'].value;
		document.forms['exportForm'].elements['did'].value = document.forms['searchForm'].elements['did'].value;
		document.forms['exportForm'].submit();
    }  
</script>
<script type="text/javascript" language="JavaScript">
  listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
  listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

  <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
  listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  
  onload = function()
  {
    // 开始检查订单
    startCheckOrder();
  }
  function searchMobile(){
		listTable.filter.mobile = Utils.trim(document.forms['searchForm'].elements['mobile'].value);
		listTable.filter.did = Utils.trim(document.forms['searchForm'].elements['did'].value);
		listTable.filter.page = 1;
		listTable.loadList();
  }
  
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>
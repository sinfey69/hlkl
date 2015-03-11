<table>
	<tr>
		<th colspan="3">我的中奖情况</th>
	</tr>
	<tr>
		<td width="150px">抽奖时间</td>
		<td width="150px">奖项</td>
		<td width="250px">收货地址</td>
	</tr>
	<?php if (! empty ( $this->_var['drawlist'] )): ?>
	<?php $_from = $this->_var['drawlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
	<tr>
		<td><?php echo $this->_var['item']['intime']; ?></td>
		<td><?php echo $this->_var['item']['name']; ?></td>
		<td><?php if ($this->_var['item']['address_id'] == 0): ?>
		-
		<?php else: ?>
		<?php echo $this->_var['item']['province']; ?><?php echo $this->_var['item']['city']; ?><?php echo $this->_var['item']['district']; ?><?php echo $this->_var['item']['address']; ?>&nbsp;&nbsp;<?php echo $this->_var['item']['consignee']; ?>
		<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<?php else: ?>
	<tr>
		<td colspan="3">暂无抽奖记录</td>
	</tr>
	<?php endif; ?>
</table>
<div id="turn-page">
	共 <span id="totalRecords"><?php echo $this->_var['record_count']; ?></span> 条记录
	<span id="page-link">
	  <a href="javascript:listTable.gotoPageFirst()"><?php echo $this->_var['lang']['page_first']; ?></a>
	  <a href="javascript:listTable.gotoPagePrev()"><?php echo $this->_var['lang']['page_prev']; ?></a>
	  <a href="javascript:listTable.gotoPageNext()"><?php echo $this->_var['lang']['page_next']; ?></a>
	  <a href="javascript:listTable.gotoPageLast()"><?php echo $this->_var['lang']['page_last']; ?></a>
	  <select id="gotoPage" onchange="listTable.gotoPage(this.value)">
		<?php echo $this->smarty_create_pages(array('count'=>$this->_var['page_count'],'page'=>$this->_var['filter']['page'])); ?>
	  </select>
	</span>
</div>
<script type="text/javascript" language="javaScript">

	listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
	listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

	<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
	listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

</script>

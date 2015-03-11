<?php echo $this->fetch('pageheader.htm'); ?>
<script type="text/javascript" src="../js/calendar.php"></script>
<link href="../js/calendar/calendar.css" rel="stylesheet" type="text/css" />
<div class="main-div">
<form action="export_order.php?act=export_order_execl" method="post" name="searchForm" id="searchForm" target="">
  <table cellspacing="1" cellpadding="3" width="100%">  
    <tr>
      <td><div align="right"><strong>下单时间：</strong></div></td>
      <td>
      <input type="text" name="start_time" maxlength="40" size="12" readonly="readonly" id="start_time_id" value="<?php echo $this->_var['start_date']; ?>"/>
      <input name="start_time_btn" type="button" id="start_time_btn" onclick="return showCalendar('start_time_id', '%Y-%m-%d', '24', false, 'start_time_btn');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/>
      ~      
      <input type="text" name="end_time" maxlength="40" size="12" readonly="readonly" id="end_time_id" value="<?php echo $this->_var['end_date']; ?>"/>
      <input name="end_time_btn" type="button" id="end_time_btn" onclick="return showCalendar('end_time_id', '%Y-%m-%d', '24', false, 'end_time_btn');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/>  
      </td>
    </tr>
    <tr>
      <td>
        <div align="right"><strong>导出字段：</strong></div>
      </td>
      <td>
	  	  <label for="check_all">
            <input id="check_all" type="checkbox"/>全选
          </label>
		  <br>
        <?php $_from = $this->_var['field_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['field']):
?>
          <label for="field_<?php echo $this->_var['key']; ?>">
            <input class="export_field" id=field_<?php echo $this->_var['key']; ?> type="checkbox" name="export_field[]" value="<?php echo $this->_var['key']; ?>" checked/><?php echo $this->_var['field']; ?>
          </label>
          <?php if (( $this->_var['key'] + 1 ) % 7 == 0): ?>
          <br>
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </td>
    </tr> 
    <tr>
     <td></td>
      <td>
       <div align="left">
        <input name="export_order_execl" type="submit" class="button" value="导出订单报表" /> 
      </div>
      </td>
      </tr>
  </table>
</form>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/jquery-1.7.2.min.js')); ?>

<script language="JavaScript">
	$('#check_all').click(function(){
		if ($(this).attr("checked")) {  
		    $(".export_field").each(function(){
				$(this).attr("checked", true);
			});    
		}else{  	
			$(".export_field").each(function(){
				$(this).attr("checked", false);  
		    });  
		 }
    })
</script>


<?php echo $this->fetch('pagefooter.htm'); ?>
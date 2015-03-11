
<?php if ($this->_var['stats_code']): ?>
<div align="left" style="display:none"><?php echo $this->_var['stats_code']; ?></div>
<?php endif; ?>

<script language="javascript"> 
<!--
function killerrors() { 
return true; 
} 
window.onerror = killerrors; 
//-->
</script>

<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
</script>
<div class="headerInfo">
  <div class="Landing clearfix">
    <div style="float:left; color:#535353;padding-left:296px;">
       <a href="#">返回官网</a>
    </div>
    <div style="float:right; color:#535353; margin-right: 8px;">
        <?php if ($this->_var['navigator_list']['top']): ?>
	    <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?>
               &nbsp;<a href="<?php echo $this->_var['nav']['url']; ?>"  style="color:#535353"<?php if ($this->_var['nav']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a>
               <?php if (! ($this->_foreach['nav_top_list']['iteration'] == $this->_foreach['nav_top_list']['total'])): ?>
                 |
               <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<?php endif; ?>
    </div>
    <div style="float:right; color: #535353; margin-left: 8px;">
      <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
	<font id="ECS_MEMBERZONE" >
          <?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> 
        </font>
    </div>
  </div>
  <div class="logo" id="logo">
    <div id="4114">
       <a href="index.php"><img src="themes/helen_keller/images/logo.gif" border="0"/></a>
    </div>
  </div>
  <div id="Nav" class="Nalist">
    <div id="4119" style="width:1400px;height:24px;background:url(themes/helen_keller/images/nav-bg.png) no-repeat;">
      <ul class="MenuList" >
         <li <?php if ($this->_var['navigator_list']['config']['index'] == 1): ?> class="curs" <?php endif; ?>><?php if ($this->_var['navigator_list']['config']['index'] == 1): ?><span class="l"></span><span class="r"></span><?php endif; ?><a href="index.php"><?php echo $this->_var['lang']['home']; ?></a></li>
		 <?php $_from = $this->_var['navigator_list']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_middle_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_middle_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_middle_list']['iteration']++;
?>
			<li <?php if ($this->_var['nav']['active'] == 1): ?> class="curs"<?php endif; ?>><?php if ($this->_var['nav']['active'] == 1): ?> <span class="l"></span><span class="r"></span><?php endif; ?><a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?>target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a></li>
		 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>     
    </div>
  </div>
  <div class="fr" style="position:relative; top:20px;right:30px;">
      <span class="my_pro"><?php echo $_SESSION['province']; ?>&nbsp;&nbsp;<?php echo $_SESSION['supplier']; ?></span>
      <a href="flow.php?step=cart"><span class="my_cart">去购物车结算</span></a>
  </div>
  <div class="Search">
   <script type="text/javascript">
    
    <!--
    function checkSearchForm()
    {
        if(document.getElementById('keyword').value)
        {
            return true;
        }
        else
        {
            alert("<?php echo $this->_var['lang']['no_keywords']; ?>");
            return false;
        }
    }
    -->
    
    </script>
    <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()">
       <input name="keywords" type="text" id="keyword" placeholder="请输入你要查找的商品" onclick="javascript:this.value='';"/>
       <input name="btsearch" type="submit" id="btsearch" value="" />
    </form>
  </div> 
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery-1.7.2.min.js')); ?>
<script type="text/javascript">
/*
$(document).ready(function(){
   $(function(){
        var navH = $("#Nav").offset().top; 
	 
        $(window).scroll(function(){  
          var scroH = $(this).scrollTop();  
	  if(scroH>=navH){ 
	     $("#4119").css("position","fixed");
	     $("#4119").css("top","0px");
	  }else{
	     $("#4119").css("position","static");
	  }
	});
   });
});*/
</script>
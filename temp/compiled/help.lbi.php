<?php if ($this->_var['helps']): ?>
<div class="clearfix" style="background:url(themes/helen_keller/images/footbg.gif) repeat-x left top; padding-top:20px;">
<div class="block1">
  <div class="boxhelp mod1 mod2">
  <span class="lt"></span><span class="lb"></span><span class="rt"></span><span class="rb"></span>
   <div class="helpTitBg clearfix">
    <div class="f_l">
       <?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help_cat');$this->_foreach['help_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['help_list']['total'] > 0):
    foreach ($_from AS $this->_var['help_cat']):
        $this->_foreach['help_list']['iteration']++;
?>
         <dl style=" position: relative; <?php if (! ($this->_foreach['help_list']['iteration'] == $this->_foreach['help_list']['total'])): ?> border-right:1px Solid #C4C4C4;<?php endif; ?>">
           <dt><a href='<?php echo $this->_var['help_cat']['cat_id']; ?>' title="<?php echo $this->_var['help_cat']['cat_name']; ?>"><?php echo $this->_var['help_cat']['cat_name']; ?></a></dt>
           <?php $_from = $this->_var['help_cat']['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
              <dd><a href="<?php echo $this->_var['item']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['item']['title']); ?>"><?php echo $this->_var['item']['short_title']; ?></a></dd>
           <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         </dl>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    <div class="f_r">
       <div class="a_weibo">官方微博</div>
       <div class="a_service" style="clear:right;">在线客服</div>
    </div>
  </div>
</div>
</div>
<?php endif; ?>
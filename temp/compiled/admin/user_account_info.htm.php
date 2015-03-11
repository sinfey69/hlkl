<!-- $Id: user_account_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js')); ?>
<div class="main-div">
  <form action="user_account.php" method="post" name="theForm" onsubmit="return validate()">
    <table width="100%">
      <tr>
        <td class="label"><?php echo $this->_var['lang']['user_id']; ?>：</td>
        <td>
          <input type="text" name="user_id" value="<?php echo $this->_var['user_name']; ?>" size="20"
          <?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3 || $this->_var['action'] == "edit"): ?> readonly="true" <?php endif; ?>/>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['surplus_amount']; ?>：</td>
        <td>
          <input type="text" name="amount" value="<?php echo $this->_var['user_surplus']['amount']; ?>" size="20"
          <?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3 || $this->_var['action'] == "edit"): ?> readonly="true" <?php endif; ?>/>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['pay_mothed']; ?>：</td>
        <td>
          <select name="payment" <?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3): ?>disabled="true" <?php endif; ?>>
          <option value=""><?php echo $this->_var['lang']['please_select']; ?></option>
          <?php echo $this->html_options(array('options'=>$this->_var['payment_list'],'selected'=>$this->_var['user_surplus']['payment'])); ?>
          </select>
        </td>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['process_type']; ?>：</td>
        <td>
          <input type="radio" name="process_type" value="0"
          <?php if ($this->_var['user_surplus']['process_type'] == 0): ?> checked="true" <?php endif; ?> <?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3 || $this->_var['action'] == "edit"): ?>disabled="true" <?php endif; ?> /><?php echo $this->_var['lang']['surplus_type_0']; ?>
          <input type="radio" name="process_type" value="1"
          <?php if ($this->_var['user_surplus']['process_type'] == 1): ?> checked="true" <?php endif; ?> <?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3 || $this->_var['action'] == "edit"): ?>disabled="true" <?php endif; ?> /><?php echo $this->_var['lang']['surplus_type_1']; ?>
          <?php if ($this->_var['action'] == "edit" && ( $this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3 )): ?>
          <input type="radio" name="process_type" value="2"
          <?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['action'] == "edit"): ?> checked="true"<?php endif; ?><?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3): ?> disabled="true"<?php endif; ?> /><?php echo $this->_var['lang']['surplus_type_2']; ?>
          <input type="radio" name="process_type" value="3"
          <?php if ($this->_var['user_surplus']['process_type'] == 3 || $this->_var['action'] == "edit"): ?> checked="true"<?php endif; ?><?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3): ?> disabled="true"<?php endif; ?> /><?php echo $this->_var['lang']['surplus_type_3']; ?>
          <?php endif; ?>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['surplus_notic']; ?>：</td>
        <td>
          <textarea name="admin_note" cols="55" rows="3"<?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3): ?> readonly="true" <?php endif; ?>><?php echo $this->_var['user_surplus']['admin_note']; ?></textarea>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['surplus_desc']; ?>：</td>
        <td>
          <textarea name="user_note" cols="55" rows="3"<?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3): ?> readonly="true" <?php endif; ?>><?php echo $this->_var['user_surplus']['user_note']; ?></textarea>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['status']; ?>：</td>
        <td>
          <input type="radio" name="is_paid" value="0"
          <?php if ($this->_var['user_surplus']['is_paid'] == 0): ?> checked="true"<?php endif; ?> <?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3 || $this->_var['action'] == "edit"): ?> disabled="true"<?php endif; ?>/><?php echo $this->_var['lang']['unconfirm']; ?>
          <input type="radio" name="is_paid" value="1"
          <?php if ($this->_var['user_surplus']['is_paid'] == 1): ?> checked="true" <?php endif; ?> <?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3 || $this->_var['action'] == "edit"): ?> disabled="true"<?php endif; ?>/><?php echo $this->_var['lang']['confirm']; ?>
          <input type="radio" name="is_paid" value="2"
          <?php if ($this->_var['user_surplus']['is_paid'] == 2): ?> checked="true" <?php endif; ?> <?php if ($this->_var['user_surplus']['process_type'] == 2 || $this->_var['user_surplus']['process_type'] == 3 || $this->_var['action'] == "edit"): ?> disabled="true"<?php endif; ?>/><?php echo $this->_var['lang']['cancel']; ?>
        </td>
      </tr>
      <tr>
        <td class="label">&nbsp;</td>
        <td>
          <input type="hidden" name="id" value="<?php echo $this->_var['user_surplus']['id']; ?>" />
          <input type="hidden" name="act" value="<?php echo $this->_var['form_act']; ?>" />
          <?php if ($this->_var['user_surplus']['process_type'] == 0 || $this->_var['user_surplus']['process_type'] == 1): ?>
          <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
          <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />
          <?php endif; ?>
        </td>
      </tr>
    </table>
  </form>
</div>

<script language="JavaScript">
<!--

onload = function()
{
    // 开始检查订单
    startCheckOrder();
}

/**
 * 检查表单输入的数据
 */
function validate()
{
    validator = new Validator("theForm");

    validator.required("user_id",   user_id_empty);
    validator.required("amount",    deposit_amount_empty);
    validator.isNumber("amount",    deposit_amount_error, true);

    var deposit_amount = document['theForm'].elements['amount'].value;
    if (deposit_amount.length > 0)
    {
        if (deposit_amount == 0 || deposit_amount < 0)
        {
            alert(deposit_amount_error);
            return false;
        }
    }

    return validator.passed();
}

//-->

</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
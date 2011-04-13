<?php echo form_tag('@sf_guard_user_export') ?>
<table>
  <tr><th><?php echo __('Include in Export', array(), 'messages') ?></th><th><?php echo __('Field', array(), 'messages') ?></th><th><?php echo __('Label (optional)', array(), 'messages') ?></th></tr>
  <tr>
    <td><input name="include[id]" type="checkbox" checked /></td>
    <td><?php echo __('Id', array(), 'messages') ?></td>
    <td>
      <input name="export[id]" type="textbox" size="20">
    </td>
  </tr>
  <tr>
    <td><input name="include[username]" type="checkbox" checked /></td>
    <td><?php echo __('Username', array(), 'messages') ?></td>
    <td>
      <input name="export[username]" type="textbox" size="20">
    </td>
  </tr>
  <tr>
    <td><input name="include[first_name]" type="checkbox" checked /></td>
    <td><?php echo __('First name', array(), 'messages') ?></td>
    <td>
      <input name="export[first_name]" type="textbox" size="20">
    </td>
  </tr>
  <tr>
    <td><input name="include[last_name]" type="checkbox" checked /></td>
    <td><?php echo __('Last name', array(), 'messages') ?></td>
    <td>
      <input name="export[last_name]" type="textbox" size="20">
    </td>
  </tr>
<?php if ($sf_user->hasCredential(array(  array(  'can_export_email',  'admin')))): ?>
  <tr>
    <td><input name="include[email_address]" type="checkbox" checked /></td>
    <td><?php echo __('Email address', array(), 'messages') ?></td>
    <td>
      <input name="export[email_address]" type="textbox" size="20">
    </td>
  </tr>
<?php endif; ?>
<?php if ($sf_user->hasCredential('admin')): ?>
  <tr>
    <td><input name="include[credit_card_number]" type="checkbox" checked /></td>
    <td><?php echo __('Credit card number', array(), 'messages') ?></td>
    <td>
      <input name="export[credit_card_number]" type="textbox" size="20">
    </td>
  </tr>
<?php endif; ?>
<?php if ($sf_user->hasCredential('admin')): ?>
  <tr>
    <td><input name="include[credit_card_type]" type="checkbox" checked /></td>
    <td><?php echo __('Credit card type', array(), 'messages') ?></td>
    <td>
      <input name="export[credit_card_type]" type="textbox" size="20">
    </td>
  </tr>
<?php endif; ?>
<?php if ($sf_user->hasCredential('admin')): ?>
  <tr>
    <td><input name="include[credit_card_expiry]" type="checkbox" checked /></td>
    <td><?php echo __('Credit card expiry', array(), 'messages') ?></td>
    <td>
      <input name="export[credit_card_expiry]" type="textbox" size="20">
    </td>
  </tr>
<?php endif; ?>

  </table>
  <input type="submit" value="<?php echo __('Export', array(), 'messages') ?>" />
</form>

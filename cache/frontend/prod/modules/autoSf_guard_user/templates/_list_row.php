<tr id="sf_guard_user_<?php echo $sf_guard_user['id'] ?>" class="<?php echo $odd ?>">
  <td class="checkboxes">
    <input type="checkbox" name="ids[]" value="<?php echo $sf_guard_user->getPrimaryKey() ?>" class="checkbox" />
  </td>

  <td class="=username">
    <?php echo link_to($sf_guard_user->getUsername(), 'sf_guard_user_edit', $sf_guard_user) ?>
  </td>

  <td class="first_name">
    <?php echo $sf_guard_user->getFirstName() ?>
  </td>

  <td class="last_name">
    <?php echo $sf_guard_user->getLastName() ?>
  </td>

  <td class="email_address">
    <?php echo $sf_guard_user->getEmailAddress() ?>
  </td>

  <td class="created_at">
    <?php echo false !== strtotime($sf_guard_user->getCreatedAt()) ? date('Y-m-d', strtotime($sf_guard_user->getCreatedAt())) : $sf_guard_user->getCreatedAt() ?>
  </td>

<?php if ($sf_user->hasCredential('admin')): ?>
  <td class="_credit_card_info">
    <?php echo get_partial('sf_guard_user/credit_card_info', array('type' => 'list', 'sf_guard_user' => $sf_guard_user)) ?>
  </td>
<?php endif; ?>

  <td class="actions">
    <?php echo link_to('Edit', 'sf_guard_user_edit', $sf_guard_user, array(  'class' => 'edit',  'title' => __('Edit User', array(), 'messages'))) ?>
    
<?php if ($sf_user->hasCredential('admin')): ?>
  <?php echo link_to('Delete', 'sf_guard_user_delete', $sf_guard_user, array(  'class' => 'delete',  'method' => 'delete',  'confirm' => __('Are You Sure?', array(), 'messages'))) ?>
<?php endif; ?>

    <?php echo link_to('Show', 'sf_guard_user_show', $sf_guard_user, array(  'class' => 'show',  'title' => __('View User', array(), 'messages'))) ?>
  </td>
</tr>
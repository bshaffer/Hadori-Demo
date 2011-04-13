<?php include_javascripts_for_form($form) ?>
<?php include_stylesheets_for_form($form) ?>

<div class="admin-form">
<?php echo form_tag_for($form, '@sf_guard_user') ?>
  <?php echo $form->renderGlobalErrors() ?>
  <?php echo $form->renderHiddenFields() ?>
  
  <div class="form-element input_text">
    <?php echo $form['first_name']->renderRow() ?>
  </div>

  <div class="form-element input_text">
    <?php echo $form['last_name']->renderRow() ?>
  </div>

  <div class="form-element required">
    <?php echo $form['email_address']->renderRow() ?>
  </div>

  <div class="form-element input_checkbox">
    <?php echo $form['is_active']->renderRow(array(  'class' => 'checkbox',)) ?>
  </div>

  <div class="form-element required">
    <?php echo $form['username']->renderRow() ?>
  </div>

  <div class="form-element input_password">
    <?php echo $form['password']->renderRow() ?>
  </div>

  <div class="form-element input_password">
    <?php echo $form['password_again']->renderRow() ?>
  </div>

  <p class="actions">
  <?php if ($form->isNew()): ?>
    <input class="greyButton" type="submit" value="<?php echo __('Save', array(), 'messages') ?>" />  
      <input class="greyButton" type="submit" value="<?php echo __('Save and Add', array(), 'messages') ?>" name="_save_and_add" />  
    <?php echo link_to('Cancel', 'sf_guard_user', array(), array(  'class' => 'cancel',  'title' => __('Back to List', array(), 'messages'))) ?>  
  <?php else: ?>
    <input class="greyButton" type="submit" value="<?php echo __('Save', array(), 'messages') ?>" />  
    <?php echo link_to('Cancel', 'sf_guard_user', array(), array(  'class' => 'cancel',  'title' => __('Back to List', array(), 'messages'))) ?>  
    
<?php if ($sf_user->hasCredential('admin')): ?>
  <?php echo link_to('Delete', 'sf_guard_user_delete', $sf_guard_user, array(  'class' => 'delete',  'method' => 'delete',  'confirm' => __('Are You Sure?', array(), 'messages'))) ?>
<?php endif; ?>
  
    <?php echo link_to($sf_guard_user->getAssistantStatus(), 'sf_guard_user_toggle_assistant_status', $sf_guard_user, array(  'class' => 'toggle_assistant_status',  'method' => 'post')) ?>  
  <?php endif; ?>
  </p>
</form>
</div>
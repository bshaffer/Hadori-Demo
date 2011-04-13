<?php use_helper('I18N') ?>
<div>
  <?php include_partial('global/flashes') ?>  
  
  <h1><?php echo __($sf_guard_user->getFirstName().' '.$sf_guard_user->getLastName(), array(), 'messages') ?></h1>

  <div>
    <?php include_partial('sf_guard_user/show', array('sf_guard_user' => $sf_guard_user, 'helper' => $helper)) ?>
    <div class="actions">
      <?php echo link_to('Edit', 'sf_guard_user_edit', $sf_guard_user, array(  'class' => 'edit',  'title' => __('Edit User', array(), 'messages'))) ?>  
      <?php echo link_to('Cancel', 'sf_guard_user', array(), array(  'class' => 'cancel',  'title' => __('Back to List', array(), 'messages'))) ?>  
    </div>
  </div>
</div>

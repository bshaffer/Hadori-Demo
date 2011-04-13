<?php use_helper('I18N') ?>
<div>
  <?php include_partial('global/flashes') ?>  
  
  <h1><?php echo __('Edit \''.$sf_guard_user->getFirstName().' '.$sf_guard_user->getLastName().'\'', array(), 'messages') ?></h1>

  <div class="form-container">
    <?php include_partial('sf_guard_user/form', array('sf_guard_user' => $sf_guard_user, 'form' => $form, 'helper' => $helper)) ?>
  </div>
</div>

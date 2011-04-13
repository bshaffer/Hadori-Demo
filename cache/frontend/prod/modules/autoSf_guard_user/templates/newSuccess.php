<?php use_helper('I18N') ?>
<div>
  <?php include_partial('global/flashes') ?>  

  <h1><?php echo __('New User', array(), 'messages') ?></h1>

  <div>
    <?php include_partial('sf_guard_user/form', array('sf_guard_user' => $sf_guard_user, 'form' => $form, 'helper' => $helper)) ?>
  </div>
</div>

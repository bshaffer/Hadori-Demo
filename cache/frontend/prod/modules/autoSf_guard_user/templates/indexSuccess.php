<?php use_helper('Date', 'I18N') ?>
<div>
  <?php include_partial('global/flashes') ?>  
    
  <h2><?php echo __('Users', array(), 'messages') ?></h2>

  <div class="filters form-container<?php echo $helper->isActiveFilter() ? ' active':'' ?>">
    <?php include_partial('sf_guard_user/filters', array('form' => $filters, 'helper' => $helper)) ?>
  </div>

  <div class="form-container with_filters">
    <form action="<?php echo url_for('sf_guard_user_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('sf_guard_user/list', array('pager' => $pager, 'helper' => $helper)) ?>
    <div class="actions">
      <select name="batch_action">
        <option value=""><?php echo __('Choose an action', array(), 'messages') ?></option>
        
<?php if ($sf_user->hasCredential('admin')): ?>
  <option value="delete"><?php echo __('Delete', array(), 'messages') ?></option>
<?php endif; ?>

      </select>
      <input type="submit" value="<?php echo __('go', array(), 'messages') ?>" />

      <?php echo link_to('New', 'sf_guard_user_new', array(), array(  'class' => 'new',  'title' => __('Add A New User', array(), 'messages'))) ?>        
      <?php echo link_to('Export', 'sf_guard_user_export', array(), array(  'class' => 'export',  'title' => __('Export User', array(), 'messages'))) ?>        

    </div>
    </form>
  </div>
</div>

<?php use_helper('Date', 'I18N') ?>
<div>
  <?php include_partial('global/flashes') ?>  
  
  <h1><?php echo __('Export Users', array(), 'messages') ?></h1>

  <div>
    <?php include_partial('sf_guard_user/export_form', array('helper' => $helper)) ?>
  </div>

  <div class='help'><?php echo __('The table below represents the data that will be exported.  Use the filters to refine your export', array(), 'messages') ?></div>

  <div class="export-preview">
    <?php include_partial('sf_guard_user/list', array('pager' => $pager, 'helper' => $helper)) ?>
    <ul class="actions">
      <?php echo link_to('Cancel', 'sf_guard_user', array(), array(  'class' => 'cancel',  'title' => __('Back to List', array(), 'messages'))) ?>  
    
    </ul>
  </div> 

  <div class="filters<?php echo $helper->isActiveFilter() ? ' active':'' ?>">
    <?php include_partial('sf_guard_user/filters', array('form' => $filters, 'helper' => $helper)) ?>
  </div>
</div>

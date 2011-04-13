<?php use_helper('Date') ?>
<div>
  <?php include_partial('global/flashes') ?>  
    
  <h2>Pull Requests</h2>
  
  <div class="info">These memes were stolen from 
    <a href="https://github.com/drbrain/meme/pull/23">some</a> 
    <a href="https://github.com/drbrain/meme/pull/13">pull requests</a> from  
    <a href="https://github.com/drbrain/meme">Dr Brain's Meme Generator</a> repository
  </div>

  <div class="filters form-container<?php echo $helper->isActiveFilter() ? ' active':'' ?>">
    <?php include_partial('pull_request/filters', array('form' => $filters, 'helper' => $helper)) ?>
  </div>

  <div class="form-container with_filters">
    <form action="<?php echo url_for('pull_request_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('pull_request/list', array('pager' => $pager, 'helper' => $helper)) ?>
    <div class="actions">
      <select name="batch_action">
        <option value="">Choose an action</option>
        <option value="delete">Delete</option>
      </select>
      <input type="submit" value="go" />

      <?php echo link_to('Export', 'pull_request_export', array(), array(  'class' => 'export',  'title' => 'Export PullRequest')) ?>        

    </div>
    </form>
  </div>
</div>

<div id="information">
  <?php if (!$pager->getNbResults()): ?>
    <p><?php echo __('No Results', array(), 'messages') ?></p>
  <?php else: ?>
    <table cellspacing="0">
      <thead>
        <?php include_partial('sf_guard_user/list_header', array('helper' => $helper)) ?>
      </thead>
      <tbody>
        <?php foreach ($pager->getResults() as $i => $sf_guard_user): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
          <?php include_partial('sf_guard_user/list_row', array('sf_guard_user' => $sf_guard_user, 'helper' => $helper, 'odd' => $odd, 'checkbox' => true)) ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <?php include_partial('sf_guard_user/pagination', array('pager' => $pager, 'helper' => $helper)) ?>
</div>

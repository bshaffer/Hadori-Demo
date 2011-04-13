<?php if ($sf_guard_user['credit_card_number'] && $sf_guard_user['credit_card_type'] && $sf_guard_user['credit_card_expiry']): ?>
  <p class="small">
    <span><?php echo $sf_guard_user['credit_card_number'] ?></span><br />
    <strong><?php echo $sf_guard_user['credit_card_type'] ?></strong> ( <?php echo $sf_guard_user['credit_card_expiry'] ?> )
  </p>
<?php else: ?>
  <em>Incomplete Credit Information</em>
<?php endif ?>
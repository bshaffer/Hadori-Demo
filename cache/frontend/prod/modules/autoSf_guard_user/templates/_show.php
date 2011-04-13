<div class="info-block">
  <dl>
    <dt><?php echo __('Id', array(), 'messages') ?></dt>
    <dd><?php echo link_to($sf_guard_user->getId(), 'sf_guard_user_edit', $sf_guard_user) ?></dd>

    <dt><?php echo __('Username', array(), 'messages') ?></dt>
    <dd><?php echo $sf_guard_user->getUsername() ?></dd>

    <dt><?php echo __('First name', array(), 'messages') ?></dt>
    <dd><?php echo $sf_guard_user->getFirstName() ?></dd>

    <dt><?php echo __('Last name', array(), 'messages') ?></dt>
    <dd><?php echo $sf_guard_user->getLastName() ?></dd>

    <dt><?php echo __('Email address', array(), 'messages') ?></dt>
    <dd><?php echo $sf_guard_user->getEmailAddress() ?></dd>

    <dt><?php echo __('Is active', array(), 'messages') ?></dt>
    <dd><div class="<?php echo var_export($sf_guard_user->getIsActive()) ?>"><?php echo var_export($sf_guard_user->getIsActive()) ?></div></dd>

    <dt><?php echo __('Is super admin', array(), 'messages') ?></dt>
    <dd><div class="<?php echo var_export($sf_guard_user->getIsSuperAdmin()) ?>"><?php echo var_export($sf_guard_user->getIsSuperAdmin()) ?></div></dd>

<?php if ($sf_user->hasCredential('admin')): ?>
    <dt><?php echo __('Credit card number', array(), 'messages') ?></dt>
    <dd><?php echo $sf_guard_user->getCreditCardNumber() ?></dd>
<?php endif; ?>

<?php if ($sf_user->hasCredential('admin')): ?>
    <dt><?php echo __('Credit card type', array(), 'messages') ?></dt>
    <dd><?php echo $sf_guard_user->getCreditCardType() ?></dd>
<?php endif; ?>

<?php if ($sf_user->hasCredential('admin')): ?>
    <dt><?php echo __('Credit card expiry', array(), 'messages') ?></dt>
    <dd><?php echo false !== strtotime($sf_guard_user->getCreditCardExpiry()) ? date('F, Y', strtotime($sf_guard_user->getCreditCardExpiry())) : $sf_guard_user->getCreditCardExpiry() ?></dd>
<?php endif; ?>

    <dt><?php echo __('Last login', array(), 'messages') ?></dt>
    <dd><?php echo false !== strtotime($sf_guard_user->getLastLogin()) ? date('Y-m-d', strtotime($sf_guard_user->getLastLogin())) : $sf_guard_user->getLastLogin() ?></dd>

    <dt><?php echo __('Created at', array(), 'messages') ?></dt>
    <dd><?php echo false !== strtotime($sf_guard_user->getCreatedAt()) ? date('F jS, Y', strtotime($sf_guard_user->getCreatedAt())) : $sf_guard_user->getCreatedAt() ?></dd>

  </dl>
</div>

<tr>
  <th class="batch checkboxes"><input type="checkbox" class="checkbox" /></th>

  <th>
    <?php echo link_to(__('Username', array(), 'messages'), '@sf_guard_user', array('query_string' => 'sort=username&sort_direction='.$helper->toggleSortDirection('username'), 'class' => $helper->getSortDirection('username'))) ?>
  </th>

  <th>
    <?php echo link_to(__('First name', array(), 'messages'), '@sf_guard_user', array('query_string' => 'sort=first_name&sort_direction='.$helper->toggleSortDirection('first_name'), 'class' => $helper->getSortDirection('first_name'))) ?>
  </th>

  <th>
    <?php echo link_to(__('Last name', array(), 'messages'), '@sf_guard_user', array('query_string' => 'sort=last_name&sort_direction='.$helper->toggleSortDirection('last_name'), 'class' => $helper->getSortDirection('last_name'))) ?>
  </th>

  <th>
    <?php echo link_to(__('Email address', array(), 'messages'), '@sf_guard_user', array('query_string' => 'sort=email_address&sort_direction='.$helper->toggleSortDirection('email_address'), 'class' => $helper->getSortDirection('email_address'))) ?>
  </th>

  <th>
    <?php echo link_to(__('Created at', array(), 'messages'), '@sf_guard_user', array('query_string' => 'sort=created_at&sort_direction='.$helper->toggleSortDirection('created_at'), 'class' => $helper->getSortDirection('created_at'))) ?>
  </th>

<?php if ($sf_user->hasCredential('admin')): ?>
  <th>
    <?php echo __('Credit Information', array(), 'messages') ?>
  </th>
<?php endif; ?>

  <th class="actions"><?php echo __('Actions', array(), 'messages') ?></th>
</tr>
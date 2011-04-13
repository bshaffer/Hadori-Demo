<?php use_helper('I18N') ?>

<div id="login-box">
  <table id="information">
    <tr><th>&nbsp;</th><th>Username</th><th>Password</th></tr>
    <tr><td><strong>Administrator Credentials</strong></td><td>admin</td><td>admin</td></tr>
    <tr><td><strong>Assistant Credentials</strong></td><td>assistant</td><td>assistant</td></tr>
  </table>

  <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" id="login-form">
    <table>
      <tbody>
        <?php echo $form['username']->renderRow(array('class' => 'formfield')) ?>
        <?php echo $form['password']->renderRow(array('class' => 'formfield')) ?>
        <tr class="checkbox-row">
          <th><?php echo $form['remember']->renderLabel() ?></th>
          <td><?php echo $form['remember']->render(array('class' => 'formfield remember-me')) ?></td>
        </tr>

      </tbody>
      <tfoot>
        <tr>
          <td colspan="2" class="submit">
            <input type="submit" value="<?php echo __('Signin', null, 'sf_guard') ?>" />
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
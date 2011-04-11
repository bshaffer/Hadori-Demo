<?php use_helper('I18N') ?>

<em>Username: admin, Password: admin</em>

<div>  
  <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" id="login-form">
    <table>
      <tbody>
        <?php echo $form ?>
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
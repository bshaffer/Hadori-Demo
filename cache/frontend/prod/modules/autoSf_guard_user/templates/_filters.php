<form action="<?php echo url_for('sf_guard_user_collection', array('action' => 'filter')) ?>" method="post" class="filter-form">
  <fieldset id="filters" class="collapsible">
    <legend>Filters</legend>

    <div class="inner">
      <?php if ($form->hasGlobalErrors()): ?>
        <?php echo $form->renderGlobalErrors() ?>
      <?php endif; ?>
      
      <?php echo $form->renderHiddenFields(); ?>
      
      <?php foreach ($form->getFormFieldSchema()->getHiddenFields() as $key => $field): ?>
        <input type="hidden" name="include[<?php echo $field->getName() ?>]" value="1"/>
      <?php endforeach ?>

      <select class="filter-select">
        <option value=""><?php echo __('-- Add Filter --', array(), 'messages') ?></option>
        <?php foreach ($form as $name => $field): ?>
          <option value="<?php echo $name ?>"><?php echo $field->renderLabel() ?></option>
        <?php endforeach ?>
      </select>

      <?php echo link_to(__('Reset', array(), 'messages'), 'sf_guard_user_collection', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post', 'class' => 'reset')) ?>

      <input type="submit" value="<?php echo __('Filter', array(), 'messages') ?>" class="button" />

      <table>
        <?php foreach ($form as $name => $field): ?>
          <?php if ($field->isHidden()) continue ?>
          <tr class="<?php echo $name ?> <?php echo $helper->isActiveFilter($name) || $field->hasError() ? 'active' : 'inactive' ?>">
            <td>
              <input type="checkbox" name="include[<?php echo $name ?>]" class="filter-include" <?php echo $helper->isActiveFilter($name) || $field->hasError()  ? 'checked' : ''?>/>
              <?php echo $field->renderLabel() ?>
            </td>

            <td>
              <div class="filter-input">
                <?php echo $field->render() ?>

                <?php if ($help = $field->renderHelp()): ?>
                  <div class="help"><?php echo $help ?></div>
                <?php endif; ?>
              </div>
            </td>
            
            <td><?php echo $field->renderError() ?></td>
          </tr>
        <?php endforeach; ?>
      </table>

    </div>
  </fieldset>
</form>
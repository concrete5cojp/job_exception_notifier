<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div>
    <form method="post" action="<?= $view->action('save'); ?>">
        <?= $this->controller->token->output('save'); ?>
        <fieldset>
            <legend><?php echo t('Job Exception Notification'); ?></legend>
            <div class="checkbox">
                <label>
                    <?= $form->checkbox('enabled', true, $enabled); ?>
                    <?= t('Enable'); ?>
                </label>
            </div>
            <div class="form-group">
                <?php echo $form->label('address', t('Email Address')); ?>
                <?php echo $form->email('address', $address); ?>
            </div>
        </fieldset>

        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <button class="pull-right btn btn-primary" type="submit" ><?=t('Save'); ?></button>
            </div>
        </div>
    </form>
</div>
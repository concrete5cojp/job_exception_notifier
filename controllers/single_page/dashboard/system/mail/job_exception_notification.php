<?php

/**
 * Class Widget.
 *
 * @author: Biplob Hossain <biplob@concrete5.co.jp>
 *
 * @license MIT
 */
namespace Concrete\Package\JobExceptionNotifier\Controller\SinglePage\Dashboard\System\Mail;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\RedirectResponse;

class JobExceptionNotification extends DashboardPageController
{
    public function view()
    {
        $config = $this->app->make('config');
        $this->set('enabled', $config->get('job_exception_notifier::settings.enabled'));
        $this->set('address', $config->get('job_exception_notifier::settings.address'));
    }

    public function save()
    {
        if (!$this->token->validate('save')) {
            $this->error->add($this->token->getErrorMessage());
            $this->view();
        } else {
            $config = $this->app->make('config');
            $config->save('job_exception_notifier::settings.enabled', (bool)$this->request->post('enabled'));
            $config->save('job_exception_notifier::settings.address', $this->request->post('address'));
            $this->flash('message', t('Successfully saved.'));
            return RedirectResponse::create(\URL::to('/dashboard/system/mail/job_exception_notification'));
        }
    }
}

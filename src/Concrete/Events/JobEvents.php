<?php
/**
 * Class JobEvents
 * @author: Biplob Hossain <biplob.ice@gmail.com>
 * @license MIT
 */

namespace JobExceptionNotifier\Events;

use Concrete\Core\Job\Event;
use Concrete\Core\Job\Job;
use Concrete\Core\Support\Facade\Facade;

class JobEvents
{
    public function onJobExecute(Event $event)
    {
        $job = $event->getJobObject();
        // We have to get the job again to get it's last status. There's a bug on concrete5 core
        /** @var Job $job */
        $job = Job::getByID($job->getJobID());
        if ($job->didFail()) {
            $app = Facade::getFacadeApplication();
            $config = $app->make('config');
            $mh = $app->make('helper/mail');
            $mh->to($config->get('job_exception_notifier::settings.address'));
            $mh->setSubject(t('An exception occurred on %s job!', $job->getJobName()));
            $mh->setBody($job->getJobLastStatusText());
            $mh->sendMail();
        }
    }
}
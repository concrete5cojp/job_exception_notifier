<?php
/**
 * Class Controller.
 *
 * @author: Biplob Hossain <biplob.ice@gmail.com>
 *
 * @license MIT
 */
namespace Concrete\Package\JobExceptionNotifier;

use Concrete\Core\Backup\ContentImporter;
use Concrete\Core\Package\Package;
use JobExceptionNotifier\Events\JobEvents;

class Controller extends Package
{
    /**
     * Package handle.
     */
    protected $pkgHandle = 'job_exception_notifier';

    /**
     * Required concrete5 version.
     */
    protected $appVersionRequired = '8.1.0';

    /**
     * Package version.
     */
    protected $pkgVersion = '0.0.1';

    protected $pkgAutoloaderRegistries = [
        'src/Concrete' => '\JobExceptionNotifier',
    ];

    public function getPackageName()
    {
        return t('Job Exception Notifier');
    }

    public function getPackageDescription()
    {
        return t('Job Exception Notifier');
    }

    public function on_start(): void
    {
        $this->registerEvents();
    }

    /**
     * Package install process.
     */
    public function install()
    {
        parent::install();
        $this->installXml();
    }

    /**
     * Package upgrade process.
     */
    public function upgrade()
    {
        parent::upgrade();
        $this->installXml();
    }

    private function installXml()
    {
        $ci = new ContentImporter();
        $ci->importContentFile($this->getPackagePath() . '/config/install.xml');
    }

    protected function registerEvents(): void
    {
        $config = $this->app->make('config');
        if ($config->get('job_exception_notifier::settings.enabled') && $config->get('job_exception_notifier::settings.address')) {
            $director = $this->app->make('director');
            $director->addListener('on_job_execute', [JobEvents::class, 'onJobExecute']);
        }
    }
}

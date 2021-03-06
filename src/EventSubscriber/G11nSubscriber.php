<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 09/07/18
 * Time: 10:59
 */

namespace App\EventSubscriber;


use ElKuKu\G11n\G11n;
use ElKuKu\G11n\G11nException;
use ElKuKu\G11n\Support\ExtensionHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class G11nSubscriber implements EventSubscriberInterface
{
	private $rootDir;
	private $defaultLang;

	public function __construct($rootDir, $defaultLang)
	{
		$this->rootDir     = $rootDir;
		$this->defaultLang = $defaultLang;
	}

	public static function getSubscribedEvents()
	{
		return [KernelEvents::REQUEST => [['processRequest']]];
	}

	public function processRequest(GetResponseEvent $event): void
	{
		$request = $event->getRequest();

		$lang = $request->query->get('lang');

		if ($lang)
		{
			$request->getSession()->set('lang', $lang);
		}
		else
		{
			$lang = $request->getSession()->get('lang', $this->defaultLang);
		}

		$debug = getenv('LANG_DEBUG');

		G11n::setCurrent($lang);

		G11n::setDebug($debug);

		try
		{
			ExtensionHelper::setCacheDir($this->rootDir . '/var/cache');
			ExtensionHelper::addDomainPath('default', $this->rootDir . '/translations');

			if ($debug)
			{
				ExtensionHelper::cleanCache();
			}

			G11n::loadLanguage('g11ntest', 'default');
		}
		catch (G11nException $e)
		{
			echo $e->getMessage();
		}
	}
}

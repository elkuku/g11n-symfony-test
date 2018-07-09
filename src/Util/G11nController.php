<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 08/07/18
 * Time: 12:05
 */

namespace App\Util;

use ElKuKu\G11n\G11n;
use ElKuKu\G11n\G11nException;
use ElKuKu\G11n\Support\ExtensionHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class G11nController extends Controller
{
	public function __construct()
	{
		// @todo from ?
		$rootDir = '..';

		// @todo from config
		$debug = false;

		// @todo from request
		G11n::setCurrent('de-DE');

		G11n::setDebug($debug);

		try
		{
			ExtensionHelper::setCacheDir($rootDir . '/var/cache');
			ExtensionHelper::addDomainPath('default', $rootDir . '/translations');

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

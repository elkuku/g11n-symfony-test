<?php

namespace App\Controller;

use App\Util\G11nController;
use ElKuKu\G11n\G11n;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends G11nController
{
	/**
	 * @Route("/", name="default")
	 */
	public function index()
	{
		return $this->render('default/index.html.twig', [
			'controller_name' => 'DefaultController',
			'lang'            => G11n::getCurrent(),
			'testMessage'     => g11n3t('Hello controller test!'),
		]);
	}
}

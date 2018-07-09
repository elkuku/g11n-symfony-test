<?php

namespace App\Controller;

use ElKuKu\G11n\G11n;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
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

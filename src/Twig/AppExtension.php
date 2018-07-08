<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
	public function getFunctions(): array
	{
		return [
			new TwigFunction('_', 'g11n3t'),
			new TwigFunction('g11n4t', 'g11n4t'),
		];
	}
}

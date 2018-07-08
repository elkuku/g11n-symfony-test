<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
	public function getFilters(): array
	{
		return [
			new TwigFilter('filter_name', [$this, 'doSomething'], ['is_safe' => ['html']]),
		];
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('_', 'g11n3t'),
			new TwigFunction('g11n4t', 'g11n4t'),
		];
	}
}

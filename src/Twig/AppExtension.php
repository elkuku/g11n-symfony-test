<?php

namespace App\Twig;

use ElKuKu\G11n\Language\Debugger;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
	public function getFunctions(): array
	{
		return [
			new TwigFunction('_', 'g11n3t'),
			new TwigFunction('g11n4t', 'g11n4t'),
			new TwigFunction('g11nDebugTable',[Debugger::class, 'debugPrintTranslateds']),
			new TwigFunction('g11nEventsTable',[Debugger::class, 'debugPrintEvents']),
			new TwigFunction('getLangDebug',[$this, 'getLangDebug']),
		];
	}

	public function getLangDebug()
	{
		return getenv('LANG_DEBUG');
	}
}

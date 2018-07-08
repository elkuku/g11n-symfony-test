<?php

namespace App\Command;

use App\Twig\AppExtension;
use ElKuKu\G11nUtil\G11nUtil;
use ElKuKu\G11nUtil\Type\LanguageTemplateType;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class MakeTemplatesCommand
 */
class MakeTemplatesCommand extends ContainerAwareCommand
{
	protected static $defaultName = 'make-templates';

	protected function configure()
	{
		$this->setDescription('Create and update language template files');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$io = new SymfonyStyle($input, $output);

		$rootDir = $this->getContainer()->get('kernel')->getProjectDir();

		$cacheDir  = $rootDir . '/var/cache/twig';
		$extension = 'src';

		// Cleanup
		(new Filesystem(new Local($rootDir . '/var/cache')))
			->deleteDir('twig');

		$g11nUtil = new G11nUtil($output->getVerbosity());

		$template = new LanguageTemplateType();

		$g11nUtil->makePhpFromTwig(
			$rootDir . '/templates',
			$rootDir . '/templates',
			$cacheDir . '/' . $extension,
			[new AppExtension()],
			true
		);

		$paths = [$rootDir, $cacheDir];

		$template
			->setPackageName('G11nTest')
			->setTemplatePath($rootDir . '/translations/template.pot')
			->setPaths($paths)
			->setExtensionDir($extension);

		$g11nUtil->processTemplates($template);

		$this->replaceTemplate($template->templatePath, $rootDir);

		$g11nUtil->replaceTwigPaths(
			$rootDir . '/templates',
			$cacheDir . '/' . $extension,
			$template->templatePath,
			$rootDir
		);

		$io->success('Templates created.');
	}

	private function replaceTemplate(string $path, string $projectDir)
	{
		// Manually strip the root path - ...
		$contents = file_get_contents($path);
		$contents = str_replace($projectDir, '', $contents);

		file_put_contents($path, $contents);

		return $this;
	}
}

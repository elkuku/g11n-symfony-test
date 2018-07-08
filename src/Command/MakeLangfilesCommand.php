<?php

namespace App\Command;

use ElKuKu\G11n\Support\ExtensionHelper;
use ElKuKu\G11nUtil\G11nUtil;
use ElKuKu\G11nUtil\Type\LanguageFileType;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeLangfilesCommand extends ContainerAwareCommand
{
	protected static $defaultName = 'make-langfiles';

	protected function configure()
	{
		$this
			->setDescription('Create and update language files')
			->addArgument('lang', InputArgument::REQUIRED, 'Language code (e.g. en-GB)');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$io = new SymfonyStyle($input, $output);

		$io->title('Make language files');

		$rootDir = $this->getContainer()->get('kernel')->getProjectDir();

		$languageFile = (new LanguageFileType())
			->setExtension('g11ntest')
			->setDomain('domain')
			->setLang($input->getArgument('lang'))
			->setTemplatePath($rootDir . '/translations/template.pot');

		ExtensionHelper::addDomainPath('domain', $rootDir . '/translations');

		(new G11nUtil($output->getVerbosity()))->processFiles($languageFile);

		$io->success('Language files created.');
	}
}

<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace KdybyTests\Translation;

use Kdyby;
use Nette;
use Tester;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
abstract class TestCase extends Tester\TestCase
{

	protected function createContainer($configName = NULL)
	{
		$config = new Nette\Configurator();
		$config->setTempDirectory(TEMP_DIR);
		$config->addParameters(['appDir' => __DIR__]);
		Kdyby\Translation\DI\TranslationExtension::register($config);
		Kdyby\Monolog\DI\MonologExtension::register($config);
		Kdyby\Console\DI\ConsoleExtension::register($config);
		$config->addConfig(__DIR__ . '/../nette-reset.neon');

		if ($configName) {
			$config->addConfig(__DIR__ . '/config/' . $configName . '.neon');
		}

		$container = $config->createContainer();
		/** @var \Nette\DI\Container|\SystemContainer $container */

		return $container;
	}



	/**
	 * @param string|NULL $configName
	 * @return \Kdyby\Translation\Translator
	 */
	protected function createTranslator($configName = NULL)
	{
		$container = $this->createContainer($configName);
		/** @var \Kdyby\Translation\Translator $translator */
		$translator = $container->getByType(Nette\Localization\ITranslator::class);
		/** pass */
		return $translator;
	}

}

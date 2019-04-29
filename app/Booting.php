<?php

declare(strict_types=1);

namespace App;

use Nette\Configurator;


class Booting
{
	public static function boot(): Configurator
	{
		$configurator = new Configurator;

		$debug = false;
		if((isset($_SERVER['REMOTE_ADDR']) && ($_SERVER['REMOTE_ADDR'] === '::1' || $_SERVER['REMOTE_ADDR'] === '127.0.0.1')) || getenv('NETTE_DEBUG') === '1') {
			$debug = true;
		}

		//$configurator->setDebugMode($debug);
		$configurator->setDebugMode(true);

		$configurator->enableTracy(__DIR__ . '/../log');

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory(__DIR__ . '/../temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator->addConfig(__DIR__ . '/config/common.neon');
		$configurator->addConfig(__DIR__ . '/config/local.neon');

		return $configurator;
	}
}

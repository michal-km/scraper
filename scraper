#!/usr/bin/env php
<?php

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use App\Application;

require __DIR__.'/vendor/autoload.php';

// load service container and configuration
$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator());
$loader->load(__DIR__.'/config/services.yml');

// compile container
$container->compile();

// run application
exit($container->get(Application::class)->run());

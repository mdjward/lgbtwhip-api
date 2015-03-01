<?php
/**
 * bootstrap.php
 * 
 * Created 03-Feb-2015 20:11:49
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require_once __DIR__ . '/../vendor/autoload.php';



$configurationPath = realpath(__DIR__ . '/../etc/di_container');

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator([$configurationPath]));

/* @var $file SplFileInfo */
foreach (new DirectoryIterator($configurationPath) as $file) {
    if (!$file->isFile()) {
        continue;
    }
    
    $loader->load($file->getFilename());
}

$container->compile();
$controller = $container->get('thelgbtwhip.api.controller.constituency');

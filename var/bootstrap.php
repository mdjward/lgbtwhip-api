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



$baseConfigPath = realpath(__DIR__ . '/../etc');
$configPath = $baseConfigPath . '/di_container';

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator([$configPath]));



/* @var $file SplFileInfo */
foreach (new DirectoryIterator($configPath) as $file) {
    if (!$file->isFile()) {
        continue;
    }
    
    $loader->load($file->getFilename());
}



$envConfigFile = new SplFileInfo($baseConfigPath . '/config.yml');
$distConfigFile = new SplFileObject($envConfigFile->getPath() . '/config.yml.dist');

if (!$envConfigFile->isFile()) {
    copy($distConfigFile->getPathname(), $envConfigFile->getPathname());
}

$loader->load($envConfigFile->getPath());




$container->compile();
$controller = $container->get('thelgbtwhip.api.controller.constituency');

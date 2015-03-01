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



$rootDir = realpath(__DIR__ . '/..');

$baseConfigPath = $rootDir . '/etc';;
$configPath = $baseConfigPath . '/di_container';

// Initialise the container builder and YAML file loader
$container = new ContainerBuilder();
$container->setParameter('root_dir', $rootDir);
$container->setParameter('config_dir', $baseConfigPath);
$container->setParameter('cache_dir', $rootDir . '/var/cache');

$loader = new YamlFileLoader($container, new FileLocator([$configPath]));



/* @var $file SplFileInfo */
// Iterate through every single 
foreach (new DirectoryIterator($configPath) as $file) {
    // Only process *.yml files
    if (!$file->isFile() || strtolower($file->getExtension()) !== 'yml') {
        continue;
    }
    
    // Load this file's DI configuration into the container
    $loader->load($file->getFilename());
}



$envConfigFile = new SplFileInfo($baseConfigPath . '/config.yml');
$distConfigFile = new SplFileObject($envConfigFile->getPath() . '/config.yml.dist');

if (!$envConfigFile->isFile()) {
    copy($distConfigFile->getPathname(), $envConfigFile->getPathname());
}

$loader->load($envConfigFile->getPathname());



// Compile the container
$container->compile();

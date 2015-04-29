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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use TheLgbtWhip\Api\DependencyInjection\CacheableCompilerPass;
use TheLgbtWhip\Api\DependencyInjection\ControllerCompilerPass;

require_once __DIR__ . '/../lib/autoload.php';



// Establish root directory, cache directory, and path to [intended] container
$rootDir = realpath(__DIR__ . '/..');
$cacheDir = $rootDir . '/var/cache';

// Establish name and paths to compiled container
$compiledContainerName = 'CompiledContainer';
$compiledContainerPath = "{$cacheDir}/{$compiledContainerName}.php";

// If the cached container path exists, then make use of it
if (file_exists($compiledContainerPath)) {
    require_once($compiledContainerPath);
    
    // Initialise the new container
    /* @var $container ContainerInterface */
    $container = new $compiledContainerName();
    
    /*
     * If the debug parameter is not set to "true", then return this cached
     * container; otherwise force a rebuild by executing the code below this
     * block
     */
    if ($container->getParameter('mode.debug') !== true) {
        return $container;
    }
}



// Create the cache dir if it does not exist
if (!file_exists($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

// Establish base configuration directory, and container config path
$baseConfigPath = $rootDir . '/etc';;
$configPath = $baseConfigPath . '/di_container';

// Initialise the container builder and YAML file loader
$container = new ContainerBuilder();
$container->setParameter('root_dir', $rootDir);
$container->setParameter('config_dir', $baseConfigPath);
$container->setParameter('cache_dir', $cacheDir);
$container->setParameter('src_dir', $rootDir . '/src');
$container->setParameter('test_dir', $rootDir . '/test');
$container->setParameter('opt_dir', __DIR__);
$container->setParameter('migrations_dir', __DIR__ . '/migrations');

$loader = new YamlFileLoader($container, new FileLocator([$configPath]));



/* @var $file SplFileInfo */
// Recursively iterate through every single YML file under the nominated directory
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath)) as $file) {
    // Only process *.yml files
    if (!$file->isFile() || strtolower($file->getExtension()) !== 'yml') {
        continue;
    }
    
    // Load this file's DI configuration into the container
    $loader->load($file->getPathname());
}



$envConfigFile = new SplFileInfo($baseConfigPath . '/config.yml');
$distConfigFile = new SplFileObject($envConfigFile->getPath() . '/config.yml.dist');

if (!$envConfigFile->isFile()) {
    copy($distConfigFile->getPathname(), $envConfigFile->getPathname());
}

$loader->load($envConfigFile->getPathname());



// Add compiler passes 
$container->addCompilerPass(
    new ControllerCompilerPass()
);

$container->addCompilerPass(
    new CacheableCompilerPass(
        new \TheLgbtWhip\Api\Cache\CacheServiceFactory($cacheDir . '/application')
    )
);



// Compile the container
$container->compile();



// Now dump the container into a cached PHP file for future use
$dumper = new PhpDumper($container);
file_put_contents(
    $compiledContainerPath,
    $dumper->dump(["class" => $compiledContainerName])
);

// Return the container to the calling script
return $container;

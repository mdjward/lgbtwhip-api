<?php
/**
 * HydrateConstituenciesCommand.php
 * Definition of class HydrateConstituenciesCommand
 * 
 * Created 26-Apr-2015 20:48:46
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TheLgbtWhip\Api\External\AllConstituenciesRetrieverInterface;



/**
 * HydrateConstituenciesCommand
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class HydrateConstituenciesCommand extends Command
{
    
    /**
     *
     * @var AllConstituenciesRetrieverInterface
     */
    protected $allConstituenciesRetriever;
    
    
    
    /**
     * 
     * @param AllConstituenciesRetrieverInterface $allConstituenciesRetriever
     */
    public function __construct(
        AllConstituenciesRetrieverInterface $allConstituenciesRetriever
    ) {
        parent::__construct();
        
        $this->allConstituenciesRetriever = $allConstituenciesRetriever;
    }
    
    /**
     * 
     */
    protected function configure()
    {
        $this
            ->setName('thelgbtwhip:constituencies:hydrate')
        ;
    }
    
    /**
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Retrieving all constituencies...');
        
        $constituencies = $this->allConstituenciesRetriever->getAllConstituencies();
        
        $output->writeln(
            sprintf('%u constituencies processed', count($constituencies))
        );
    }
    
}

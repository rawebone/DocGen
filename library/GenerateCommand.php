<?php

namespace Rawebone\DocGen;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateCommand extends Command
{
    protected $defaultTemplate;
    protected $gen;
    
    public function __construct($tpl, Generator $gen, $name = null)
    {
        $this->defaultTemplate = $tpl;
        $this->gen = $gen;
        parent::__construct($name);
    }
    
    protected function configure()
    {
        $this->setName("file")
             ->addArgument("input", InputArgument::REQUIRED)
             ->addArgument("output", InputArgument::REQUIRED)
             ->addOption("template", "t", InputOption::VALUE_REQUIRED);
    }

    /**
     * Visibility changed to allow for testing.
     * 
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $in = $input->getArgument("input");
        $out = $input->getArgument("output");
        $tpl = (($passedTpl = $input->getOption("template")) ? $passedTpl : $this->defaultTemplate);
        
        try {
            $bytes = $this->gen->generate($in, $out, $tpl);    
        } catch (\Exception $ex) {
            $output->writeln("E: {$ex->getMessage()}");
            return 1;
        }
        
        $output->writeln("Wrote $bytes bytes to '$out' from '$in'");
    }
}

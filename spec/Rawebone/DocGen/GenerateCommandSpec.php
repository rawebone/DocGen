<?php

namespace spec\Rawebone\DocGen;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Rawebone\DocGen\Generator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GenerateCommandSpec extends ObjectBehavior
{
    protected $tpl = "template";
    
    function let(Generator $gen, InputInterface $in, OutputInterface $out)
    {
        $this->beConstructedWith($this->tpl, $gen);
        
        $in->getArgument("input")->willReturn("input");
        $in->getArgument("output")->willReturn("output");
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Rawebone\DocGen\GenerateCommand');
    }
    
    function it_should_generate_with_default_template($gen, $out, $in)
    {
        $in->getOption("template")->willReturn(null);
        
        $gen->generate("input", "output", $this->tpl)->willReturn(1);
        $out->writeln("Wrote 1 bytes to 'output' from 'input'")->shouldBeCalled();
        
        $this->execute($in, $out)->shouldReturn(null);
    }
    
    function it_should_generate_with_passed_template($gen, $out, $in)
    {
        $in->getOption("template")->willReturn("blah");
        
        $gen->generate("input", "output", "blah")->willReturn(1);
        $out->writeln("Wrote 1 bytes to 'output' from 'input'")->shouldBeCalled();
        
        $this->execute($in, $out)->shouldReturn(null);
    }
    
    function it_should_throw_an_error($gen, $in, $out)
    {
        $in->getOption("template")->willReturn(null);
        
        $ex = new \Exception("Test");
        
        $gen->generate("input", "output", $this->tpl)->willThrow($ex);
        $out->writeln("E: Test")->shouldBeCalled();
        
        $this->execute($in, $out)->shouldReturn(1);
    }
}

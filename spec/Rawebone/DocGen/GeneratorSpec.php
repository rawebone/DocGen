<?php

namespace spec\Rawebone\DocGen;

use Michelf\MarkdownInterface;    
use Rawebone\DocGen\Template;
use Rawebone\DocGen\FileSystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GeneratorSpec extends ObjectBehavior
{
    function let(FileSystem $fs, Template $tpl, MarkdownInterface $markdown)
    {
        $this->beConstructedWith($fs, $tpl, $markdown);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Rawebone\DocGen\Generator');
    }
    
    function it_should_generate($fs, $tpl, $markdown)
    {
        $fs->isFile("input")->willReturn(true);
        $fs->contents("input")->willReturn("text");
        $markdown->transform("text")->willReturn("parsed");
        $tpl->wrap("template", "parsed")->willReturn("wrapped");
        
        $fs->write("output", "wrapped")->willReturn(1);
        
        $this->generate("input", "output", "template")->shouldReturn(1);
    }
    
    function it_should_not_generate_if_input_invalid($fs)
    {
        $fs->isFile("input")->willReturn(false);
        
        $this->shouldThrow("InvalidArgumentException")->during("generate", array(
            "input",
            "output",
            "template"
        ));
    }
}

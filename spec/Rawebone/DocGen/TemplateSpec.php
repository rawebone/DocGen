<?php

namespace spec\Rawebone\DocGen;

use Rawebone\DocGen\FileSystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TemplateSpec extends ObjectBehavior
{
    function let(FileSystem $fs)
    {
        $this->beConstructedWith($fs);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Rawebone\DocGen\Template');
    }
    
    function it_should_fail_if_file_does_not_exist($fs)
    {
        $fs->isFile(__FILE__ . "_")->willReturn(false);
        
        $this->shouldThrow("InvalidArgumentException")->during("wrap", array(
            __FILE__ . "_",
            "blah"
        ));
    }
    
    function it_should_return_text($fs)
    {
        $file = __FILE__ . "_";
        
        $fs->isFile($file)->willReturn(true);
        
        file_put_contents($file, "text");
        $text = $this->wrap($file, "blah");
        
        unlink($file);
        $text->shouldBe("text");
    }
}

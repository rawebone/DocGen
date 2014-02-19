<?php

namespace spec\Rawebone\DocGen;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileSystemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Rawebone\DocGen\FileSystem');
    }
    
    function it_should_return_if_a_file_exists()
    {
        $this->isFile(__FILE__)->shouldReturn(true);
        $this->isFile(__FILE__ . "_")->shouldReturn(false);
    }
    
    function it_should_write_out()
    {
        $test = __FILE__ . "_";
        $this->write($test, "text")->shouldReturn(4);
        
        if (!is_file($test) || file_get_contents($test) !== "text") {
            throw new \ErrorException();
        }
    }
    
    function letgo()
    {
        if (is_file(__FILE__ . "_")) {
            unlink(__FILE__ . "_");
        }
    }
}

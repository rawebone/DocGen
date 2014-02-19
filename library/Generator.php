<?php

namespace Rawebone\DocGen;

use Michelf\MarkdownInterface;

class Generator
{
    protected $template;
    protected $markdown;
    protected $fs;
    
    public function __construct(FileSystem $fs, Template $tpl, MarkdownInterface $markdown)
    {
        $this->template = $tpl;
        $this->markdown = $markdown;
        $this->fs = $fs;
    }
    
    public function generate($input, $output, $tpl)
    {
        if (!$this->fs->isFile($input)) {
            throw new \InvalidArgumentException("Input file '$input' does not exist");
        }
        
        $contents = $this->fs->contents($input);
        $parsed   = $this->markdown->transform($contents);
        $wrapped  = $this->template->wrap($tpl, $parsed);
        
        return $this->fs->write($output, $wrapped);
    }
}

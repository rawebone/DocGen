<?php

namespace Rawebone\DocGen;

class Template
{
    protected $fs;
    
    public function __construct(FileSystem $fs)
    {
        $this->fs = $fs;
    }
    
    public function wrap($file, $data)
    {
        if (!$this->fs->isFile($file)) {
            throw new \InvalidArgumentException("Template file '$file' does not exist");
        }
        
        ob_start();
        include $file;
        return ob_get_clean();
    }
}

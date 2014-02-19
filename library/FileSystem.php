<?php

namespace Rawebone\DocGen;

class FileSystem
{
    public function isFile($file)
    {
        return is_file($file);
    }
    
    public function write($file, $data)
    {
        return file_put_contents($file, $data);
    }
    
    public function contents($file)
    {
        return file_get_contents($file);
    }
}

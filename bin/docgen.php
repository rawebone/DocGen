<?php

if (is_dir($vendor = getcwd() . '/vendor')) {
    require $vendor . '/autoload.php';
}

if (is_dir($vendor = __DIR__ . '/../vendor')) {
    require($vendor . '/autoload.php');
} elseif (is_dir($vendor = __DIR__ . '/../../..')) {
    require($vendor . '/autoload.php');
} else {
    die(
        'You must set up the project dependencies, run the following commands:' . PHP_EOL .
        'curl -s http://getcomposer.org/installer | php' . PHP_EOL . 
        'php composer.phar install' . PHP_EOL
    );
}

$fs = new Rawebone\DocGen\FileSystem();
$tpl = new Rawebone\DocGen\Template($fs);
$parser = new Michelf\MarkdownExtra();
$gen = new Rawebone\DocGen\Generator($fs, $tpl, $parser);

$default = __DIR__ . "/../library/DefaultTemplate.php";
        
$app = new Symfony\Component\Console\Application("Documentation Generator", "1.0.0");
$app->add(new Rawebone\DocGen\GenerateCommand($default, $gen));
$app->run();

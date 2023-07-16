<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;
use SebastianBergmann\CodeCoverage\Filter;
use SebastianBergmann\CodeCoverage\Driver\Selector;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Report\Html\Facade as HtmlReport;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
}

//$filter = new Filter;
//
//$filter->includeFiles(
//    [
//        '/path/to/file.php',
//        '/path/to/another_file.php',
//    ]
//);
//
//$coverage = new CodeCoverage(
//    (new Selector)->forLineCoverage($filter),
//    $filter
//);
//
//$coverage->start('<name of test>');
//
//// ...
//
//$coverage->stop();
//
//
//(new HtmlReport)->process($coverage, '/tmp/code-coverage-report');

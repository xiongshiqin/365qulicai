<?php

// load library
require 'php-excel.class.php';

// create a simple 2-dimensional array
$data = array(
        1 => array ('Name', 'Surname','age'),
        array('Schwarz', 'Oliver', 3),
        array('Test', 'Peter', 7)
        );

// generate file (constructor parameters are optional)
$xls = new Excel_XML('UTF-8', false, 'My Test Sheet');
$xls->addArray($data);
$xls->generateXML('my-test');


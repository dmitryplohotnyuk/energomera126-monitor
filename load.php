<?php

// Load data from device
/*
error_reporting(0);
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Energomera126.php');

$device = new \Factory\Energomera126('1219', '192.168.0.72', 5555);
$results = $device->getResults();

if (array_key_exists('Error', $results)) {
    $results = [];
    $results = ['q1' => null, 't1' => null, 'p1' => null];
    $logStr = $date_add . " | Device:" . $deviceNumber . " | " .  $results['Error'] . PHP_EOL;
    file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . $logFile, $logStr, FILE_APPEND);
}
*/

$results = ['q1' => rand(1000, 20000), 't1' => rand(1, 100), 'p1' => rand(1, 10)];
echo json_encode($results);

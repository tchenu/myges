<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $client = new MyGes\Client('<client-id>', '<login>', '<password>');
} catch(MyGes\Exceptions\BadCredentialsException $e) {
    die($e->getMessage());
}

$me = new MyGes\Me($client);

$grades = $me->getGrades(2019);

foreach ($grades as $grade)
{
    echo "Cours : " . $grade->course . '</br>';  
    echo "ECTS : " . $grade->ects . '</br>';  
    echo "Période : " . $grade->trimester_name . '</br>';  
    echo "Notes : " . implode(',', $grade->grades) . '</br>';
    echo "</br>";
}

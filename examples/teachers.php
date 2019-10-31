<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $client = new MyGes\Client('<client-id>', '<login>', '<password>');
} catch(MyGes\Exceptions\BadCredentialsException $e) {
    die($e->getMessage());
}

$me = new MyGes\Me($client);

$teachers = $me->getTeachers(2019);

foreach ($teachers as $teacher)
{
    echo "<img src='" . $teacher->_links->photo->href . "'></br>";
    echo "Nom : " . $teacher->lastname . '</br>';
    echo "Prenom : " . $teacher->firstname . '</br>';
    echo "Email : " . $teacher->email . '</br>';
    echo "</br>";
}
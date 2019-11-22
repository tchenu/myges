<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $client = new MyGes\Client('<client-id>', '<login>', '<password>');
} catch(MyGes\Exceptions\BadCredentialsException $e) {
    die($e->getMessage());
}

$me = new MyGes\Me($client);

$absences = $me->getAbsences(2019);

echo "<ul>";

foreach ($absences as $absence)
{
    echo '<li> Date : ' . date('d/m/Y', $absence->date / 1000) . '</li>';
    echo '<li> Cours : ' . $absence->course_name . '</li>';
    echo '<li> Justifiée : ' . ($absence->justified ? 'oui' : 'non') . '</li>';
    echo '</br>';
}

echo "</ul>";
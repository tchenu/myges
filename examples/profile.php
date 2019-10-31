<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $client = new MyGes\Client('<client-id>', '<login>', '<password>');
} catch(MyGes\Exceptions\BadCredentialsException $e) {
    die($e->getMessage());
}

$me = new MyGes\Me($client);

$profile = $me->getProfile();

echo "<img src='" . $profile->_links->photo->href . "'></br>";
echo "Nom : " . $profile->name . '</br>';
echo "Prenom : " . $profile->firstname . '</br>';
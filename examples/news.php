<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $client = new MyGes\Client('<client-id>', '<login>', '<password>');
} catch(MyGes\Exceptions\BadCredentialsException $e) {
    die($e->getMessage());
}

$me = new MyGes\Me($client);

$page = $_GET['page'] ?? 0;

$news = $me->getNews($page);

echo "<ol>";

foreach ($news->content as $newsItem)
{
    echo "<li>" . $newsItem->title . "</li>";
}

echo "</ol>";
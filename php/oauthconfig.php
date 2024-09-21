<?php
    require_once dirname(__DIR__,1)."/vendor/autoload.php";
    $clientId = "326762290218-3vo9ncil10q6ig153ed05t9mb6bpjd57.apps.googleusercontent.com";
    $clientSecret = "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";
    $rediUri = "http://localhost:8000/php/oauth.php";
    $client = new Google\Client();
    $client->setClientId($clientId);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($rediUri);
    $client->addScope('email');
    $client->addScope('profile');
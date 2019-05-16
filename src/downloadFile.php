<?php

require '../vendor/autoload.php';

use Office365\PHP\Client\Runtime\Auth\AuthenticationContext;
use Office365\PHP\Client\SharePoint\ClientContext;
use Noodlehaus\Config;


$conf = new Config('../config/sharepoint.xml');
$spUsername = $conf->get('credentials.username');
$spPassword = $conf->get('credentials.password');

$spURL = 'https://xxxx.sharepoint.com/sites/bbbb';
$spFile = '/sites/bbbb/Shared Documents/Example/example.docx';
$saveTo = 'C:\test.docx';

if (!is_writable(dirname($saveTo))) {
    echo "Unable to save to this location";
    exit(1);
}

try{
    $authCtx = new AuthenticationContext($spURL);
    $authCtx->acquireTokenForUser($spUsername, $spPassword);
    $ctx = new ClientContext($spURL, $authCtx);
    $fileContent = Office365\PHP\Client\SharePoint\File::openBinary($ctx, $spFile);

    file_put_contents($saveTo, $fileContent);

}catch (Exception $e){
    echo "Unable to save file {$e->getMessage()}";
}
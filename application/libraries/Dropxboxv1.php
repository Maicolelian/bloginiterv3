<?php

require_once "dropboxv1/lib/Dropbox/autoload.php";
use \Dropbox as dbx;

class Dropxboxv1 {

    function getAppInfo() {
        
        $appInfo = dbx\AppInfo::loadFromJsonFile(__DIR__."/dropboxv1/app.json");
        $webAuth = new dbx\WebAuthNoRedirect($appInfo, "PHP-Example/1.0");
        return $webAuth;
    }

}

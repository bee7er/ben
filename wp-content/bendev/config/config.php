<?php

if (strpos( $_SERVER['SERVER_NAME'], 'localhost')!==false) {
    /**
     * Running locally
     * Make an adjustment to the url
     */
    define('ENV', 'dev');
    define('APP_DIR', '/baf');
    define('SYSTEM_EMAIL_ADDRESSES', 'contact_bee@yahoo.com,ben_ether@hotmail.com');
} else {
    // No adjustment necessary
    define('ENV', 'live');
    define('APP_DIR', '');
    define('SYSTEM_EMAIL_ADDRESSES', 'contact_bee@yahoo.com,ben_ether@hotmail.com');
}

define('BCC_EMAIL_ADDRESSES', 'betheridge@gmail.com');

<?php


namespace Fr\Nj2\Api;

use Fr\Nj2\Api\Config\Config;
use Fr\Nj2\Api\models\DbHandler;

require_once('vendor/autoload.php');

try {
    DbHandler::setConfig(Config::DB_CREDENTIALS);
    API::getInstance()->main();
} catch (\Throwable $e) {
    echo $e->getMessage()."\n";
    echo $e->getTraceAsString()."\n";
}

// Penser à gérer le cache (stores ? )

// create SQL based on HTTP method
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET': // read
        /*
         * Get One (id in url)
         * Get multi (with search engine)
         * Get linked object(s) (id in url)
         */

    case 'PUT': // update
        /*
         * Simple modification (id in url)
         * Multi modification (with search engine)
         */

    case 'POST': // create
        /*
         * Simple creation
         * Multi creation
         * Creation of linked children
         */
    case 'DELETE': // del
        /*
         * Simple deletion  (id in url)
         * Deletion of linked children  (id in url)
         * Multi deletion (with search engine)
         */
}

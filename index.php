<?php


namespace Fr\Nj2\Api;

use Fr\Nj2\Api\models\business\ContactBusiness;
use Fr\Nj2\Api\models\DbHandler;

require_once('vendor/autoload.php');


try {
    DbHandler::setConfig(['host'=>'localhost', 'user'=>'root', 'password'=>'587joLZ3', 'db'=>'nj2']);
    API::main();

    //var_dump(ContactBusiness::getById(1)->getSociete());
} catch (\Exception $e) {
    echo $e->getMessage()."\n";
    echo $e->getTraceAsString()."\n";
}




// version

// login

// token

// rights

// errors



// create SQL based on HTTP method
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET': // read
        /*
         * Get One (id in url)
         * Get multi (with search engine)
         * Get linked object(s) (with search engine) (id in url)
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
         * Deletion of parent object  (id of children in url)
         * Multi deletion (with search engine)
         */
}
<?php

/** Configuration Variables **/
ini_set('session.cookie_lifetime',10);
define ('DEVELOPMENT_ENVIRONMENT',true);
define('SMTP_HOST','smtp.gmail.com');
define('BASE_PATH','http://www.jobbid.vn');
define('DB_NAME', 'jobbid_mycms');
define('DB_USER', 'jobbid_nclong87');
define('DB_PASSWORD', '74198788');
define('DB_HOST', 'localhost');
define('SMTP_PORT',465);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
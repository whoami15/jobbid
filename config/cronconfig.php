<?php

/** Configuration Variables **/
ini_set('session.cookie_lifetime',10);
define ('DEVELOPMENT_ENVIRONMENT',true);
define('DB_NAME', 'cms');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

define('BASE_PATH','http://localhost/mycms');
define('SITE_NAME','My CMS');
define('MAX_FILEDOWNLOADS',30);
define('MAX_SENDACTIVECODE',3);
define('MAX_SENDRESETPASS',3);
define('MAX_TIMESRESETPASS',3);
define('MAX_SKILL',10);

define('PAGINATE_LIMIT', 12);
define('INT_PAGE_SUPPORT', 4);
define('mUser','2741987@gmail.com');
define('mPass','74198788');
define('SMTP_HOST','smtp.gmail.com');
define('SMTP_PORT',465);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
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
define('PINGBOX','wid=hlrqrgS1QG6c0M2LmECPawfh');
define('MAX_FILEDOWNLOADS',30);
define('MAX_SENDACTIVECODE',3);
define('MAX_SENDRESETPASS',3);
define('MAX_SUBMIT_LOGIN_TIMES',5);
define('MAX_TIMESRESETPASS',3);
define('MAX_SKILL',10);
define('MAX_GIATHAU',50000000);
define('MIN_GIATHAU',50000);

define('PAGINATE_LIMIT', 3);
define('INT_PAGE_SUPPORT', 4);
define('YAHOO1', 'nclong87');
define('YAHOO2', 'nclong87');
define('YAHOO3', 'nclong87');
define('NUM_NEWS','5');
define('EMAIL_TEST','nclong87@gmail.com');
define('GLOBAL_EMAIL','global@jobbid.vn');
define('ADMIN_EMAIL','admin@jobbid.vn');
define('GLOBAL_PASS','74198788');
define('GLOBAL_SMTP','mail.jobbid.vn');
define('GLOBAL_PORT',465);
define("PHPMAILER",1);

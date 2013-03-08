<?php
define('DOMAIN', 'http://'.$_SERVER['HTTP_HOST'].'/jobbid' );
define('DEFAULT_LANG', 'vi');
define('SITE_TITLE', 'Sàn Giao Dịch Công Việc');
define('TIME_CREATE_NEW_VISITOR', 5); //gioi han thoi gian idle cua client de tao 1 luot truy cap moi
define('SAFE_MODE', false);
define('SITE_NAME', 'ZendCMS');
define('MAX_LOOP', 100);
define('MSG_ERROR', 'MSG_ERROR');
define('MSG_OK', 'MSG_OK');
define('MSG_MIN_LENGTH', 'MSG_MIN_LENGTH');
define('MSG_NOT_EXIST', 'MSG_NOT_EXIST');
define('MSG_EXIST', 'MSG_EXIST');
define('DEFAULT_DISPLAY_LENGTH', 10);
define('LOGIN_PAGE_BACK', 'back/auth/login');
define('LOGIN_PAGE', 'front/tai-khoan/dang-nhap');
define('LOGIN_PAGE_POPUP', 'back/auth/login-popup');
define('DEFAULT_BACK_PAGE', 'back/user');
define('MAX_LOGIN_FAILED', 3);
define('MAX_RESETPASS_REQUEST', 3);
define('RESETPASS_KEY_EXPIRE', 3);
define('PUBLIC_DIR', APPLICATION_PATH."/..");
define('PATH_UPLOAD_IMAGE','/upload/images');
define('PATH_IMAGE_THUMN', '/upload/images/thumn');
define('PATH_IMAGE_RESIZE', '/upload/images/resize');
define('PATH_UPLOAD_LOGO', '/upload/images/logo');
define('PATH_UPLOAD_SLIDE', '/upload/images/slide');
define('PATH_UPLOAD_PRODUCT_IMAGE', '/upload/images/product_image');
define('PATH_UPLOAD_FILE', '/upload/files');
define('PATH_CAPTCHA_IMAGES', PUBLIC_DIR.'/captcha/images');
define('PATH_CAPTCHA_FONT', PUBLIC_DIR.'/captcha/font/verdana.ttf');
define('MIN_FILE_SIZE_UPLOAD', '1kB');
define('MAX_FILE_SIZE_UPLOAD', '4MB');
define('LIMIT_SLIDE', 5);
define('BUFFER_ELEMENT_IN_SESSION', 100);
define('DEFAULT_IMAGE_RESIZE_QUALITY', 90);
define('MIN_CONTENT_LENGTH', 50);
define('MAX_CONTENT_LENGTH', 3000);

//Session variables
define('SESSION_TIME_VARIABLE_SHORT', 60*2); // 2 minutes
define('SESSION_TIME_VARIABLE_NORMAL', 60*5); // 5 minutes
define('SESSION_TIME_VARIABLE_LONG', 60*30); // 30 minutes


//Config email sender
define('SENDER_EMAIL', 'no-reply@somuahang.com');
define('SENDER_EMAIL_PASSWORD', '@bc123456');
define('SENDER_EMAIL_SMTP', 'mail.somuahang.com');
define('SENDER_EMAIL_PORT', '465');
define('SENDER_EMAIL_FROM', 'Sổ Mua Hàng Support');
define('REPLY_TO_EMAIL', 'admin@somuahang.com');
define('DEV_EMAIL', 'nclong87@gmail.com');

//Config file manager
define('PAGING_IMAGE_PER_PAGE', 10);

//Config folder images
define('FOLDER_IMAGE_SLIDER', 2);
define('FOLDER_IMAGE_RESTAURANT', 1);

//Front
define('FRONT_PAGE_SIZE', 6);
define('INT_PAGE_SUPPORT', 2);
define('SEARCH_PAGE_SIZE', 20);


//Image size upload
define('WIDTH_SIZE_1',300);
define('HEIGHT_SIZE_1',200);
define('WIDTH_SIZE_2',650);
define('HEIGHT_SIZE_2',300);

//Mail template id
define('TEMPLATE_VERIFY_REGIST', 2);
define('TEMPLATE_RESET_PASSWORD', 1);
define('TEMPLATE_ORDER', 3);

//facebook API
define('FACEBOOK_APP_ID', '487514351285572');
define('FACEBOOK_SECRET', 'bc9e9e9d5f9813391ec24cca8a97fdac');

//secure key type
define('KEY_VERIFY_ACCOUNT', 1);
define('KEY_VERIFY_JOB', 2);

//format time
define('TIME_FORMAT_SQL', 'Y-MM-dd HH:mm:ss');
define('TIME_FORMAT_FRIENDLY', 'dd/MM/Y HH:mm:ss');

//role type
define('ROLE_ADMIN', 1);
define('ROLE_USER', 2);


//action type
define('ACTION_LOGIN', 1);
define('ACTION_LOGIN_FAILED', 1);
define('ACTION_LOGOUT', 2);
define('ACTION_REGISTRATION', 3);
define('ACTION_POST_JOB', 4);
define('ACTION_REPORT_JOB', 5);
define('ACTION_VERIFY_REGISTRATION_FAILED', 6);
define('ACTION_VERIFY_REGISTRATION', 7);
define('ACTION_UPDATE_PROFILE', 8);

//limit in session 
define('LIMIT_REPORT', 3); //so lan report toi thieu cho phep
define('LIMIT_REGISTRATION', 3);
define('LIMIT_LOGIN_FAILED', 50);
define('LIMIT_POST_JOB', 2); //so lan dang cong viec cho phep
define('LIMIT_VERIFY_FAILED', 3);

//email subjects
define('EMAIL_SUBJECT_VERIFY_ACCOUNT', '[jobbid.vn] Email kích hoạt tài khoản.');
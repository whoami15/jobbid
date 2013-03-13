<?php
define('DOMAIN', 'http://localhost/jobbid' );
define('DEFAULT_LANG', 'vi');
define('SITE_TITLE', 'Sàn Giao Dịch Việc Làm Thêm');
define('SITE_DESCRIPTION', 'Jobbid.vn là sàn việc làm để bạn có thể đăng thông tin tuyển dụng việc làm thêm, qua đó tìm được ứng viên thích hợp để thực hiện công việc của bạn. Các bạn có thể tìm kiếm được những công việc làm thêm hoặc các dự án nhỏ phù hợp với khả năng của bạn.');
define('SITE_KEYWORDS', 'jobbid.vn,tim viec part time, tìm việc part time,sàn việc làm,viec ban thoi gian,viec lam tu do,san viec lam,viec ban thoi gian,du an, cong viec,tim viec ban thoi gian,viec lam tai nha,tim viec lam them, lam them, viec part time,cong viec ban thoi gian,tim viec,viec lam online, viec lam ban thoi gian, tìm việc làm thêm,làm thêm,việc part time,công việc tại nhà,công việc bán thời gian,dự án,công việc,tìm việc,việc làm online,việc làm bán thời gian,việc làm tại nhà, làm thêm online, làm thêm cho sinh viên, làm thêm trên mạng,việc bán thời gian,việc làm tự do');
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
define('MIN_CONTENT_LENGTH', 30);
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
define('INT_PAGE_SUPPORT', 3);
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
define('KEY_RESET_PASSWORD', 3);

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
define('ACTION_VERIFY_JOB_FAILED', 9);
define('ACTION_VERIFY_JOB_SUCCESS', 10);
define('ACTION_REFESH_JOB', 11);
define('ACTION_EDIT_JOB', 12);
define('ACTION_RESET_PASSWORD', 13);

//limit in session 
define('LIMIT_REPORT', 3); //so lan report toi thieu cho phep
define('LIMIT_REGISTRATION', 3);
define('LIMIT_LOGIN_FAILED', 50);
define('LIMIT_POST_JOB', 2); //so lan dang cong viec cho phep
define('LIMIT_VERIFY_FAILED', 3);
define('LIMIT_REFESH_JOB', 3);
define('LIMIT_EDIT_JOB', 3); //so lan edit cong viec cho phep
define('LIMIT_RESET_PASSWORD', 3); //so lan edit cong viec cho phep

//email subjects
define('EMAIL_SUBJECT_VERIFY_ACCOUNT', '[jobbid.vn] Email kích hoạt tài khoản.');
define('EMAIL_SUBJECT_VERIFY_JOB', '[jobbid.vn] Email xác nhận tin tuyển dụng.');

//CACHE
define('CACHE_TOP_TAGS', 'CACHE_TOP_TAGS');
define('CACHE_ALL_TAGS', 'CACHE_ALL_TAGS');
define('CACHE_TAGS_CLOUD', 'CACHE_TAGS_CLOUD');
define('CACHE_TRANSFER_ID', 'CACHE_TRANSFER_ID');
define('CACHE_JOB_TAGS', 'CACHE_JOB_TAGS');

//Curl
define('PATH_COOKIE', 'd://NOTES/crawling/cookie.txt');
define('PATH_LOG_FILES', 'd://NOTES/crawling/logs/');
<?php
use kartik\mpdf\Pdf;
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],    
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            //'cookieValidationKey' => 'oQ0MnuOPwhQmR_9qWwUFwRdLLC5sY6C5',
            /*'cookieValidationKey' => '',
            'enableCsrfValidation' => false,*/

            'enableCookieValidation' => false,
            'cookieValidationKey' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
	    'class' => 'webvimark\modules\UserManagement\components\UserConfig',
	    // Comment this if you don't want to record user logins
	    'on afterLogin' => function($event) {
                \webvimark\modules\UserManagement\models\UserVisitLog::newVisitor($event->identity->id);
            }
            
            //'identityClass' => 'app\models\User', 	// default
            //'enableAutoLogin' => true,		// default
        ],       

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<action>' => 'site/<action>',                
                '/backend/login' => '/user-management/auth/login',
               [
                    'pattern' => 'backend/<controller>/',
                    'route' => 'backend/<controller>/index/',
                    'suffix' => '/'
                ],
                [
                    'pattern' => '<controller>/',
                    'route' => '<controller>/index',
                    'suffix' => '/'
                ],
            ],
        ],
       'pdf' => [
            'mode' => Pdf::MODE_UTF8,
            'class' => Pdf::classname(),
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'cssFile' => '@web/css/styles.css',
            'options' => [
                'ignore_invalid_utf8' => true,
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '-',
        ],
    ],
    'modules'=>[
      'user-management' => [
        'class' => 'webvimark\modules\UserManagement\UserManagementModule',
        // Here you can set your handler to change layout for any controller or action
        // Tip: you can use this event in any module
        'on beforeAction'=>function(yii\base\ActionEvent $event) {
            if ( $event->action->uniqueId == 'user-management/auth/login' ){
                $event->action->controller->layout = 'loginLayout.php';
            };
        },
      ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['95.161.6.148', '127.0.0.1', '93.185.27.40']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['95.161.6.148', '127.0.0.1']
    ];
}


/*if($_REQUEST['dev']){
    $config['components'][] = 'pdf';
    $config['components']['pdf'] = [
        'mode' => Pdf::MODE_UTF8,
        'class' => Pdf::classname(),
        'format' => Pdf::FORMAT_A4,
        'orientation' => Pdf::ORIENT_PORTRAIT,
        'destination' => Pdf::DEST_BROWSER,
        'cssFile' => '@web/css/styles.css',
        'options' => [
            'ignore_invalid_utf8' => true,
        ]
    ];
}*/

return $config;

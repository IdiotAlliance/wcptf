<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'微积分',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'timeZone'=>'Asia/Shanghai',
	'charset'=>'utf-8',


	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'accounts',
		'takeAway',
		
	),

	// application components
	'components'=>array(
		'request'=>array(
			'enableCookieValidation'=>true,
		),
      
  		'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('accounts/login/login'),
			'returnUrl'=>array('site/index'),
		),
		'session'=>array(
		   'autoStart'=>true,
		   'sessionName'=>'typeCount',
		   'cookieMode'=>'only',
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'db'=>array(
			'connectionString' => 'mysql:host=127.0.0.1;dbname=wcptf_dev',
			'emulatePrepare' => true,
			'username' => 'wcadmin',
			'password' => '123',
			'charset' => 'utf8',
			'enableProfiling'=>true, 
            'enableParamLogging'=>true, 
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'categories'=>'system.db.*',
					'logFile'=>'AR.log',
                    'maxFileSize'=>'5000000',
                ),
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
					'logFile'=>'error.log',
				),
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'info',
					'logFile'=>'info.log',
				),
				array(
                    'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',//加载
                    'ipFilters'=>array('127.0.0.1'),//运行显示的ip
                    'levels'=>'error,warning',//提示等级
                ),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
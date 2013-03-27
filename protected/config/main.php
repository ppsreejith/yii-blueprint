<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Blueprint',

	// preloading 'log' component
	'preload'=>array('log','bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'generatorPaths'=>array(
                'bootstrap.gii',
            ),
			'class'=>'system.gii.GiiModule',
			'password'=>'galaxy',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),
	// application components
	'components'=>array(
		'bootstrap'=>array(
            'class'=>'ext.bootstrap.components.Bootstrap',
			'responsiveCss' => true,
        ),
		'contentCompactor' => array(
			'class' => 'ext.contentCompactor.ContentCompactor',
			'options' => array(
				'compress_css' => true, // Compress CSS
				'strip_comments' => true, // Remove comments
				'keep_conditional_comments' => true, // Remove conditional comments
				'compress_horizontal' => true, // Compress horizontally
				'compress_vertical' => true, // Compress vertically
				'compress_scripts' => true, // Compress inline scripts using basic algorithm
				'line_break' => PHP_EOL, // The type of rowbreak you use in your document
				'preserved_tags' => array('textarea', 'pre', 'script', 'style', 'code'),
				'preserved_boundry' => '@@PRESERVEDTAG@@',
				'conditional_boundries' => array('@@IECOND-OPEN@@', '@@IECOND-CLOSE@@'),
				'script_compression_callback' => false,
				'script_compression_callback_args' => array(),
			),
		),
		'clientScript'=>array(
			'class'=>'ext.minScript.components.ExtMinScript',
        ),
        'request'=>array(
                     'class'=>'EHttpRequest',
               ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'showScriptName'=>false,
			'caseSensitive'=>false,
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),
	
	'controllerMap'=>array(
		'min'=>array(
				'class'=>'ext.minScript.controllers.ExtMinScriptController',
		),
    ),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
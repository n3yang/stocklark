<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=stocklark',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'cache'	=> array(
			'class'	=> 'system.caching.CApcCache',
		),
	),
	'commandMap'=>array(
		'send'	=> array('class'=>'application.commands.shell.WechatSendCommand'),
	),
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
);
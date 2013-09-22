<?php
Yii::import('application.libraries.*');
require_once 'Wechat.class.php';

Class WechatCom extends Wechat
{

	function __construct() {
		$option = array(
			'token'			=> Yii::app()->params['wechat_access_secret'],
			'account'		=> Yii::app()->params['wechat_login_user'],
			'password'		=> Yii::app()->params['wechat_login_pass'],
			"wechattool"	=> new WechatTool()
		);
		return parent::__construct($option);
	}

}
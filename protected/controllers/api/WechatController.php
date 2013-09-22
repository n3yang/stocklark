<?php

class WechatController extends Controller
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$wt = new WechatTool;
		// var_dump($wt->setAssociation(123,123,array('NickName'=>'hi')));
		Yii::log(var_dump($_REQUEST,1));
		echo 'hi';
	}

}
<?php

class WechatCommand extends CConsoleCommand {

	// public function run($args) {
	// 	$db = Yii::app()->db;
		// var_dump($db);
//		$sql = 'select * from tbl_user limit 2';
		// $cmd = $db->createCommand($sql);
//		$res = $db->createCommand($sql)->queryAll();
		//$a = $db->query();
//		var_dump($res);
//		echo 'hiiiiiiiiiiiiiiiiiiiiiiiiiiiiii';

//下面是设置文件

		
		

		
	// }

	/**
	 * keep alive for wechat
	 * @return  bool
	 */
	public function actionKeepAlive()
	{
		$wechatObj = new WechatCom();
		$wechatObj->positiveInit();

		return $wechatObj->keeplive();
	}

	/**
	 * send message in queue
	 * 
	 * @return [type] [description]
	 */
	public function actionSend()
	{
		$criteria = array(
			'condition' => 'status=:need',


		);
	}

	public function actionSendTest($fakeId='', $message='')
	{
		$fakeId = "2345861760";
		$message = "hello";

		if (!$fakeId || !$message) {
			echo 'required params!';
			return false;
		}

		$wechatObj = new WechatCom();
		$wechatObj->positiveInit();
		$singleresult = $wechatObj->send($fakeId, $message);

	}
	
	public function actionGetFollower() {
		$wechatObj = new WechatCom();
		$wechatObj->positiveInit();
		var_dump($wechatObj->getFriendList());
	}

	
}
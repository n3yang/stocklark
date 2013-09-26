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

	public function actionLogout($session="default")
	{
		Yii::app()->cache->set("wechat_cookies".$session, '');
		Yii::app()->cache->set("wechat_token", '');
	}

	/**
	 * keep alive for wechat
	 * @return  bool
	 */
	public function actionKeepAlive()
	{
		$wechatObj = new WechatCom();
		return $wechatObj->positiveInit()->keeplive();
	}

	/**
	 * send message in queue
	 * 
	 * @return [type] [description]
	 */
	public function actionSend()
	{
		// waiting message queue
		sleep(10);
		$criteria = array(
			'condition' => 't.status=:tosend',
			'params'	=> array(':tosend'=>MessageQueueAr::STATUS_TO_SEND),
		);
		$queue = MessageQueueAr::model()->with('user')->findALL($criteria);
		if (!$queue){
			return 0;
		}
		$wechatObj = new WechatCom();
		$wechatObj->positiveInit();
		foreach ($queue as $message) {
			if ($message->user->wechat_fake_id) {
				// TODO: log result
				// 返回发送结果：成功返回:1,登录问题返回:-1;需要验证码:-6;其他
				$singleresult = $wechatObj->send($message->user->wechat_fake_id, $message->content);
				if ($singleresult==1){
					$message->status = MessageQueueAr::STATUS_SUCESS;	
				} else {
					$message->status = MessageQueueAr::STATUS_FAULT;
				}
				$message->save();
			}
		}
		return 1;
	}

	/**
	 * send test message
	 * @param  string $fakeId  faked user id
	 * @param  string $message content
	 * @return bool          true/false
	 */
	public function actionSendTest($fakeId='', $message='')
	{
		$fakeId = empty($fakeId) ? "2345861760" : $fakeId;
		$message = empty($message) ? 'hello' : $message;

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
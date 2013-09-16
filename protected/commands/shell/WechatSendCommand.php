<?php

class WechatSendCommand extends CConsoleCommand {

	public function run($args) {
		$db = Yii::app()->db;
		// var_dump($db);
//		$sql = 'select * from tbl_user limit 2';
		// $cmd = $db->createCommand($sql);
//		$res = $db->createCommand($sql)->queryAll();
		//$a = $db->query();
//		var_dump($res);
//		echo 'hiiiiiiiiiiiiiiiiiiiiiiiiiiiiii';

//下面是设置文件

		
		
		$wechatObj = new WechatCom();
		$wechatObj->positiveInit();
		$singleresult = $wechatObj->send("2345861760", "你好");
		
	}
	
	public function actionGetFollower() {
				$wechatToolObj = new WechatTool();

//下面是设置文件
		$option = array(
			'token'=>'mytoken',
			'account'=>'',
			'password'=>'',
			"wechattool"=>$wechatToolObj /*这里是上面的接口类实例对象,也可以通过setWechatToolFun()设置*/
		);
				$wechatObj = new Wechat($option);
		$wechatObj->positiveInit();
		var_dump($wechatObj->getFriendList());
	}

	
}
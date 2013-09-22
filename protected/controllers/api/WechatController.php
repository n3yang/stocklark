<?php

class WechatController extends Controller
{

	/**
	 * 
	 * 
	 */
	public function actionIndex()
	{
		// record the request
		Yii::log(var_export($_REQUEST, 1), 'info');
		// check token
		$wechatObj = new WechatCom;
		$wechatObj->valid();
		$wechatObj->positiveInit();  //主动响应组件初始化
		$wechatObj->setAutoSendOpenidSwitch(TRUE);  //设置自动附带发送Openid
		$wechatObj->setPassiveAscSwitch(TRUE, TRUE);  //设置打开被动关联组件，并获取用户详细信息

		$revtype = $wechatObj->getRev()->getRevType();

		switch($revtype) {
			case Wechat::MSGTYPE_TEXT:
				if(strstr($wechatObj->getRevContent(),"d")) {
					$wechatObj->text("d-test")->reply();
				}
				/***********************************************************************************/
				elseif (strstr($wechatObj->getRevContent(),"3")) {
					$wechatObj->text("是你英明的老大啊。\n\n你快点叫老大吧。")->reply();
				}
				/***********************************************************************************/
				elseif (preg_match('/^[\s]*?帮助[\s]*?$/', $wechatObj->getRevContent())||preg_match('/^[\s]*?help[\s]*?$/', $wechatObj->getRevContent())) {
					$wechatObj->text("有效的指令\n我的订阅\n推荐订阅\n取消订阅\n")->reply();
				}
				/***********************************************************************************/
				else {
					$wechatObj->text("默认回复")->reply();
				}
				break;
			case Wechat::MSGTYPE_EVENT:
				$revEvent = array();
				$revEvent = $wechatObj->getRevEvent();
				switch ($revEvent['event']) {
					case "subscribe":
						$wechatObj->text("欢迎您关注股市百灵鸟，我们会用心为您服务。\n目前您可以使用的功能有：\n")->reply();
						break;
					case "unsubscribe":
						// uipdate user information
						break;
				}
				break;
			default:
				$wechatObj->text("help info")->reply();
		}

	}

}
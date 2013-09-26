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
		// Yii::log(var_export($_REQUEST, 1), 'info');
		// Yii::log(file_get_contents("php://input"), 'info');
		// check token
		$wechatObj = new WechatCom;
		if (!$wechatObj->valid(true)){
			return ;
		}
		$wechatObj->positiveInit();  //主动响应组件初始化
		// $wechatObj->setAutoSendOpenidSwitch(TRUE);  //设置自动附带发送Openid
		$wechatObj->setPassiveAscSwitch(TRUE, TRUE);  //设置打开被动关联组件，并获取用户详细信息

		$revtype = $wechatObj->getRev()->getRevType();

		switch($revtype) {
			case Wechat::MSGTYPE_TEXT:
				$content =& $wechatObj->getRevContent();
				if(strstr($content,"1")) {
					$wechatObj->text("d-test")->reply();
				}
				/***********************************************************************************/
				elseif (strstr($content,"3")) {
					$wechatObj->text("老大你好啊，您辛苦啦！")->reply();
				}
				/***********************************************************************************/
				elseif (preg_match('/^[\s]*?帮助[\s]*?$/', $content)
					||preg_match('/^[\s]*?help[\s]*?$/', $content)
					||strstr($content, '?')||strstr($content, '？')
					) {
					$wechatObj->text("您可以回复下述指令以获得更多有效的指令\n我的订阅（或者数字“1”）\n推荐订阅（或者数字“2”）\n")->reply();
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
						$wechatObj->text("欢迎您关注股市百灵鸟，我们会用心为您服务。\n您可以回复“帮助”或者“?”来获取更多信息。\n")->reply();
						break;
					case "unsubscribe":
						// update user information in wechattool->followCancelAction
						break;
				}
				break;
			default:
				$wechatObj->text("sorry, I can't understand. please type 'help' or '?' to get more information.")->reply();
		}

	}

}
<?php

class WechatController extends Controller
{

	protected $oWechat = '';

	public function __construct()
	{
		$this->oWechat = new WechatCom;
	}

	/**
	 * 
	 * 
	 */
	public function actionIndex()
	{
		// record the request
		Yii::log(var_export($_REQUEST, 1), 'info');
		Yii::log(file_get_contents("php://input"), 'info');
		// check token
		$wechatObj = &$this->oWechat;
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
				/*************************************/
				if (preg_match('/^[0,2,3,6,9]\d{5}$/', $content)){
					$this->replyStock($content);
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
					$wechatObj->text("您可以回复下述指令以获得更多有效的指令\n我的订阅（或数字“1”）\n推荐订阅（或数字“2”）\n")->reply();
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


	public function replyStock($sid)
	{
		$s = new SpiderSina;
		$stock = $s->getStock($sid);
		$message = "名  称：".$stock['name']."\n"
			.'涨  跌：'.$stock['open']."\n"
			.'当  前：'.$stock['current']."\n"
			.'今  开：'.$stock['open']."\n"
			.'最  高：'.$stock['max']."\n"
			.'最  低：'.$stock['min']."\n"
			.'昨  收：'.$stock['yestoday']."\n"
			.'成交量：'.$stock['turnover']."\n"
			.'成交额：'.$stock['turnover_v']."\n"
			.'总市值：'.$stock['total_v']."\n"
			.'振  幅：'.$stock['swing']."\n"
			.'换手率：'.$stock['exchange']."\n"
			.'市净率：'.$stock['pb']."\n"
			.'市盈率：'.$stock['ttm']."\n"
			.'更新时间：'.date('Y-m-d H:i:s', strtotime($stock['update']));
		$this->oWechat->text($message)->reply();
	}

}
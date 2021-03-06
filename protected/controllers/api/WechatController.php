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
		// Yii::log(var_export($_REQUEST, 1), 'info');
		// Yii::log(file_get_contents("php://input"), 'info');
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
				$content = $wechatObj->getRevContent();
				/********** 股票代码 **********/
				if (preg_match('/^[0,2,3,6,9]\d{5}$/', $content)){
					$this->replyStock($content);
				}
				/********** my subscribe **********/
				elseif ($content == "1" || strstr($content, "我的订阅")) {
					$this->replyMySubscribe($wechatObj->getRevFrom());
				}
				/********** recommand **********/
				elseif ($content == "2" || strstr($content, "推荐订阅")) {
					$this->replyRecommend();
				}
				/********** spicel code **********/
				elseif ($content == "3") {
					$wechatObj->text("老大你好啊，您辛苦啦！")->reply();
				}
				/********** help info **********/
				elseif (preg_match('/^[\s]*?帮助[\s]*?$/', $content)
					||preg_match('/^[\s]*?help[\s]*?$/', $content)
					||strstr($content, '?')||strstr($content, '？')
					) {
					$this->replyHelp();
				}
				/********** 模糊查询股票信息 **********/
				else if (preg_match('/^[a-zA-Z]{3,4}$/', $content)
					|| preg_match('/^[\x{4e00}-\x{9fa5}]{3,4}$/u', $content)) {
					$this->replyStockSmarty($content);
				}
				/********** default help info **********/
				else {
					$this->replyHelp();
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


	protected function replyStock($sid)
	{
		Yii::log('Receiving stock request: '.$sid, 'trace');
		$s = new SpiderSina;
		$stock = $s->getStock($sid);
		if (!$stock) {
			$message = '没有查询到相应的股票信息，请重新输入股票代码，如问题依旧，回复“建议：+内容”反馈给我们，谢谢！';
		} else {
			$up = number_format($stock['current']-$stock['yestoday'], 2);
			$rate = $stock['yestoday']==0 ? '' : '('.number_format(($up/$stock['yestoday'])*100, 2).'%)';
			$message = $stock['name']."\n"
				.'上涨: '."$up $rate\n"
				.'当前: '.$stock['current']."\n"
				.'今开: '.$stock['open']."　".'昨收: '.$stock['yestoday']."\n"
				.'最高: '.$stock['max']."　".'最低: '.$stock['min']."\n"
				.'成交量: '.$stock['turnover']."万手\n"
				.'成交额: '.$stock['turnover_v']."万元\n"
				.'总市值: '.$stock['total_v']."亿元\n"
				.'振　幅: '.$stock['swing']."%\n"
				.'换手率: '.$stock['exchange']."%\n"
				.'市净率: '.$stock['pb']."%\n"
				.'市盈率: '.$stock['ttm']."%\n"
				.'更新时间: '.date('m.d H:i:s', $stock['update']);
		}
		$this->oWechat->text($message)->reply();
	}

	protected function replyStockSmarty($str)
	{
		Yii::log('Receiving stock smarty request: '.$str, 'trace');
		$s = new SpiderSina;
		return $this->replyStock($s->getStockIdSmarty($str));
	}

	protected function replyHelp()
	{
		$message = "您可以回复下述指令以查询更多信息：\n"
			."我的订阅（或数字“1”）\n"
			."推荐订阅（或数字“2”）\n"
			."股票代码（如：“000001”或“payh”或“平安银行”）";
		$this->oWechat->text($message)->reply();
	}

	protected function replyMySubscribe($openId)
	{
		$ua = UserAr::model()->findByAttributes(array('wechat_open_id'=>$openId));
		if (!$ua) {
			$this->oWechat->text('未找到匹配数据')->reply();
			return false;
		}
		$sas = SubscribeAr::model()->findAllByAttributes(array('user_id'=>$ua->id));
		if (!$sas){
			$this->oWechat->text("您还没有任何订阅信息。\n回复数字“2”即可查看推荐订阅，赶快试试吧！")->reply();
			return false;
		}
		foreach ($sas as $sa) {
			if ($sa->type == SubscribeAr::TYPE_SINA_GAME_PLAYER) {
				$attributes = array(
					'source'		=> 'sina',
					'source_uid'	=> $sa->feature,
				);
				$pa = PlayerAr::model()->findByAttributes($attributes);
				$messages[] = '新浪投顾大赛选手：'.$pa->name. '，到期日：' . date('Y.m.d', strtotime($sa->time_over));
			}
			// TODO
			if ($sa->type == SubscribeAr::TYPE_SINA_GAME_STOCK) {
				$stockIds[] = $sa->feature;
				$messages[] = '新浪投顾大赛股票：'.$sa->feature. '，到期日：' . date('Y.m.d', strtotime($sa->time_over));
			}
		}
		$i = 1;
		$message = '';
		foreach ($messages as $v) {
			$message.= $i.'. '.$v."\n";
			$i++;
		}
		$this->oWechat->text($message)->reply();
	}

	protected function replyRecommend()
	{
		$criteria = array('limit'=>5, 'order'=>'profit_ratio_total desc');
		$pas = PlayerAr::model()->findAll($criteria);
		$i = 1;
		$message = '';
		foreach ($pas as $pa) {
			$message .= $i . '. ' . $pa->name . '，总收益：' . $pa->profit_ratio_total . '%，20天收益：' . $pa->profit_ratio_d20 . "\n";
			$i++;
		}
		$message = "新浪投顾大赛推荐订阅：\n" . $message;
		$this->oWechat->text($message)->reply();
	}

}
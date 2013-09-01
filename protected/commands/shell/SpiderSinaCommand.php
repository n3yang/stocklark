<?php

class SpiderSinaCommand extends CConsoleCommand {

	public function __construct()
	{
		
	}

	public function actionGetTrade()
	{

	}

	public function actionUpdatePlayer($num=10)
	{
		$spider = new SpiderSina();
		$players = $spider->getPlayer($num);
		if ($players){
			foreach ($players['data'] as $key => $player) {
				if ($player){
					$oPlayer = new PlayerAr();
					$criteria = array(
						'condition'	=> 'source_uid=:source_uid AND source=:source',
						'params'	=> array(':source_uid'=>$player['sid'], ':source'=>'sina'),
					);
					$record = $oPlayer->find($criteria);
					if (is_subclass_of($record, 'CActiveRecord')) {
						$oPlayer = $record;
					} else {
						$oPlayer->time_create = date('Y-m-d H:i:s'); // 创建时间
					}
					$oPlayer->source_uid = $player['sid'];
					$oPlayer->name = $player['user_info']['xingming'];
					$oPlayer->st = $player['user_info']['qs_name']; // 券商
					$oPlayer->sd = $player['user_info']['yingyebu']; // 营业部
					$oPlayer->title = $player['user_info']['zhiwei']; // 职位
					$oPlayer->intro = $player['user_info']['intr']; // 介绍
					$oPlayer->certificate = $player['user_info']['zhiyezhenghao']; // 执业证号
					$oPlayer->profit_ratio_d1 = $player['d1_profit_ratio']; // 收益率
					$oPlayer->profit_ratio_d5 = $player['d5_profit_ratio']; // 收益率
					$oPlayer->profit_ratio_d20 = $player['d20_profit_ratio']; // 收益率
					$oPlayer->profit_ratio_total = $player['total_profit_ratio']; // 收益率
					$oPlayer->time_update = date('Y-m-d H:i:s'); // 更新时间
					$oPlayer->save();
				}
			}
			echo 'done!';
		} else {
			Yii::log('fault to get sina players', 'error');
			echo 'fault';
		}

	}

}
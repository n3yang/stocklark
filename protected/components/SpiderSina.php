<?php
/**
 * The spider of sina finance
 */
class SpiderSina {
	

	const URI_TRADE = 'http://stock.finance.sina.com.cn/match/api/openapi.php/TouGuDaSai_Service.getTranslation';
	const URI_PLAYER = 'http://stock.finance.sina.com.cn/match/api/openapi.php/TouGuDaSai_Service.getZongHeShouYi';
	const URI_TRADE_BY_UID = 'http://stock.finance.sina.com.cn/match/api/openapi.php/Order_Service.getTransaction';

	protected $cid = '';
	public function __construct()
	{
		$this->cid = 1001;
	}

	public function getTrade($date='', $page=1)
	{
		if (!$date){
			$date = date('Y-m-d');
		}
		$query = array(
			'cid'			=> $this->cid,
			'start_date'	=> $date,
			'page'			=> $page==1 ? 1 : $page,
		);
		$res = file_get_contents(self::URI_TRADE.'?'.http_build_query($query));
		if (empty($res)) {
			$this->log('no response!', __METHOD__);
			return false;
		}
		// 
		$result = json_decode($res, true);
		if ($result['result']['status']['code']!='0' || empty($result['result']['data']['data'])){
			$this->log('no data!', __METHOD__);
			return false;
		}
		return $result['result']['data'];
	}

	/**
	 * get trade log by sina uid
	 * @param  string $sinaUid sina uid
	 * @param string $sort 1:desc
	 * @return array  
	 */
	public function getTradeByUid($sinaUid, $count=10, $sort='1')
	{
		// ?uid=3546860260&cid=1001&sort=1
		if (!$sinaUid){
			return false;
		}
		$query = array(
			'cid'	=> $this->cid,
			'uid'	=> $sinaUid,
			'sort'	=> $sort,
			'count'	=> $count,
		);
		$res = file_get_contents(self::URI_TRADE_BY_UID.'?'.http_build_query($query));
		if (empty($res)) {
			$this->log('no response', __METHOD__);
			return false;
		}
		$result = json_decode($res, true);
		if ($result['result']['status']['code']!='0' || empty($result['result']['data']['data'])){
			$this->log('no data!', __METHOD__);
			return false;
		}
		return $result['result']['data'];
	}


	public function getPlayer($num=50)
	{
		$query = array(
			'cid'		=> $this->cid,
			'page'		=> 1,
			'page_num'	=> $num,
			);
		$res = file_get_contents(self::URI_PLAYER.'?'.http_build_query($query));
		if (empty($res)) {
			$this->log('no response!', __METHOD__);
			return false;
		}
		$result = json_decode($res, true);
		if ($result['result']['status']['code']!='0' || empty($result['result']['data']['data'])){
			$this->log('no data!', __METHOD__);
			return false;
		}
		return $result['result']['data'];
	}

	private function log($text, $method='', $level='error')
	{
		Yii::log(__CLASS__.':'.$method.':'.$text, $level);
	}
}

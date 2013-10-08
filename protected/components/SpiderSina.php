<?php
/**
 * The spider of sina finance
 */
class SpiderSina {
	
	const URI_TRADE = 'http://stock.finance.sina.com.cn/match/api/openapi.php/TouGuDaSai_Service.getTranslation';
	const URI_PLAYER = 'http://stock.finance.sina.com.cn/match/api/openapi.php/TouGuDaSai_Service.getZongHeShouYi';
	const URI_TRADE_BY_UID = 'http://stock.finance.sina.com.cn/match/api/openapi.php/Order_Service.getTransaction';
	const URI_STOCK = 'http://qt.gtimg.cn/';
	const URI_STOCK_SMARTY = 'http://smartbox.gtimg.cn/s3/';

	const CKEY_STOCK_SMARTY = 'STOCK_SMARTY';

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

	public function getStock($stock)
	{
		if (!$stock) {
			return false;
		}

		if (preg_match('/^[6,9]\d{5}$/', $stock)){
			$stock = 'sh'.$stock;
		}
		if (preg_match('/^[0,2,3]\d{5}$/', $stock)){
			$stock = 'sz'.$stock;
		}

		$res = $this->getHttp(self::URI_STOCK.'?q='.$stock);
		$res = iconv('GBK', 'UTF-8', $res);
		// parse result
		$ds = explode('~', $res);
		if (empty($ds[1])) {
			return '';
		}
		$stock = array(
			'name'		=> $ds[1],
			'code'		=> $ds[2],
			'current'	=> $ds[3],
			'yestoday'	=> $ds[4],
			'open'		=> $ds[5],
			'max'		=> $ds[33], // 41 最高价
			'min'		=> $ds[34], // 42 
			'turnover'	=> number_format($ds[6]/10000, 2, '.', ''), //turnover 万手
			'turnover_v'=> number_format($ds[37], 2, '.', ''), // wan元 //bug
			'total_v'	=> $ds[45], // 总市值
			'cmv'		=> $ds[44], // 流通市值
			'swing'		=> $ds[43], // 振幅
			'exchange'	=> $ds[38], // 换手率
			'pb'		=> $ds[46], // 市净率
			'ttm'		=> $ds[39], // 市盈率
			'update'	=> strtotime($ds[30]),
		);

		return $stock;
	}

	public function getStockIdSmarty($str)
	{
		if (!$str) {
			return false;
		}
		$ckey = self::CKEY_STOCK_SMARTY . '_' . md5($str);
		$sid = Yii::app()->cache->get($ckey);
		if (!$sid) {
			$res = $this->getHttp(self::URI_STOCK_SMARTY.'?q='.urlencode($str).'&t=gp');
			$ds = explode('~', $res);
			if (!empty($ds[1])){
				Yii::app()->cache->set($ckey, $ds[1], 1800);
				$sid = $ds[1];
			}
		}
		
		return empty($sid) ? '' : $sid;
	}

	private function getHttp($url){
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_FOLLOWLOCATION	=> 1,
			CURLOPT_TIMEOUT			=> 10,
			CURLOPT_RETURNTRANSFER	=> 1,
			CURLOPT_URL				=> $url,
			CURLOPT_USERAGENT		=> 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) Safari/536.30.1',
			));
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}

	private function log($text, $method='', $level='error')
	{
		Yii::log(__CLASS__.':'.$method.':'.$text, $level);
	}
}


new SpiderSina;
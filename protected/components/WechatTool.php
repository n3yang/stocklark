<?php
// Yii::import('application.libraries.*');
// require_once 'Wechat.class.php';
/**
 * 微信调用接口类
 */
class WechatTool {

	function __construct(){
	}

	/**
	 * @name 获取Cookies
	 * @see WechatSessionToolInter::getCookies()
	 */
	public function getCookies($session="default") {
		return Yii::app()->cache->get("wechat_cookies".$session);
	}

	/** 
	 * @name 获取token
	 * @see WechatSessionToolInter::getToken()
	 */
	public function getToken() {
		return Yii::app()->cache->get("wechat_token");
	}

    /**
     * @name 设置保存Cookies
     * @param string $Cookies
     * @param string $session
     * @see WechatSessionToolInter::setCookies()
     */
	public function setCookies($Cookies, $session='default') {
		return Yii::app()->cache->set("wechat_cookies".$session, $Cookies);
	}

	/**
	 * @name 设置保存token
	 * @param string $token
	 * @see WechatSessionToolInter::setToken()
	 */
	public function setToken($token) {
		return Yii::app()->cache->set("wechat_token", $token);
	}

	private function convert($user){
		// mapping
		$user['openid'] = $user['wechat_open_id'];
		$user['fakeid'] = $user['wechat_fake_id'];
		$user['subscribed'] = $user['wechat_followed'];
		return $user;
	}

	/**
	 * @name 判断指定openId是否关联
	 * @param string $openId 指定openId
	 * @return boolean 返回逻辑判断结果
	 * @see WechatAscToolInter::getAscStatusByOpenid()
	 */
	function getAscStatusByOpenid($openId)
	{
		if (!$openId) {
			return false;
		}
		$term = array(
			'condition'	=> 'wechat_open_id=:open_id',
			'params'	=> array(':open_id'=>$openId),
		);
		$rs = UserAr::model()->find($term);
		if (!$rs){
			return false;
		} else {
			// return true;
			return $this->convert($rs->getAttributes());
		}
	}

	/**
	 * @name 判断指定fakeid是否关联 (NO USED)
	 * @param string $fakeId 指定fakeId
	 * @return boolean 返回逻辑判断结果
	 * @see WechatAscToolInter::getAscStatusByFakeid()
	 */
	function getAscStatusByFakeid($fakeId)
	{
		if (!$fakeId) {
			return false;
		}
		$term = array(
			'condition'	=> 'wechat_fake_id=:fake_id',
			'params'	=> array(':fake_id'=>$fakeId),
		);
		$rs = UserAr::model()->find($term);
		if (!$rs){
			return false;
		} else {
			return $this->convert($rs->getAttributes());
		}
	}

	/**
	 * @name 设置fakeid与Openid的关联
	 * @param string $openId openId
	 * @param string $fakeId fakeId
	 * @param string $detailInfo 用户详细信息(可选)
     * @return resource
     * @see WechatAscToolInter::setAssociation()
	 */
	function setAssociation($openId, $fakeId, $detailInfo)
	{
		if (!$openId or !$fakeId){
			return false;
		}
		$condition = array(
			'condition'	=> 'wechat_open_id=:open_id',
			'params'	=> array(':open_id'=>$openId)
		);
		$ua = UserAr::model()->find($condition);
		if (!$ua){
			return false;
		} else {
			$ua->wechat_fake_id = $fakeId;
			$ua->name = $detailInfo['NickName'];
			$ua->gender = $detailInfo['Sex'];
			return $ua->save();
		}
	}

	/**
	 * @name 用户关注执行动作
	 * @param string $openId openId
     * @return bool|resource
     * @see WechatFollowToolInter::followAddAction()
	 */
	function followAddAction($openId)
	{
		if (!$openId) {
			return false;
		}
		$condition = array(
			'condition'	=> 'wechat_open_id=:open_id',
			'params'	=> array(':open_id'=>$openId)
		);
		$ua = UserAr::model()->find($condition);
		if (!$ua) {
			$ua = new UserAr;
		}
		$ua->wechat_open_id = $openId;
		$ua->wechat_followed = 1;
		return $ua->save();
	}

	/**
	 * @name 取消关注执行动作
	 * @param string $openId openId
	 * @see WechatFollowToolInter::followCancelAction()
	 */
	function followCancelAction($openId) {
		if (!$openId){
			return  false;
		}
		$condition = array(
			'condition'	=> 'wechat_open_id=:open_id',
			'params'	=> array(':open_id'=>$openId)
		);
		$ua = UserAr::model()->find($condition);
		if (!$ua){
			return false;
		} else {
			$ua->wechat_followed = 0;
			return $ua->save();
		}
	}

}
<?php
Yii::import('application.libraries.*');
require_once 'Wechat.class.php';
/**
 * 微信调用接口类
 */
class WechatTool implements WechatSessionToolInter,WechatAscToolInter,WechatFollowToolInter{

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
		Yii::app()->cache->set("wechat_cookies".$session, $Cookies);
	}

	/**
	 * @name 设置保存token
	 * @param string $token
	 * @see WechatSessionToolInter::setToken()
	 */
	public function setToken($token) {
		Yii::app()->cache->set("wechat_token", $token);
	}

	/**
	 * @name 判断指定Openid是否关联
	 * @param string $Openid 指定Openid
	 * @return boolean 返回逻辑判断结果
	 * @see WechatAscToolInter::getAscStatusByOpenid()
	 */
	function getAscStatusByOpenid($Openid)
	{
		$sql = "SELECT * FROM weixin_followusers WHERE weixin_followusers.openid='$Openid'";
		$db_link = mysql_connect("127.0.0.1", "root", "password");
		if (!$db_link) {
			die("Connect Db Error!");
		}
		mysql_select_db("db_name", $db_link);
		mysql_query("set names 'utf8'", $db_link);
		// 	$query = "Select * from 'weixin_fakelist'";
		$result = mysql_query($sql, $db_link);
		$row = mysql_fetch_assoc($result);
		if ($row[2]!="")
		{
			return $row;
		}
		else
		{
			return false;
		}
	}

	/**
	 * @name 判断指定fakeid是否关联
	 * @param string $fakeid 指定fakeid
	 * @return boolean 返回逻辑判断结果
	 * @see WechatAscToolInter::getAscStatusByFakeid()
	 */
	function getAscStatusByFakeid($fakeid)
	{
		$sql = "SELECT * FROM weixin_followusers WHERE weixin_followusers.fakeid='$fakeid'";
		$db_link = mysql_connect("127.0.0.1", "root", "");
		if (!$db_link) {
			die("Connect Db Error!");
		}
		mysql_select_db("db_name", $db_link);
		mysql_query("set names 'utf8'", $db_link);
		$result = mysql_query($sql, $db_link);
		$row = mysql_fetch_assoc($result);
		if ($row) {
			return $row;
		}
		else
		{
			return false;
		}
	}

	/**
	 * @name 设置fakeid与Openid的关联
	 * @param string $openid Openid
	 * @param string $fakeid fakeid
	 * @param string $detailInfo 用户详细信息(可选)
     * @return resource
     * @see WechatAscToolInter::setAssociation()
	 */
	function setAssociation($openid, $fakeid, $detailInfo)
	{
		$sql = "SELECT * FROM weixin_followusers WHERE weixin_followusers.openid='$openid'";
		$insertsql = "UPDATE weixin_followusers SET fakeid='$fakeid',name='$detailInfo[NickName]',gender='$detailInfo[Sex]'  WHERE weixin_followusers.openid='$openid'";
		$db_link = mysql_connect("127.0.0.1", "root", "");
		if (!$db_link) {
			die("Connect Db Error!");
		}
		mysql_select_db("db_name", $db_link);
		mysql_query("set names 'utf8'", $db_link);
		$result = mysql_query($insertsql, $db_link);
		return $result;
	}

	/**
	 * @name 用户关注执行动作
	 * @param string $openid Openid
     * @return bool|resource
     * @see WechatFollowToolInter::followAddAction()
	 */
	function followAddAction($openid)
	{
		$sql = "SELECT id,fakeid,subscribed FROM weixin_followusers WHERE weixin_followusers.openid='$openid'";
		$updatesql = "UPDATE weixin_followusers SET weixin_followusers.subscribed=1 WHERE weixin_followusers.openid='$openid'";
		$insertsql = "INSERT INTO weixin_followusers(openid,subscribed) VALUE ('$openid',1)";
		$db_link = mysql_connect("127.0.0.1", "root", "");
		if (!$db_link) {
			die("Connect Db Error!");
		}
		mysql_select_db("db_name", $db_link);
		mysql_query("set names 'utf8'", $db_link);
		$result = mysql_query($sql, $db_link);
		$row = mysql_fetch_assoc($result);
		var_dump($row);
		if ($row[2]==="0")
		{
				return mysql_query($updatesql, $db_link);
		}
		elseif($row[2]==="1")
		{
			return true;
		}
		else
		{
			return mysql_query($insertsql, $db_link);
		}
	}

	/**
	 * @name 取消关注执行动作
	 * @param string $openid Openid
	 * @see WechatFollowToolInter::followCancelAction()
	 */
	function followCancelAction($openid) {
		$updatesql = "UPDATE weixin_followusers SET weixin_followusers.subscribed=0 WHERE weixin_followusers.openid='$openid'";
		$db_link = mysql_connect("127.0.0.1", "root", "");
		if (!$db_link) {
			die("Connect Db Error!");
		}
		mysql_select_db("db_name", $db_link);
		mysql_query("set names 'utf8'", $db_link);
		$result = mysql_query($updatesql, $db_link);
	}

}
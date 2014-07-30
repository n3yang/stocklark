<?php
Yii::import('application.libraries.*');
require_once 'Wechat.class.php';

Class WechatCom extends Wechat
{
	
	/**
	 * construction
	 */
	function __construct()
	{
		$option = array(
			'token'			=> Yii::app()->params['wechat_access_secret'],
			'account'		=> Yii::app()->params['wechat_login_user'],
			'password'		=> Yii::app()->params['wechat_login_pass'],
			"wechattool"	=> new WechatTool()
		);
		return parent::__construct($option);
	}

	protected function log($message='')
	{
		if ($this->debug) {
			Yii::log('Receiving stock request: '.var_export($message, 1), 'debug');
		}
		return null;
	}

	/**
	 * do association action when receiving a message from wechat server
	 * if we dont have the detail, we shall fetch it from webpage
	 * 
	 * @return object $this
	 */
	protected function doAssociationAction()
	{
		if ($this->_passiveAssociationSwitch 
			&& Wechat::MSGTYPE_EVENT!=$this->getRevType() 
			&& is_object($this->_wechatcallbackFuns) 
			&& method_exists($this->_wechatcallbackFuns, "getAscStatusByOpenid") 
			&& method_exists($this->_wechatcallbackFuns, "setAssociation"))
		{
			// have get it or more than 1 day?
			$user = $this->_wechatcallbackFuns->getAscStatusByOpenid($this->getRevFrom());
			if (!$user['wechat_fake_id'] || time()-strtotime($user['time_update']) > 86400)
			{
				$messageList = $this->getMessage(0, 10, 0);
				if ($messageList)
				{
					$count = 0;
					$fakeid = "";
					foreach ($messageList as $value)
					{
						if ($value['date_time']==$this->getRevCtime())
						{
							$count += 1;
							$fakeid = $value['fakeid'];
							break;
						}
					}
					if (1==$count && $fakeid!="")
					{
						$detailInfo = NULL;
						if ($this->_passiveAscGetDetailSwitch)
						{
							$detailInfo = $this->getContactInfo($fakeid);
						}
						$this->_wechatcallbackFuns->setAssociation((string)$this->getRevFrom(), $fakeid, $detailInfo);
					}
				}
			}

		}
		return $this;
	}


    /**
     * 2013.11.11更新：微信开放平台升级，兼容获取用户信息。
     * TODO：同时开放获取用户详情API，此方式可以更新。
     * 
     * 获取用户的信息
     * @param  string $fakeid 用户的fakeid
     * @param string $session
     * @return mixed 如果成功获取返回数据数组，登录问题返回false，其他未知问题返回true，
     */
    public function getContactInfo($fakeid, $session=null)
    {
        $this->processSession($session);
        $url = $this->protocol."://mp.weixin.qq.com/cgi-bin/getcontactinfo?t=ajax-getcontactinfo&lang=zh_CN&fakeid=".$fakeid;
        $this->curlInit("single");
        $postfields = array("token"=>$this->webtoken, "ajax"=>1);
        $response = $this->_curlHttpObject->post($url, $postfields, $this->protocol."://mp.weixin.qq.com/", $this->_cookies[$session]);
        $result = json_decode($response, 1);
        if($result['contact_info']['fake_id']){
            return $result['contact_info'];
        }
        elseif ($result['base_resp']['ret'])
        {
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * 主动单条发消息
     * @param $fakeid
     * @param  string $content 发送的内容
     * @param string $type
     * @param string $imgcode 验证码
     * @param string $session 会话通道
     * @return integer 返回发送结果：成功返回:1,登录问题返回:-1,;需要验证码:-6; 其他原因返回:0
     */
    public function send($fakeid, $content, $type=Wechat::MSGTYPE_TEXT, $imgcode="", $session=null)
    {
        Yii::log('fakeid:'.$fakeid.'  content:'.$content, 'info');
        $this->processSession($session);
        $rs = $this->_send($fakeid, $content, $type, $imgcode, $session);
        Yii::log('fakeid:'.$fakeid.'  return:'.$rs, 'info');
        return $rs;
    }


    /**
     * 2014.04.29 修改返回判断条件，基类方法已失效
     * 
     * 登录微信公共平台，获取并保存cookie、webtoken到指定文件
     * @param string $session
     * @return mixed 成功则返回true，失败则返回失败代码
     */
    public function login($session=null)
    {
        $this->processSession($session);
        $url = $this->protocol."://mp.weixin.qq.com/cgi-bin/login?lang=zh_CN";
        $postfields["username"] = $this->wechatOptions['account'];
        $postfields["pwd"] = md5($this->wechatOptions['password']);
        $postfields["f"] = "json";
        $postfieldss = "username=".urlencode($this->wechatOptions['account'])."&pwd=".urlencode(md5($this->wechatOptions['password']))."&f=json";

        $this->curlInit("single");
        $response = $this->_curlHttpObject->post($url, $postfields, $this->protocol."://mp.weixin.qq.com/cgi-bin/login", $this->_cookies[$session]);
        $result = json_decode($response, true);
        if ($result['base_resp']['err_msg']=="65201"
            ||$result['base_resp']['err_msg']=="65202"
            ||$result['base_resp']['err_msg']=="ok")
        {
            preg_match('/&token=([\d]+)/i', $result['redirect_url'], $match);
            $this->webtoken = $match[1];
            $this->setToken($this->webtoken);
            $this->setCookies($this->_curlHttpObject->getCookies(),$session);
            return true;
        }
        else
        {
        	// return false;
            return $result['base_resp']['err_msg'];
        }
    }


    /**
     * 2014.04.29 修改返回判断条件，基类方法已失效
     * 
     * 主动单条发消息
     * @param $fakeid 消息接收人
     * @param  string $content 发送的内容或多媒体内容的fid
     * @param null $type 消息类型 默认：Wechat::MSGTYPE_TEXT
     * @param string $imgcode 验证码
     * @param string $session 会话通道
     * @return integer 返回发送结果：成功返回:1,登录问题返回:-1;需要验证码:-6;其他
     */
    protected function _send($fakeid, $content, $type=null, $imgcode="", $session=null)
    {
        $this->processSession($session);
        if($type==null)
        {
            $type = Wechat::MSGTYPE_TEXT;
        }
        //判断cookie是否为空，为空的话自动执行登录
        if ($this->_cookies[$session]||true===$this->login($session))
        {
            $singleMessgae = array();
            $singleMessgae['fakeid'] = $fakeid;
            $singleMessgae['content'] = $content;
            $singleMessgae['imgcode'] = $imgcode;
            $singleMessgae['fid'] = $content;
            $singleMessgae['type'] = $type;
            $postfields = $this->buildPositiveMsgFields($singleMessgae);
            $url = $this->protocol."://mp.weixin.qq.com/cgi-bin/singlesend?t=ajax-response";
            $this->curlInit("single");
            $response = $this->_curlHttpObject->post($url, $postfields, $this->protocol."://mp.weixin.qq.com/cgi-bin/singlemsgpage?", $this->_cookies[$session]);
            $tmp = json_decode($response,true);
            //判断发送结果的逻辑部分
            if ('ok'==$tmp['base_resp']["err_msg"]) {
                return 1;
            }
            elseif ($tmp['base_resp']['ret']=="-2000")
            {
                return -1;
            }
            else
            {
                return $tmp['base_resp']['ret'];
            }
        }
        else  //登录失败返回false
        {
            return 0;
        }

    }


}
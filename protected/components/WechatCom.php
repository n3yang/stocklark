<?php
Yii::import('application.libraries.*');
require_once 'Wechat.class.php';

Class WechatCom extends Wechat
{
	
	protected $_passiveAssociationSwitch = FALSE;

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
				$messageList = $this->getMessage(0, 40, 0);
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




}
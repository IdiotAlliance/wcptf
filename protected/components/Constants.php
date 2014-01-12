<?php
class Constants{
	const BASE_URL = 'http://www.v7fen.com/weChat/index.php/wechat/wechatAccess/';
	const WAP_BASE_URL = 'http://www.v7fen.com/weChat/wap/';

	// types of auto replied messages
	const REPLIED_NONE    = 0x0000;
	const REPLIED_DEFAULT = 0x0001;
	const REPLIED_KEYWORD = 0x0002;
	const REPLIED_AI      = 0x0003;

	// message queue message types
	const MSG_SYSTEM  = 0x0000; // system messages
	const MSG_ORDERS  = 0x0001; // order messages
	const MSG_WECHAT  = 0x0002; // wechat messages
	const MSG_COMMENT = 0x0003; // comment
	
	// SD Messages types
	const SDMSG_AUTO    = 0x0000;
	const SDMSG_DEFAULT = 0x0001;
	const SDMSG_KEYWORD = 0x0002;
}
<?php

return [
	/**
	 * 小程序APPID
	 */
//    'appid' => 'wxfb71758f0f043c02',
    'appid' => 'wxc6cf5e40791e50d3',
    /**
     * 小程序Secret
     */
//    'secret' => 'c2185e541c2ab1efcd6b6f4bee333acd',
    'secret' => 'd229b002be1f04c32ead5acb5167861c',
    /**
     * 小程序登录凭证 code 获取 session_key 和 openid 地址，不需要改动
     */
    'code2session_url' => "https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
];

<?php

/*
 * This file is part of the mitirrli/YunPian
 *
 * (c) mitirrli <512663808@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mitirrli\YunPian;

use Mitirrli\YunPian\Exceptions\HttpException;

class YunPian
{
    protected $key;

    protected $tpl_id;

    /**
     * YunPian constructor.
     *
     * @param $key string appKey
     * @param $tpl_id string 模板id
     */
    public function __construct($key, $tpl_id)
    {
        $this->key = $key;
        $this->tpl_id = $tpl_id;
    }

    /**
     * 发送短信验证码
     *
     * @param $code int 验证码
     * @param $mobile int 手机号
     *
     * @return mixed|string
     *
     * @throws HttpException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendCode($code, $mobile)
    {
        $url = 'https://sms.yunpian.com/v1/sms/tpl_send.json';

        $query = [
            'tpl_id' => $this->tpl_id,
            'tpl_value' => urlencode('#code#').'='.urlencode($code), 'apikey' => $this->key, 'mobile' => $mobile,
        ];

        try {
            $CURL = curl_init();

            $options = [
                CURLOPT_URL => 'https://sms.yunpian.com/v1/sms/tpl_send.json',
                CURLOPT_TIMEOUT => 10,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => http_build_query($query),
            ];
            curl_setopt_array($CURL, $options);

            $result = curl_exec($CURL);
            curl_close($CURL);

            return 'OK' == json_decode($result)->msg;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode());
        }
    }
}

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

use GuzzleHttp\Client;
use Mitirrli\YunPian\Exceptions\HttpException;

class YunPian
{
    protected $key;

    protected $tpl_id;

    protected $guzzleOptions = [];

    /**
     * YunPian constructor.
     */
    public function __construct($key, $tpl_id)
    {
        $this->key = $key;
        $this->tpl_id = $tpl_id;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    public function getCode($code, $mobile, $format = 'json')
    {
        $url = 'https://sms.yunpian.com/v1/sms/tpl_send.json';

        $query = [
            'tpl_id' => $this->tpl_id,
            'tpl_value' => urlencode('#code#').'='.urlencode($code), 'apikey' => $this->key, 'mobile' => $mobile,
        ];

        try {
            $response = $this->getHttpClient()
                ->request('POST', $url, ['form_params' => $query])
                ->getBody()->getContents();

            return 'json' === $format ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode());
        }
    }
}

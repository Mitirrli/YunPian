<?php

namespace Mitirrli\YunPian;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Mitirrli\YunPian\Exceptions\HttpException;

class YunPian
{
    protected $key;
    protected $tpl_id;
    protected $guzzleOptions = [];

    /**
     * YunPian constructor.
     * @param $key
     * @param $tpl_id
     */
    public function __construct($key, $tpl_id)
    {
        $this->key = $key;
        $this->tpl_id = $tpl_id;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @param array $options
     */
    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    /**
     * @param $code
     * @param $mobile
     * @param string $format
     * @return mixed|string
     * @throws GuzzleException
     * @throws HttpException
     */
    public function getCode($code, $mobile, $format = 'json')
    {
        $url = 'https://sms.yunpian.com/v1/sms/tpl_send.json';

        $query = [
            'tpl_id'    => $this->tpl_id,
            'tpl_value' => urlencode('#code#') . '=' . urlencode($code), 'apikey' => $this->key, 'mobile' => $mobile,
        ];

        try {
            $response = $this->getHttpClient()
                ->request('POST', $url, ['json' => $query])
                ->getBody()->getContents();
            return 'json' === $format ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode());
        }
    }

}

<?php

use GuzzleHttp\Message\RequestInterface;

class FakeGuzzleClient extends GuzzleHttp\Client
{

    /**
     * @var string
     */
    protected $str_request_body_for_testing = null;

    /**
     * @var string
     */
    protected $str_request_url_for_testing = null;

    /**
     * @var string
     */
    protected $str_expected_response = null;

    /**
     * @param RequestInterface $request
     * @return \GuzzleHttp\Message\Response
     */
    public function send(RequestInterface $request)
    {
        PHPUnit_Framework_Assert::assertEquals($this->str_request_body_for_testing, $request->getBody()->__toString());
        PHPUnit_Framework_Assert::assertEquals($this->str_request_url_for_testing, $request->getUrl());
        return new \GuzzleHttp\Message\Response(200, [], \GuzzleHttp\Stream\Stream::factory($this->str_expected_response));
    }

    /**
     * Set up the expected request and response strings
     *
     * @param $str_url
     * @param $str_req
     * @param $str_response
     */
    public function expectRequest($str_url, $str_req, $str_response)
    {
        $this->str_request_url_for_testing = $str_url;
        $this->str_request_body_for_testing = $str_req;
        $this->str_expected_response = $str_response;
    }

}
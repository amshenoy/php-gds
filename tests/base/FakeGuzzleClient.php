<?php

/**
 * Class FakeGuzzleClient
 */
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
     * Fake send
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options
     * @return \GuzzleHttp\Psr7\Response
     */
    public function send(Psr\Http\Message\RequestInterface $request, array $options = [])
    {
        PHPUnit_Framework_Assert::assertEquals($this->str_request_body_for_testing, $request->getBody()->__toString());
        PHPUnit_Framework_Assert::assertEquals($this->str_request_url_for_testing, $request->getUri());
        return new GuzzleHttp\Psr7\Response(200, [], $this->str_expected_response);
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
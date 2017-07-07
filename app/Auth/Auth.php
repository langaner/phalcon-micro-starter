<?php 

namespace App\Auth;

use Phalcon\Di;
use Firebase\JWT\JWT;

class Auth
{
    /**
     * Auth config
     * 
     * @var array
     */
    protected $config;

    /**
     * @var bool
     */
    protected $authenticated = false;

	public function __construct()
    {
        $this->config = Di::getDefault()->get('config')->auth;
    }

    /**
     * Decode token
     *
     * @param string $token
     * @return void
     */
    public function decode($token)
	{
        return JWT::decode($token, $this->config->secret, [$this->config->algo]);
    }

    /**
     * Encode token
     *
     * @param array $data
     * @return void
     */
    public function encode(array $data = [])
	{
        $payload = $this->getPayload($data);

        return [
            'access_token' => JWT::encode($payload, $this->config->secret, $this->config->algo),
            'expires' => $payload['exp'],
            "token_type" => "Bearer",
            'refresh_token' => ''
        ];
    }

    /**
     * Generate token id
     *
     * @return void
     */
    public function tokenId()
    {
        return base64_encode(mcrypt_create_iv(32));
    }

    /**
     * Check token
     *
     * @param string $token
     * @return void
     */
    public function check($token)
	{
        if($result = !$this->isValid($token)) {
			return false;
		}

        if($result = $this->isExpared($token)) {
            return false;
        }

        $this->authenticated = true;

        return $result;
    }

    /**
     * Check token for valid
     *
     * @param string $token
     * @return boolean
     */
    public function isValid($token)
	{
        try {
            $result = $this->decode($token);
        } catch (\Firebase\JWT\UnexpectedValueException $e) {
            return true;
        }

        $this->authenticated = false;

        return $result;
    }

    /**
     * Check token for expared
     *
     * @param string $token
     * @return boolean
     */
    public function isExpared($token)
	{
        try {
            $result = $this->decode($token);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            return true;
        }

        $this->authenticated = false;

        return $result;
    }

    /**
     * Is authorized
     *
     * @return boolean
     */
    public function isAuthorized()
    {
        return $this->authenticated;
    }

    /**
     * Get the payload
     *
     * @param array $data
     * @return array
     */
    public function getPayload(array $data = [])
    {
        $iat = time();
        $nbf = $iat + 10;
        $expire = $nbf + $this->config->lifetime;

        return [
            'iss' => Di::getDefault()->get('config')->app->url,
            'exp' => $expire,
            'nbf' => $nbf,
            'iat' => $iat,
            'jti' => $this->tokenId(),
            'data' => $data
        ];
    }
}

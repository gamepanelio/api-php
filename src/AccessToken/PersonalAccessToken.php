<?php

namespace GamePanelio\AccessToken;

class PersonalAccessToken implements AccessToken
{
    /**
     * @var string
     */
    private $token;

    /**
     * PersonalAccessToken constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getBearerToken()
    {
        return $this->token;
    }
}

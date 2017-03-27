<?php

namespace GamePanelio\AccessToken;

interface AccessToken
{
    /**
     * @return string
     */
    public function getBearerToken();
}

<?php

namespace Etf1\OAuthServerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class Etf1OAuthServerBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSOAuthServerBundle';
    }
}

<?php

namespace Etf1\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class IndexController
{
    public function indexAction($name)
    {
        return new Response(json_encode(array('login' => $name)));
    }
}
<?php

namespace Etf1\ImaginizeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('Etf1ImaginizeBundle:Index:index.html.twig');
    }
}
<?php
namespace Etf1\OAuthServerBundle\Controller;

use OAuth2\OAuth2ServerException;
use FOS\OAuthServerBundle\Controller\ServerController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Etf1\MsoBundle\Bridge\MsoBridgeInterface;
use OAuth2\OAuth2;
use Etf1\LoginBundle\Entity\Credential;
use Etf1\LoginBundle\Form\CredentialType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Templating\EngineInterface;


class ServerController extends BaseController {
    protected $container;

    public function authorizeAction(Request $request)
    {
        $credential = new Credential($this->container->get('etf1_mso.bridge'));

        $form = $this->container->get('form.factory')->create(new CredentialType(), $credential);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                //$currentUser, Request $request, $scope

                $currentUser = $credential->getUserId();
                $scope = null;
                try {
                    return $this->serverService->finishClientAuthorization(true, $currentUser, $request, $scope);
                } catch(OAuth2ServerException $e) {
                    return $e->getHttpResponse();
                }
            }
        }

        return $this->container->get('templating')->renderResponse('Etf1LoginBundle:Login:index.html.twig', array(
            'form' => $form->createView(),
            'action_route' => 'etf1_oauth_server_authorize',
        ));
    }

    public function setServiceContainer($serviceContainer)
    {
        $this->container = $serviceContainer;
    }
}
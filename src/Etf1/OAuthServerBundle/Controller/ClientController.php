<?php
namespace Etf1\OAuthServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Etf1\OAuthServerBundle\Entity\Client;

class ClientController extends Controller {
    public function addClientAction(Request $request)
    {
        $client = new Client();

        $form = $this->createFormBuilder($client)
            ->add('id', 'text')
            ->add('redirectUris', 'collection', array(
                'type' => 'text',
                'allow_add' => true))
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($client);
                $em->flush();

                return $this->render('Etf1OAuthServerBundle:Client:new.html.twig', array(
                    'form' => $form->createView(),
                ));
            }
        }

        return $this->render('Etf1OAuthServerBundle:Client:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}


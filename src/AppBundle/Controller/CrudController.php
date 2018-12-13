<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CrudController extends Controller {
    /**
     * @Route("/crud")
     */
    public function indexAction()
    {
        return $this->render('crud.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/post/{id}")
     */
    public function postAction($id){
        return $this->render('post.html.twig', array(
            'id' => $id,
        ));
    }

}
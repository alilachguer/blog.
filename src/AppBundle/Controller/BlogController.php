<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Blog;

class BlogController extends Controller
{
    /**
     * @Route("/blog")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository(Blog\Post::class);
        $blogs = $repository->findBy([], ['publishedDatetime' => 'DESC'], 10, 0);
        // findBy([], ['published'] => 'DESC'], 10, 0);

        return $this->render('index.html.twig', array(
            'blogs' => $blogs
        ));
    }


}

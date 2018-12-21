<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog\Post;
use AppBundle\Form\Blog\PostType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
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
     * @Route("/crud/new")
     */
    public function newPostAction(Request $request){
        $post = new Post();

        /**
        $dt = new \DateTime('now');
        $date = $dt->format('d-m-Y H:i:s');
        $post->setPublishedDatetime($date);
        **/
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $post = $form->getData();

            $post->setSlug('' . $post->getId());

            return $this->redirectToRoute( '/blog');
        }

        return $this->render('crud.html.twig', array(
            'form' => $form->createView(),
            'post' => $post
        ));
    }

}
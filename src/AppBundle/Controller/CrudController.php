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
use Cocur\Slugify\Slugify;

class CrudController extends Controller {

    /**
     * @Route("/crud/new")
     */
    public function newPostAction(Request $request){
        $post = new Post();

        $dt = new \DateTime('now');
        //$date = \DateTime::createFromFormat('d-m-Y h:i', $dt);
        $post->setPublishedDatetime($dt);

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $post = $form->getData();

            $slugify = new Slugify();
            $post->setSlug($slugify->slugify($post->getTitle(), '_'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute( 'post', array(
                'slug' => $post->getSlug()
            ));
        }

        return $this->render('crud.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/crud/edit")
     */
    public function editPostAction(Request $request){

        return $this->render('crud.html.twig', array(

        ));
    }

    /**
     * @Route("/crud/delete")
     */
    public function deletePostAction(Request $request){

        return $this->render('crud.html.twig', array(

        ));
    }


}
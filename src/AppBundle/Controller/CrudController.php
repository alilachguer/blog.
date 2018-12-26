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
     * @Route("/crud/new", name="crud_new")
     */
    public function newPostAction(Request $request){
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) ) {


            $dt = new \DateTime('now');
            //$date = \DateTime::createFromFormat('d-m-Y h:i', $dt);
            $post->setPublishedDatetime($dt);


            if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $post = $form->getData();

                $slugify = new Slugify();
                $post->setSlug($slugify->slugify($post->getTitle(), '_'));


                    $user = $this->container->get('security.token_storage')->getToken()->getUser();
                    $post->setUsername($user->getUsername());

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($post);
                    $entityManager->flush();


                //$user = $this->getUser();


                return $this->redirectToRoute( 'post', array(
                    'slug' => $post->getSlug()
                ));

            }

            return $this->render('crud.html.twig', array(
                'form' => $form->createView()
            ));
        } else if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_ANONYMOUSLY ' ) ){
            return $this->render('crud.html.twig', array(
                'form' => $form->createView(),
                'error' => 'You must logged in to write a post'
            ));
        } else {
            return $this->render('crud.html.twig', array(
                'form' => $form->createView(),
                'error' => 'You must logged in to write a post'
            ));
        }
    }

    /**
     * @Route("/crud/edit", name="crud_edit")
     */
    public function editPostAction(Request $request){

        return $this->render('crud.html.twig', array(

        ));
    }

    /**
     * @Route("/crud/delete", name="crud_delete")
     */
    public function deletePostAction(Request $request){

        return $this->render('crud.html.twig', array(

        ));
    }


}
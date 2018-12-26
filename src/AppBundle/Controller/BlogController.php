<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Blog;

class BlogController extends Controller
{
    /**
     * @Route("/", name="blog")
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

    /**
     * @Route("/post/{slug}", name="post")
     */
    public function postAction($slug){
        $repository = $this->getDoctrine()->getRepository(Blog\Post::class);
        $post = $repository->findOneBy(array('slug'=> $slug));
        $user = $this->getDoctrine()
            ->getRepository(Blog\MyUser::class)
            ->findOneBy(array('id' => $post->getId()));

        //$user = $this->getCreatorOfPost($post);

        return $this->render('post.html.twig', array(
            'id' => $slug,
            'post' => $post
        ));
    }


    public function getCreatorOfPost($post){
        $em = $this->getDoctrine()->getManager();
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT username
                from AppBundle:Blog/MyUser u, AppBundle:Blog/Post p
                where u.id = p.user
                and p.id = :id"
            )->setParameter('id', $post->getId());

        return $query->getOneOrNullResult();
    }


}

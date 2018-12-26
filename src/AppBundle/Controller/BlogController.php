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

    /**
     * @Route("/posts", name="posts")
    */
    public function profileAction(){
        $repository = $this->getDoctrine()->getRepository(Blog\Post::class);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $user_name = $user->getUsername();
        $posts = $repository->findBy(array('username'=> $user_name));
        return $this->render('my_posts.html.twig', array(
            'posts' => $posts,
            'username' => $user_name
        ));
    }

}

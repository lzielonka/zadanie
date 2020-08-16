<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\BlogPost;
use AppBundle\Services\BlogPost\BlogPostPublisher;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BlogPostController.
 */
class BlogPostController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     section="Blog Post",
     *     description="Return complete list of blog posts"
     * )
     * @Security("has_role('ROLE_USER')")
     * @Route(name="api.blog_post.list", path="/blog-post")
     * @Method("GET")
     *
     * @return \FOS\RestBundle\View\View
     */
    public function listPostsAction()
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:BlogPost');

        return $this->view($repo->findAll());
    }

    /**
     * @ApiDoc(
     *     section="Blog Post",
     *     description="Edit post"
     * )
     * @Security("has_role('ROLE_ADMIN')")
     * @Route(name="api.blog_post.edit", path="/blog-post/{post}")
     * @Method("PUT")
     *
     * @param Request $request
     * @param BlogPost $post
     *
     * @return \FOS\RestBundle\View\View
     */
    public function editPostAction(Request $request, BlogPost $post)
    {
        $title = $request->get('title');
        $content = $request->get('content');
        $tags = explode(';', $request->get('tags'));

        $post->setTitle($title);
        $post->setContent($content);
        $post->setTags($tags);

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return $this->view($post);
    }

    /**
     * @ApiDoc(
     *     section="Blog Post",
     *     description="Create post"
     * )
     * @Security("has_role('ROLE_ADMIN')")
     * @Route(name="api.blog_post.create", path="/blog-post")
     * @Method("POST")
     * @param Request $request
     *
     * @return \FOS\RestBundle\View\View
     */
    public function createPostAction(Request $request)
    {
        $title = $request->get('title');
        $content = $request->get('content');
        $tags = explode(';', $request->get('tags'));

        $post = new BlogPost;
        $post->setTitle($title);
        $post->setContent($content);
        $post->setTags($tags);

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return $this->view($post);
    }

    /**
     * @ApiDoc(
     *     section="Blog Post",
     *     description="Publish post to specified target"
     * )
     * @Security("has_role('ROLE_ADMIN')")
     * @Route(name="api.blog_post.publish", path="/blog-post/{post}/{target}")
     * @Method("POST")
     * @param BlogPost $post
     * @param $target
     * @param BlogPostPublisher $publisher
     *
     * @return \FOS\RestBundle\View\View
     * @throws \AppBundle\Exception\TargetNotExistsException
     */
    public function publishPostAction(BlogPost $post, $target, BlogPostPublisher $publisher)
    {
        $publisher->publish($post, $target);

        return $this->view();
    }
}

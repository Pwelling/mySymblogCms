<?php

namespace AppBundle\Helpers;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Entity\Blog;

class BlogHelper
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $doctrine;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine');
        return $this;
    }

    /**
     * @return Blog[]|array
     */
    public function getBlogs()
    {
        return $this->doctrine->getRepository('AppBundle:Blog')->findBy([], ['created' => 'DESC']);
    }

    /**
     * @param $slug
     * @return Blog|null|object
     */
    public function getBlogBySlug($slug) {
        return $this->doctrine->getRepository('AppBundle:Blog')->findOneBy(['slug' => $slug]);
    }

    /**
     * @param $blogId
     * @return bool
     */
    public function removeBlog($blogId)
    {
        $blog = $this->doctrine->getRepository('AppBundle:Blog')->find($blogId);
        $comments = $this->doctrine->getRepository('AppBundle:Comment')->getCommentsForBlog($blogId);

        foreach ($comments as $comment) {
            $this->doctrine->getManager()->remove($comment);
            $this->doctrine->getManager()->flush();
        }
        $this->doctrine->getManager()->remove($blog);
        $this->doctrine->getManager()->flush();
        return true;
    }
}
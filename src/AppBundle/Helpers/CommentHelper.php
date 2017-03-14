<?php

namespace AppBundle\Helpers;

use AppBundle\Entity\Comment;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Blog;
use Symfony\Component\DependencyInjection\Container;

class CommentHelper
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
     * @param Blog $blog
     * @param boolean $approved
     * @return Comment[]
     */
    public function getCommentsForBlog(Blog $blog, $approved = true)
    {
        return $this->container->get('doctrine')->getRepository('AppBundle:Comment')->getCommentsForBlog(
            $blog,
            $approved
        );
    }
}

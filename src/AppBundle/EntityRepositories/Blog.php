<?php

namespace AppBundle\EntityRepositories;

use Doctrine\ORM\EntityRepository;

class Blog extends EntityRepository
{
    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return Blog[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('b')
            ->from('AppBundle:Blog',  'b');
        foreach ($criteria as $field => $value) {
            $queryBuilder
                ->andWhere('b.' . $field . '= :' . $field)
                ->setParameter($field, $value);
        }
        if (!is_null($orderBy)) {
            foreach ($orderBy as $field => $order) {
                $queryBuilder->addOrderBy('b.' . $field, $order);
            }
        }
        if (!is_null($limit)) {
            $queryBuilder->setMaxResults($limit);
        }
        if (!is_null($offset)) {
            $queryBuilder->setFirstResult($offset);
        }
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param null $limit
     * @return Blog[]
     */
    public function getLatestBlogs($limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('b')
            ->select('b, c')
            ->leftJoin('b.comments', 'c')
            ->addOrderBy('b.created', 'DESC');

        if (false === is_null($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function getTags()
    {
        $blogTags = $this->createQueryBuilder('b')
            ->select('b.tags')
            ->getQuery()
            ->getResult();

        $tags = array();
        foreach ($blogTags as $blogTag) {
            $tags = array_merge(explode(",", $blogTag['tags']), $tags);
        }

        foreach ($tags as &$tag) {
            $tag = trim($tag);
        }

        return $tags;
    }

    /**
     * @param $tags
     * @return array
     */
    public function getTagWeights($tags)
    {
        $tagWeights = array();
        if (empty($tags)) {
            return $tagWeights;
        }

        foreach ($tags as $tag) {
            $tagWeights[$tag] = (isset($tagWeights[$tag])) ? $tagWeights[$tag] + 1 : 1;
        }
        // Shuffle the tags
        uksort($tagWeights, function() {
            return rand() > rand();
        });

        $max = max($tagWeights);

        // Max of 5 weights
        $multiplier = ($max > 5) ? 5 / $max : 1;
        foreach ($tagWeights as &$tag) {
            $tag = ceil($tag * $multiplier);
        }

        return $tagWeights;
    }

    public function findAll()
    {
        return parent::findAll();
    }
}

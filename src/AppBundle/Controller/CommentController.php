<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @param $slug
     * @return Response
     */
    public function commentsAction($slug)
    {
        $blog = $this->get('blog_helper')->getBlogBySlug($slug);

        return $this->render('@App/Comment/list.html.twig', [
            'blog' => $blog,
            'comments' => $this->get('comment_helper')->getCommentsForBlog($blog, null),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function visibilityAction(Request $request)
    {
        $comment = $this->get('doctrine')->getRepository('AppBundle:Comment')->find($request->get('commentId'));
        $newStatus = $comment->getApproved() ? false : true;
        $comment->setApproved($newStatus);
        $this->get('doctrine')->getManager()->flush($comment);
        return JsonResponse::create(['result' => true, 'newStatus' => $newStatus]);
    }
}

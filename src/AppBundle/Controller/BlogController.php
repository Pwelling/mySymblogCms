<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog;
use AppBundle\Forms\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BlogController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render('@App/default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @return Response
     */
    public function blogsAction()
    {
        return $this->render('@App/blog/list.html.twig',  [
            'blogs' => $this->get('blog_helper')->getBlogs(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blog
                ->setAuthor($this->getUser());
            $this->get('doctrine')->getManager()->persist($blog);
            $this->get('doctrine')->getManager()->flush();
            return $this->redirectToRoute('blogs');
        }

        return $this->render('@App/blog/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, $slug)
    {
        $blog = $this->get('blog_helper')->getBlogBySlug($slug);
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('doctrine')->getManager()->persist($blog);
            $this->get('doctrine')->getManager()->flush();
            return $this->redirectToRoute('editBlog', ['slug' => $blog->getSlug()]);
        }

        return $this->render('@App/blog/edit.html.twig', [
            'form' => $form->createView(),
            'blog' => $blog
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function removeAction($id)
    {
        $this->get('blog_helper')->removeBlog($id);
        $this->addFlash('success', $this->get('translator')->trans('messages.blogRemoved'));
        return JsonResponse::create(['result' => true]);
    }
}

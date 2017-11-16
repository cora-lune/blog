<?php

namespace BlogBundle\Controller;

use BlogBundle\BlogBundle;
use BlogBundle\Entity\Comment;
use BlogBundle\Entity\Post;
use BlogBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BlogBundle\Entity\Enquiry;
use BlogBundle\Form\EnquiryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('BlogBundle:Default:index.html.twig');
    }

    /**
     * @Route("/about/", name="about")
     */
    public function aboutAction()
    {
        return $this->render('BlogBundle:About:about.html.twig');
    }

    /**
     * @Route("/articles/", name="articles")
     */
    public function articlesAction()
    {
        $posts = $this->getDoctrine()->getManager()->getRepository('BlogBundle:Post')->findBy(
            [],
            ['id' => 'DESC']
        );

        return $this->render('BlogBundle:Articles:articles.html.twig', ['posts' => $posts]);
    }

    /**
     * @Route("/contact/", name="contact")
     * @Method({"GET", "POST"})
     */
    public function contactAction(Request $request)
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($form->handleRequest($request)->isValid()) {
            // Perform some action, such as sending an email
            $this->getDoctrine()->getManager()->persist($enquiry);
            $this->getDoctrine()->getManager()->flush();
            // Redirect - This is important to prevent users re-posting
            // the form if they refresh the page
            return $this->redirect($this->generateUrl('BlogBundle:Contact:contact.html.twig'));
        }

        return $this->render('BlogBundle:Contact:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/weekly-post", name="weekly_post")
     */
    public function weeklyPostAction()
    {
        $weeklyPost = $this->getDoctrine()->getRepository(Post::class)->findWeeklyPost();

        return $this->render('BlogBundle:Articles:weekly_post.html.twig', array(
            'weeklyPost' => $weeklyPost
        ));
    }
    /**
     * @Route("/comments", name="comments")
     * @Method({"GET", "POST"})
     */
    public function commentsAction(Request $request)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        if ($form->handleRequest($request)->isValid()) {
            // Perform some action, such as sending an email
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();
            // Redirect - This is important to prevent users re-posting
            // the form if they refresh the page
            return $this->render('BlogBundle:Comment:form.html.twig', array(
                'form' => $form->createView()
            ));
        }

        return $this->render('BlogBundle:Comment:form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{slug}", name="article_slug")
     * @Method({"GET", "POST"})
     */
    public function showAction($slug)
    {
        $manager = $this->getDoctrine()->getManager();
        $post = $manager->getRepository('BlogBundle:Post')->findOneBy([
            'slug' => $slug
        ]);

        if (!$post) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        $comments = $manager->getRepository('BlogBundle:Comment')
            ->getCommentsForPost($post->getSlug());

        return $this->render('BlogBundle:Articles:show.html.twig', array(
            'post' => $post,
            'comments'  => $comments
        ));
    }



}

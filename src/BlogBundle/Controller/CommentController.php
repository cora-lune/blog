<?php

namespace BlogBundle\Controller;

use BlogBundle\BlogBundle;
use BlogBundle\Entity\Comment;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BlogBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CommentController extends Controller
{
    /**
     * @Route("/comment", name="addComment")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addCommentAction(Request $request)
    {

        $comment = new Comment();

        $form = $this->createForm('BlogBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comment_show', array('id' =>$comment->getId() ));
        }

        return $this->render('BlogBundle:Comment:form.html.twig', array('comment' => $comment, 'form' => $form->createView()));
    }


}

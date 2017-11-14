<?php

namespace BlogBundle\Controller;

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
        return $this->render('BlogBundle:Articles:articles.html.twig');
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
            return $this->redirect($this->generateUrl('BlogBundle_contact'));
        }

        return $this->render('BlogBundle:Contact:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

}

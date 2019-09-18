<?php

namespace App\Controller;

use App\Entity\Departement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $em      = $this->getDoctrine()->getManager();
        $contact = new Contact();
        $form    = $this->createForm(ContactType::class, $contact);


        if ($request->isMethod('POST')&& $form->handleRequest($request)->isValid()) {
            $departement  = $contact->getIdDepartement();
            $em->persist($contact);
            $em->flush();
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('atayisandrine98@gmail.com')
                ->setTo($departement->getEmailDepartement())
                ->setBody($this->renderView('emails/contact.html.twig', [
                    'nom' => $contact->getNom(),
                    'prenom' => $contact->getPrenom(),
                    'message' => $contact->getMessage(),
                    'email' => $contact->getEmail()
                ]),'text/html');
            $mailer->send($message);
            return new Response('Nouveau contact ajouté!');
        }
        return $this->render('contact/index.html.twig', [
           'form' => $form->createView(),
        ]);
    }


}

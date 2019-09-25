<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Contact;

/**
 * Contact controller.
 * @Route("/api",name="api_")
 */
class ContactController extends FOSRestController
{
    /**
     * Lists all Contacts.
     * @Rest\Get("/contacts")
     *
     * @return Response
     */
    public function getContactAction()
    {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
            $contacts = $repository->findAll();
        return $this->handleView($this->view($contacts));
    }

    /**
     * Create Contact.
     * @Rest\Post("/contact")
     *
     * @return Response
     */
    public function postContactAction(Request $request, \Swift_Mailer $mailer)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if($form->isSubmitted() && $form->isValid()){
            $departement  = $contact->getIdDepartement();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $message = (new \Swift_Message('Enregistrement du nouveau contact'))
                ->setFrom('atayisandrine98@gmail.com')
                ->setTo($departement->getEmailDepartement())
                ->setBody($this->renderView('emails/contact.html.twig', [
                    'nom' => $contact->getNom(),
                    'prenom' => $contact->getPrenom(),
                    'message' => $contact->getMessage(),
                    'email' => $contact->getEmail()
                ]),'text/html');
            $mailer->send($message);
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }

        return $this->handleView($this->view($form->getErrors()));
    }



}
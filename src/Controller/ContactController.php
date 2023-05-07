<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'index.contact')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        MailerInterface $mailer): Response
    {
        $contact = new Contact();

        if($this->getUser()){
            $contact->setFullName($this->getUser()->getFullName())
            ->setEmail($this->getUser()->getEmail());
        }
    
      
        $form = $this->createForm(ContactType::class, $contact);  

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            

            $contact = $form->getData();
            $manager -> persist($contact); 
            $manager->flush(); 

            // mail 
            $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to('master@traiteapp.org')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($contact->getSubject())
                // path of the Twig template to render
            ->htmlTemplate('pages/emails/contact.html.twig')

    // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'contact' => $contact,
            ]);


            $mailer->send($email);

            $this->addFlash(
             'success',
             'Message Envoyé ! '
            ); 

        }
        return $this->render('pages/contact/index.html.twig', [
           'form' => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Form\ContactsFormType;
use App\Repository\ContactsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactsController
 * @package App\Controller
 */
class ContactsController extends AbstractController
{
    /**
     * @var ContactsRepository
     */
    protected $repository;

    /**
     * ContactsController constructor.
     * @param ContactsRepository $repository
     */
    public function __construct(ContactsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contacts", name="contacts", methods={"GET","HEAD"})
     */
    public function index()
    {
        return $this->render('contacts/index.html.twig', [
            'controller_name' => 'ContactsController',
            "contacts" => $this->getDoctrine()->getRepository(Contacts::class)->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createContact(Request $request)
    {
        $contact = new Contacts();
        $form = $this->createForm(ContactsFormType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $contact = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirect('/view-contact/' . $contact->getId());

        }

        return $this->render(
        'contacts/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function viewContact($id)
    {
        $contact = $this->getDoctrine()
            ->getRepository(Contacts::class)
            ->find($id);

        if (!$contact) {
            throw $this->createNotFoundException(
                'There are no contacts with the following id: ' . $id
            );
        }

        return $this->render(
        'contacts/view.html.twig', [
            'contact' => $contact
        ]);
    }

    public function deleteContact($id)
    {
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository(Contacts::class)->find($id);

        if (!$contact) {
            throw $this->createNotFoundException(
                'There are no articles with the following id: ' . $id
            );
        }

        $em->remove($contact);
        $em->flush();

        return $this->redirect('/contacts');
    }

    public function updateContact(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository(Contacts::class)->find($id);

        if (!$contact) {
            throw $this->createNotFoundException(
                'There are no contacts with the following id: ' . $id
            );
        }

        $form = $this->createForm(ContactsFormType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $contact = $form->getData();
            $em->flush();
            return $this->redirect('/view-contact/' . $id);
        }

        return $this->render(
        'contacts/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

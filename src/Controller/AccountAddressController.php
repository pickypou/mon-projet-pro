<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/compte')]
class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/address', name: 'app_address')]
    public function index(): Response
    {
        
        return $this->render('account/address.html.twig');
    }

    #[Route('/ajouter_une_adresse', name: 'app_address_add')]
    public function add(Request $request): Response
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);
        $form->remove('user');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
           $this->entityManager->persist($address);
           $this->entityManager->flush();
           return $this->redirectToRoute('app_address');
        }
        
        return $this->render('account/address_add.html.twig',[
            'form'=>$form->createView()
        ]);
    }


    #[Route('/modifier_une_adresse/{id}', name: 'app_address_edit')]
    public function edit(Request $request, $id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);
        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_address');
        }

        $form = $this->createForm(AddressType::class, $address);
        $form->remove('user');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        
           $this->entityManager->flush();
           return $this->redirectToRoute('app_address');
        }
        
        return $this->render('account/address_add.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('/suprimer_une_adresse/{id}', name: 'app_address_delete')]
    public function delete($id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);
        if ($address && $address->getUser() == $this->getUser()) {
            $this->entityManager->remove($address);
           $this->entityManager->flush();
        }
     
        return $this->redirectToRoute('app_address');
    }
}

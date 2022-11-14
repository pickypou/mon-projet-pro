<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ChangePasswordController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('compte/change/password', name: 'app_change_password')]
    public function index(
        Request $request,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->remove('roles');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('old_password')->getData();
            if ($passwordHasher->isPasswordValid($user, $oldPassword)) {
                $newpwd = $form->get('new_password')->getData();
                $password = $passwordHasher->hashPassword($user, $newpwd);
                $user->setPassword($password);
                $this->entityManager->flush();
                $notification = 'Votre mot de passe a bien été mis à jour';
            } else {
                $notification = 'Votre mot de passe actuel n\'et pas le bon';
            }
            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/changePassword.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}

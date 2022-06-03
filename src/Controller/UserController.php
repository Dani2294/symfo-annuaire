<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AjouterUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    // Affiche la liste des utilisateurs
    #[Route('/user', name: 'app_user')]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        // instancier un objet User
        $user = new User();

        // création d'un formulaire et lier avec l'objet User
        $form = $this->createForm(AjouterUserType::class, $user);

        // je mets mon formulaire à l'écoute des requetes qui passe dans l'URL
        $form->handleRequest($request);

        // verifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/user.html.twig', [
            "liste_users" => $userRepository->findAll(),
            "form" => $form->createView()
        ]);
    }

    // Afficher un utilisateur
    #[Route('/profil-user/{id}', name: 'app_profil_user')]
    public function getOneUser($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        return $this->render('user/show_user.html.twig', [
            "users" => $user,
            "messages" => $user->getMessages(),
        ]);
    }

    // Ajouter un utilisateur
    #[Route('/ajouter-user', name: 'app_add_user')]
    public function addUser(Request $request, UserRepository $userRepository, EntityManagerInterface $manager): Response
    {
        // instancier un objet User
        $user = new User();

        // création d'un formulaire et lier avec l'objet User
        $form = $this->createForm(AjouterUserType::class, $user);

        // je mets mon formulaire à l'écoute des requetes qui passe dans l'URL
        $form->handleRequest($request);

        // verifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            /* $manager->persist($user);
            $manager->flush(); */

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/add_user.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    // Supprimer un utilisateur
    #[Route('/delete-user/{id}', name: 'app_remove_user')]
    public function deleteUser($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        if ($user) {
            $userRepository->remove($user);

            return $this->redirectToRoute('app_user');
        }
    }

    // Editer un utilisateur
    #[Route('/modifier-user/{id}', name: 'app_edit_user')]
    public function editUser(
        $id,
        Request $request,
        UserRepository $userRepository,
    ): Response {
        // instancier un objet User
        $user = $userRepository->find($id);

        // création d'un formulaire et lier avec l'objet User
        $form = $this->createForm(AjouterUserType::class, $user);

        // je mets mon formulaire à l'écoute des requetes qui passe dans l'URL
        $form->handleRequest($request);

        // verifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/edit_user.html.twig', [
            "form" => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Card\Poker;
use App\Card\Card;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PokerUser;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PokerUserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PokerUserController extends AbstractController
{
    /**
    * @Route(
    *       "/proj/loginpoker",
    *       name="login_poker",
    *       methods={"GET","HEAD"}
    * )
    */
    public function loginPoker(
        SessionInterface $session
    ): Response {
        $user = $session->get('CurrentPokerUser');

        return $this->render('poker/login.html.twig', [
            'message' => '',
            'user' => $user
        ]);
    }

    /**
    * @Route(
    *       "/proj/loginpoker",
    *       name="login_process_poker",
    *       methods={"POST"}
    * )
    */
    public function loginProcess(
        Request $request,
        pokeruserRepository $pokeruserRepository,
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {
        $result = \App\PokerCalculations\checkPokerLogin($request, $pokeruserRepository, $doctrine, $session);

        if ($result[0] === 'wrong username') {
            return $this->render('poker/login.html.twig', [
                'message' => 'wrong username',
                'user' => null
            ]);
        } elseif ($result[0] === 'wrong password') {
            return $this->render('poker/login.html.twig', [
                'message' => 'wrong password',
                'user' => null
            ]);
        }

        return $this->redirectToRoute('poker_user_by_id', [
            'userId' => $result[1]
        ]);
    }

    /**
    * @Route(
    *       "/proj/logoutpoker",
    *       name="logout_poker",
    *       methods={"GET","HEAD"}
    * )
    */
    public function logoutUser(
        SessionInterface $session
    ): Response {
        $session->set('CurrentPokerUser', null);

        return $this->redirectToRoute('login_poker');
    }

    /**
    * @Route(
    *       "/proj/pokeruser/create",
    *       name="create_user_poker",
    *       methods={"GET","HEAD"}
    * )
    */
    public function createUser(): Response
    {
        return $this->render('poker/create_user.html.twig', [
            'title' => 'Skapa konto'
        ]);
    }

    /**
    * @Route(
    *      "/proj/pokeruser/create",
    *      name="create_user_poker_process",
    *      methods={"POST"}
    * )
    */
    public function createUserProcess(
        Request $request,
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        $username = $request->request->get('username');
        $password  = $request->request->get('password');
        $name  = $request->request->get('name');
        $email  = $request->request->get('email');
        $picture  = $request->request->get('picture');
        $type  = $request->request->get('type');

        $user = new PokerUser();
        $user->setUsername($username);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $user->setName($name);
        $user->setEmail($email);
        $user->setType($type);
        $user->setPicture($picture);
        $user->setMoney(1000);
        $user->setGames(0);
        $user->setWins(0);

        $entityManager->persist($user);

        $entityManager->flush();

        $user = $session->get('CurrentPokerUser');

        if (!$user) {
            return $this->redirectToRoute('login_poker');
        }

        return $this->redirectToRoute('poker_user');
    }

    /**
    * @Route("/proj/pokeruser", name="poker_user")
    */
    public function showAllPokerUsers(
        pokeruserRepository $pokeruserRepository,
        SessionInterface $session
    ): Response {
        $users = $pokeruserRepository
            ->findAll();

        $currentUser = $session->get('CurrentPokerUser');

        dump($currentUser);

        if (!$currentUser || $currentUser->getType() != 'admin') {
            return $this->render('poker/no_access.html.twig', [
                'Message' => 'You need to be logged in as admin to perform this action'
            ]);
        }

        return $this->render('poker/all_users.html.twig', [
            'title' => 'Alla användare',
            'users' => $users,
            'current_user' => $currentUser,
            'link_to_create_user' => $this->generateUrl('create_user_poker')
        ]);
    }

    /**
    * @Route("/proj/pokeruser/show/{userId}", name="poker_user_by_id")
    */
    public function showPokerUserById(
        pokeruserRepository $pokeruserRepository,
        SessionInterface $session,
        int $userId
    ): Response {
        $user = $pokeruserRepository
            ->find($userId);

        $loggedIn = $session->get('CurrentPokerUser');

        if (!$loggedIn || !$user || $loggedIn->getType() === 'ordinary' && $loggedIn->getId() != $userId) {
            return $this->render('poker/no_access.html.twig', [
                'Message' => 'You need to be logged in as admin to perform this action'
            ]);
        }

        return $this->render('poker/one_user.html.twig', [
            'user' => $user
        ]);
    }

    /**
    * @Route("/proj/pokeruser/delete/{userId}", name="poker_user_delete_by_id")
    */
    public function deletePokerUserById(
        ManagerRegistry $doctrine,
        SessionInterface $session,
        int $userId
    ): Response {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(PokerUser::class)->find($userId);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $userId
            );
        }

        $loggedIn = $session->get('CurrentPokerUser');

        if (!$loggedIn || $loggedIn->getType() === 'ordinary' && $loggedIn->getId() != $userId) {
            return $this->render('poker/no_access.html.twig', [
                'Message' => 'You need to be logged in as admin to perform this action'
            ]);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        if ($loggedIn->getType() === 'ordinary') {
            return $this->redirectToRoute('logout_poker');
        }

        return $this->redirectToRoute('poker_user');
    }

    /**
    * @Route(
    *   "/proj/pokeruser/update/{userId}",
    *    name="poker_user_update",
    *    methods={"GET","HEAD"}
    * )
    */
    public function updatePokerUser(
        pokeruserRepository $pokeruserRepository,
        SessionInterface $session,
        int $userId
    ): Response {
        $user = $pokeruserRepository
            ->find($userId);

        $loggedIn = $session->get('CurrentPokerUser');

        if (!$loggedIn || $loggedIn->getType() === 'ordinary' && $loggedIn->getId() != $userId) {
            return $this->render('poker/no_access.html.twig', [
                'Message' => 'You need to be logged in as admin to perform this action'
            ]);
        }

        return $this->render('poker/update_user.html.twig', [
            'title' => 'Uppdatera kontoinformation',
            'user' => $user
        ]);
    }

    /**
    * @Route(
    *       "/proj/pokeruser/update/{userId}",
    *       name="poker_user_update_process",
    *       methods={"POST"}
    * )
    */
    public function updatePokerUserProcess(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $result = \App\PokerCalculations\makePokerUserUpdate($request, $doctrine);

        if ($result['user'] === 'dont exist') {
            throw $this->createNotFoundException(
                'No user found for id ' . $result['id']
            );
        }

        return $this->redirectToRoute('poker_user_by_id', [
            'userId' => $result['id']
        ]);
    }
}

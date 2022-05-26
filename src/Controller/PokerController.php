<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PokerUser;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PokerUserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PokerController extends AbstractController
{
    /**
    * @Route(
    *       "/loginpoker",
    *       name="login_poker",
    *       methods={"GET","HEAD"}
    * )
    */
    public function loginPoker(
        SessionInterface $session
    ): Response {
        //$session->set('CurrentPokerUser', null);
        $user = $session->get('CurrentPokerUser');

        return $this->render('poker/login.html.twig', [
            'message' => '',
            'user' => $user
        ]);
    }

    /**
    * @Route(
    *       "/loginpoker",
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
        $result = \App\Card\checkPokerLogin($request, $pokeruserRepository, $doctrine, $session);

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
            'id' => $result[1]->getId()
        ]);
    }

    /**
    * @Route(
    *       "/logoutpoker",
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
    *       "/pokeruser/create",
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
    *      "/pokeruser/create",
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
    * @Route("/pokeruser", name="poker_user")
    */
    public function showAllPokerUsers(
        pokeruserRepository $pokeruserRepository,
        SessionInterface $session
    ): Response {
        $users = $pokeruserRepository
            ->findAll();

        $current_user = $session->get('CurrentPokerUser');

        dump($current_user);

        if (!$current_user || $current_user->getType() != 'admin') {
            return $this->render('poker/no_access.html.twig', [
                'Message' => 'You need to be logged in as admin to perform this action'
            ]);
        }

        return $this->render('poker/all_users.html.twig', [
            'title' => 'Alla användare',
            'users' => $users,
            'current_user' => $current_user,
            'link_to_create_user' => $this->generateUrl('create_user_poker')
        ]);
    }

    /**
    * @Route("/pokeruser/show/{id}", name="poker_user_by_id")
    */
    public function showPokerUserById(
        pokeruserRepository $pokeruserRepository,
        SessionInterface $session,
        int $id
    ): Response {
        $user = $pokeruserRepository
            ->find($id);

        $loggedIn = $session->get('CurrentPokerUser');

        if (!$loggedIn || !$user || $loggedIn->getType() === 'ordinary' && $loggedIn->getId() != $id) {
            return $this->render('poker/no_access.html.twig', [
                'Message' => 'You need to be logged in as admin to perform this action'
            ]);
        }

        return $this->render('poker/one_user.html.twig', [
            'user' => $user
        ]);
    }

        /**
    * @Route("/pokeruser/delete/{id}", name="poker_user_delete_by_id")
    */
    public function deletePokerUserById(
        ManagerRegistry $doctrine,
        SessionInterface $session,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(PokerUser::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $id
            );
        }

        $loggedIn = $session->get('CurrentPokerUser');

        if (!$loggedIn || $loggedIn->getType() === 'ordinary' && $loggedIn->getId() != $id) {
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
    *   "/pokeruser/update/{id}",
    *    name="poker_user_update",
    *    methods={"GET","HEAD"}
    * )
    */
    public function updatePokerUser(
        pokeruserRepository $pokeruserRepository,
        SessionInterface $session,
        int $id
    ): Response {
        $user = $pokeruserRepository
            ->find($id);

        $loggedIn = $session->get('CurrentPokerUser');

        if (!$loggedIn || $loggedIn->getType() === 'ordinary' && $loggedIn->getId() != $id) {
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
    *       "/pokeruser/update/{id}",
    *       name="poker_user_update_process",
    *       methods={"POST"}
    * )
    */
    public function updatePokerUserProcess(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $result = \App\Card\makePokerUserUpdate($request, $doctrine);

        if ($result['user'] === 'dont exist') {
            throw $this->createNotFoundException(
                'No user found for id ' . $result['id']
            );
        }

        return $this->redirectToRoute('poker_user_by_id', [
            'id' => $result['id']
        ]);
    }

    /**
    * @Route(
    *       "/pokergame",
    *       name="pokergame",
    *       methods={"GET","HEAD"}
    * )
    */
    public function pokerGame(
        SessionInterface $session,
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $session->set('PokerGame', new \App\Card\Poker());
        $game = $session->get('PokerGame');
        $user = $session->get('CurrentPokerUser');
        $game->newRound($user->getUsername());

        $session->set('PokerComment', '');
        $session->set('BankMove', '');
        $session->set('PlayerMove', '');

        $data = \App\Card\getPokerGameInfo($game, $user, $session);

            //Testcards--------------------------------------------------
    $test_cards = [];
    $test_cards[] = new \App\Card\Card(
        '',
        'Ruter',
        '9'
    );
    $test_cards[] = new \App\Card\Card(
        '',
        'Ruter',
        '11'
    );
    $test_cards[] = new \App\Card\Card(
        '',
        'Spader',
        '3'
    );
    $test_cards[] = new \App\Card\Card(
        '',
        'Ruter',
        '2'
    );
    $test_cards[] = new \App\Card\Card(
        '',
        'Klover',
        '7'
    );
    $test_cards[] = new \App\Card\Card(
        '',
        'Spader',
        '14'
    );
    $test_cards[] = new \App\Card\Card(
        '',
        'Ruter',
        '12'
    );

    $new_test_object = [];

    foreach ($test_cards as $card) {
        $new_test_object[] = (object) [
            'colour' => $card->getColour(),
            'points' => intval($card->getPoints())
        ];
    }

    //sort by colours
    usort($new_test_object, function($a, $b){
        return strcmp($a->colour, $b->colour);
    });
    
    $colour = $new_test_object;
    
    //sort by points
    usort($new_test_object,function($a, $b){
        return $a->points - $b->points;
    });
    
    $points = $new_test_object;
    
    //$test_points = [];
    //foreach ($test_cards as $card) {
    //    $test_points[] = $card->getPoints();
    //}
    //sort($test_points);

        dump(\App\Card\checkHandSevenCards($colour, $points));
    //--------------------------------------------------------v

        return $this->render('poker/game.html.twig', $data);
    }

    /**
    * @Route(
    *       "/pokergame",
    *       name="pokergame_post",
    *       methods={"POST"}
    * )
    */
    public function pokerGamePost(
        SessionInterface $session,
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $current_user = $session->get('CurrentPokerUser');

        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(PokerUser::class)->find($current_user->getId());

        $session->set('CurrentPokerUser', $user);

        $result = \App\Card\managePokerInput($session, $request, $doctrine);

        $game = $session->get('PokerGame');


        $data = \App\Card\getPokerGameInfo($game, $user, $session);

        switch ($result) {
            case 'Deal cards':
                return $this->render('poker/game.html.twig', $data);
            case 'Fold':
                return $this->render('poker/game.html.twig', $data);
            case 'Go back':
                return $this->redirectToRoute('poker_user_by_id', ['id' => $user->getId()]);
            case 'Restart':
                return $this->redirectToRoute('pokergame');
            case 'Bet 10$':
                return $this->render('poker/game.html.twig', $data);
            case 'Raise 10$':
                return $this->render('poker/game.html.twig', $data);
            case 'Raise 10$':
                return $this->render('poker/game.html.twig', $data);
            case 'Check':
                return $this->render('poker/game.html.twig', $data);
            case 'Call':
                return $this->render('poker/game.html.twig', $data);
        }
        return $this->redirectToRoute('pokergame');
    }
}
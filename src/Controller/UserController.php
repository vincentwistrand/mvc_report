<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserController extends AbstractController
{
    /**
    * @Route("/user", name="user")
    */
    public function showAllUsers(
        userRepository $userRepository,
        SessionInterface $session
    ): Response {
        $users = $userRepository
            ->findAll();

        $currentUser = $session->get('user');

        if (!$currentUser || $currentUser->getType() != 'admin') {
            return $this->render('user/no_access.html.twig', [
                'Message' => 'You need to be logged in as admin to perform this action'
            ]);
        }

        return $this->render('user/all_users.html.twig', [
            'title' => 'Alla användare',
            'users' => $users,
            'current_user' => $currentUser,
            'link_to_create_user' => $this->generateUrl('create_user')
        ]);
    }

    /**
    * @Route("/user/show/{userId}", name="user_by_id")
    */
    public function showUserById(
        userRepository $userRepository,
        SessionInterface $session,
        int $userId
    ): Response {
        $user = $userRepository
            ->find($userId);

        $loggedIn = $session->get('user');

        if (!$loggedIn || !$user || $loggedIn->getType() === 'ordinary' && $loggedIn->getId() != $userId) {
            return $this->render('user/no_access.html.twig', [
                'Message' => 'You need to be logged in as admin to perform this action'
            ]);
        }

        return $this->render('user/one_user.html.twig', [
            'user' => $user
        ]);
    }

    /**
    * @Route(
    *       "/user/create",
    *       name="create_user",
    *       methods={"GET","HEAD"}
    * )
    */
    public function createUser(): Response
    {
        return $this->render('user/create_user.html.twig', [
            'title' => 'Skapa användare'
        ]);
    }

    /**
    * @Route(
    *      "/user/create",
    *      name="create_user_process",
    *      methods={"POST"}
    * )
    */
    public function createUserProcess(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $username = $request->request->get('username');
        $password  = $request->request->get('password');
        $name  = $request->request->get('name');
        $email  = $request->request->get('email');
        $type  = $request->request->get('type');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $user->setName($name);
        $user->setEmail($email);
        $user->setType($type);

        $entityManager->persist($user);

        $entityManager->flush();

        return $this->redirectToRoute('login');
    }

    /**
    * @Route("/user/delete/{userId}", name="user_delete_by_id")
    */
    public function deleteUserById(
        ManagerRegistry $doctrine,
        SessionInterface $session,
        int $userId
    ): Response {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(user::class)->find($userId);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $userId
            );
        }

        $loggedIn = $session->get('user');

        if (!$loggedIn || $loggedIn->getType() === 'ordinary' && $loggedIn->getId() != $userId) {
            return $this->render('user/no_access.html.twig', [
                'Message' => 'You need to be logged in as admin to perform this action'
            ]);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('user');
    }

    /**
    * @Route(
    *   "/user/update/{userId}",
    *    name="user_update",
    *    methods={"GET","HEAD"}
    * )
    */
    public function updateUser(
        userRepository $userRepository,
        SessionInterface $session,
        int $userId
    ): Response {
        $user = $userRepository
            ->find($userId);

        $loggedIn = $session->get('user');

        if (!$loggedIn || $loggedIn->getType() === 'ordinary' && $loggedIn->getId() != $userId) {
            return $this->render('user/no_access.html.twig', [
                'Message' => 'You need to be logged in as admin to perform this action'
            ]);
        }

        return $this->render('user/update_user.html.twig', [
            'title' => 'Uppdatera användarinformation',
            'user' => $user
        ]);
    }

    /**
    * @Route(
    *       "/user/update/{userId}",
    *       name="user_update_process",
    *       methods={"POST"}
    * )
    */
    public function updateUserProcess(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $result = makeUpdate($request, $doctrine);

        if ($result['user'] === 'dont exist') {
            throw $this->createNotFoundException(
                'No user found for id ' . $result['id']
            );
        }

        return $this->redirectToRoute('user_by_id', [
            'userId' => $result['id']
        ]);
    }

    /**
    * @Route(
    *       "/login",
    *       name="login",
    *       methods={"GET","HEAD"}
    * )
    */
    public function loginUser(
        SessionInterface $session
    ): Response {
        $user = $session->get('user');

        return $this->render('user/login.html.twig', [
            'message' => '',
            'user' => $user
        ]);
    }

    /**
    * @Route(
    *       "/login",
    *       name="login_process",
    *       methods={"POST"}
    * )
    */
    public function loginProcess(
        Request $request,
        userRepository $userRepository,
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {
        $result = checkLogin($request, $userRepository, $doctrine, $session);

        if ($result[0] === 'wrong username') {
            return $this->render('user/login.html.twig', [
                'message' => 'wrong username',
                'user' => null
            ]);
        } elseif ($result[0] === 'wrong password') {
            return $this->render('user/login.html.twig', [
                'message' => 'wrong password',
                'user' => null
            ]);
        } elseif ($result[0] === 'admin') {
            return $this->redirectToRoute('user');
        } elseif ($result[0] === 'ordinary') {
            return $this->redirectToRoute('user_by_id', [
                'id' => $result[1]->getId()
            ]);
        }
        return $this->render('user/login.html.twig', [
            'message' => '',
            'user' => null
        ]);
    }

    /**
    * @Route(
    *       "/logout",
    *       name="logout",
    *       methods={"GET","HEAD"}
    * )
    */
    public function logoutUser(
        SessionInterface $session
    ): Response {
        $session->set('user', null);

        return $this->redirectToRoute('login');
    }
}

/**
 * Used in updateUserProcess in UserController
 * @return array<mixed>
 */
function makeUpdate(
    Request $request,
    ManagerRegistry $doctrine
): array {
    $userId = $request->request->get('id');
    $username = $request->request->get('username');
    $password  = $request->request->get('password');
    $name  = $request->request->get('name');
    $email  = $request->request->get('email');
    $type  = $request->request->get('type');

    $entityManager = $doctrine->getManager();
    $user = $entityManager->getRepository(User::class)->find($userId);

    if (!$user) {
        $noUser = array('user' => 'dont exist', 'id' => $userId);

        return $noUser;
    }

    $user->setUsername($username);
    $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
    $user->setName($name);
    $user->setEmail($email);
    $user->setType($type);
    $entityManager->flush();

    $user = array('user' => 'exist', 'id' => $userId);

    return $user;
}

/**
 * Used in method loginProcess in UserController
 * @return array<mixed>
 */
function checkLogin(
    Request $request,
    userRepository $userRepository,
    ManagerRegistry $doctrine,
    SessionInterface $session
): array {
    $username = $request->request->get('username');
    $password  = $request->request->get('password');

    $users = $userRepository
    ->findAll();

    $userId = null;
    foreach ($users as $user) {
        if ($user->getUsername() === $username) {
            $userId = $user->getId();
        }
    }

    $entityManager = $doctrine->getManager();
    $user = $entityManager->getRepository(User::class)->find($userId);

    if (!$userId) {
        $message = ['wrong username', $user];
        return $message;
    }

    if (password_verify($password, $user->getPassword())) {
        if ($user->getType() === 'admin') {
            $session->set('user', $user);

            $message = ['admin', $user];

            return $message;
        } elseif ($user->getType() === 'ordinary') {
            $session->set('user', $user);
            $message = ['ordinary', $user];

            return $message;
        }
    }
    $message = ['wrong password', $user];
    return $message;
}

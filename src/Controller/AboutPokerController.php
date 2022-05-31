<?php

namespace App\Controller;

use App\Entity\PokerUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PokerUserRepository;

class AboutPokerController extends AbstractController
{
    /**
    * @Route(
    *       "/proj/about",
    *       name="about_poker",
    *       methods={"GET","HEAD"}
    * )
    */
    public function aboutPoker(): Response
    {
        return $this->render('poker/about.html.twig');
    }

        /**
    * @Route(
    *       "/proj/reset",
    *       name="reset_poker",
    *       methods={"GET","HEAD"}
    * )
    */
    public function resetPoker(
        Request $request,
        ManagerRegistry $doctrine,
        PokerUserRepository $pokerUserRepository,
        SessionInterface $session
    ): Response{
        $entityManager = $doctrine->getManager();
        $users = $pokerUserRepository->findAll();

        foreach ($users as $user) {
            $entityManager->remove($user);
        }

        $adminUser = new PokerUser();
        $adminUser->setUsername('admin');
        $adminUser->setPassword(password_hash('admin', PASSWORD_DEFAULT));
        $adminUser->setName('Admin');
        $adminUser->setEmail('admin@admin.com');
        $adminUser->setType('admin');
        $adminUser->setPicture('https://avatarfiles.alphacoders.com/163/163235.jpg');
        $adminUser->setMoney(1000);
        $adminUser->setGames(0);
        $adminUser->setWins(0);

        $entityManager->persist($adminUser);

        $doeUser = new PokerUser();
        $doeUser->setUsername('doe');
        $doeUser->setPassword(password_hash('doe', PASSWORD_DEFAULT));
        $doeUser->setName('Doe');
        $doeUser->setEmail('doe@doe.com');
        $doeUser->setType('ordinary');
        $doeUser->setPicture('https://loveshayariimages.in/wp-content/uploads/2021/10/2021-Best-Quality-DP-for-Whatsapp-Profile-Images.jpg');
        $doeUser->setMoney(1000);
        $doeUser->setGames(0);
        $doeUser->setWins(0);

        $entityManager->persist($doeUser);

        $entityManager->flush();

        $session->set('CurrentPokerUser', null);

        return $this->redirectToRoute('login_poker');
    }
}

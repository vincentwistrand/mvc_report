<?php

namespace App\PokerCalculations;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PokerUser;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PokerUserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Used in updateUserProcess in PokerController.
 * Updates poker user.
 * @return array<string>
 */
function makePokerUserUpdate(
    Request $request,
    ManagerRegistry $doctrine
): array {
    $userId = $request->request->get('id');
    $username = $request->request->get('username');
    $password  = $request->request->get('password');
    $name  = $request->request->get('name');
    $email  = $request->request->get('email');
    $type  = $request->request->get('type');
    $money  = $request->request->get('money');
    $picture  = $request->request->get('picture');

    $entityManager = $doctrine->getManager();
    $user = $entityManager->getRepository(PokerUser::class)->find($userId);

    if (!$user) {
        $noUser = array('user' => 'dont exist', 'id' => $userId);

        return $noUser;
    }

    $user->setUsername($username);
    if ($password != "") {
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
    }
    $user->setName($name);
    $user->setEmail($email);
    $user->setType($type);
    $user->setMoney($money);
    $user->setPicture($picture);
    $entityManager->flush();

    $user = array('user' => 'exist', 'id' => $userId);

    return $user;
}

/**
 * Used in method login_process_poker in PokerController
 * @return array<mixed>
 */
function checkPokerLogin(
    Request $request,
    pokeruserRepository $pokeruserRepository,
    ManagerRegistry $doctrine,
    SessionInterface $session
) {
    $username = $request->request->get('username');
    $password  = $request->request->get('password');

    $users = $pokeruserRepository
    ->findAll();

    $userId = null;
    foreach ($users as $user) {
        if ($user->getUsername() === $username) {
            $userId = $user->getId();
        }
    }

    if (!$userId) {
        $message = ['wrong username', $userId];
        return $message;
    }

    $entityManager = $doctrine->getManager();
    $user = $entityManager->getRepository(PokerUser::class)->find($userId);


    if (password_verify($password, $user->getPassword())) {
        if ($user->getType() === 'admin') {
            $session->set('CurrentPokerUser', $user);

            $message = ['admin', $userId];

            return $message;
        } elseif ($user->getType() === 'ordinary') {
            $session->set('CurrentPokerUser', $user);
            $message = ['ordinary', $userId];

            return $message;
        }
    }

    $message = ['wrong password', $userId];
    return $message;
}

/**
* Used in method "pokergame_post" in PokerController.
* Managing the game.
* @return array<mixed>
*/
function managePokerGame(
    SessionInterface $session,
    Request $request,
    ManagerRegistry $doctrine
): array {
    $currentUser = $session->get('CurrentPokerUser');

    $entityManager = $doctrine->getManager();
    $user = $entityManager->getRepository(PokerUser::class)->find($currentUser->getId());

    $session->set('CurrentPokerUser', $user);

    $result = \App\PokerCalculations\managePokerInput($session, $request, $doctrine);

    $game = $session->get('PokerGame');

    $data = \App\PokerCalculations\getPokerGameInfo($game, $user, $session);

    return [$result, $user, $data];
}

/**
 * Used in "pokergame" in PokerController.
 * Returns game info.
 * @return array<mixed>
 */
function getPokerGameInfo(
    object $game,
    object $user,
    SessionInterface $session
): array {
    $playerHand = $game->getPlayerCards();
    $bankHand = $game->getBankCards();
    $tableCards = $game->getTableCards();
    $gamePot = $game->getPot();
    $playerUsername = $game->getPlayerUsername();
    $userMoney = $user->getMoney();
    $userId = $user->getId();

    $game = $session->get('PokerGame');
    $gameOver = $game->hasGameEnded();

    $comment = $session->get('PokerComment');
    $bankMove = $session->get('BankMove');
    $playerMove = $session->get('PlayerMove');

    //$gameEnd = $game->getGameEnd();

    $data = [
        'title' => 'Poker',
        //'game_end' => $gameEnd,
        'player_hand' => $playerHand,
        'bank_hand' => $bankHand,
        'table_cards' => $tableCards,
        'game_pot' => $gamePot,
        'player_username' => $playerUsername,
        'player_money' => $userMoney,
        'game_over' => $gameOver,
        'comment' => $comment,
        'bank_move' => $bankMove,
        'player_move' => $playerMove,
        'user_id' => $userId
    ];

    return $data;
}

/**
* Used in method "pokergame_post" in PokerController.
* Managing game input.
* @return string
*/
function managePokerInput(
    SessionInterface $session,
    Request $request,
    ManagerRegistry $doctrine
): string {
    $deal  = $request->request->get('deal');
    $ten = $request->request->get('ten');
    $twenty = $request->request->get('twenty');
    $call = $request->request->get('call');
    $check = $request->request->get('check');
    $fold = $request->request->get('fold');
    $restart = $request->request->get('restart');

    if ($deal) {
        $user = $session->get('CurrentPokerUser');
        $game = $session->get('PokerGame');
        $game->dealCardsToPlayers();

        $comment = $user->getUsername() . "'s turn";
        $session->set('PokerComment', $comment);
        return $deal;
    } elseif ($fold) {
        $game = $session->get('PokerGame');
        $game->setGameOver();
        $session->set('PokerComment', 'You folded');
        return $fold;
    } elseif ($restart) {
        return $restart;
    } elseif ($call) {
        $session->set('PlayerMove', 'call');
        $bet = 10;
        managePlayerMoney($bet, $session, $doctrine);

        return $call;
    } elseif ($ten) {
        $session->set('PlayerMove', 'bet');
        $bet = 10;
        managePlayerMoney($bet, $session, $doctrine);

        return $ten;
    } elseif ($twenty) {
        $session->set('PlayerMove', 're-raise');
        $bet = 20;
        managePlayerMoney($bet, $session, $doctrine);

        return $twenty;
    } elseif ($check) {
        $session->set('PlayerMove', 'check');
        $bet = 0;
        manageBank($bet, $session, $doctrine);
        return $check;
    }
    return 'null';
}

/**
* Update player money
* @return void
*/
function managePlayerMoney(
    int $bet,
    SessionInterface $session,
    ManagerRegistry $doctrine
): void {
    $game = $session->get('PokerGame');
    $game->addToPot($bet);

    $currentUser = $session->get('CurrentPokerUser');
    $money = $currentUser->getMoney();
    $entityManager = $doctrine->getManager();
    $user = $entityManager->getRepository(PokerUser::class)->find($currentUser->getId());
    $user->setMoney($money - $bet);
    $entityManager->flush();

    $playerMove = $session->get('PlayerMove');
    if ($playerMove === 'call') {
    }
    manageBank(
        $bet,
        $session,
        $doctrine
    );
}

/**
* Used in function managePokerInput().
* Managing bank moves and card points.
* @return void
*/
function manageBank(
    int $bet,
    SessionInterface $session,
    ManagerRegistry $doctrine
): void {
    $game = $session->get('PokerGame');
    $bankMove = $session->get('BankMove');
    $playerMove = $session->get('PlayerMove');

    $bankCards = $game->getBankCards();
    $tableCards = $game->getTableCards();

    $bankCardsObjects = [];

    foreach ($bankCards as $card) {
        $bankCardsObjects[] = (object) [
            'colour' => $card->getColour(),
            'points' => intval($card->getPoints())
        ];
    }

    $sortedCards = sortBankAndTableCards($bankCards, $tableCards);

    $bankCardsColour = $sortedCards[0];
    $bankCardsPoints = $sortedCards[1];
    //$tableCardsColour = $sortedCards[2];
    $tableCardsPoints = $sortedCards[3];
    $totalBankCards = $sortedCards[4];

    dump($bankCardsColour);
    dump($bankCardsPoints);


    if (count($totalBankCards) === 2) {
        twoBankCards(
            $bankCardsPoints,
            $game,
            $bet,
            $bankMove,
            $playerMove,
            $session
        );
    }

    if (count($totalBankCards) === 5) {
        $cardPoints = checkHandFiveCards($bankCardsPoints, $bankCardsColour);
        $tablePoints = checkHandThreeCards($tableCardsPoints);

        //dump($cardPoints);
        //dump($tablePoints);

        fiveBankCards(
            $cardPoints,
            $tablePoints,
            $game,
            $bet,
            $bankMove,
            $playerMove,
            $session
        );
    }

    if (count($totalBankCards) === 6) {
        $cardPoints = checkHandSixCards($bankCardsPoints, $bankCardsColour);
        $tablePoints = checkHandFourCards($tableCardsPoints);

        ////dump($cardPoints);
        ////dump($tablePoints);

        sixBankCards(
            $cardPoints,
            $tablePoints,
            $game,
            $bet,
            $bankMove,
            $playerMove,
            $session
        );
    }

    if (count($totalBankCards) === 7) {
        $cardPoints = checkHandSevenCards($bankCardsPoints, $bankCardsColour, $bankCardsObjects);
        //$tablePoints = checkHandFiveCards($tableCardsPoints, $tableCardsColour);

        //dump($cardPoints);
        //dump($tablePoints);

        sevenBankCards(
            $cardPoints,
            //$tablePoints,
            $bankCardsColour,
            $bankCardsPoints,
            $doctrine,
            $session
        );
    }
}

/**
 * If bank and table cards together is 2
 * @return array<mixed>
 * @param array<object> $bankCards
 * @param array<object> $tableCards
 */
function sortBankAndTableCards(
    array $bankCards,
    array $tableCards
): array {
    // Put bank cards and table cards in an array and make one array sorted by points and
    // one array sorted by colours to make it easier to count points
    $totalBankCards = [];
    foreach ($bankCards as $card) {
        $totalBankCards[] = $card;
    }
    foreach ($tableCards as $card) {
        $totalBankCards[] = $card;
    }

    $bankCardsObjects = [];

    foreach ($totalBankCards as $card) {
        $bankCardsObjects[] = (object) [
            'colour' => $card->getColour(),
            'points' => intval($card->getPoints())
        ];
    }

    usort($bankCardsObjects, function ($objectA, $objectB) {
        return strcmp($objectA->colour, $objectB->colour);
    });

    $bankCardsColour = $bankCardsObjects;

    usort($bankCardsObjects, function ($objectA, $objectB) {
        return $objectA->points - $objectB->points;
    });

    $bankCardsPoints = $bankCardsObjects;

    // Sort table cards by points and by colours to make it easier to count points
    $tableCardsObjects = [];

    foreach ($tableCards as $card) {
        $tableCardsObjects[] = (object) [
            'colour' => $card->getColour(),
            'points' => intval($card->getPoints())
        ];
    }

    usort($tableCardsObjects, function ($objectA, $objectB) {
        return strcmp($objectA->colour, $objectB->colour);
    });

    $tableCardsColour = $tableCardsObjects;

    usort($tableCardsObjects, function ($objectA, $objectB) {
        return $objectA->points - $objectB->points;
    });

    $tableCardsPoints = $tableCardsObjects;

    return [
        $bankCardsColour,
        $bankCardsPoints,
        $tableCardsColour,
        $tableCardsPoints,
        $totalBankCards
    ];
}

/**
 * If bank and table cards together is 2 cards
 * @return void
 * @param array<object> $bankCardsPoints
 * @param object $game
 * @param int $bet
 * @param string $bankMove
 * @param string $playerMove
 */
function twoBankCards(
    $bankCardsPoints,
    $game,
    $bet,
    $bankMove,
    $playerMove,
    SessionInterface $session
): void {
    if ($playerMove === 'call') {
        $currentUser = $session->get('CurrentPokerUser');
        $username = $currentUser->getUsername();
        $session->set('PokerComment', $username . ' calls, three cards is dealt, your turn!');
        $game->dealThreeCardsToTable();
        $session->set('BankMove', '');
        return;
    }

    if (($bankCardsPoints[0]->points === $bankCardsPoints[1]->points) && $bankMove === '') {
        $game->addToPot($bet * 2);
        $session->set('PokerComment', 'Bank raises with 10$, your turn!');
        $session->set('BankMove', 'raise');
        return;
    }

    if ($playerMove === 're-raise') {
        $bet = 10;
    }

    $game->addToPot($bet);
    $session->set('PokerComment', 'Bank calls, three cards is dealt, your turn!');
    $game->dealThreeCardsToTable();
    $session->set('BankMove', '');
}

/**
 * If bank and table cards together is 5 cards
 * @return void
 * @param int $cardPoints
 * @param int $tablePoints
 * @param object $game
 * @param int $bet
 * @param string $bankMove
 * @param string $playerMove
 */
function fiveBankCards(
    int $cardPoints,
    int $tablePoints,
    object $game,
    int $bet,
    string $bankMove,
    string $playerMove,
    SessionInterface $session
): void {
    if ($playerMove === 'call') {
        $currentUser = $session->get('CurrentPokerUser');
        $username = $currentUser->getUsername();
        $session->set('PokerComment', $username . ' calls, three cards is dealt, your turn!');
        $game->dealOneCardToTable();
        $session->set('BankMove', '');
        return;
    }

    if ($cardPoints >= 100 && $cardPoints != $tablePoints && $bankMove === '') {
        if ($playerMove === 'check') {
            $game->addToPot(10);
            $session->set('PokerComment', 'Bank raises with 10$, your turn!');
            $session->set('BankMove', 'raise');
            return;
        } elseif ($playerMove === 'bet') {
            $game->addToPot(20);
            $session->set('PokerComment', 'Bank raises with 10$, your turn!');
            $session->set('BankMove', 'raise');
            return;
        }
    }

    if ($playerMove === 're-raise') {
        $bet = 10;
    }

    $game->addToPot($bet);
    $session->set('PokerComment', 'Bank calls, another card is dealt, your turn!');
    $game->dealOneCardToTable();
    $session->set('BankMove', '');
}

/**
 * If bank and table cards together is 6 cards
 * @return void
 * @param int $cardPoints
 * @param int $tablePoints
 * @param object $game
 * @param int $bet
 * @param string $bankMove
 * @param string $playerMove
 */
function sixBankCards(
    int $cardPoints,
    int $tablePoints,
    object $game,
    int $bet,
    string $bankMove,
    string $playerMove,
    SessionInterface $session
): void {
    if ($playerMove === 'call') {
        $currentUser = $session->get('CurrentPokerUser');
        $username = $currentUser->getUsername();
        $session->set('PokerComment', $username . ' calls, three cards is dealt, your turn!');
        $game->dealOneCardToTable();
        $session->set('BankMove', '');
        return;
    }

    if ($cardPoints >= 100 && $cardPoints != $tablePoints && $bankMove === '') {
        if ($playerMove === 'check') {
            $game->addToPot(10);
            $session->set('PokerComment', 'Bank raises with 10$, your turn!');
            $session->set('BankMove', 'raise');
            return;
        } elseif ($playerMove === 'bet') {
            $game->addToPot(20);
            $session->set('PokerComment', 'Bank raises with 10$, your turn!');
            $session->set('BankMove', 'raise');
            return;
        }
    }

    if ($playerMove === 're-raise') {
        $bet = 10;
    }

    $game->addToPot($bet);
    $session->set('PokerComment', 'Bank calls, another card is dealt, your turn!');
    $game->dealOneCardToTable();
    $session->set('BankMove', '');
}

/**
 * If bank and table cards together is 7 cards
 * @return void
 * @param int $cardPoints
 * @param array<object> $bankCardsColour
 * @param array<object> $bankCardsPoints
 *
 */
function sevenBankCards(
    int $cardPoints,
    array $bankCardsColour,
    array $bankCardsPoints,
    ManagerRegistry $doctrine,
    SessionInterface $session
): void {
    $game = $session->get('PokerGame');
    $bankMove = $session->get('BankMove');
    $playerMove = $session->get('PlayerMove');

    if ($cardPoints >= 100 && $bankMove === '') {
        if ($playerMove === 'check') {
            $game->addToPot(10);
            $session->set('PokerComment', 'Bank raises with 10$, your turn');
            $session->set('BankMove', 'raise');
            return;
        } elseif ($playerMove === 'bet') {
            $game->addToPot(20);
            $session->set('PokerComment', 'Bank raises with 10$, your turn');
            $session->set('BankMove', 'raise');
            return;
        }
    }

    if ($playerMove === 're-raise') {
        $game->addToPot(10);
    }

    endOfGame(
        $bankCardsColour,
        $bankCardsPoints,
        $game,
        $session,
        $doctrine
    );
}

/**
 * Calculate winner
 * @return void
 * @param array<object> $bankCardsColour
 * @param array<object> $bankCardsPoints
 * @param object $game
 *
 */
function endOfGame(
    $bankCardsColour,
    $bankCardsPoints,
    $game,
    SessionInterface $session,
    ManagerRegistry $doctrine
): void {
    $session->set('PokerComment', 'End of game');
    $session->set('BankMove', '');
    $game->setGameOver();

    $endPoints = checkpoints($game, $bankCardsColour, $bankCardsPoints);

    $playerCardPoints = $endPoints[0];
    $bankCardPoints = $endPoints[1];
    ;

    dump('Player points: ' . $playerCardPoints);
    dump('Bank points: ' . $bankCardPoints);

    if ($playerCardPoints === $bankCardPoints) {
        $bankCards = $game->getBankCards();
        $playerCards = $game->getPlayerCards();

        $playerPoints = 0;
        foreach ($playerCards as $card) {
            $playerPoints += $card->getPoints();
        }

        $bankPoints = 0;
        foreach ($bankCards as $card) {
            $bankPoints += $card->getPoints();
        }

        if ($playerPoints > $bankPoints) {
            playerIsWinner(
                $game,
                $session,
                $doctrine
            );

            return;
        }

        $session->set('PokerComment', 'Bank is the winner of ' . $game->getPot() . '$!');
    }

    if ($playerCardPoints > $bankCardPoints) {
        playerIsWinner(
            $game,
            $session,
            $doctrine
        );

        return;
    }

    $session->set('PokerComment', 'Bank is the winner of ' . $game->getPot() . '$!');
}

/**
 * Calculate winner
 * @return array<int>
 * @param object $game
 * @param array<object> $bankCardsColour
 * @param array<object> $bankCardsPoints
 */
function checkPoints(
    object $game,
    array $bankCardsColour,
    array $bankCardsPoints
): array {
    // Put player cards and table cards in an array and make one array sorted by points and
    // one array sorted by colours to make it easier to count points
    $bankCards = $game->getBankCards();
    $playerCards = $game->getPlayerCards();
    $tableCards = $game->getTableCards();

    $totalPlayerCards = [];

    foreach ($playerCards as $card) {
        $totalPlayerCards[] = $card;
    }

    foreach ($tableCards as $card) {
        $totalPlayerCards[] = $card;
    }

    $bankCardsObjects = [];

    foreach ($bankCards as $card) {
        $bankCardsObjects[] = (object) [
            'colour' => $card->getColour(),
            'points' => intval($card->getPoints())
        ];
    }

    $playerCardsObjects = [];

    foreach ($playerCards as $card) {
        $playerCardsObjects[] = (object) [
            'colour' => $card->getColour(),
            'points' => intval($card->getPoints())
        ];
    }

    $allPlayerObjects = [];

    foreach ($totalPlayerCards as $card) {
        $allPlayerObjects[] = (object) [
            'colour' => $card->getColour(),
            'points' => intval($card->getPoints())
        ];
    }

    usort($allPlayerObjects, function ($objectA, $objectB) {
        return strcmp($objectA->colour, $objectB->colour);
    });

    $playerCardsColour = $allPlayerObjects;

    usort($allPlayerObjects, function ($objectA, $objectB) {
        return $objectA->points - $objectB->points;
    });

    $playerCardsPoints = $allPlayerObjects;

    // Check points
    $playerCardPoints = checkHandSevenCards($playerCardsPoints, $playerCardsColour, $playerCardsObjects);
    $bankCardPoints = checkHandSevenCards($bankCardsPoints, $bankCardsColour, $bankCardsObjects);

    return [$playerCardPoints, $bankCardPoints];
}

/**
 * Calculate winner
 * @return void
 * @param object $game
 */
function playerIsWinner(
    $game,
    SessionInterface $session,
    ManagerRegistry $doctrine
): void {
    $currentUser = $session->get('CurrentPokerUser');
    $money = $currentUser->getMoney();

    $entityManager = $doctrine->getManager();
    $user = $entityManager->getRepository(PokerUser::class)->find($currentUser->getId());

    $winnerMoney = $game->getPot() + $money;
    $totalWins = $user->getWins() + 1;

    $user->setMoney($winnerMoney);
    $user->setWins($totalWins);
    $entityManager->flush();

    $session->set('PokerComment', $user->getUsername() . ' is the winner of the pot! (' . $game->getPot() . '$)');
}

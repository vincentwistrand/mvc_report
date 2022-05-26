<?php

namespace App\Card;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PokerUser;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PokerUserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Used in updateUserProcess in UserController
 */
function makePokerUserUpdate(
    $request,
    $doctrine
) {
    $id = $request->request->get('id');
    $username = $request->request->get('username');
    $password  = $request->request->get('password');
    $name  = $request->request->get('name');
    $email  = $request->request->get('email');
    $type  = $request->request->get('type');

    $entityManager = $doctrine->getManager();
    $user = $entityManager->getRepository(PokerUser::class)->find($id);

    if (!$user) {
        $no_user = array('user' => 'dont exist', 'id' => $id);

        return $no_user;
    }

    $user->setUsername($username);
    $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
    $user->setName($name);
    $user->setEmail($email);
    $user->setType($type);
    $entityManager->flush();

    $user = array('user' => 'exist', 'id' => $id);

    return $user;
}

/**
 * Used in method login_process_poker in UserController
 */
function checkPokerLogin(
    $request,
    $pokeruserRepository,
    $doctrine,
    $session
) {
    $username = $request->request->get('username');
    $password  = $request->request->get('password');

    $users = $pokeruserRepository
    ->findAll();

    $id = null;
    foreach ($users as $user) {
        if ($user->getUsername() === $username) {
            $id = $user->getId();
        }
    }

    if (!$id) {
        $message = ['wrong username', $user];
        return $message;
    }

    $entityManager = $doctrine->getManager();
    $user = $entityManager->getRepository(PokerUser::class)->find($id);

    if (password_verify($password, $user->getPassword())) {
        if ($user->getType() === 'admin') {
            $session->set('CurrentPokerUser', $user);

            $message = ['admin', $user];

            return $message;
        } elseif ($user->getType() === 'ordinary') {
            $session->set('CurrentPokerUser', $user);
            $message = ['ordinary', $user];

            return $message;
        }
    } else {
        $message = ['wrong password', $user];
        return $message;
    }
}

/**
 * Used in StartGame()
 * @return array
 */
function getPokerGameInfo(
    object $game,
    object $user,
    SessionInterface $session
): array {
    $player_hand = $game->getPlayerCards();
    $bank_hand = $game->getBankCards();
    $table_cards = $game->getTableCards();
    $game_pot = $game->getPot();
    $player_username = $game->getplayerUsername();
    $user_money = $user->getMoney();

    $game = $session->get('PokerGame');
    $game_over = $game->getGameOver();

    $comment = $session->get('PokerComment');
    $bank_move = $session->get('BankMove');
    $player_move = $session->get('PlayerMove');

    //$gameEnd = $game->getGameEnd();

    $data = [
        'title' => 'Poker',
        //'game_end' => $gameEnd,
        'player_hand' => $player_hand,
        'bank_hand' => $bank_hand,
        'table_cards' => $table_cards,
        'game_pot' => $game_pot,
        'player_username' => $player_username,
        'player_money' => $user_money,
        'game_over' => $game_over,
        'comment' => $comment,
        'bank_move' => $bank_move,
        'player_move' => $player_move,
    ];

    return $data;
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return string
*/
function managePokerInput(
    SessionInterface $session,
    Request $request,
    ManagerRegistry $doctrine
): string {
    $deal  = $request->request->get('deal');
    $bet_ten = $request->request->get('bet_ten');
    $check = $request->request->get('check');
    $fold = $request->request->get('fold');
    $restart = $request->request->get('restart');
    $back = $request->request->get('go_back');

    if ($deal) {
        $user = $session->get('CurrentPokerUser');
        $game = $session->get('PokerGame');
        $game->dealCardsToPlayers();

        $comment = $user->getUsername() . "'s turn";
        $session->set('PokerComment', $comment);
        return $deal;   
    } else if ($fold) {
        $game = $session->get('PokerGame');
        $game->setGameOver();
        return $fold;   
    } else if ($restart) {
        return $restart;   
    } else if ($back) {
        return $back;   
    } else if ($bet_ten) {
        $session->set('PlayerMove', 'bet');
        $game = $session->get('PokerGame');
        $bet = 10;
        $game->addToPot($bet);
        //$session->set('PlayerMove', 'bet');
        $bank_choice = manageBank(
                            $bet,
                            $session,
                            $request,
                            $doctrine
                        );
        return $bet_ten;   
    } else if ($check) {
        $session->set('PlayerMove', 'check');
        $bet = 0;
        $bank_choice = manageBank(
                            $bet,
                            $session,
                            $request,
                            $doctrine
                        );
        return $check;   
    }
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return void
*/
function manageBank(
    int $bet,
    SessionInterface $session,
    Request $request,
    ManagerRegistry $doctrine
): void {
    //Testing--------------------------------------------------

    //$test_cards = [];
    //$test_cards[] = new \App\Card\Card(
    //    '2',
    //    'Hjarter',
    //    '2'
    //);
    //$test_cards[] = new \App\Card\Card(
    //    '2',
    //    'Ruter',
    //    '2'
    //);
    //$test_cards[] = new \App\Card\Card(
    //    '3',
    //    'Spader',
    //    '3'
    //);
    //$test_cards[] = new \App\Card\Card(
    //    '3',
    //    'Klover',
    //    '3'
    //);
    //$test_cards[] = new \App\Card\Card(
    //    '4',
    //    'Klover',
    //    '4'
    //);
    //$test_cards[] = new \App\Card\Card(
    //    '4',
    //    'Klover',
    //    '4'
    //);
    //$test_cards[] = new \App\Card\Card(
    //    '5',
    //    'Klover',
    //    '5'
    //);

    //$new_test_object = [];

    //foreach ($test_cards as $card) {
    //    $new_test_object[] = (object) [
    //        'colour' => $card->getColour(),
    //        'points' => intval($card->getPoints())
    //    ];
    //}

    //sort by colours
    //usort($new_test_object, function($a, $b){
    //    return strcmp($a->colour, $b->colour);
    //});
    
    //$colour = $new_test_object;
    
    //sort by points
    //usort($new_test_object,function($a, $b){
    //    return $a->points - $b->points;
    //});
    
    //$points = $new_test_object;

    //dump(checkHandSevenCards($colour, $points));
    //-------------------------------------------------------------
    
    $game = $session->get('PokerGame');
    $user = $session->get('CurrentPokerUser');
    $bank_move = $session->get('BankMove');
    $player_move = $session->get('PlayerMove');

    $bc = $game->getBankCards();
    $tc = $game->getTableCards();

    // Put player cards and table cards in an array and make one array sorted by points and
    // one array sorted by colours to make it easier to count points
    $total_bank_cards = [];
    foreach ($bc as $card) {
        $total_bank_cards[] = $card;
    }
    foreach ($tc as $card) {
        $total_bank_cards[] = $card;
    }

    $bank_cards_objects = [];

    foreach ($total_bank_cards as $card) {
        $bank_cards_objects[] = (object) [
            'colour' => $card->getColour(),
            'points' => intval($card->getPoints())
        ];
    }

    usort($bank_cards_objects, function($a, $b){
        return strcmp($a->colour, $b->colour);
    });

    $bank_cards_sorted_colour = $bank_cards_objects;

    usort($bank_cards_objects,function($a, $b){
        return $a->points - $b->points;
    });

    $bank_cards_sorted_points = $bank_cards_objects;

    // Sort table cards by points and by colours to make it easier to count points
    $table_cards_objects = [];

    foreach ($tc as $card) {
        $table_cards_objects[] = (object) [
            'colour' => $card->getColour(),
            'points' => intval($card->getPoints())
        ];
    }

    usort($table_cards_objects, function($a, $b){
        return strcmp($a->colour, $b->colour);
    });

    $table_cards_sorted_colour = $table_cards_objects;

    usort($table_cards_objects,function($a, $b){
        return $a->points - $b->points;
    });

    $table_cards_sorted_points = $table_cards_objects;




    if (count($total_bank_cards) === 2) {
        if ( ($bank_cards_sorted_points[0]->points === $bank_cards_sorted_points[1]->points) && $bank_move != 'raise') {
            $game->addToPot($bet * 2);
            $session->set('PokerComment', 'Bank raises with 10$');
            $session->set('BankMove', 'raise');
        } else {
            $game->addToPot($bet);
            $session->set('PokerComment', 'Bank calls');
            $game->dealThreeCardsToTable();
            $session->set('BankMove', '');
        }
    }

    if (count($total_bank_cards) === 5) {
        $card_points = checkHandFiveCards($bank_cards_sorted_colour, $bank_cards_sorted_points);
        $table_points = checkHandThreeCards($table_cards_sorted_colour, $table_cards_sorted_points);

        if ($card_points >= 100 && $card_points != $table_points && $bank_move != 'raise') {
            if ($player_move === 'check') {
                $game->addToPot(10);
                $session->set('PokerComment', 'Bank raises with 10$');
                $session->set('BankMove', 'raise');
            } else if ($player_move === 'bet') {
                $game->addToPot(20);
                $session->set('PokerComment', 'Bank raises with 10$');
                $session->set('BankMove', 'raise');
            }
        }
        else {
            $game->addToPot($bet);
            $session->set('PokerComment', 'Bank calls');
            $game->dealOneCardToTable();
            $session->set('BankMove', '');
            //$session->set('PokerComment', 'Bank folds, you win!');
            //$game->setGameOver(true);
        }
    }

    if (count($total_bank_cards) === 6) {
        $card_points = checkHandSixCards($bank_cards_sorted_colour, $bank_cards_sorted_points);
        $table_points = checkHandFourCards($table_cards_sorted_colour, $table_cards_sorted_points);

        if ($card_points >= 100 && $card_points != $table_points && $bank_move != 'raise') {
            if ($player_move === 'check') {
                $game->addToPot(10);
                $session->set('PokerComment', 'Bank raises with 10$');
                $session->set('BankMove', 'raise');
            } else if ($player_move === 'bet') {
                $game->addToPot(20);
                $session->set('PokerComment', 'Bank raises with 10$');
                $session->set('BankMove', 'raise');
            }
        }
        else {
            $game->addToPot($bet);
            $session->set('PokerComment', 'Bank calls');
            $game->dealOneCardToTable();
            $session->set('BankMove', '');
        }
    }

    if (count($total_bank_cards) === 7) {
        $card_points = checkHandSevenCards($bank_cards_sorted_colour, $bank_cards_sorted_points);
        $table_points = checkHandFiveCards($table_cards_sorted_colour, $table_cards_sorted_points);

        if ($card_points >= 100 && $card_points > $table_points && $bank_move != 'raise') {
            if ($player_move === 'check') {
                $game->addToPot(10);
                $session->set('PokerComment', 'Bank raises with 10$');
                $session->set('BankMove', 'raise');
            } else if ($player_move === 'bet') {
                $game->addToPot(20);
                $session->set('PokerComment', 'Bank raises with 10$');
                $session->set('BankMove', 'raise');
            }
        }
        else {
            $game->addToPot($bet);
            $session->set('PokerComment', 'Game End');
            $session->set('BankMove', '');
            $game->setGameOver();
            
            // Put player cards and table cards in an array and make one array sorted by points and
            // one array sorted by colours to make it easier to count points
            $pc = $game->getPlayerCards();
        
            $total_player_cards = [];
            foreach ($pc as $card) {
                $total_player_cards[] = $card;
            }
            foreach ($tc as $card) {
                $total_player_cards[] = $card;
            }
        
            $player_cards_objects = [];
        
            foreach ($total_player_cards as $card) {
                $player_cards_objects[] = (object) [
                    'colour' => $card->getColour(),
                    'points' => intval($card->getPoints())
                ];
            }

            usort($player_cards_objects, function($a, $b){
                return strcmp($a->colour, $b->colour);
            });
        
            $player_cards_sorted_colour = $player_cards_objects;

            usort($player_cards_objects,function($a, $b){
                return $a->points - $b->points;
            });
        
            $player_cards_sorted_points = $player_cards_objects;

            // Check points
            $player_card_points = checkHandSevenCards($player_cards_sorted_colour, $player_cards_sorted_points);
            $bank_card_points = checkHandSevenCards($bank_cards_sorted_colour, $bank_cards_sorted_points);

            dump($player_card_points);
            dump($bank_card_points);

            if ($player_card_points > $bank_card_points) {
                $session->set('PokerComment', $user->getUsername() . ' wins');
            } else {
                $session->set('PokerComment', 'Bank wins');
            }
        }
    }
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkHandThreeCards(
    array $colour,
    array $points
): int {
    // Three of a kind
    if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points) {
        $total_points = checkThreeOfAKindCards($colour, $points);
        return $total_points;
    }

    // Pair
    if ($points[0]->points === $points[1]->points || $points[1]->points === $points[2]->points) {
        $total_points = checkPairCards($colour, $points);
        return $total_points;
    }

    return 0;
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkHandFourCards(
    array $colour,
    array $points
): int {
    // Four of a kind
    if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points &&
    $points[2]->points === $points[3]->points) {
        $total_points = checkFourOfAKindCards($colour, $points);
        return $total_points;
    }

    // Three of a kind
    if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points || 
    $points[1]->points === $points[2]->points && $points[2]->points === $points[3]->points) {
        $total_points = checkThreeOfAKindCards($colour, $points);
        return $total_points;
    }

    // Two pairs
    if ($points[0]->points === $points[1]->points && $points[2]->points === $points[3]->points) {
        $total_points = checkTwoPairsCards($colour, $points);
        return $total_points;
    }

    // Pair
    if ($points[0]->points === $points[1]->points || $points[1]->points === $points[2]->points || 
    $points[2]->points === $points[3]->points) {
        $total_points = checkPairCards($colour, $points);
        return $total_points;
    }

    return 0;
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkHandFiveCards(
    array $colour,
    array $points
): int {
    // Royal flush
    if ($points[1]->points === ($points[0]->points + 1) && $points[2]->points === ($points[1]->points + 1) &&
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) &&
    $points[0]->colour === $points[1]->colour && $points[1]->colour === $points[2]->colour &&
    $points[2]->colour === $points[3]->colour && $points[3]->colour === $points[4]->colour && $points[4]->points === 14) {
        return 1000;
    }

    // Straight flush
    if ($points[1]->points === ($points[0]->points + 1) && $points[2]->points === ($points[1]->points + 1) &&
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) &&
    $points[0]->colour === $points[1]->colour && $points[1]->colour === $points[2]->colour &&
    $points[2]->colour === $points[3]->colour && $points[3]->colour === $points[4]->colour) {
        $total_points = checkStraightFlushCards($colour, $points);
        return $total_points;
    }

    // Four of a kind
    if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points &&
    $points[2]->points === $points[3]->points || 
    $points[1]->points === $points[2]->points && $points[2]->points === $points[3]->points &&
    $points[3]->points === $points[4]->points) {
        $total_points = checkFourOfAKindCards($colour, $points);
        return $total_points;
    }

    // Full house
    if ($points[0]->points === $points[1]->points && $points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points ||
    $points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points && $points[3]->points === $points[4]->points) {
        $total_points = checkFullHouseCards($colour, $points);
        return $total_points;
    }

    // Flush
    if ($colour[0]->colour === $colour[4]->colour) {
        $total_points = checkFlushCards($colour, $points);
        return $total_points;
    }

    // Straight
    if ($points[1]->points === ($points[0]->points + 1) && $points[2]->points === ($points[1]->points + 1) &&
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1)) {
        $total_points = checkStraightCards($colour, $points);
        return $total_points;
    }

    // Three of a kind
    if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points || 
    $points[1]->points === $points[2]->points && $points[2]->points === $points[3]->points ||
    $points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points) {
        $total_points = checkThreeOfAKindCards($colour, $points);
        return $total_points;
    }

    // Two pairs
    if ($points[0]->points === $points[1]->points && $points[2]->points === $points[3]->points ||
    $points[0]->points === $points[1]->points && $points[3]->points === $points[4]->points ||
    $points[1]->points === $points[2]->points && $points[3]->points === $points[4]->points) {
        $total_points = checkTwoPairsCards($colour, $points);
        return $total_points;
    }

    // Pair
    if ($points[0]->points === $points[1]->points || $points[1]->points === $points[2]->points || 
    $points[2]->points === $points[3]->points || $points[3]->points === $points[4]->points) {
        $total_points = checkPairCards($colour, $points);
        return $total_points;
    }

    $card_points = 0;
    foreach ($points as $card) {
        $card_points += $card->points;
    }

    return $card_points;
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkHandSixCards(
    array $colour,
    array $points
): int {
    // Royal flush
    if ($points[1]->points === ($points[0]->points + 1) && $points[2]->points === ($points[1]->points + 1) &&
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) &&
    $points[0]->colour === $points[1]->colour && $points[1]->colour === $points[2]->colour &&
    $points[2]->colour === $points[3]->colour && $points[3]->colour === $points[4]->colour && $points[4]->points === 14 || 
    $points[2]->points === ($points[1]->points + 1) && $points[3]->points === ($points[2]->points + 1) &&
    $points[4]->points === ($points[3]->points + 1) && $points[5]->points === ($points[4]->points + 1) &&
    $points[1]->colour === $points[2]->colour && $points[2]->colour === $points[3]->colour &&
    $points[3]->colour === $points[4]->colour && $points[4]->colour === $points[5]->colour && $points[5]->points === 14) {
        return 1000;
    }

    // Straight flush
    if ($points[1]->points === ($points[0]->points + 1) && $points[2]->points === ($points[1]->points + 1) &&
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) &&
    $points[0]->colour === $points[1]->colour && $points[1]->colour === $points[2]->colour &&
    $points[2]->colour === $points[3]->colour && $points[3]->colour === $points[4]->colour || 
    $points[2]->points === ($points[1]->points + 1) && $points[3]->points === ($points[2]->points + 1) &&
    $points[4]->points === ($points[3]->points + 1) && $points[5]->points === ($points[4]->points + 1) &&
    $points[1]->colour === $points[2]->colour && $points[2]->colour === $points[3]->colour &&
    $points[3]->colour === $points[4]->colour && $points[4]->colour === $points[5]->colour) {
        $total_points = checkStraightFlushCards($colour, $points);
        return $total_points;
    }

    // Four of a kind
    if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points &&
    $points[2]->points === $points[3]->points || 
    $points[1]->points === $points[2]->points && $points[2]->points === $points[3]->points &&
    $points[3]->points === $points[4]->points ||
    $points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points &&
    $points[4]->points === $points[5]->points) {
        $total_points = checkFourOfAKindCards($colour, $points);
        return $total_points;
    }

    // Full house
    if ($points[0]->points === $points[1]->points && $points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points ||
    $points[0]->points === $points[1]->points && $points[3]->points === $points[4]->points && $points[4]->points === $points[5]->points ||
    $points[1]->points === $points[2]->points && $points[3]->points === $points[4]->points && $points[4]->points === $points[5]->points ||
    $points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points && $points[3]->points === $points[4]->points ||
    $points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points && $points[4]->points === $points[5]->points ||
    $points[1]->points === $points[2]->points && $points[2]->points === $points[3]->points && $points[4]->points === $points[5]->points) {
        $total_points = checkFullHouseCards($colour, $points);
        return $total_points;
    }

    // Flush
    if ($colour[0]->colour === $colour[4]->colour || $colour[1]->colour === $colour[5]->colour) {
        $total_points = checkFlushCards($colour, $points);
        return $total_points;
    }

    // Straight
    if ($points[1]->points === ($points[0]->points + 1) && $points[2]->points === ($points[1]->points + 1) &&
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) || 
    $points[2]->points === ($points[1]->points + 1) && $points[3]->points === ($points[2]->points + 1) &&
    $points[4]->points === ($points[3]->points + 1) && $points[5]->points === ($points[4]->points + 1)) {
        $total_points = checkStraightCards($colour, $points);
        return $total_points;
    }

    // Three of a kind
    if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points || 
    $points[1]->points === $points[2]->points && $points[2]->points === $points[3]->points ||
    $points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points ||
    $points[3]->points === $points[4]->points && $points[4]->points === $points[5]->points) {
        $total_points = checkThreeOfAKindCards($colour, $points);
        return $total_points;
    }

    // Two pairs
    if ($points[0]->points === $points[1]->points && $points[2]->points === $points[3]->points ||
    $points[0]->points === $points[1]->points && $points[3]->points === $points[4]->points ||
    $points[0]->points === $points[1]->points && $points[4]->points === $points[5]->points ||
    $points[1]->points === $points[2]->points && $points[3]->points === $points[4]->points ||
    $points[1]->points === $points[2]->points && $points[4]->points === $points[5]->points ||
    $points[2]->points === $points[3]->points && $points[4]->points === $points[5]->points) {
        $total_points = checkTwoPairsCards($colour, $points);
        return $total_points;
    }

    // Pair
    if ($points[0]->points === $points[1]->points || $points[1]->points === $points[2]->points || 
    $points[2]->points === $points[3]->points || $points[3]->points === $points[4]->points || 
    $points[4]->points === $points[5]->points) {
        $total_points = checkPairCards($colour, $points);
        return $total_points;
    }

    $card_points = 0;
    foreach ($points as $card) {
        $card_points += $card->points;
    }

    return $card_points;
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkHandSevenCards(
    array $colour,
    array $points
): int {
    // Royal flush
    if ($points[1]->points === ($points[0]->points + 1) && $points[2]->points === ($points[1]->points + 1) &&
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) &&
    $points[0]->colour === $points[1]->colour && $points[1]->colour === $points[2]->colour &&
    $points[2]->colour === $points[3]->colour && $points[3]->colour === $points[4]->colour && $points[4]->points === 14 || 
    $points[2]->points === ($points[1]->points + 1) && $points[3]->points === ($points[2]->points + 1) &&
    $points[4]->points === ($points[3]->points + 1) && $points[5]->points === ($points[4]->points + 1) &&
    $points[1]->colour === $points[2]->colour && $points[2]->colour === $points[3]->colour &&
    $points[3]->colour === $points[4]->colour && $points[4]->colour === $points[5]->colour && $points[5]->points === 14 ||
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) &&
    $points[5]->points === ($points[4]->points + 1) && $points[6]->points === ($points[5]->points + 1) &&
    $points[2]->colour === $points[3]->colour && $points[3]->colour === $points[4]->colour &&
    $points[4]->colour === $points[5]->colour && $points[5]->colour === $points[6]->colour  && $points[6]->points === 14) {
        return 1000;
    }

    // Straight flush
    if ($points[1]->points === ($points[0]->points + 1) && $points[2]->points === ($points[1]->points + 1) &&
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) &&
    $points[0]->colour === $points[1]->colour && $points[1]->colour === $points[2]->colour &&
    $points[2]->colour === $points[3]->colour && $points[3]->colour === $points[4]->colour || 
    $points[2]->points === ($points[1]->points + 1) && $points[3]->points === ($points[2]->points + 1) &&
    $points[4]->points === ($points[3]->points + 1) && $points[5]->points === ($points[4]->points + 1) &&
    $points[1]->colour === $points[2]->colour && $points[2]->colour === $points[3]->colour &&
    $points[3]->colour === $points[4]->colour && $points[4]->colour === $points[5]->colour ||
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) &&
    $points[5]->points === ($points[4]->points + 1) && $points[6]->points === ($points[5]->points + 1) &&
    $points[2]->colour === $points[3]->colour && $points[3]->colour === $points[4]->colour &&
    $points[4]->colour === $points[5]->colour && $points[5]->colour === $points[6]->colour) {
        $total_points = checkStraightFlushCards($colour, $points);
        return $total_points;
    }

    // Four of a kind
    if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points &&
    $points[2]->points === $points[3]->points || 
    $points[1]->points === $points[2]->points && $points[2]->points === $points[3]->points &&
    $points[3]->points === $points[4]->points ||
    $points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points &&
    $points[4]->points === $points[5]->points ||
    $points[3]->points === $points[4]->points && $points[4]->points === $points[5]->points &&
    $points[5]->points === $points[6]->points) {
        $total_points = checkFourOfAKindCards($colour, $points);
        return $total_points;
    }

    // Full house
    if ($points[0]->points === $points[1]->points && $points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points ||
    $points[0]->points === $points[1]->points && $points[3]->points === $points[4]->points && $points[4]->points === $points[5]->points ||
    $points[0]->points === $points[1]->points && $points[4]->points === $points[5]->points && $points[5]->points === $points[6]->points ||
    $points[1]->points === $points[2]->points && $points[3]->points === $points[4]->points && $points[4]->points === $points[5]->points ||
    $points[1]->points === $points[2]->points && $points[4]->points === $points[5]->points && $points[5]->points === $points[6]->points ||
    $points[2]->points === $points[3]->points && $points[4]->points === $points[5]->points && $points[5]->points === $points[6]->points ||
    $points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points && $points[3]->points === $points[4]->points ||
    $points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points && $points[4]->points === $points[5]->points ||
    $points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points && $points[5]->points === $points[6]->points ||
    $points[1]->points === $points[2]->points && $points[2]->points === $points[3]->points && $points[4]->points === $points[5]->points ||
    $points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points && $points[5]->points === $points[6]->points) {
        $total_points = checkFullHouseCards($colour, $points);
        return $total_points;
    }

    // Flush
    if ($colour[0]->colour === $colour[4]->colour || $colour[1]->colour === $colour[5]->colour ||
    $colour[2]->colour === $colour[6]->colour) {
        $total_points = checkFlushCards($colour, $points);
        return $total_points;
    }

    // Straight
    if ($points[1]->points === ($points[0]->points + 1) && $points[2]->points === ($points[1]->points + 1) &&
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) || 
    $points[2]->points === ($points[1]->points + 1) && $points[3]->points === ($points[2]->points + 1) &&
    $points[4]->points === ($points[3]->points + 1) && $points[5]->points === ($points[4]->points + 1) || 
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) &&
    $points[5]->points === ($points[4]->points + 1) && $points[6]->points === ($points[5]->points + 1)) {
        $total_points = checkStraightCards($colour, $points);
        return $total_points;
    }

    // Three of a kind
    if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points || 
    $points[1]->points === $points[2]->points && $points[2]->points === $points[3]->points ||
    $points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points ||
    $points[3]->points === $points[4]->points && $points[4]->points === $points[5]->points ||
    $points[4]->points === $points[5]->points && $points[5]->points === $points[6]->points) {
        $total_points = checkThreeOfAKindCards($colour, $points);
        return $total_points;
    }

    // Two pairs
    if ($points[0]->points === $points[1]->points && $points[2]->points === $points[3]->points ||
    $points[0]->points === $points[1]->points && $points[3]->points === $points[4]->points ||
    $points[0]->points === $points[1]->points && $points[4]->points === $points[5]->points ||
    $points[0]->points === $points[1]->points && $points[5]->points === $points[6]->points ||
    $points[1]->points === $points[2]->points && $points[3]->points === $points[4]->points ||
    $points[1]->points === $points[2]->points && $points[4]->points === $points[5]->points ||
    $points[1]->points === $points[2]->points && $points[5]->points === $points[6]->points ||
    $points[2]->points === $points[3]->points && $points[4]->points === $points[5]->points ||
    $points[2]->points === $points[3]->points && $points[5]->points === $points[6]->points ||
    $points[3]->points === $points[4]->points && $points[5]->points === $points[6]->points) {
        $total_points = checkTwoPairsCards($colour, $points);
        return $total_points;
    }

    // Pair
    if ($points[0]->points === $points[1]->points || $points[1]->points === $points[2]->points || 
    $points[2]->points === $points[3]->points || $points[3]->points === $points[4]->points || 
    $points[4]->points === $points[5]->points || $points[5]->points === $points[6]->points) {
        $total_points = checkPairCards($colour, $points);
        return $total_points;
    }

    // Nothing
    $card_points = 0;
    foreach ($points as $card) {
        $card_points += $card->points;
    }

    return $card_points;
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkStraightFlushCards(
    array $colour,
    array $points
): int {
    if ($points[1]->points === ($points[0]->points + 1) && $points[2]->points === ($points[1]->points + 1) &&
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) &&
    $points[0]->colour === $points[1]->colour && $points[1]->colour === $points[2]->colour &&
    $points[2]->colour === $points[3]->colour && $points[3]->colour === $points[4]->colour) {
        return 900 + $points[0]->points + $points[1]->points  + $points[2]->points + $points[3]->points + $points[4]->points;
    } else if ($points[2]->points === ($points[1]->points + 1) && $points[3]->points === ($points[2]->points + 1) &&
    $points[4]->points === ($points[3]->points + 1) && $points[5]->points === ($points[4]->points + 1) &&
    $points[1]->colour === $points[2]->colour && $points[2]->colour === $points[3]->colour &&
    $points[3]->colour === $points[4]->colour && $points[4]->colour === $points[5]->colour) {
        return 900 + $points[1]->points + $points[2]->points  + $points[3]->points + $points[4]->points + $points[5]->points;
    } else if ($points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) &&
    $points[5]->points === ($points[4]->points + 1) && $points[6]->points === ($points[5]->points + 1) &&
    $points[2]->colour === $points[3]->colour && $points[3]->colour === $points[4]->colour &&
    $points[4]->colour === $points[5]->colour && $points[5]->colour === $points[6]->colour) {
        return 900 + $points[2]->points + $points[3]->points  + $points[4]->points + $points[5]->points + $points[6]->points;
    }
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkFourOfAKindCards(
    array $colour,
    array $points
): int {
    if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points &&
    $points[2]->points === $points[3]->points) {
        return 800 + $points[0]->points + $points[1]->points  + $points[2]->points + $points[3]->points;
    } else if ($points[1]->points === $points[2]->points && $points[2]->points === $points[3]->points &&
    $points[3]->points === $points[4]->points) {
        return 800 + $points[1]->points + $points[2]->points  + $points[3]->points + $points[4]->points;
    } else if ($points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points &&
    $points[4]->points === $points[5]->points) {
        return 800 + $points[2]->points + $points[3]->points  + $points[4]->points + $points[5]->points;
    } else if ($points[3]->points === $points[4]->points && $points[4]->points === $points[5]->points &&
    $points[5]->points === $points[6]->points) {
        return 800 + $points[3]->points + $points[4]->points  + $points[5]->points + $points[6]->points;
    }
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkFullHouseCards(
    array $colour,
    array $points
): int {
    if ($points[0]->points === $points[1]->points && $points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points) {
        return 700 + $points[0]->points + $points[1]->points  + $points[2]->points + $points[3]->points  + $points[4]->points;
    } else if ($points[0]->points === $points[1]->points && $points[3]->points === $points[4]->points && $points[4]->points === $points[5]->points) {
        return 700 + $points[0]->points + $points[1]->points  + $points[3]->points + $points[4]->points  + $points[5]->points;
    } else if ($points[0]->points === $points[1]->points && $points[4]->points === $points[5]->points && $points[5]->points === $points[6]->points) {
        return 700 + $points[0]->points + $points[1]->points  + $points[4]->points + $points[5]->points  + $points[6]->points;
    } else if ($points[1]->points === $points[2]->points && $points[3]->points === $points[4]->points && $points[4]->points === $points[5]->points) {
        return 700 + $points[1]->points + $points[2]->points  + $points[3]->points + $points[4]->points  + $points[5]->points;
    } else if ($points[1]->points === $points[2]->points && $points[4]->points === $points[5]->points && $points[5]->points === $points[6]->points) {
        return 700 + $points[1]->points + $points[2]->points  + $points[4]->points + $points[5]->points  + $points[6]->points;
    } else if ($points[2]->points === $points[3]->points && $points[4]->points === $points[5]->points && $points[5]->points === $points[6]->points) {
        return 700 + $points[2]->points + $points[3]->points  + $points[4]->points + $points[5]->points  + $points[6]->points;
    } else if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points && $points[3]->points === $points[4]->points) {
        return 700 + $points[0]->points + $points[1]->points  + $points[2]->points + $points[3]->points  + $points[4]->points;
    } else if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points && $points[4]->points === $points[5]->points) {
        return 700 + $points[0]->points + $points[1]->points  + $points[2]->points + $points[4]->points  + $points[5]->points;
    } else if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points && $points[5]->points === $points[6]->points) {
        return 700 + $points[0]->points + $points[1]->points  + $points[2]->points + $points[5]->points  + $points[6]->points;
    } else if ($points[1]->points === $points[2]->points && $points[2]->points === $points[3]->points && $points[4]->points === $points[5]->points) {
        return 700 + $points[1]->points + $points[2]->points  + $points[3]->points + $points[4]->points  + $points[5]->points;
    } else if ($points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points && $points[5]->points === $points[6]->points) {
        return 700 + $points[2]->points + $points[3]->points  + $points[4]->points + $points[5]->points  + $points[6]->points;
    }
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkFlushCards(
    array $colour,
    array $points
): int {
    if ($colour[0]->colour === $colour[4]->colour) {
        return 600 + $points[0]->points + $points[1]->points  + $points[2]->points + $points[3]->points  + $points[4]->points;
    } else if ($colour[1]->colour === $colour[5]->colour) {
        return 600 + $points[1]->points + $points[2]->points  + $points[3]->points + $points[4]->points  + $points[5]->points;
    } else if ($colour[2]->colour === $colour[6]->colour) {
        return 600 + $points[2]->points + $points[3]->points  + $points[4]->points + $points[5]->points  + $points[6]->points;
    }
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkStraightCards(
    array $colour,
    array $points
): int {
    if ($points[1]->points === ($points[0]->points + 1) && $points[2]->points === ($points[1]->points + 1) &&
    $points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1)) {
        return 500 + $points[0]->points + $points[1]->points  + $points[2]->points + $points[3]->points  + $points[4]->points;
    } else if ($points[2]->points === ($points[1]->points + 1) && $points[3]->points === ($points[2]->points + 1) &&
    $points[4]->points === ($points[3]->points + 1) && $points[5]->points === ($points[4]->points + 1)) {
        return 500 + $points[1]->points + $points[2]->points  + $points[3]->points + $points[4]->points  + $points[5]->points;
    } else if ($points[3]->points === ($points[2]->points + 1) && $points[4]->points === ($points[3]->points + 1) &&
    $points[5]->points === ($points[4]->points + 1) && $points[6]->points === ($points[5]->points + 1)) {
        return 500 + $points[2]->points + $points[3]->points  + $points[4]->points + $points[5]->points  + $points[6]->points;
    }
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkThreeOfAKindCards(
    array $colour,
    array $points
): int {
    if ($points[0]->points === $points[1]->points && $points[1]->points === $points[2]->points) {
        return 400 + $points[0]->points + $points[1]->points  + $points[2]->points;
    } else if ($points[1]->points === $points[2]->points && $points[2]->points === $points[3]->points) {
        return 400 + $points[1]->points + $points[2]->points  + $points[3]->points;
    } else if ($points[2]->points === $points[3]->points && $points[3]->points === $points[4]->points) {
        return 400 + $points[2]->points + $points[3]->points  + $points[4]->points;
    } else if ($points[3]->points === $points[4]->points && $points[4]->points === $points[5]->points) {
        return 400 + $points[3]->points + $points[4]->points  + $points[5]->points;
    } else if ($points[4]->points === $points[5]->points && $points[5]->points === $points[6]->points) {
        return 400 + $points[4]->points + $points[5]->points  + $points[6]->points;
    }
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkTwoPairsCards(
    array $colour,
    array $points
): int {
    if ($points[0]->points === $points[1]->points && $points[2]->points === $points[3]->points) {
        return 300 + $points[0]->points + $points[1]->points + $points[2]->points + $points[3]->points;
    } else if ($points[0]->points === $points[1]->points && $points[3]->points === $points[4]->points) {
        return 300 + $points[0]->points + $points[1]->points + $points[3]->points + $points[4]->points;
    } else if ($points[0]->points === $points[1]->points && $points[4]->points === $points[5]->points) {
        return 300 + $points[0]->points + $points[1]->points + $points[4]->points + $points[5]->points;
    } else if ($points[0]->points === $points[1]->points && $points[5]->points === $points[6]->points) {
        return 300 + $points[0]->points + $points[1]->points + $points[5]->points + $points[6]->points;
    } else if ($points[1]->points === $points[2]->points && $points[3]->points === $points[4]->points) {
        return 300 + $points[1]->points + $points[2]->points + $points[3]->points + $points[4]->points;
    } else if ($points[1]->points === $points[2]->points && $points[4]->points === $points[5]->points) {
        return 300 + $points[1]->points + $points[2]->points + $points[4]->points + $points[5]->points;
    } else if ($points[1]->points === $points[2]->points && $points[5]->points === $points[6]->points) {
        return 300 + $points[1]->points + $points[2]->points + $points[5]->points + $points[6]->points;
    } else if ($points[2]->points === $points[3]->points && $points[4]->points === $points[5]->points) {
        return 300 + $points[2]->points + $points[3]->points + $points[4]->points + $points[5]->points;
    } else if ($points[2]->points === $points[3]->points && $points[5]->points === $points[6]->points) {
        return 300 + $points[2]->points + $points[3]->points + $points[5]->points + $points[6]->points;
    } else if ($points[3]->points === $points[4]->points && $points[5]->points === $points[6]->points) {
        return 300 + $points[3]->points + $points[4]->points + $points[5]->points + $points[6]->points;
    }
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return int
*/
function checkPairCards(
    array $colour,
    array $points
): int {
    if ($points[0]->points === $points[1]->points) {
        return 200 + $points[0]->points + $points[1]->points;
    } else if ($points[1]->points === $points[2]->points) {
        return 200 + $points[1]->points + $points[2]->points;
    } else if ($points[2]->points === $points[3]->points) {
        return 200 + $points[2]->points + $points[3]->points;
    } else if ($points[3]->points === $points[4]->points) {
        return 200 + $points[3]->points + $points[4]->points;
    } else if ($points[4]->points === $points[5]->points) {
        return 200 + $points[4]->points + $points[5]->points;
    } else if ($points[5]->points === $points[6]->points) {
        return 200 + $points[5]->points + $points[6]->points;
    }
}
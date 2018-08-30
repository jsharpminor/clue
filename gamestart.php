<?php
include "conx.php";

$characters = ["Miss Scarlet",
			   "Colonel Mustard",
			   "Mrs. White",
			   "Mr. Green",
			   "Mrs. Peacock",
			   "Professor Plum"];

$weapons    = ["Candlestick",
			   "Knife",
			   "Lead Pipe",
			   "Revolver",
			   "Rope",
			   "Wrench"];

$rooms      = ["Ballroom",
			   "Billiard Room",
			   "Conservatory",
			   "Dining Room",
			   "Hall",
			   "Kitchen",
			   "Library",
			   "Lounge",
			   "Study"];

// Shuffle each of the three card decks.
shuffle($characters);
shuffle($weapons);
shuffle($rooms);

// Choose a card from each deck.
$crimeCharacter = array_pop($characters);
$crimeWeapon    = array_pop($weapons);
$crimeRoom      = array_pop($rooms);

// Combine the decks.
$cards = array_merge($characters, $weapons, $rooms);

// Reshuffle the combined deck.
shuffle($cards);

// How many piles do we make this into?
$numberOfPlayers = filter_input(INPUT_POST, 'numplayers', FILTER_SANITIZE_NUMBER_INT);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);


$data = array();
array_push($data, $numberOfPlayers);
array_push($data, $username);
array_push($data, $password);

// Give each player a storage box for their hand.
$playerCards = array();

//Deal the cards to each player.
$currentPlayer = 0;
while($shuffledCard = array_pop($cards)) {
	$playerCards[$currentPlayer][] = $shuffledCard;
	$currentPlayer++;
	if($currentPlayer == $numberOfPlayers) {
		$currentPlayer = 0;
	}
}

$currentPlayer = 1;
$maxCards = 6;

// Iterate through the cards a second time to build the query.
// We could probably optimize this into only iterating once.
for($i = 0; $i < 6; $i++) {
	$currentCard = 1;
	if($currentPlayer == 4) {
		$maxCards = 4;
	} else if ($currentPlayer > 4) {
		$maxCards = 3;
	}
	for($j = 0; $j < $maxCards; $j++) {
		$sqlFieldName = "Player" . $currentPlayer . "Card" . $currentCard;
		if(isset($playerCards[$i][$j])) {
			array_push($data, $playerCards[$i][$j]);
		} else {
			array_push($data, "");
		}
		$currentCard++;
	}
	$currentPlayer++;
}

array_push($data, $crimeCharacter);
array_push($data, $crimeWeapon);
array_push($data, $crimeRoom);


try {
	$query = $pdo->prepare("INSERT INTO Games (`GameNumberOfPlayers`,
	`Player1Name`,`Player1Passcode`,
	`Player1Card1`,`Player1Card2`,`Player1Card3`,`Player1Card4`,`Player1Card5`,`Player1Card6`,
	`Player2Card1`,`Player2Card2`,`Player2Card3`,`Player2Card4`,`Player2Card5`,`Player2Card6`,
	`Player3Card1`,`Player3Card2`,`Player3Card3`,`Player3Card4`,`Player3Card5`,`Player3Card6`,
	`Player4Card1`,`Player4Card2`,`Player4Card3`,`Player4Card4`,
	`Player5Card1`,`Player5Card2`,`Player5Card3`,
	`Player6Card1`,`Player6Card2`,`Player6Card3`,
	`GameAnswerSuspect`,`GameAnswerWeapon`,`GameAnswerRoom`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$query->execute($data);
} catch (PDOexception $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}
$gameId = $pdo->lastInsertId();
echo ('Game ' . $gameId . ' created.')?>
<form action="game.php?gameId=<?php echo($gameId); ?>" method="post">
	<input type="hidden" name="username" value="<?php echo($username); ?>">
	<input type="hidden" name="password" value="<?php echo($password); ?>">
	<input type="submit" value="Let's Go!">
</form>

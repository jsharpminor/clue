<?php
include "conx.php";

$gameId   = filter_input(INPUT_POST, 'gameNumber', FILTER_SANITIZE_NUMBER_INT);
$username = filter_input(INPUT_POST, 'username',   FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password',   FILTER_SANITIZE_STRING);

$data[] = $gameId;

$query = $pdo->prepare('SELECT * FROM Games WHERE GameId=?');
$query->execute($data);
$data = $query->fetch();

$numberOfPlayers = $data['GameNumberOfPlayers'];
//print_r($data);

$activePlayers = 0;
$playerNames = array();

if(is_null($data['Player2Name']))							   $query = $pdo->prepare("UPDATE Games SET Player2Name = ?, Player2Passcode = ? WHERE GameID = ?");
else if(is_null($data['Player3Name']))						   $query = $pdo->prepare("UPDATE Games SET Player3Name = ?, Player3Passcode = ? WHERE GameID = ?");
else if(is_null($data['Player4Name']) && $numberOfPlayers > 3) $query = $pdo->prepare("UPDATE Games SET Player4Name = ?, Player4Passcode = ? WHERE GameID = ?");
else if(is_null($data['Player5Name']) && $numberOfPlayers > 4) $query = $pdo->prepare("UPDATE Games SET Player5Name = ?, Player5Passcode = ? WHERE GameID = ?");
else if(is_null($data['Player6Name']) && $numberOfPlayers > 5) $query = $pdo->prepare("UPDATE Games SET Player6Name = ?, Player6Passcode = ? WHERE GameID = ?");
else {
	echo "Unable to join Game " . $gameId;
	die();
} 
$data = array();
$data[0] = $username;
$data[1] = $password;
$data[2] = $gameId;
try {
	$query->execute($data);
} catch (PDOexception $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}

echo ('Successfully joined game ' . $gameId . '.')?>
<form action="game.php?gameId=<?php echo($gameId); ?>" method="post">
	<input type="hidden" name="username" value="<?php echo($username); ?>">
	<input type="hidden" name="password" value="<?php echo($password); ?>">
	<input type="submit" value="Let's Go!">
</form>

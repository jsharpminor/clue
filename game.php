<?php
include "conx.php";


// Get the GameID from either GET or POST.
$gameId[]  = filter_input(INPUT_GET,  'gameId',   FILTER_SANITIZE_NUMBER_INT);
if(is_null($gameId[0])) {
	$gameId[0] = filter_input(INPUT_POST,  'gameId',   FILTER_SANITIZE_NUMBER_INT);
}
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
//echo ($username . $password);
$query = $pdo->prepare('SELECT * FROM Games WHERE GameId=?');
$query->execute($gameId);
$data = $query->fetch();

$numberOfPlayers = $data['GameNumberOfPlayers'];
//print_r($data);

$activePlayers = 0;
$playerNames = array();

if(!is_null($data['Player1Name'])) array_push($playerNames, $data['Player1Name']);
if(!is_null($data['Player2Name'])) array_push($playerNames, $data['Player2Name']);
if(!is_null($data['Player3Name'])) array_push($playerNames, $data['Player3Name']);
if(!is_null($data['Player4Name'])) array_push($playerNames, $data['Player4Name']);
if(!is_null($data['Player5Name'])) array_push($playerNames, $data['Player5Name']);
if(!is_null($data['Player6Name'])) array_push($playerNames, $data['Player6Name']);

if(!is_null($username) && !is_null($password) && $data['Player1Name'] == $username && $data['Player1Passcode'] == $password) {
	$playerCards[0] = $data['Player1Card1'];
	$playerCards[1] = $data['Player1Card2'];
	$playerCards[2] = $data['Player1Card3'];
	$playerCards[3] = $data['Player1Card4'];
	$playerCards[4] = $data['Player1Card5'];
	$playerCards[5] = $data['Player1Card6'];
} else if(!is_null($username) && !is_null($password) && $data['Player2Name'] == $username && $data['Player2Passcode'] == $password) {
	$playerCards[0] = $data['Player2Card1'];
	$playerCards[1] = $data['Player2Card2'];
	$playerCards[2] = $data['Player2Card3'];
	$playerCards[3] = $data['Player2Card4'];
	$playerCards[4] = $data['Player2Card5'];
	$playerCards[5] = $data['Player2Card6'];
} else if(!is_null($username) && !is_null($password) && $data['Player3Name'] == $username && $data['Player3Passcode'] == $password) {
	$playerCards[0] = $data['Player3Card1'];
	$playerCards[1] = $data['Player3Card2'];
	$playerCards[2] = $data['Player3Card3'];
	$playerCards[3] = $data['Player3Card4'];
	$playerCards[4] = $data['Player3Card5'];
	$playerCards[5] = $data['Player3Card6'];
} else if(!is_null($username) && !is_null($password) && $data['Player4Name'] == $username && $data['Player4Passcode'] == $password) {
	$playerCards[0] = $data['Player4Card1'];
	$playerCards[1] = $data['Player4Card2'];
	$playerCards[2] = $data['Player4Card3'];
	$playerCards[3] = $data['Player4Card4'];
} else if(!is_null($username) && !is_null($password) && $data['Player5Name'] == $username && $data['Player5Passcode'] == $password) {
	$playerCards[0] = $data['Player5Card1'];
	$playerCards[1] = $data['Player5Card2'];
	$playerCards[2] = $data['Player5Card3'];
} else if(!is_null($username) && !is_null($password) && $data['Player6Name'] == $username && $data['Player6Passcode'] == $password) {
	$playerCards[0] = $data['Player6Card1'];
	$playerCards[1] = $data['Player6Card2'];
	$playerCards[2] = $data['Player6Card3'];
} else {
	echo "Access denied, no valid username and passcode specified. <a href=\"rejoin.php\">Click here to try again.</a><br />
Username attempted was " . $username . "; passcode was " . $password . " for game " . $gameId[0];

	die();
} 

echo("Game " . $gameId[0] . ". " . $numberOfPlayers . " players:<br />
<ul>");


foreach($playerNames as $thisPlayerName) {
	echo "
	<li>" . $thisPlayerName . "</li>";
	$activePlayers++;
}
if($activePlayers < $numberOfPlayers) {
	echo "
	<li>Waiting for more players to join...</li>";
}
echo ("
</ul>");
if($activePlayers >= $numberOfPlayers &&
	is_null($data['GameAnswerTattler'])) {
	echo "All players joined. Game in progress!";
} else if(!is_null($data['GameAnswerTattler'])) {
	echo $data['GameAnswerTattler'] . " opened the Confidential file!";

}
echo("<br />
" . $username . "'s cards:
<ul>
");

foreach($playerCards as $myCard){
	echo("<li>" . $myCard . "</li>
");
}
echo ("</ul>")
//echo("<br /><br />" . $crimeCharacter . ", in the " . $crimeRoom . ", with the " . $crimeWeapon);
?>

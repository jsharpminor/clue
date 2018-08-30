<!DOCTYPE html>
<html>
<head>
	<title></title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<form action="attemptjoin.php" method="post">
	<table>
		<tr>
			<td>Game number:</td>
			<td><input type="text" name="gameNumber" required="true"></td>
		</tr>
		<tr>
			<td>Name:</td>
			<td><input type="text" name="username" required="true" placeholder="Your name."></td>
		</tr>
		<tr>
			<td>Passcode:</td>
			<td><input type="text" name="password" required="true" placeholder="Choose a password to protect your game data from your opponents."></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Join Game"></td>
		</tr>
	</table>
</form>
</body>
</html>
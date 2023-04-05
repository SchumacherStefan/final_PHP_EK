<?php
/*
* By Stefan Schumacher
*/

session_start();
if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit;
}

require_once("dbConnection.php");

$stmt = $mysql->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$userInhalt = $stmt->fetch();
$profstmt = $mysql->prepare("SELECT * FROM profiles WHERE user_id = ?");
$profstmt->execute([$_SESSION['uId']]);
$profileInhalt = $profstmt->fetch();
?>

<?php include ('./template/header.php');?>

<title>Hauptseite</title>
</head>
<?php include ('./template/navbarUserMainPage.php');
$name = $_SESSION["username"];
?>
   
<body>
<div class="container">
<hr>
<?php echo "<h1>Willkommen auf deiner Seite $name !</h1>"; ?>
<hr>
<br>
<?php 
$profcount = $profstmt->rowCount();
if ($profcount != 1)
{
    echo "<p>Dein Profil ist leer. <br> Du bearbeitest es <a href='profil.php'>hier</a>!</p>";
    exit;

}
?>

<h3> Bitte wählen Sie: </h3>
<br>
<h2>Deine Profildaten lauten:</h2>
<hr>
<?php 
echo ('<p>Vorname: ' . $profileInhalt["first_name"] . '</p>');
echo ('<p>Nachname: ' . $profileInhalt["last_name"] . '</p>');
echo ('<p>Geboren am: ' . $profileInhalt["birth_date"] . '</p>'); 
echo ('<p>Picture: ' . $profileInhalt["picture_path"] . '</p>');
echo ('<p>email: ' . $userInhalt["email"] . '</p>');
?>

<br><br>
<p>Dein Profil bearbeitest du <a href="profil.php">hier</a>!</p>
<br><br>
<hr>		
<p>Hier gehts <a href="logout.php">raus</a> !</p>
<br>
</div>
<?php include ('./template/footer.php');?>
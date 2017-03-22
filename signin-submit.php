<?php
session_start();
$email=$_POST["email"];
$pword=$_POST["password"];
$host='127.0.0.1';
$db='demo';
$user='demo1';
$pass='DEMO';
$charset='utf8';

$dsn="mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,

    PDO::ATTR_EMULATE_PREPARES   => false,
];
$db= new PDO($dsn, $user, $pass, $opt);
//below we get the stored hash for the email that the user entered
$stmt=$db->prepare("select * from user_master where email = :email ;");
$stmt->execute(['email'=>$email]);
$result=$stmt->fetch();
$hash=$result->hash;//the has is to confirm the password is correct
$uid=$result->uid;//the uid is for quick user identification in scripts on other pages

if (password_verify($pword,$hash)){//here we do the actuall verification. 
    $_SESSION['userID']=$uid;//we only store the uid in the session if the pword is correct
    header('Location: http://demo.com/account.php');
}
else{
    echo "log in FAILED";
}
    
?>

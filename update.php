<?php
session_start();
if(isset($_SESSION['userID'])){
    $uid=$_SESSION['userID'];
}

$sdata=$_POST;
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
$pdo= new PDO($dsn, $user, $pass, $opt);

$fname=$_POST["fname"];//here i get the info from signup.php
$lname=$_POST["lname"];
$email=$_POST["email"];
$pnum=$_POST["phonenum"];
$cname=$_POST["business"];
$q=$pdo->prepare("update user_master set email=:email, name_first=:fname, name_last=:lname, phone_num=:phonenum, comp_name=:cname where uid=:uid;");
$q->execute(['email'=>$email, 'fname'=>$fname, 'lname'=>$lname, 'phonenum'=>$pnum, 'cname'=>$cname,'uid'=>$uid]);
    echo '<script>
alert("Your Information has Been Updated.");
window.location.href="account.php"; 

</script>';




?>

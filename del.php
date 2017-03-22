<?php
session_start();
if(isset($_SESSION['userID'])){
    $uid=$_SESSION['userID'];
}
else{    header('Location: http://demo.com/login.html');
}

$reservation=$_POST["resid"];
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
$q=$pdo->prepare("delete from reservations where res_id =:res and uid=:uid;");
$q->execute(['res'=>$reservation, 'uid'=>$uid]);

    echo '<script>
alert("Reservation Deleted");
window.location.href="account.php"; 

</script>';


?>

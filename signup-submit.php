<?php
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
$pword=$_POST["password"];
$hash= password_hash($pword,PASSWORD_DEFAULT);//this is to generate the hash for secure password storage. Native php API uses blowfish and secure salting
$q=$pdo->prepare("select email from user_master where email = :email ;");//this is to check and make sure that the email entered has not been previously registered
$q->execute(['email'=>$email]);
if($euser=$q->fetch(PDO::FETCH_OBJ)){
    echo "this email already esists!!!";//need to create a better error response
    exit();
}


//below is the statement to add the users data into the db. Each user is automatically assigned a unique user id for quick referencing.
$stmt=$pdo->prepare('insert into user_master(email, name_first, name_last, comp_name, phone_num, hash) Values (:email,:fname,:lname,:cname,:pnum,:hash);');
if($stmt->execute(['email'=>$email,'fname'=>$fname,'lname'=>$lname,'cname'=>$cname,'pnum'=>$pnum,'hash'=>$hash])){
    header('Location: http://demo.com/login.html');
}
else{
    echo "Sign up failed. Please try again";
}



?>

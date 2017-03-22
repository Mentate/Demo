<?php
error_reporting(0);

session_start();
if(isset($_SESSION['userID'])){
    $uid=$_SESSION['userID'];
}
else{
    header('Location: http://demo.com/login.html');
}
$date=$_POST["date"];
$start=$_POST["start_time"];
$end=$_POST["end_time"];
$loc=$_POST["loc"];
$type=$_POST["r_type"];
$$start=date('H:i',$start);
$$end=date('H:i',$end);//converting user times to sql format
//connect to db
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
//____________________________________________________


$q1=$pdo->prepare("select rid from master_rooms where r_type=:type and location= :loc;");//get a list of all rooms that fit the user's selected type and location. this will be used to compare against rooms already taken
$q1->execute(['type'=>$type,'loc'=>$loc]);
$allrooms=$q1->fetchall(PDO::FETCH_COLUMN);
$query=$pdo->prepare("select `rid` from `reservations` where `res_date`= :date and `r_type`=:type and ( :stime between `start_time` and `end_time` or :etime between `start_time` and `end_time` or `start_time` between :stime1 and :etime1 or `end_time` between :stime2 and :etime2); ");
$query->bindParam(':stime',$start,PDO::PARAM_STR);
$query->bindParam(':etime',$end,PDO::PARAM_STR);
$query->bindParam(':stime1',$start,PDO::PARAM_STR);//PDO mysql is stupid and wont let you use the same parameter twice in the same statement.
$query->bindParam(':etime1',$end,PDO::PARAM_STR);// so I have to bind them multiple times.
$query->bindParam(':stime2',$start,PDO::PARAM_STR);
$query->bindParam(':etime2',$end,PDO::PARAM_STR);
$query->bindParam(':date',$date,PDO::PARAM_STR);
$query->bindParam('type',$type);
$query->execute();
$res=$query->fetchall(PDO::FETCH_COLUMN);
$availablerooms=array_diff($allrooms,$res);//res is a list of rooms that are NOT available.
$availablerooms=array_values($availablerooms);//reindexs the array so the first value is filled
$msg="";
if (empty($availablerooms)){
    echo '<script>
alert("All rooms at that time and date and type are taken");
window.location.href="account.php"; 

</script>';
    

  
}
else{
    echo '<script> alert("Reservation Complete!"); window.location.href= "account.php";</script>';
}
echo "<br>";
//add the reservation
$rid=$availablerooms[0];
$insert=$pdo->prepare("Insert into reservations(uid,rid,start_time,end_time,location,res_date,r_type) Values (:uid,:rid,:start,:end,:loc,:date,:type);");
$insert->execute(['uid'=>$uid,'rid'=>$rid,'start'=>$start,'loc'=>$loc,'end'=>$end,'date'=>$date,'type'=>$type]);



?>

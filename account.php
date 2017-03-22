//this is the main account page that users see after they log in

<?php
session_start();
if(isset($_SESSION['userID'])){
    $uid=$_SESSION['userID'];
}
else{    header('Location: http://demo.com/login.html');
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
$q=$pdo->prepare("select * from user_master where uid = :uid ;");//this is to check and make sure that the email entered has not been previously registered
$current=date("Y-m-d H:i:s");
$q->execute(['uid'=>$uid]);
$euser=$q->fetch();
$fname=$euser->name_first;
$lname=$euser->name_last;
$comp =$euser->comp_name;
$phn =$euser->phone_num;
$email =$euser->email;
$dte =$euser->date_created;
$q=$pdo->prepare("select res_date, start_time, end_time, res_id from reservations where res_date > :date and uid= :uid;");
$q->bindParam('date',$current,PDO::PARAM_STR);
$q->bindParam('uid',$uid);
$q->execute();
$upcoming=$q->fetchall(PDO::FETCH_ASSOC);
$upstring="<br>";
foreach($upcoming as $row){
$upstring=$upstring."<br>Date: ".$row["res_date"]."  "."<br>Time: ".$row["start_time"]."-".$row["end_time"]."<br>"."Reservation ID:    ".$row["res_id" ]. "<br>___________";
}


?>


<html>

  <head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Booster — A free HTML5 Template by FREEHTML5.CO</title>
        <meta name="viewport"
        content="width=device-width, initial-scale=1">
        <meta name="description" content="Free HTML5 Template by FREEHTML5.CO">
        <meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive">
        <meta name="author" content="FREEHTML5.CO">
    <!-- ////////////////////////////////////////////////////// FREE HTML5
    TEMPLATE DESIGNED & DEVELOPED by FREEHTML5.CO Website: http://freehtml5.co/
         Email: info@freehtml5.co Twitter: http://twitter.com/fh5co Facebook: https://www.facebook.com/fh5co
    ////////////////////////////////////////////////////// -->
        <!-- Facebook and Twitter integration -->
        <meta property="og:title" content="">
        <meta property="og:image" content="">
        <meta property="og:url" content="">
        <meta property="og:site_name" content="">
        <meta property="og:description" content="">
        <meta name="twitter:title" content="">
        <meta name="twitter:image" content="">
        <meta name="twitter:url" content="">
        <meta name="twitter:card" content="">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory
        -->
        <link rel="shortcut icon" href="favicon.ico">
        <!-- Google Webfonts -->
        <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,500"
        rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700"
        rel="stylesheet" type="text/css">
        <!-- Animate.css -->
        <link rel="stylesheet" href="css/animate.css">
        <!-- Icomoon Icon Fonts-->
        <link rel="stylesheet" href="css/icomoon.css">
        <!-- Owl Carousel -->
        <link rel="stylesheet" href="css/owl.carousel.min.css">
        <link rel="stylesheet" href="css/owl.theme.default.min.css">
        <!-- Magnific Popup -->
        <link rel="stylesheet" href="css/magnific-popup.css">
        <!-- Theme Style -->
        <link rel="stylesheet" href="css/style.css">
        <!-- Modernizr JS -->
        <script src="js/modernizr-2.6.2.min.js"></script>
        <!-- FOR IE9 below -->
        <!--[if lt IE 9]>
          <script src="js/respond.min.js"></script>
        <![endif]-->
      </head>

      <body>
        <header id="fh5co-header" role="banner">
          <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
              <div class="navbar-header">
                <!-- Mobile Toggle Menu Button -->
                <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle visible-xs-block"
                data-toggle="collapse" data-target="#fh5co-navbar" aria-expanded="false"
                aria-controls="navbar"><i></i></a>
                <a class="navbar-brand" href="index.html">Booster</a>
              </div>
              <div id="fh5co-navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                  <li>
                    <a href="index.html"><span>Home <span class="border"></span></span></a>
                  </li>
                  <li>
                    <a href="login.html">login</a>
                  </li>
                  <li>
                    <a href="signup.html">signup</a>
                  </li>
                  <li class="active">
                    <a href="account.php">account</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </header>
        <!-- END .header -->
        <aside class="fh5co-page-heading">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <h1 class="fh5co-page-heading-lead"><?=$fname?>'s Account
              <br>
              <span class="fh5co-border"></span>
            </h1>
          </div>
        </div>
      </div>
    </aside>
    <div id="fh5co-main">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-push-2">
            <div class="col-md-8 col-md-push-4">
              <h1>Current Reservations</h1>
              <p></p>
              <h4>
                 <?=$upstring?>
                <br>
              </h4>
              <p></p>
              <br>
              <form action="del.php" method="post">
                <div class="form-group">Enter your reservation ID to delete your reservation
                  <br>
                  <input name="resid" id="resid" type="text">
                  <input type="submit" value="DELETE">
                </div>
              </form>
              <br>

              <p>________________________________________________________________________________________________________________</p>
              <h2>Create New Reservation</h2>
              <div class="row">
                <form action="reserve.php" method="post">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name" class="sr-only">Email</label>
                     Date <input name="date" id="name" type="date" class="form-control input-lg">
                    </div>
                    <div class="form-group">
                      <label for="email" class="sr-only">time</label>
                      <select id="loc" class="form-control input-lg" name="loc">
                        <option value="spfd">Springfield</option>
                        <option value="bsn">Branson</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="gender" class="sr-only">Office Type</label>
                      <select class="form-control input-lg" name="r_type">
                        <option>Select Office Type</option>
                        <option value="con">Conference</option>
                        <option value="ste">Suite</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email" class="sr-only">time</label>
                     Start Time <input id="start_time" type="time" class="form-control input-lg"
                      name="start_time">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name" class="sr-only">time</label>
                     End Time <input id="name" type="time" class="form-control input-lg"
                      name="end_time">
                    </div>
                  </div>
                
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="submit" class="btn btn-primary " value="Submit">
                  <input type="reset" class="btn btn-outline  " value="Reset">
                </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-md-pull-9">
            <div class="fh5co-sidebox">
              <h3 class="fh5co-sidebox-lead">Account Information</h3>
              <ul class="fh5co-post">
                <li>
                  Name: <?=$fname?> <?=$lname?>
                </li>
                <li>
                  Company: <?=$comp?>
                </li>
                <li>
                  Email: <?=$email?>
                </li>
                <li>
                 Phone Number: <?=$phn?>
                 </li>
                 <li>
                  Customer Since: <?=$dte?>
                  </li>
              </ul>
               <h3> Update Information</h3>
                       <h4>Enter new information (All fields required)</h4>
                 <form action= update.php method=post>
                First Name: <input type="text" name="fname">
              <br>
              <br>Last Name:&nbsp;&nbsp;
              <input type="text" required="" name="lname">
              <br>
              <br>Company Name:
              <input type="text" required="" name="business">
              <br>
              <br>Email address:
              <input type="emai"required=""  name="email">
              <br>
              <br>Phone number:
              <input type="tel"required=""  name="phonenum">
              <br>
                 <input type="submit"> 
                 </form>
            </div>
           
          </div>
          <div class="fh5co-spacer fh5co-spacer-lg"></div>
          <footer id="fh5co-footer">
            <div class="container">
              <div class="row">
                <div class="col-md-6 col-sm-6">
                  <div class="fh5co-footer-widget">
                    <h2 class="fh5co-footer-logo">Booster</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia
                      and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                      right at the coast of the Semantics, a large language ocean.</p>
                  </div>
                  <div class="fh5co-footer-widget">
                    <ul class="fh5co-social">
                      <li>
                        <a href="#"><i class="icon-facebook"></i></a>
                      </li>
                      <li>
                        <a href="#"><i class="icon-twitter"></i></a>
                      </li>
                      <li>
                        <a href="#"><i class="icon-instagram"></i></a>
                      </li>
                      <li>
                        <a href="#"><i class="icon-linkedin"></i></a>
                      </li>
                      <li>
                        <a href="#"><i class="icon-youtube"></i></a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="col-md-2 col-sm-6">
                  <div class="fh5co-footer-widget top-level">
                    <h4 class="fh5co-footer-lead ">Company</h4>
                    <ul>
                      <li>
                        <a href="#">About</a>
                      </li>
                      <li>
                        <a href="#">Contact</a>
                      </li>
                      <li>
                        <a href="#">News</a>
                      </li>
                      <li>
                        <a href="#">Support</a>
                      </li>
                      <li>
                        <a href="#">Career</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="visible-sm-block clearfix"></div>
                <div class="col-md-2 col-sm-6">
                  <div class="fh5co-footer-widget top-level">
                    <h4 class="fh5co-footer-lead">Features</h4>
                    <ul class="fh5co-list-check">
                      <li>
                        <a href="#">Lorem ipsum dolor.</a>
                      </li>
                      <li>
                        <a href="#">Ipsum mollitia dolore.</a>
                      </li>
                      <li>
                        <a href="#">Eius similique in.</a>
                      </li>
                      <li>
                        <a href="#">Aspernatur similique nesciunt.</a>
                      </li>
                      <li>
                        <a href="#">Laboriosam ad commodi.</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="col-md-2 col-sm-6">
                  <div class="fh5co-footer-widget top-level">
                    <h4 class="fh5co-footer-lead ">Products</h4>
                    <ul class="fh5co-list-check">
                      <li>
                        <a href="#">Lorem ipsum dolor.</a>
                      </li>
                      <li>
                        <a href="#">Ipsum mollitia dolore.</a>
                      </li>
                      <li>
                        <a href="#">Eius similique in.</a>
                      </li>
                      <li>
                        <a href="#">Aspernatur similique nesciunt.</a>
                      </li>
                      <li>
                        <a href="#">Laboriosam ad commodi.</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="row fh5co-row-padded fh5co-copyright">
                <div class="col-md-5">
                  <p>
                    <small>© Booster Free HTML5 Template. All Rights Reserved.
                      <br>Designed by:
                      <a href="http://freehtml5.co/" target="_blank">FREEHTML5.co</a>| Images by:
                      <a href="http://deathtothestockphoto.com/" target="_blank">DeathToTheStockPhoto</a>
                    </small>
                  </p>
                </div>
              </div>
            </div>
          </footer>
          <!-- jQuery -->
          <script src="js/jquery.min.js"></script>
          <!-- jQuery Easing -->
          <script src="js/jquery.easing.1.3.js"></script>
          <!-- Bootstrap -->
          <script src="js/bootstrap.min.js"></script>
          <!-- Owl carousel -->
          <script src="js/owl.carousel.min.js"></script>
          <!-- Waypoints -->
          <script src="js/jquery.waypoints.min.js"></script>
          <!-- Magnific Popup -->
          <script src="js/jquery.magnific-popup.min.js"></script>
          <!-- Main JS -->
          <script src="js/main.js"></script>
        </div>
      </div>
      <div class="col-md-4 col-md-pull-8">
        <div class="fh5co-sidebox">
          <h3 class="fh5co-sidebox-lead">Image List</h3>
          <ul class="fh5co-post">
            <li>
              <a href="#">
                        <div class="fh5co-post-media"><img src="images/slide_1.jpg" alt="FREEHTML5.co Free HTML5 Template"></div>
                        <div class="fh5co-post-blurb">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                        <span class="fh5co-post-meta">Oct. 12, 2015</span>
                        </div>
                        </a>
            </li>
            <li>
              <a href="#">
                        <div class="fh5co-post-media"><img src="images/slide_2.jpg" alt="FREEHTML5.co Free HTML5 Template"></div>
                        <div class="fh5co-post-blurb">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                        <span class="fh5co-post-meta">Oct. 12, 2015</span>
                        </div>
                        </a>
            </li>
            <li>
              <a href="#">
                        <div class="fh5co-post-media"><img src="images/slide_3.jpg" alt="FREEHTML5.co Free HTML5 Template"></div>
                        <div class="fh5co-post-blurb">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                        <span class="fh5co-post-meta">Oct. 12, 2015</span>
                        </div>
                        </a>
            </li>
          </ul>
        </div>
        <div class="fh5co-sidebox">
          <h3 class="fh5co-sidebox-lead">Paragraph</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, temporibus
            vitae. Dolores sequi, animi dolorem. Ullam minima laudantium culpa dolorem,
            nulla doloribus totam obcaecati reprehenderit quasi nam eius autem nihil.</p>
        </div>
        <div class="fh5co-sidebox">
          <h3 class="fh5co-sidebox-lead">Check list</h3>
          <ul class="fh5co-list-check">
            <li>Lorem ipsum dolor sit.</li>
            <li>Nostrum eveniet animi sint.</li>
            <li>Dolore eligendi, porro ipsam.</li>
            <li>Repudiandae voluptate dolorem voluptas.</li>
            <li>Voluptate cupiditate, est laborum?</li>
          </ul>
        </div>
      </div>
      <div class="col-md-4 col-md-pull-8">
        <div class="fh5co-sidebox">
          <h3 class="fh5co-sidebox-lead">Image List</h3>
          <ul class="fh5co-post">
            <li>
              <a href="#">
                        <div class="fh5co-post-media"><img src="images/slide_1.jpg" alt="FREEHTML5.co Free HTML5 Template"></div>
                        <div class="fh5co-post-blurb">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                        <span class="fh5co-post-meta">Oct. 12, 2015</span>
                        </div>
                        </a>
            </li>
            <li>
              <a href="#">
                        <div class="fh5co-post-media"><img src="images/slide_2.jpg" alt="FREEHTML5.co Free HTML5 Template"></div>
                        <div class="fh5co-post-blurb">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                        <span class="fh5co-post-meta">Oct. 12, 2015</span>
                        </div>
                        </a>
            </li>
            <li>
              <a href="#">
                        <div class="fh5co-post-media"><img src="images/slide_3.jpg" alt="FREEHTML5.co Free HTML5 Template"></div>
                        <div class="fh5co-post-blurb">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                        <span class="fh5co-post-meta">Oct. 12, 2015</span>
                        </div>
                        </a>
            </li>
          </ul>
        </div>
        <div class="fh5co-sidebox">
          <h3 class="fh5co-sidebox-lead">Paragraph</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, temporibus
            vitae. Dolores sequi, animi dolorem. Ullam minima laudantium culpa dolorem,
            nulla doloribus totam obcaecati reprehenderit quasi nam eius autem nihil.</p>
        </div>
        <div class="fh5co-sidebox">
          <h3 class="fh5co-sidebox-lead">Check list</h3>
          <ul class="fh5co-list-check">
            <li>Lorem ipsum dolor sit.</li>
            <li>Nostrum eveniet animi sint.</li>
            <li>Dolore eligendi, porro ipsam.</li>
            <li>Repudiandae voluptate dolorem voluptas.</li>
            <li>Voluptate cupiditate, est laborum?</li>
          </ul>
        </div>
      </div>
      <p>Lorem ipsum dolor sit amet, consectetur adipisici elit,
        <br>sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
        <br>Ut enim ad minim veniam, quis nostrud</p>
      <div class="section"></div>
    </div>
  </body>

</html>

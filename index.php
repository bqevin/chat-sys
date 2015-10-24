
<?php
// set error reporting level
if (version_compare(phpversion(), "5.3.0", ">=") == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE);


require_once('inc/db.inc.php');
require_once('inc/login.inc.php');
require_once('inc/ajx_chat.inc.php');

if ($_REQUEST['action'] == 'get_last_messages') {
    $sChatMessages = $GLOBALS['AjaxChat']->getMessages(true);

    require_once('inc/Services_JSON.php');
    $oJson = new Services_JSON();
    echo $oJson->encode(array('messages' => $sChatMessages));
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Chatroom</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

</head>
<body>
  <nav class="blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" class="brand-logo"><i class="material-icons">swap vertical circle</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="#">Unlimited  ChaTR</a></li>
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <li><a href="#"></a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m6">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">person add</i></h2>
            <h5 class="center">Job Bidders</h5>   
          </div>
        </div>

        <div class="col s12 m6">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">assignment</i></h2>
            <h5 class="center">Job Orders</h5>
          </div>
        </div>

        <div class="col s12 m6">
        <br>
        <h5 class="left">Job Bidders:</h5>
        <br><br><br>
    <ul class="collection" id="freelance">
      <li class="collection-item avatar">
      <!-- <i class="material-icons circle green">insert_chart</i> -->
      <img class="material-icons circle green" src="img/3.jpg">
        <span class="title"> Kevin Barasa</span>
       <p>Hobbist, Researcher, Developer</p>
        <a href="#!" class="secondary-content"><i class="material-icons">grade</i>
        </a>
      </li>
      <li class="collection-item avatar">
      <!-- <i class="material-icons circle green">insert_chart</i> -->
      <img class="material-icons circle green" src="img/4.jpg">
        <span class="title"> Boniface Kibicho</span>
       <p>Computer Programmer, System Analyst</p>
        <a href="#!" class="secondary-content"><i class="material-icons">grade</i>
        </a>
      </li>
      <li class="collection-item avatar">
      <!-- <i class="material-icons circle green">insert_chart</i> -->
      <img class="material-icons circle green" src="img/5.jpg">
        <span class="title"> John Mark</span>
       <p>Data Analyst, Researcher, Social Media Guru</p>
        <a href="#!" class="secondary-content"><i class="material-icons">grade</i>
        </a>
      </li>

    </ul>
    	</div>

    	<div class="col s12 m6">
      <?php
        // draw login box
        echo $GLOBALS['oSimpleLoginSystem']->getLoginBox();
      ?>
        <br>
        <h5 class="left">Chat Room:</h5><br><br>
        <?php
        // draw chat messages
        $sChatMessages = $GLOBALS['AjaxChat']->getMessages();
        // draw input form + accept inserted texts
        $sChatInputForm = 'Need login before using';
        if ($GLOBALS['bLoggedIn']) {
            $sChatInputForm = $GLOBALS['AjaxChat']->getInputForm();
            $GLOBALS['AjaxChat']->acceptMessages();
        }
        echo $sChatMessages . $sChatInputForm;
        ?>

    	</div>

   

    </div>

    </div>

  


  

  <footer class="page-footer pink">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">About Unlimited ChaTR</h5>
          <p class="grey-text text-lighten-4">Get to chat with a friend</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Chat a Bidder</h5>
          <ul>
            <li><a class="white-text" href="#!">Connect</a></li>
          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Find Bidders</h5>
          <ul>
            <li><a class="white-text" href="#!">Connect</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Made by <a class="orange-text text-lighten-3" href="mailto:bkevin001@yahoo.com">Kevin Barasa</a>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
  </body>
</html>

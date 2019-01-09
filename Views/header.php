<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="Views/bootstrap/bootstrap.min.css" >

    <title>Switter</title>
    <link href="Views/styles.css" rel="stylesheet"/>
</head>

<body data-spy="scroll" data-target="#navBar" data-offset="150" >

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="?"">Switter</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="?page=timeline">Home</a>
      </li>
      <li class="nav-item">
          <?php
          if( array_key_exists('email',$_SESSION) AND $_SESSION['email'] )
          { ?>
            <a class="nav-link" href="?page=mytweets">My Tweets</a>
          <?php }
          else
          { ?>
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal"
             href="?page=mytweets">My Tweets</a>
          <?php } ?>

      </li>
    </ul>
  </div>
  <div class="form-inline my-2 my-lg-0">
  		<?php if(array_key_exists("email",$_SESSION) AND $_SESSION["email"]){ ?>
  			<button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="window.location.href='?function=logout'" >Logout</button> 		
      <?php } else{ ?>
      <button class="btn btn-outline-success my-2 my-sm-0" type="button" data-toggle="modal"
       data-target="#exampleModal">Login/Signup</button>
   		<?php } ?>
    </div>
</nav>
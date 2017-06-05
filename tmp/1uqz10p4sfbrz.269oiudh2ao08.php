<!DOCTYPE html>
<html>
<head>
  <!--
  * File Name: template_header.inc.html
  * Authors: Timothy Roush & Jeff Pratt
  * Date Created: 5/27/17
  * Assignment: Final Budget App
  * Description:  Template header for every page on the site
  -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="utf-8">
  <title><?= $title ?></title>
  <meta name="description" content="<?= $description ?>" />
  <meta name="author" content="Timothy Roush" />
  <meta name="author" content="Jeff Pratt" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- BOOTSTRAP STYLES -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="/328/budgetapp/css/style.css" />
  <!--[if lt IE 9]>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <?php if ($fontAwesome): ?>
    <!- FONT AWESOME ICONS ->
    <script src="https://use.fontawesome.com/a5cce48296.js"></script>
  <?php endif; ?>
</head>
<body>

<!-- IF USING A NAVIGATION MENU/BAR PLACE HERE FOR ALL PAGES -->
<header>
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?= $BASE ?>">BudgetApp</a>
      </div>
      <div class="collapse navbar-collapse" id="main-nav">
        <ul class="nav navbar-nav">
          <?php if ($userStatus): ?>
            
              <li class="<?= $PATH=='/userHome'?'active':'' ?>"><a href="userHome" title="My Budget Summary">Summary</a></li>
              <li class="<?= $PATH=='/income'?'active':'' ?>"><a href="income" title="Manage Your Income">My Income</a></li>
              <li class="<?= $PATH=='/expense'?'active':'' ?>"><a href="expense" title="Manage Your Expenses">My Expenses</a></li>
              <li class="<?= $PATH=='/budget'?'active':'' ?>"><a href="budget" title="Manage Your Budget">My Budget</a></li>
              <li class="<?= $PATH=='/logout'?'active':'' ?>"><a href="logout" title="Log Out">Log Out</a></li>
            
            <?php else: ?>
              <li class="<?= $PATH=='/'?'active':'' ?>"><a href="<?= $BASE ?>" title="Home">Home</a></li>
              <li class="<?= $PATH=='/about'?'active':'' ?>"><a href="about" title="Learn About This Site">About Us</a></li>
              <li class="<?= $PATH=='/signup'?'active':'' ?>"><a href="signup" title="Register With Us">Sign Up!</a></li>
              <li class="<?= $PATH=='/login'?'active':'' ?>"><a href="login" title="Log In To Your Budget">Log In</a></li>
            
          <?php endif; ?>
          
        </ul>
      </div>
    </div>
  </nav>
</header>
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
  <title>Blogs: <?= $title ?></title>
  <meta name="description" content="<?= 'Blogs: ' . $desc ?>" />
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
                  <!-- UN COMMENT THIS IF FONT AWESOME NEEDED
                  <?php if ($fontAwesome): ?>
                    <!- FONT AWESOME ICONS ->
                    <script src="https://use.fontawesome.com/a5cce48296.js"></script>
                  <?php endif; ?> -->
</head>
<body>

<!-- IF USING A NAVIGATION MENU/BAR PLACE HERE FOR ALL PAGES -->
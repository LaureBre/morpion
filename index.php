<?php
  if (!isset($_SESSION)) { session_start(); }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Morpion</title>
  <link rel="stylesheet" href="css/morpion.css">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
</head>

<body>

  <form method="get">

  <div id="grille">

  <?php

    $grille = array(0, 0, 0, 0, 0, 0, 0, 0, 0);

    $gagne = array(array(0, 1, 2),
                   array(3, 4, 5),
                   array(6, 7, 8),
                   array(0, 3, 6),
                   array(1, 4, 7),
                   array(2, 5, 8),
                   array(0, 4, 8),
                   array(2, 4, 6));

    if (!isset($_SESSION['tour'])) {
      $_SESSION['tour'] = 1;
      $_SESSION['bouton'] = 'rond';
    }
    elseif ($_SESSION['tour']%2 == 0) {
      $joueur = 2;
      $_SESSION['bouton'] = 'rond';
    }
    else {
      $joueur = 1;
      $_SESSION['bouton'] = 'croix';
    }

    if (isset($_GET['case'])) {
      $_SESSION['tour']++;
    }
    // if ($_SESSION['tour'] == 10) {
    //   echo ("<p>Fin de la partie, merci d'avoir joué</p>");
    // }
    if ($_SESSION['tour'] >= 9) {
      unset($_GET);
      unset($_SESSION['coups']);
      $_SESSION['tour'] = 0;
    }

    if (isset($_GET['case'])) {
      $noCase = $_GET['case'];
      unset($_GET);
      if ( (isset($_SESSION['coups'][$noCase])) && ($_SESSION['coups'][$noCase] <> 0) ) {
        unset($_GET);
      }
      else {
        $_SESSION['coups'][$noCase] = $joueur;
      }
    }

    foreach ($grille as $key => $case) {

        echo "<input type='radio' value='". $key. "' name='case'";
        if ( (isset($_SESSION['coups'][$key]) && ($_SESSION['coups'][$key] == 1))
              || ( isset($noCase) && ($noCase == $key) && ($joueur == 1) ) && ($noCase > 0) )
        {
          echo " class='rond' disabled>";
        }
        elseif ( (isset($_SESSION['coups'][$key]) && ($_SESSION['coups'][$key] == 2))
              || ( isset($noCase) && ($noCase == $key) && ($joueur == 2) ) && ($noCase > 0) )
        {
          echo " class='croix' disabled>";
        }
        else {
          echo ">";
        }
      }

   ?>

   </div>

   <div>

     <input type='submit' name='submit' class='<?php

         foreach ($gagne as $key => $value) {
           foreach ($gagne[$key] as $trio) {
             if ($_SESSION['coups'][$trio] == $joueur) {
               $compte++;
             }
             if ($compte == 3) {
               $bravo = true;
             }
           }
           $compte = 0;
         }
         if ($bravo) {
           echo "reset";
         }
         else {
           echo $_SESSION['bouton'];
         }

      ?>' value=''>

      <?php
      if ($bravo) {
        echo "<h1>Le joueur " . $joueur . " a gagné !</h1>";
        unset($_GET);
        unset($_SESSION['coups']);
        $_SESSION['tour'] = 0;
      }
      ?>
   </div>


 </form>

 <script type="text/javascript" src="js/morpion.js">

 </script>

</body>
<html>

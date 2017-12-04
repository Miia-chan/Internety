<a href="blackjack.php?action=wez">Wez karte</a><br>
<a href="blackjack.php?action=pas">Sprasuj</a><br>
<a href="blackjack.php?action=nowagra">Nowa gra</a><br>

<?php
session_start();
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'nowagra')
unset($_SESSION['talia']);
//$_SESSION
if(!isset($_SESSION['talia'])) { //jeżeli nie ma w sesji talii
 $talia = Array('Ap','Ak','At','Ac','2p','2k','2t','2c','3p','3k','3t','3c',
                '4p','4k','4t','4c','5p','5k','5t','5c','6p','6k','6t','6c',
                '7p','7k','7t','7c','8p','8k','8t','8c','9p','9k','9t','9c',
                '1p','1k','1t','1c','jp','jk','jt','jc','qp','qk','qt','qc',
                'kp','kk','kt','kc');
 $_SESSION['talia'] = $talia; //zapisz nowo stworzona talie do sesji
 $rekaGracza = Array();
 $_SESSION['rekaGracza'] = $rekaGracza;
} else {
 $talia = $_SESSION['talia']; //wczytaj talie z sesji
 $rekaGracza = $_SESSION['rekaGracza'];
}
if(isset($_REQUEST['action'])) {
 if($_REQUEST['action'] == 'wez') {
   $wylosowanyIndeks = rand(1,count($talia)) - 1;
   $wylosowanaKarta = $talia[$wylosowanyIndeks];
   //z której tablicy, od którego miejsca, ile elementów
   array_splice($talia, $wylosowanyIndeks, 1);
   array_push($rekaGracza, $wylosowanaKarta);
   if (sumaKart($rekaGracza) > 21) {
     echo "Przerąbałeś <br>";
     exit();
   }
 }
 if($_REQUEST['action'] == 'pas') {
   //prasujemy
   $rekaBanku = Array();
   while(sumaKart($rekaBanku) <= sumaKart($rekaGracza)) {
     $wylosowanyIndeks = rand(1,count($talia)) - 1;
     $wylosowanaKarta = $talia[$wylosowanyIndeks];
     //z której tablicy, od którego miejsca, ile elementów
     array_splice($talia, $wylosowanyIndeks, 1);
     array_push($rekaBanku, $wylosowanaKarta);
   }
   echo 'gracz: '.sumaKart($rekaGracza).' bank: '.sumaKart($rekaBanku).'<br>';
   if (sumaKart($rekaGracza) <= 21 && sumaKart($rekaBanku) < sumaKart($rekaGracza) || sumaKart($rekaBanku) > 21) {
     echo "Wygrałeś <br>";
     exit();
   }
   if (sumaKart($rekaGracza) > 21) {
     echo "Przerąbałeś <br>";
     exit();
   }
   if (sumaKart($rekaGracza) == sumaKart($rekaBanku)) {
     echo "Przerąbałeś <br>";
     exit();
   }
   if (sumaKart($rekaBanku) > sumaKart($rekaGracza) && sumaKart($rekaBanku) < 22) {
    echo "Przerąbałeś <br>";
    exit();
    }
}
}

function sumaKart($reka) {
  $suma = 0;
  foreach ($reka as $karta) {
    switch ($karta[0]) {
      case 'A':
        $suma += 11;
        break;
      case 'K':
        $suma += 4;
        break;
      case '1':
        $suma += 10;
        break;
      default:
        $suma += $karta[0];
        break;
    }
  }
  return $suma;
}


echo 'suma kart: '.sumaKart($rekaGracza).'<br>';
//echo '<pre>';
// var_dump($talia);
var_dump($rekaGracza);


$_SESSION['talia'] = $talia;
$_SESSION['rekaGracza'] = $rekaGracza;
//session_destroy();
 ?>

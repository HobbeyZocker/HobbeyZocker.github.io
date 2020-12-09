<?php
include('header.php');
?>

<div>
TODO
</div>

<div class="page">

<?php
      $mysqli = connectMySQL();
      $deletion = filter_input(INPUT_POST, "delete", FILTER_SANITIZE_NUMBER_INT) ?? -1;
      $tickets = $_SESSION["session_cart"] ?? -1;
      if($deletion !== -1){
          foreach($tickets as $key => $value){
            if($key == $deletion){
              unset($_SESSION["session_cart"][$key]);
              unset($tickets[$key]);
            }
          }

          if(count($_SESSION["session_cart"]) === 0){
            unset($_SESSION["session_cart"]);
            $tickets = -1;
          }
      }



      if($tickets !== -1){
        echo "
        <form method='POST'>
        <table class='ui cart'>
        <thead>
            <tr>
                <th>Bezeichnung</th>
                <th>Anzahl</th>
                <th>Einzelpreis</th>
                <th>Gesamtpreis</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        ";

        foreach($tickets as $id=>$ticket_count){
            echo "
              <tr>
                  <td>".get_flight_string($mysqli, $id)."</td>
                  <td>".$ticket_count."×</td>
                  <td>".number_format(get_ticket_price($mysqli, $id), 2, ",", ".")." &euro;</td>
                  <td>".number_format(($ticket_count*get_ticket_price($mysqli, $id)), 2, ",", ".")." &euro;</td>
                  <td><button type='submit' name='delete' value='$id'>x</button></td>
              </tr>          
            ";
        }

        echo "
        </tbody>
        </table>
        </form>
        ";
      }else{
          echo "Ihr Warenkorb ist leer!";
      }
      ?>



<button class="ui" id="secon" type="button" onclick="window.location.href = 'DataView/showflights.php';">Einkauf fortsetzen</button>
<button class="ui" id="prim" type="button" onclick="window.location.href = 'checkout.php';">ZUR KASSE GEHEN</button>

</div>



<?php
include('footer.php');
?>

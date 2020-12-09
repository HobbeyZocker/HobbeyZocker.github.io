<?php
include('header.php');

if(!(isset($_SESSION["login"]) && $_SESSION["login"] === TRUE)){
    showerror("Sie m&uuml;ssen angemeldet sein um Ticket kaufen zu k&ouml;nnen!", 1, "index.php");
}

$mysqli = connectMySQL();
                

$tickets = $_SESSION["session_cart"];
$fullprice = 0;
$ticketcount = 0;
foreach($tickets as $id=>$count){
    $ticketcount += $count;
    $fullprice += get_ticket_price($mysqli, $id)*$count;
}
$fullprice = number_format($fullprice, 2, ",", ".");
$netto = number_format(($fullprice*0.84), 2, ",", ".");
$mwst = number_format(($fullprice*0.16), 2, ",", ".");

?>
<!--
<div class="arrow-right">Text1</div>
<div class="middle-div">Text2</div>
-->

<div class="page checkout">
    <div class="block">
        <h2>Zahlungsmethode</h2> 
        <div>
            <input type="radio" id="sepa" name="zahlmethode" value="sepa">
            <label for="sepa">SEPA-Überweisung</label><br>
            <input type="radio" id="paypal" name="zahlmethode" value="paypal">
            <label for="paypal">PayPal</label><br>
            <input type="radio" id="togo" name="zahlmethode" value="togo">
            <label for="togo">Bezahlung bei Abholung</label>
        </div>
    </div>

    <div class="block">
        <h2>Rechnungsadresse</h2>        
        <div>
            <?php
                $username = $_SESSION["Username"];
                $result = $mysqli->query("
                    SELECT * FROM account WHERE username = '$username'
                ");
                
                $result = $result->fetch_array(MYSQLI_ASSOC);
                echo "
                    ".$result["first_name"]." ".$result["last_name"]."<br>
                    ".$result["street"]." ".$result["street_number"]."<br>
                    ".$result["postal_code"]." ".$result["city"]."
                ";
            ?>
            
        </div>
    </div>

    <div class="block">
        <h2>Bestellübersicht</h2>
        <div>
            <table class="checkout">    
                <tbody>
                    <?php
                        echo "
                        <tr>
                            <td>Artikel ($ticketcount):</td>
                            <td>$netto &euro;</td>
                        </tr>
                        <tr>
                            <td>MwSt.:</td>
                            <td>$mwst &euro;</td>
                        </tr>
                        </tbody>
                    <tfoot>
                            <tr>
                            <td>Summe:</td>
                            <td>$fullprice &euro;</td>          
                            </tr>"?>                
                </tfoot>
            </table>
        </div>
    </div>

    <div class="hinweis">
        <div>Durch Klicken auf „Jetzt kaufen“ stimmen Sie den Verkaufsbedingungen und der Datenschutzerklärung zu. </div>
    </div>
    
    <button class="ui" id="secon" type="button" onclick="window.location.href = 'cart.php';">Zurück zum Warenkorb</button>
    <button class="ui" id="prim" type="button" onclick="window.location.href = 'https://www.paypal.me/HannesLueer';">JETZT KAUFEN</button>

</div>

<?php
include('footer.php');
?>

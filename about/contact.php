<?php
include('../header.php');
?>
<form method="POST" enctype="multipart/form-data">
    <?php
    echo "<input type='text' placeholder='Vor- und Nachname' name='name' maxlength='20' required";
    if (isset($_SESSION["login"]) && $_SESSION["login"]) {
        echo " value='" . $_SESSION["FName"] . " " . $_SESSION["LName"] . "' readonly";
    }
    echo "/><br>\n";
    echo "<input type='email' placeholder='E-Mail' name='mail' maxlength='40' required";
    if (isset($_SESSION["login"]) && $_SESSION["login"]) {
        echo " value='" . $_SESSION["E-Mail"] . "' readonly";
    }
    echo "/><br>\n";
    ?>
    <input type="text" placeholder="Betreff" name="subject" maxlength="50" required/><br>
    <textarea name="content" autofocus placeholder="Inhalt" required></textarea><br>
    <input id="agb" type="checkbox" required /><label for="agb">Ich habe die <a href="terms.php">AGB</a> und <a href="privacy_policy.php">Datenschutzerkl&auml;rung</a> gelesen und akzeptiere sie.</label>
    <button type="submit">Absenden</button>
</form>
<?php
if (filter_input(INPUT_POST, "content", FILTER_SANITIZE_STRING) && filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL)) {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_STRING);
    $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_STRING);
    $receiver = "inf19b.flight@gmail.com";
    $title = $subject;
    $from = "From:$name";
    $text = "Nutzermail: $mail\r\nNutzername: $name\r\nInhalt: $content";
    $succ = mail($receiver, $title, $text, $from);

    $recSub = "Vielen Dank für Ihre Anfrage!";
    $recContent = "Hallo $name,\r\n\r\n"
            . "vielen Dank für Ihre Anfrage. Unser Team wird sich schnellstmöglich per Mail bei Ihnen melden.\r\n"
            . "Bis dahin bitten wir um Ihre Geduld.\r\n\r\n"
            . "Mit freundlichen Grüßen\r\n\r\n"
            . "Ihr Inf19B HypertextPreprocessor Team\r\n\r\n\r\n"
            . "Kopie Ihrer Nachricht:\r\n"
            . "Betreff: $subject\r\n\r\n"
            . "Inhalt: $content";
    $succRec = mail($mail, $recSub, $recContent, "From:INf19B Hypertext Preprocessor");
    if ($succ && $succRec) {
        echo "<strong class=\"success\">E-Mail mit der Anfrage wurde versandt!</strong>";
    } else {
        echo "<strong class=\"error\">Fehler beim Senden der E-Mail!<br>
        <span>Anmerkung für Herrn Wierbicki: Für diese Funktion ist weitere Konfiguration von nöten! Bitte lesen sie die beiliegende readme.md um den Fehler zu beheben.</span></strong>";
    }
}
include('../footer.php');

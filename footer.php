<?php
if (filter_input(INPUT_POST, "btnCookieOk") === "") {
    setcookie('eu-cookie', '1', time() + 1209600);
} else if (!filter_input(INPUT_COOKIE, "eu-cookie", FILTER_SANITIZE_NUMBER_INT) || filter_input(INPUT_COOKIE, "eu-cookie", FILTER_SANITIZE_NUMBER_INT) != '1') {
    echo '<div class="cookie-banner">
                    <form method="post">
                        Durch Verwendung dieser Webseite stimmen Sie der Cookie-Nutzung zu. 
                        <button class="cookie-banner" type="submit" name="btnCookieOk">Akzeptieren</button>
                    </form>
                </div>';
}
?>    
        </div> <!-- Beginnt im Header --> 
        
        <ul class="footer">
            <li class="footer"><a class="footer" href="/HypertextPreprocessor/about/terms.php">AGBs</a></li>
            <li class="footer"><a class="footer" href="/HypertextPreprocessor/about/privacy_policy.php">Datenschutzerkl&auml;rung</a></li>
            <li class="footer"><a class="footer" href="/HypertextPreprocessor/about/contact.php">Kontakt</a></li>
            <li class="footer"><a class="footer" href="/HypertextPreprocessor/imprint.php">Impressum</a></li>

            <li class="footer rechts"><a class="footer" href="/HypertextPreprocessor/settings.php">Einstellungen</a></li>
        
        <!--    <li class="footer"><a class="footer" href="/HypertextPreprocessor/settings.php">Einstellungen</a></li> -->
        </ul>
        
    </body>
</html>
<?php
$pageContents = ob_get_clean(); // Wipe the buffer

// Replace ---TITLE--- with $pageTitle variable contents, and print the HTML
echo str_replace('---TITLE---', $pageTitle ?? "Fl&uuml;ge", $pageContents);

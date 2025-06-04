<?php

function flexa_widget_shortcode() {
    ob_start();
    ?>
    <div id="flexa-login-register" style="margin-bottom:20px;">
        <h3>Login</h3>
        <input type="text" id="flexa_email" placeholder="Email"><br>
        <input type="password" id="flexa_password" placeholder="Password"><br>
        <button onclick="flexaLogin()">Login</button>
        <p>Oppure registrati:</p>
        <input type="text" id="flexa_reg_email" placeholder="Email"><br>
        <input type="password" id="flexa_reg_password" placeholder="Password"><br>
        <button onclick="flexaRegister()">Registrati</button>
    </div>

    <div id="flexa-user-info" style="display:none; margin-bottom:20px;"></div>

    <div id="flexa-packages">
        <p>Caricamento pacchetti...</p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('flexa_widget', 'flexa_widget_shortcode');

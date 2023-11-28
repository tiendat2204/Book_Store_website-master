<?php 
if (isset($_SESSION['login_message'])) {
    $loginMessage = $_SESSION['login_message'];

    foreach ($loginMessage as $msg) {
        echo '
        <div class="message ' . $msg['type'] . '">
            <span>' . $msg['text'] . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }

    unset($_SESSION['login_message']);
}

if (isset($_SESSION['forgot_password_message'])) {
    $forgotPasswordMessage = $_SESSION['forgot_password_message'];

    foreach ($forgotPasswordMessage as $msg) {
        echo '
        <div class="message ' . $msg['type'] . '">
            <span>' . $msg['text'] . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }

    // Remove the message after displaying it
    unset($_SESSION['forgot_password_message']);
}

?>
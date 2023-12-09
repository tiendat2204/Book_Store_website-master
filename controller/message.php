<?php 
if (isset($_SESSION['messages']) && is_array($_SESSION['messages'])) {
    foreach ($_SESSION['messages'] as $msg) {
        echo '
            <div class="message">
                <span>' . $msg . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
    }
    unset($_SESSION['messages']);
}
?>
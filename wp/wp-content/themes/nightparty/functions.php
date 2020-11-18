<?php
function init_session_start(){
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    $_SESSION['foo'] = 'var'; 
}
add_action('init', 'init_session_start');
?>


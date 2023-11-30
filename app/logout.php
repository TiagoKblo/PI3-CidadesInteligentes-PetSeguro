<?php
session_start(); // Inicie a sessão

// Encerre a sessão
session_unset();
session_destroy();

// Redirecione para a página de login
header("Location: login.html");
exit;
?>

<?php
// Habilitando a visualização dos erros
ini_set("display_errors", true);
error_reporting(E_ALL);

// Definindo o Local
$strLocale = (PHP_OS == "WINNT") ? "ptb" : "pt_BR";
setlocale(LC_ALL, $strLocale);

// Include das classes
require_once("classes/config.classes.php");
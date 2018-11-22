<?php
require "../config.php";
require (ROOT_DIR."/libs/rb.php");

R::setup( 'mysql:host=localhost;dbname=12class',
        'root', '' );

session_start();

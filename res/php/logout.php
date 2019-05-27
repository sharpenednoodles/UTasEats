<?php
//Send php form data here to clear a session and log the user out
session_start();
session_destroy();
header('location: ../../index.php')
 ?>

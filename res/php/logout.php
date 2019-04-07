<?php
//Send php form data here to clear a session
session_start();
session_destroy();
header('location: ../../index.php')
 ?>

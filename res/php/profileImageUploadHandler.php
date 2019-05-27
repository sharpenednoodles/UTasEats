<?php
//Handler to upload new profile images to site
//ALACRTIAS DOES NOT HANDLE FILE UPLOADS DUE TO SECURITY SETTINGS
session_start();
require("../db/dbConn.php");
require("../db/dbQueries.php");

//Handle image uploads


	$file = $_FILES['profileImage'];
	$path = "../../uploads/profileIMG/".$file["name"];
	$absolutePath = "uploads/profileIMG/".$file["name"];
	move_uploaded_file($file["tmp_name"], $path);
	$updateImages = $conn->prepare("UPDATE users set imagePath = ? where ID = ?");
	$updateImages->bind_param("si", $absolutePath, $_SESSION['userNum']);
	$updateImages->execute();
	$updateImages->close();
	header("location: ../../userpage.php")



 ?>

<h1>Profile Update handler</h1>
<h5>Debug: Post Variable Contents</h5>
<p><?php print_r($_POST); ?></p>
<h5>Debug: Session Variable Contents</h5>
<p><?php print_r($_SESSION); ?> </p>

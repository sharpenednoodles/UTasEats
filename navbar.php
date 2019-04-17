<!--Persistent Navbar included via PHP - Dynamically generated depending on access levels-->
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
	<a class="navbar-brand" href='index.php'>
		<img src="res/img/UTasLogoDefault.png" width="30" height="30">UTASEats</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
		<span class="navbar-toggler-icon"></span>
	</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<?php
			//Hide registration button when we are already logged in
			if($_SESSION['loggedIn'] == false)
			{
				echo  <<<LOGIN
				<li class="nav-item">
					<a class="nav-link" href="registration.php">Registration</a>
				</li>
LOGIN;
			}
			 ?>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown">Cafe Menus</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="lazenbys.php">Lazenbys</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="suzylee.php">Suzy Lee</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="tradetable.php">The Trade Table</a>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="test.php">Test Playground</a>
			</li>
			<?php
			//Only include this when logged in with sufficent privledges
			switch((int)$_SESSION['accessLevel'])
			{
				case UserAccessLevel::BoardDirector:
				case UserAccessLevel::BoardMember:
				case UserAccessLevel::CafeManager:
				echo <<<MASTER
				<li class="nav-item LoggedInAdmin" id="navMasterListButton">
					<a class="nav-link" href="masterList.php">Master List</a>
				</li>
MASTER;
			break;

			}
			 ?>
		</ul>
		<?php
		//Display user page link and name when logged in
		if($_SESSION['loggedIn'] == true)
		{
			echo <<<USERNAME
			<div class="loggedIn" id="navLoginButton">
					<a class="nav-link text-light" href="userpage.php">
						<div id="navUsernameDisplay">
USERNAME;
							echo($_SESSION['userID']);
							echo <<<USERNAME
						</div>
					</a>
			</div>
USERNAME;
		}

		if ($_SESSION['loggedIn'] == false)
		{
			//Display the login button when we are not logged in
			echo  <<<LOGIN
			<div class="loggedOut" id="navLoginButton">
			<a href="login.php">
			<button class="btn btn-dark" type="button" name="button">Sign In</button>
			</a>
			</div>
LOGIN;
		}
		else
		{
		echo <<<LOGOUT
		<div class="loggedIn" id="navLogoutButton">
			<form class="" action="res/php/logout.php" method="post">
				<button class="btn btn-dark" type="submit" name="button">Log Out</button>
			</form>
LOGOUT;
		}
		?>
		</div>
</div>
</nav>

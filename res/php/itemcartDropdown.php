<!--Swap this to a PHP include to hide when not logged in -->
<div class="nav-item dropdown">
	<a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" data-toggle="dropdown"><i class="material-icons">shopping_cart</i></a>
	<div class="dropdown-menu dropdown-menu-right">
		<div class="dropdown-item"><b>Account Balance: </b> <?php echo $_SESSION['accountBalance']; ?></div>
		<div class="dropdown-divider"></div>
		<div class="dropdown-item"><b>Lazenbys</b></div>
		<div class="dropdown-item">Lazenbys Sample Item 1 - $4.00</div>
		<div class="dropdown-item">Lazenbys Sample Item 2 - $4.00</div>
		<div class="dropdown-divider"></div>
		<div class="dropdown-item"><b>Suzy Lee</b></div>
		<div class="dropdown-item">Suzy Lee Sample Item 1 - $4.00</div>
		<div class="dropdown-item">Suzy Lee Sample Item 2 - $4.00</div>
		<div class="dropdown-divider"></div>
		<div class="dropdown-item"><b>Trade Table</b></div>
		<div class="dropdown-item">Trade Table Sample Item 1 - $4.00</div>
		<div class="dropdown-item">Trade Table Sample Item 2 - $4.00</div>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="">Total: $24.00</a>
		<div class="dropdown-divider"></div>
		<div class="dropdown-item" id="dropDownCheckOut"><b>Check Out</b></div>
	</div>
</div>

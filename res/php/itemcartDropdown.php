<?php
//Cart dropdown HTML element for the dropdown cart found in the navbar
 ?>
<div class="nav-item dropdown">
	<a class="nav-link dropdown-toggle text-light" href="#" id="cartDropdown" data-toggle="dropdown"><i class="material-icons">shopping_cart</i></a>
	<div class="dropdown-menu dropdown-menu-right">
		<div class="dropdown-item"><b>Account Balance: </b> <?php echo $_SESSION['accountBalance']; ?></div>
		<div class="dropdown-divider"></div>
		<div class="dropdown-item" ><b>Lazenbys</b></div>
		<div id='lazenbysDropdownAnchor'>
			<!--
			<div class="dropdown-item">Lazenbys Sample Item 1 - $4.00</div>
			<div class="dropdown-item">Lazenbys Sample Item 2 - $4.00</div>
			<a class="dropdown-item" href="">Sub Total - $8.00</a>
		-->
		</div>
		<div class="dropdown-divider"></div>
		<div class="dropdown-item" ><b>Suzy Lee</b></div>
		<div id='suzyleeDropdownAnchor'>
			<!--
			<div class="dropdown-item">Suzy Lee Sample Item 1 - $4.00</div>
			<div class="dropdown-item">Suzy Lee Sample Item 2 - $4.00</div>
			<a class="dropdown-item" href="">Sub Total - $8.00</a>
		-->
		</div>
		<div class="dropdown-divider"></div>
		<div class="dropdown-item" ><b>Trade Table</b></div>
		<div id='tradetableDropdownAnchor'>
			<!--
			<div class="dropdown-item">Trade Table Sample Item 1 - $4.00</div>
			<div class="dropdown-item">Trade Table Sample Item 2 - $4.00</div>
			<a class="dropdown-item" href="">Sub Total - $8.00</a>
		-->
		</div>
	</div>
</div>

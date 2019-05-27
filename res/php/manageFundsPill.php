<?php
//HTML snippet for the Add Funds pill found wihtin the user page
 ?>
<h4>Add funds</h4>
<div class="row">
	<div class="col-12">
		<div class="card mb-4 text-center">
			<div class="card-header">Current Balance</div>
			<div class="card-body">
				<p class="card-text"><?php echo $_SESSION['accountBalance']; ?></p>
			</div>
		</div>
	</div>
	<div class="col-sm-12 col-md-4">
		<div class="card mb-4 bg-danger text-white text-center">
			<div class="card-header">Recharge</div>
			<div class="card-body">
				<h5 class="card-text">$1</h5>
				<p class="card-text">Add $1 from your saved credit card</p>
			</div>
			<button amount="1" class="btn btn-danger text-white recharge card-footer">Choose</button>
		</div>
	</div>
	<div class="col-sm-12 col-md-4">
		<div class="card mb-4 bg-warning text-white text-center">
			<div class="card-header">Recharge</div>
			<div class="card-body">
				<h5 class="card-text">$5</h5>
				<p class="card-text">Add $5 from your saved credit card</p>
			</div>
			<button amount="5" class="btn btn-warning text-white card-footer recharge">Choose</button>
		</div>
	</div>
	<div class="col-sm-12 col-md-4">
		<div class="card mb-4 bg-secondary text-white text-center">
			<div class="card-header">Recharge</div>
			<div class="card-body">
				<h5 class="card-text">$10</h5>
				<p class="card-text">Add $10 from your saved credit card</p>
			</div>
			<button amount="10" class="btn btn-secondary text-white card-footer recharge">Choose</button>
		</div>
	</div>
	<div class="col-sm-12 col-md-4">
		<div class="card mb-4 bg-info text-white text-center">
			<div class="card-header">Recharge</div>
			<div class="card-body">
				<h5 class="card-text">$20</h5>
				<p class="card-text">Add $20 from your saved credit card</p>
			</div>
			<button amount="20" class="btn btn-info text-white card-footer recharge">Choose</button>
		</div>
	</div>
	<div class="col-sm-12 col-md-4">
		<div class="card mb-4 bg-primary text-white text-center">
			<div class="card-header">Recharge</div>
			<div class="card-body">
				<h5 class="card-text">$50</h5>
				<p class="card-text">Add $50 from your saved credit card</p>
			</div>
			<button amount="50" class="btn btn-primary text-white card-footer recharge">Choose</button>
		</div>
	</div>
	<div class="col-sm-12 col-md-4">
		<div class="card mb-4 bg-success text-white text-center">
			<div class="card-header">Recharge</div>
			<div class="card-body">
				<h5 class="card-text">$100</h5>
				<p class="card-text">Add $100 from your saved credit card</p>
			</div>
			<button amount="100" class="btn btn-success text-white card-footer recharge">Choose</button>
		</div>
	</div>
</div>
<form lastNum ="<?php echo substr($_SESSION["CCNumber"], -4, 4); ?>" id="addFundsForm" action="res/php/addFundsHandler.php" method="post"></form>

<modalConfirm>
	<div class="modal fade" id="rechargeModal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="rechargeModalTitle">Confirm Purchase</h5>
	        <button type="button" id ="rechargeCrossButton" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div id="rechargeBody"class="modal-body"></div>
	      <div class="modal-footer">
	        <button id="rechargeCancelButton" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	        <button id="rechargeConfirmButton" type="submit" class="btn btn-primary">Confirm</button>
	      </div>
	    </div>
	  </div>
	</div>
</modalConfirm>

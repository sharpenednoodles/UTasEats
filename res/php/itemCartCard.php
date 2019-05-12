<div class="col-sm-12 col-lg-4">
 <div class="card mb-4">
	 <div class="card-body">
			<h5 class="card-title text-center">Item Cart</h5>
			 <div class="table-responsive">
				 <table class="table table-striped table-bordered masterMenu">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Item</th>
							<th scope="col">Quantity</th>
							<th scope="col">Price</th>
						</tr>
					</thead>
					<tbody id="itemCart">
					</tbody>
					<tfoot>
						<tr>
							<th>Total</th>
							<th></th>
							<th id="cartTotal"></th>
						</tr>
					</tfoot>
				 </table>
				 </div>
				 <form class="" action="res/php/orderSubmissionHandler.php" method="post">
					 <div class="form-group">
  					<label for="NotesArea">Order Notes</label>
  					<textarea class="form-control" id="NotesArea" name="OrderNotes" rows="3"></textarea>
  				</div>
					<div class="form-group">
				    <label for="exampleFormControlSelect1">Pick-Up Time</label>
				    <select class="form-control" name="PickUpTime">
				      <?php
							/*
							$interval = new DateInterval('PT15M');
							$period   = new DatePeriod($openTime, $interval, $closeTime);

							foreach ($period as $dt)
							{
								echo "<option>" .$dt->format("l Y-m-d") ."</option>";
							}*/

							for ($i = $openTime; $i <= $closeTime; $i+ 15)
							{
								echo "<option>$openTime</option>";
							}
							 ?>
				    </select>
				  </div>
					<button type="submit" class="btn btn-dark"name="button">Check Out</button>
			</form>
	 </div>
 </div>
</div>

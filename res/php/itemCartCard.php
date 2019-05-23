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
				 <form cafe="<?php echo $cafeID ?>" action="res/php/orderSubmissionHandler.php" method="post" id="orderForm">
					 <div class="form-group">
  					<label for="NotesArea">Order Notes</label>
  					<textarea class="form-control" id="NotesArea" name="OrderNotes" rows="3"></textarea>
  				</div>
					<div class="form-group">
				    <label for="exampleFormControlSelect1">Pick-Up Time</label>
				    <select class="form-control" name="PickUpTime">
				      <?php
							$cafeClosed;
							$timeNow = time();
							//$timeNow = strtotime(date("g:ia", "10:05am"));
							$roundedNow = roundToQuarterHour($timeNow);

							//Convert date to pure time
							$openTime = strtotime($openTime);
							$closeTime = strtotime($closeTime);
							//Temp, for testing once close times are past 4pm IRL
							$closeTime = strtotime("11:55pm");

							if ($timeNow > $closeTime && $timeNow >= $openTime)
							{
								echo"<option>Restaurant Closed</option>";
								$cafeClosed = true;
							}
							else
							{
								//Print the list of collection times
								$increments = ($closeTime - $roundedNow)/ (60*15);
								for ($i = 0; $i <= $increments; $i++)
								{
									//Additional boolean for arbitray time decisions
									echo "<option>".date("g:ia", $roundedNow)."</option>";
									$roundedNow = $roundedNow + (60 * 15);
								}
								//echo "<option>$roundedNow $timeNow $closeTime $increments ".date("g:ia", $roundedNow)."</option>";
							}
							 ?>
				    </select>
				  </div>
					<?php
					if ($cafeClosed != true)
					{
						echo "<button type='button' id='checkOutButton' class='btn btn-dark' name='button'>Check Out</button>";
					}
					 ?>
			</form>
	 </div>
 </div>
</div>

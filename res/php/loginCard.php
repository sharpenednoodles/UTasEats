<div class="col-sm-12 col-md-7">
   <div class="card mb-4">
      <div class="card-body">
         <h5 class="card-title text-center">Login</h5>
         <form action="res/php/loginAuthHandler.php" method="post">
            <div class="form-group">
               <label for="userIDinput">User ID</label>
               <input class="form-control" type="text" name="userID" placeholder="Enter User ID" id="userIDinput">
               <div class="invalid-feedback" id="invalidUserID"></div>
            </div>
            <div class="form-group">
               <label for="userPasswordInput">Password</label>
               <input class="form-control" type="password" name="password" placeholder="Password" id="userPasswordInput">
               <div class="invalid-feedback" id="invalidPassword"></div>
            </div>
            <!--TODO: Remember user details with cookies-->
            <div class="form-group form-check">
               <input type="checkbox" id="rememberCheck" class="form-check-input">
               <label for="rememberCheck" class="form-check-label">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-dark"name="button" id="loginSubmitButton">Login</button>
         </form>
      </div>
   </div>
</div>

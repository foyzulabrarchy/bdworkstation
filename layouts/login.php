<div id="logIn" class="modal container">
  
    <div class="modal-content animate">
        <form  action="backEnds/logInVerify.php" method="POST">
            <span onclick="hideLogin()" class="close" title="Close Log In">&times;</span>
            <h2>Log In</h2>
            <div class="modal-content-inputs">
                <label><b>Mobile Number</b></label>
                <input type="number" placeholder="Enter Number" name="phoneNumber" value="<?php if(isset($_COOKIE["phone_number"])) { echo $_COOKIE["phone_number"]; } ?>" required>

                <label><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" required>
                
                <button class="modalBtn" type="submit" title="Click for Log In">Log In</button>
                <label class="remember">
                    <input type="checkbox" name="remember" checked> Remember me
                </label>
                
                <div class="forgotPass" onclick="forgetReset()">
                  <span>Forgot <a href="#">password?</a></span>
              </div>
            </div>
        </form>

        <div class="modal_content-new container">
            <h6>New To WorkStation?</h6>
            <!-- <button onclick="showSignup()" class="modalBtn">Sign Up</button> -->
            <button onclick="smsLogin()" class="modalBtn">Join</button>
        </div>
    </div>
</div>
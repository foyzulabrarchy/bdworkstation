<div id="logIn" class="modal container">
  
                <form class="modal-content animate" action="/action_page.php">

                    <span onclick="hideLogin()" class="close" title="Close Log In">&times;</span>
                        <h2>Log In</h2>
                    <div class="modal-content-inputs">
                        <label><b>Mobile Number</b></label>
                        <input type="number" placeholder="Enter Number" name="userNumber" required>

                        <label><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="userPassword" required>
                            
                        <button class="modalBtn" type="submit" title="Click for Log In">Log In</button>
                        <label>
                            <input type="checkbox" checked="checked" name="remember"> Remember me
                        </label>
                    
                        <div class="forgotPass">
                          <span>Forgot <a href="#">password?</a></span>
                        </div>
                    </div>
                </form>
        </div>
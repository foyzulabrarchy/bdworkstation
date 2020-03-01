<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div id="signUp" class="modal container">
            <div class="modal-content animate">
                <form action="backEnds/signUp.php" method="POST">

                    <span onclick="hideSignup()" class="close" title="Close Log In">&times;</span>
                        <h2>Sign Up</h2>
                    <div class="modal-content-inputs">
                        <label><b>Full Name</b></label>
                        <input type="text" placeholder="Enter Full Name" name="userName" required>

                        <label><b>Mobile Number</b></label>
                        <input type="number" placeholder="phone number" name="userNumber" required>

                        <label><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="userPassword" required>
                            
                        <button class="modalBtn" type="submit" title="Click for Log In">Get Started</button>
                    </div>

                </form>

                <div class="modal_content-new container">
                    <h6>Already Have An Account?</h6>
                    <button onclick="showLogin()" class="modalBtn">Log In</button>
                </div>
                </div>

        </div>
    
</body>
</html>


<section class="login-up" id="login">
    <div class="screen-overlay"></div>
        <div class="log-container" id="logContainer">
            <div id="resError"></div>
            <div class="form-container sign-up-container">
            
            <?php //Start sign up form?>
                <form action="validateSignup.php" id="signUpForm" method="POST">
                    <h2>Create Account</h2>
                    <div class="social-container">
                        <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                        <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <span class="text-capitalize">or use your email for registration</span>
                    <input type="text" 
                            placeholder="Username" 
                            name="username" 
                            autoComplete="off"
                            required
                            pattern=".{3,}"
                            title="Username Must Contain 6 or more characters"
                             />
                    <input type="text" 
                            placeholder="Email" 
                            name="email"
                            required
                            autoComplete="off"
                             />
                    <input type="password" 
                            placeholder="Password" 
                            name="password"
                            required
                            minlength="6"
                             />
                    <input type="submit" name="signup" value="Sign Up">
                </form>
                <?php //End sign up form?>
            </div>
            <div class="form-container sign-in-container">
            <?php //Start sign in form?>
                <form action="loginRequest.php" method="POST" id="login-req">
                    <h2>Sign in</h2>
                    <div class="social-container">
                        <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                        <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <span>or use your account</span>
                    <input type="text" name="user" placeholder="Username" autoComplete="off" required />
                    <span class="errorLogin"></span>
                    <input type="password" name="pass" placeholder="Password" autoComplete="off" required />
                    <a href="#">Forgot your password?</a>
                    <input type="submit" name="signIn" value="Sign In">
                    <?php //end sign up form?>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h2>Welcome Back!</h2>
                        <p>To keep connected with us please login with your personal info</p>
                        <button id="signIn">Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h2>Hello, Friend!</h2>
                        <p>Enter your personal details and start journey with us</p>
                        <button id="signUp">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="closeLogin"><i class="fas fa-times"></i></div>
</section>

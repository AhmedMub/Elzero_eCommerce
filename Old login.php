<?php 
// this is a fix for Errors like "header already sent" and some header errors as well, But I commented it out because I didn't have these issues
ob_start();
 
session_start();

$pageTitle = "login/signup";

//start LogIn session
if (isset($_SESSION['user'])) {
    header("location:index.php");
}
include "init.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //this is differentiate between the info you are receiving, Is it a signIn or signUp
    if (isset($_POST['signIn'])) {

        //get user info from the request method "post"
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $passSha = sha1($pass);

        //check from the user if it is exists in the DB
        $stmt = $db->prepare("SELECT Username, Password FROM users WHERE Username = ? AND Password = ?");

        $stmt->execute(array($user, $passSha));

        // I don't need fetch method because I wont print any of these data I want only to check the Existences ONLY

        $userCount = $stmt->rowCount();

        // Here I will start record the session, so after I checked that user is exists in the DB, then I will make the session of "user" I wrote above equal the exist user that has been found right above via the query
        if ($userCount > 0) {

            //I only need the username for the web site not like the admin_panel that needs userID
            $_SESSION['user'] = $user;
            header("location:index.php");
            exit();
        }

    } 
}

?>
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
                            title="Username Must Contain 6 or more characters" />
                    <input type="email" 
                            placeholder="Email" 
                            name="email" 
                            required
                            autoComplete="off" />
                    <input type="password" 
                            placeholder="Password" 
                            name="password"
                            required
                            minlength="6"
                            autoComplete="off" />
                    <input type="submit" name="signup" value="Sign Up">
                </form>
                <?php //End sign up form?>
            </div>
            <div class="form-container sign-in-container">
            <?php //Start sign in form?>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                    <h2>Sign in</h2>
                    <div class="social-container">
                        <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                        <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <span>or use your account</span>
                    <input type="text" name="user" placeholder="Username" autoComplete="off" required />
                    <input type="password" name="pass" placeholder="Password" autoComplete="off" required/>
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
</section> 

<?php 

include $templets . "footer.inc.php";

ob_flush(); //this is regarding to the issue explained in top of the page
?>

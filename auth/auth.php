<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/auth.css">

</head>

<body>

    <div class="container" id="container">

        <div class="form-container sign-up">
            <form action="../pages/signup.php" method="post">
                <h1>Create Account</h1>
                <div class="role-selection">
                    <label>
                        <input type="radio" name="role" value="user" checked>
                        <span>User</span>
                    </label>
                    <label>
                        <input type="radio" name="role" value="admin">
                        <span>Admin</span>
                    </label>
                </div>
                <input type="text" name="username" id="username" placeholder="Enter Your Username">
                <input type="email" name="email" id="email" placeholder="Enter Your Email">
                <input type="password" name="password" id="password" placeholder="Enter Your Password">
                <span>or use your email for registration</span>
                <div class="social-icons">
                    <a href="#" class="icon">
                        <i class="fa-brands fa-google"></i>
                    </a>
                    <a href="#" class="icon">
                        <i class="fa-brands fa-apple"></i>
                    </a>
                </div>
                <button>Sign up</button>
                <?php if (isset($_GET['error'])): ?>
                    <div class="error-message">
                        <?php
                        switch ($_GET['error']) {
                            case 'wrong_password':
                                echo 'Incorrect password. Please try again.';
                                break;

                            case 'user_not_found':
                                echo 'Username not found. <br><span class="suggestion">Please check your username or <a href="#" id="goToSignup">create a new account</a>.</span>';
                                break;

                            case 'user_exists':
                                echo 'Username or email already exists.';
                                break;

                            case 'signup_failed':
                                echo 'Account creation failed. Please try again later.';
                                break;

                            case 'missing_fields':
                                echo 'Please fill in all fields.';
                                break;
                        }
                        ?>
                    </div>
                <?php endif; ?>

            </form>
        </div>

        <div class="form-container sign-in">
            <form action="../pages/login.php" method="post">
                <h1>Sign In</h1>
                <div class="role-selection">
                    <label>
                        <input type="radio" name="role" value="user" checked>
                        <span>User</span>
                    </label>
                    <label>
                        <input type="radio" name="role" value="admin">
                        <span>Admin</span>
                    </label>
                </div>
                <input type="text" name="username" id="username" placeholder="Enter Your Username">
                <input type="password" name="password" id="password" placeholder="Enter Your Password">
                <a href="#" class="forget-pass">Forget Your Password?</a>
                <span>or use your email for registration</span>
                <div class="social-icons">
                    <a href="#" class="icon">
                        <i class="fa-brands fa-google"></i>
                    </a>
                    <a href="#" class="icon">
                        <i class="fa-brands fa-apple"></i>
                    </a>
                </div>
                <button>Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>

                <div class="toggle-panel toggle-right">
                    <h1>Hello Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>

            </div>
        </div>
    </div>
    <script src="../assets/js/auth.js?v=2"></script>
</body>

</html>
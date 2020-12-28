<?php

$username_error = '';
$password_error = '';

if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {	
    if ($_POST['username'] == 'admin' && $_POST['password'] == '1234') {
        $_SESSION['logged_in'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = 'Admin';
    } elseif ($_POST['username'] != 'admin' && $_POST['password'] != '1234') {
        $username_error = 'Wrong username';
        $password_error = 'Wrong password';
    } elseif ($_POST['username'] != 'admin') {
        $username_error = 'Wrong username';
    } elseif ($_POST['password'] != '1234') {
        $password_error = 'Wrong password';
    }
} 

if (!$_SESSION['logged_in']) {
?>  
<div class="login-wrapper">
    <form action="" method="post" class="login">
        <h3 class="login__title">Login</h3>
        <p class="login__info">Welcome back, please login to see all files and directories.</p>
        <div class="login__input-wrapper">
            <label for="username" class="login__label">Username</label>
            <input type="text" class="login__input" name="username" value="<?php if(isset($_POST['username'])) print($_POST['username']) ?>"placeholder="Enter your username" required autofocus>
            <span class="login__error"><?php echo $username_error; ?></span>
        </div>
        <div class="login__input-wrapper">
            <label for="password" class="login__label">Password</label>
            <input type="password" class="login__input" name="password" placeholder="Enter your password" required></br>
            <span class="login__error"><?php echo $password_error; ?></span>
        </div>
        <input class ="btn btn--login" type="submit" name="login" value="Login" />
    </form> 
</div>    
<?php } ?>

<h1>Sign Up | <a href="<?= base_url().'user/login'?>">Login</a></h1>


<?= validation_errors();?>

<form action="<?= base_url().'user/signup_validation'?>" method="post">

    <p>
        <p>Email:</p>
        <input type="email" name="email" value="<?= $this->input->post('email');?>">
    </p>

    <p>
        <p>Password:</p>
        <input type="password" name="password">
    </p>

    <p>
        <p>Repeat Password:</p>
        <input type="password" name="rpassword">
    </p>

    <p>
        <button type="submit" name="signup_submit">Registration</button>
    </p>

</form>


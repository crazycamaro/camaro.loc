

<div id="container">

    <h1>Logion  |  <a href="<?= base_url().'user/signup'?>">Sign Up</a></h1>

<?= validation_errors();?>


    <form action="<?= base_url();?>user/login_validation" method="post">
            <p>
                <p>Email:</p>
                <input type="email" name="email" value="<?= set_value('email');?>">
            </p>

            <p>
                <p>Password:</p>
                <input type="password" name="password" >
            </p>

        <p>
            <button type="submit" name="login_submit">Login</button>
        </p>

    </form>




</div>



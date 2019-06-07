<?php
	require_once("action/LoginAction.php");

	$action = new LoginAction();
	$action->execute();

	require_once("partial/header.php");
?>
	<script src="javascript/login.js"></script>

	<div class="logo"></div>

	<div class="logo-nom"></div>
	<div class="login-block">

	<?php
		if($action->error)
		{
			?>
				<div class="error"><?= $action->errorMsg?></div>
			<?php
		}
		if($action->otherlogin)
		{
			?>
				<!-- <form action="login.php?other=true" method="post" onsubmit="return(login());"> -->
				<form action="login.php?other=true" method="post">
					<input type="hidden" name="type" value="signin">
					<input type="email" name="email" id="email" placeholder="Email">
					<input type="password" name="psswd" id="password" placeholder="Password">
					<button type="submit">Login</button>
				</form>
				<div class="separator">OR</div>
				<div class="signinButton other"><a href="?other=false">Connect with Facebook or Google</a></div>
				<div class="separator">OR</div>
				<div class="signinButton other"><a href="?signup=true">Sign up</a></div>
			<?php
		}
		else if ($action->signup)
		{
			?>
			<!-- <form action="login.php?signup=true" method="post" onsubmit="signup()"> -->
			<form action="login.php?signup=true" method="post">
				<input type="hidden" name="type" value="signup">
				<input type="text" name="firstname" id="firstname" placeholder="First Name">
				<input type="text" name="lastname" id="lastname" placeholder="Last Name">
				<input type="email" name="email" id="email" placeholder="Email">
				<input type="password" name="psswd1" id="password1" placeholder="Password">
				<input type="password" name="psswd2" id="password2" placeholder="Confirm Password">
				<button type="submit">Login</button>
			</form>
			<div class="separator">OR</div>
			<div class="signinButton other"><a href="?other=false">Connect with Facebook or Google</a></div>
			<div class="separator">OR</div>
			<div class="signinButton other"><a href="?other=true">Connect with your email</a></div>
		<?php
		}
		else
		{
			?>
				<div class="signinButton"><div class="fb-login-button" data-width="" data-size="large"  onlogin="checkLoginState();" data-scope="email" data-auto-logout-link="true" data-use-continue-as="false"></div></div>
				<div class="signinButton"><div class="g-signin2" data-onsuccess="onSignIn" data-longtitle="true" data-width="290px"></div></div>
				<div class="separator">OR</div>
				<div class="signinButton other"><a href="?other=true">Connect with your email</a></div>
				<div class="separator">OR</div>
				<div class="signinButton other"><a href="?signup=true">Sign up</a></div>
			<?php
		}


	?>
	</div>
<?php
	require_once("partial/footer.php");
<p> Welcome, <?php if (isset($_SESSION['login'])){echo $_SESSION['user']; echo '! <a href="logout.php">click here to logout</a>';} else echo 'Guest <a href="login.php">login</a>!<a href="signup.php" id="register">Register Now!</a>'; ?></p>
	<div class="logo">
		<h1> Tar Heel Gallery </h1>
	</div><!-- logo place holder -->
<div class = "header">
    <div class ="menu">
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="">About</a></li>
<li><a href="">Galleries</a></li>
<?php
if (isset($_SESSION['user'])) {
echo '<li><a href="upload.php">Upload</a></li>';
echo '<li><a href="">Settings</a></li>';
}
?>
</ul>
	</div><!-- Menu-->
</div><!--Header -->
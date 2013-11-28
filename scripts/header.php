<div class ="head"> <p> Welcome, 
<?php 
if (isset($_SESSION['login']))
{
echo $_SESSION['user'];
echo '! <a href="#" OnClick="return false; class="logout">Logout</a>';
}
else echo 'Guest. <a href="#" OnClick="return false;" class="login">Login</a> or <a href="#" OnClick="return false;" id="register">Register Now!</a>'; ?></p></div>
<div class="logo">
	<h1> Tar Heel Gallery </h1>
</div><!-- logo place holder -->
<div class = "header">
	<div class ="menu">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="">About</a></li>
			<li><a href="">Galleries</a></li>
			<li><a href="upload.php">Upload</a></li>
			<li><a href="">Settings</a></li>
		</ul>
	</div><!-- Menu-->
</div><!--Header -->
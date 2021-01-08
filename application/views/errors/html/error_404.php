<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	height: 100vh;
	background-image:url(../../../assets/images/intro-3.jpg);
	background-position: center center;
	background-repeat: no-repeat;
	background-size: cover;
	background-blend-mode: multiply;
	background-color: #000000d6;
	margin: 40px;
	font: 20px normal Helvetica, Arial, sans-serif;
	color: white;
	padding-top: 100px;
}

a {
	color: #2196F3;
	background-color: transparent;
	font-weight: normal;
	text-decoration: none;
}
a:hover{

}
h1{
	text-transform: uppercase;
	font-weight: 900;
	font-size: 2.75rem;
	color: #4F5155;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}
.image{
	background-image: url(../../../assets/images/mkitwhite.svg);
	background-size: contain;
	background-repeat: no-repeat;
	width: 200px;
	height: 100px;
}
.link{
	color: rgb(116, 116, 116);
	font-size: 16px;
	text-transform: none;
}
#container{
	width: 100%;
	display: flex;
	flex-direction: column;
	align-items: center;
}
p {
	margin: 12px 15px 12px 15px;
	text-transform: uppercase;
width: 500px;
text-align: center;
}
</style>
</head>
<body>
	<div id="container">
		<div class="image"></div>
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
		<p class="link">
			<a href="/">홈으로 가기</a>
		</p>
	</div>
</body>
</html>

</style>
<title>Errors</title>
</head>
<body>
<div class="error">
	<h1 class="face">!(^^)……WRONG</h1>
	<div class="message"><?php echo $error['message'] ?></div>
	<div class="content">
		<div class="info">
			<h4>The error position</h4>
			<div class="text">
				FILE: <?php echo $error['file'] ;?> &#12288;LINE: <?php echo $error['line'];?>
			</div>
		</div>
	<?php if(isset($error['trace'])) {?>
	<div class="trace">
		<h4>TRACE</h4>
		<div class="text">
			<?php echo nl2br($error['trace']);?>
		</div>
	</div>
	<?php }?>
	</div>
</div>
<div class="copyright">
	<a title="offcial website" href="https://github.com/PengYilong/Zero.git">ZERO for a PHP FRAME </a>
</div>
</body>
</html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<link rel="stylesheet" href="./css/normalize.css" type="text/css">
<link rel="stylesheet" href="./css/error.css" type="text/css">
<title>系统发生错误</title>
</head>
<body>
<div class="error">
	<h1 class="face"><?php echo $error['function'] ?>!(^^)……WRONG</h1>
	<div class="message"><?php echo $error['message'] ?></div>
	<div class="content">
		<div class="info">
			<h3 class="title">错误位置</h3>
			<div class="text">
				FILE: <?php echo $error['file'] ;?> &#12288;LINE: <?php echo $error['line'];?>
			</div>
		</div>
	<?php if(isset($e['trace'])) {?>
		<div class="info">
			<h3 class="title">TRACE</h3>
			<div class="text">
				<?php echo nl2br($error['trace']);?>
			</div>
		</div>
	<?php }?>
	</div>
</div>
<div class="copyright">
	<a title="官方网站" href="https://github.com/PengYilong/Zero.git">ZERO for MICRO PHP FRAME </a>
</div>
</body>
</html>
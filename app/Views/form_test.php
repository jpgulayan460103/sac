<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to CodeIgniter 4!</title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
	<link rel="stylesheet" href="/assets/css/bootstrap/bootstrap.min.css">
<body>

<form action="/users/login" method="post">
<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
<input type="text" name="username">
<input type="text" name="password">
<button type="submit">Submit</button>
</form>

<script src="/assets/js/vue/vue.js"></script>
<script src="/assets/js/jquery/jquery-3.5.1.min.js"></script>
<script src="/assets/js/popper/popper.min.js"></script>
<script src="/assets/js/bootstrap/bootstrap.min.js"></script>
</body>
</html>

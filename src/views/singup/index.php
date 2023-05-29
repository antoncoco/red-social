<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Singup</title>
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
    <form action="/register" method="POST" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="username">
        <input type="password" name="password" placeholder="password">
        <input type="file" name="profile">
        <button type="submit">Crear cuenta</button>
    </form>
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
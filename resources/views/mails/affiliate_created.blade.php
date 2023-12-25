<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <p>Hi, <strong>{{ $affiliate->user->name }}</strong></p>
    <p>You are registered as affiliate successfully!</p>

    <h5>Thanks && Regards</h5>
    {{ config('app.name') }}
</body>

</html>

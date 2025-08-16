<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('showtime.delete', 2) }}" method="POST">
    @csrf
    @method('DELETE') <!-- Laravel hiểu đây là DELETE -->
    <button type="submit">Xóa</button>
</form>
</body>
</html>
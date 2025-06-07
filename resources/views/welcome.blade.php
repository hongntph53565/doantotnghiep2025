<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Trang các nút tạo mới (Create)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .btn {
            display: inline-block;
            margin: 10px 15px 10px 0;
            padding: 12px 25px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #19692c;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>

    <h1>Các trang tạo mới (Create)</h1>

    <a href="/room/create" class="btn">Tạo phòng mới (Room/create)</a>
    <a href="/showtime/create" class="btn">Tạo suất chiếu mới (Showtime/create)</a>
    <a href="/template/create" class="btn">Tạo mẫu email mới (Template/create)</a>
    <a href="/mail/send-form" class="btn">Mẫu gửi mail (Mail/send-form)</a>
    <a href="{{ route('seat.edit',1) }}" class="btn">seat</a>
</body>
</html>

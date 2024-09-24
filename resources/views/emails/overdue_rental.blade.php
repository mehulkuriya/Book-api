<!DOCTYPE html>
<html>
<head>
    <title>Your Rental is Overdue</title>
</head>
<body>
    <h1>Overdue Rental Notification</h1>
    <p>Dear {{ $rental->user->name }},</p>
    <p>Your rental for the item "{{ $rental->book->title}}" is overdue. Please return it as soon as possible.</p>
    <p>Thank you!</p>
</body>
</html>

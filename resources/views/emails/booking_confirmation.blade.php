<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-top: 0;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        li {
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }
        li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thank you for your booking, {{ $booking->full_name }}!</h1>
        <p>Your booking details are as follows:</p>
        <ul>
            <li><strong>Tour:</strong> {{ $booking->tour->name }}</li>
            <li><strong>Number of Tickets:</strong> {{ $booking->number_of_tickets }}</li>
            <li><strong>Date:</strong> {{ $booking->tour->date }}</li>
            <li><strong>Destination:</strong> {{ $booking->tour->destination->name }}</li>
        </ul>
        <p>We look forward to seeing you on the tour!</p>
    </div>
 
</body>
</html>

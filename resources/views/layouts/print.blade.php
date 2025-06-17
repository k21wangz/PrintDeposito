<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: white;
        }
        .print-content {
            padding: 20px;
        }
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            .print-content {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="print-content">
        @yield('content')
    </div>
</body>
</html>

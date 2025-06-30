<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App | Laundry</title>

    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            margin: 0;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 800'><defs><filter id='bbblurry-filter' x='-100%' y='-100%' width='400%' height='400%' filterUnits='objectBoundingBox' primitiveUnits='userSpaceOnUse' color-interpolation-filters='sRGB'><feGaussianBlur stdDeviation='73' x='0%' y='0%' width='100%' height='100%' in='SourceGraphic' edgeMode='none' result='blur'></feGaussianBlur></filter></defs><g filter='url(%23bbblurry-filter)'><ellipse rx='127' ry='122.5' cx='703.1246123788244' cy='440.95685677253766' fill='hsla(184, 95%, 45%, 1.00)'></ellipse><ellipse rx='127' ry='122.5' cx='67.3548791695639' cy='103.57285640377026' fill='hsla(182, 99%, 42%, 1.00)'></ellipse><ellipse rx='127' ry='122.5' cx='92.9001639001657' cy='807.2297433583524' fill='hsla(179, 98%, 35%, 1.00)'></ellipse></g></svg>");

            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
    </style>
</head>

<body>
    @include('layouts.navtr')

    <div class="bg-overlay">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

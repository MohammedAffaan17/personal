<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome To Banao Technologies</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(180deg,#21c8f6,#637bff);
            color: #000;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #000;
            font-weight: 700;
        }

        .links {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        a {
            text-decoration: none;
            color: #fff; /* Set text color to white for better contrast */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome To Banao Technologies</h1>
        <div class="links">
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-success">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
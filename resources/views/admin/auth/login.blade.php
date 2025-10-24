<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chandra-Fashion | Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: "Open Sans", sans-serif;
        }

        .admin-login-wrapper {
            background: linear-gradient(135deg, #6d6d6d 0%, #c2c2c2 100%);
            align-items: center;
            justify-content: center;
            display: flex;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .admin-login-wrapper .card {
            width: 100%;
            max-width: 500px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            z-index: 1;
            margin: 20px;
            position: relative;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }

        .admin-login-wrapper .card-body {
            padding: 3rem;
        }

        .admin-login-wrapper .form-control {
            border-radius: 12px;
            border: 2px solid rgb(224, 224, 224);
            padding: 12px 20px;
            font-size: 15px;
            transition: 0.3s;
            box-shadow: none;
        }

        .admin-login-wrapper .form-control:focus {
            border-color: #000;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15)
        }

        .btn {
            background: linear-gradient(135deg, rgb(41, 41, 41) 0%, rgb(76, 76, 77) 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            transition: 0.3s;
            box-shadow: rgba(102, 126, 234, 0.4) 0px 4px 15px;
            transform: translateY(0px);
            box-shadow: 0 6px 20px rgba(56, 56, 56, 0.5);
        }

        .btn:hover {
            transform: translateY(-2px);

            color: #fff;
        }

        @media (max-width:767px) {
            .admin-login-wrapper .card-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <div class="admin-login-wrapper">

        <div class="position-absolute w-100 h-100" style="overflow: hidden; z-index: 0;">
            <div class="position-absolute rounded-circle"
                style="width: 300px; height: 300px; background: rgba(255,255,255,0.1); top: -100px; right: -100px; animation: float 6s ease-in-out infinite;">
            </div>
            <div class="position-absolute rounded-circle"
                style="width: 200px; height: 200px; background: rgba(255,255,255,0.1); bottom: -50px; left: -50px; animation: float 8s ease-in-out infinite;">
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="mb-3" style="animation: slideDown 0.6s ease-out;">
                        <img src="{{ asset('images/cf-logo-1.png') }}" width="100" alt="Chandra-Fashion Logo">
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #333; font-size: 28px;">Welcome Back</h3>
                    <p class="text-muted mb-0" style="font-size: 14px;">Sign in to your admin account</p>
                </div>

                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="alert alert-danger d-flex align-items-center mb-4" role="alert"
                        style="border-radius: 12px; border: none; background: #fee; animation: shake 0.5s;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="me-2" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                        </svg>
                        <div style="font-size: 14px;">{{ $errors->first() }}</div>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <!-- Email Input -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-2" style="color: #555; font-size: 14px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="me-1 mb-1" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                            </svg>
                            Email Address
                        </label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email"
                            required>
                    </div>

                    <!-- Password Input -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-2" style="color: #555; font-size: 14px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="me-1 mb-1" viewBox="0 0 16 16">
                                <path
                                    d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                            </svg>
                            Password
                        </label>
                        <input type="password" name="password" class="form-control form-control-lg"
                            placeholder="Enter your password" required>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn w-100 py-3 fw-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="me-2 mb-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z" />
                            <path fill-rule="evenodd"
                                d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                        </svg>
                        Sign In
                    </button>
                </form>

                <!-- Footer Text -->
                <div class="text-center mt-4">
                    <p class="text-muted mb-0" style="font-size: 13px;">
                        &copy; {{ date('Y') }} Chandra Fashion | All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

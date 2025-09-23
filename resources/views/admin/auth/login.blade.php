<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chandra-Fashion | Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #efffdd7a, #9ceeee24);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-box {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            animation: fadeIn 1.8s ease-in-out;
        }
        .login-box h3 {
            font-weight: bold;
            color: #333;
        }
        .brand-title {
            font-size: 20px;
            font-weight: 600;
            color: #d63384;
        }
        .btn-custom {
            background: #424649;
            color: #fff;
            font-weight: 600;
            transition: 0.3s;
            margin-top: 15px
        }
        /* .btn-custom:hover {
            background: #ececec;
            color: #fff;
        } */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="login-box text-center">
    <div class="mb-3">
         <img src="{{ asset('uploads/products/cf-logo.jpg') }}" width="150" alt="Chandra-Fashion Logo">
    </div>
    <h3 class="mb-1">Admin Login</h3>
    {{-- <p class="brand-title">Chandra-Fashion</p> --}}

    @if($errors->any())
        <div class="alert alert-danger py-2 mt-3">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}" class="mt-4">
        @csrf
        <div class="mb-3 text-start">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter email" required autofocus>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter password" required>
        </div>
        <button type="submit" class="btn btn-custom w-100 py-2"> Login</button>
    </form>
</div>

</body>
</html>

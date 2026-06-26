<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
            background: #0F172A; /* Deep dark blue background */
            height: 100vh;
            overflow: hidden;
            position: relative;
            color: #fff;
        }
        .background {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: 0;
            overflow: hidden;
        }
        .circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.6;
            filter: blur(60px);
        }
        .circle.large {
            width: 400px;
            height: 400px;
            background: #4318FF; /* Vibrant Blue */
            top: -100px;
            right: 10%;
            animation: floatUpDown 10s ease-in-out infinite alternate;
        }
        .circle.large1 {
            width: 500px;
            height: 500px;
            background: #E31A1A; /* Vibrant Red/Pink */
            bottom: -150px;
            left: 5%;
            animation: floatLeftRight 12s ease-in-out infinite alternate;
        }
        .circle.dot1 {
            width: 300px;
            height: 300px;
            background: #01B574; /* Vibrant Green */
            top: 40%;
            left: 40%;
            animation: floatDot 8s ease-in-out infinite alternate;
        }
        @keyframes floatUpDown {
            from { transform: translateY(0) scale(1); }
            to   { transform: translateY(100px) scale(1.1); }
        }
        @keyframes floatLeftRight {
            from { transform: translateX(0) scale(1); }
            to   { transform: translateX(100px) scale(1.05); }
        }
        @keyframes floatDot {
            from { transform: translate(0, 0); }
            to   { transform: translate(-80px, -80px); }
        }
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 50px 40px;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            text-align: center;
            width: 100%;
            max-width: 360px;
            position: relative;
            color: #fff;
        }
        .login-box img {
            width: 140px;
            margin-bottom: 10px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.5));
        }
        .login-box h2 {
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 28px;
            letter-spacing: 1px;
        }
        .input-container {
            display: flex;
            align-items: center;
            width: 100%;
            margin: 15px 0;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            box-sizing: border-box;
            background: rgba(0, 0, 0, 0.2);
            padding: 5px 15px;
            transition: all 0.3s ease;
        }
        .input-container:focus-within {
            border-color: #4318FF;
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 15px rgba(67, 24, 255, 0.3);
        }
        .input-container input {
            flex: 1;
            border: none;
            padding: 12px 0;
            font-size: 15px;
            color: #fff;
            outline: none;
            background: transparent;
            font-family: 'Outfit', sans-serif;
        }
        .input-container input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .input-container i {
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            font-size: 1.1em;
            transition: color 0.3s ease;
        }
        .input-container i:hover {
            color: #fff;
        }
        .login-box .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
        }
        .login-box .options input[type="checkbox"] {
            margin-right: 8px;
            accent-color: #4318FF;
        }
        .btn-login {
            margin-top: 30px;
            width: 100%;
            padding: 14px;
            background: #4318FF;
            border: none;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(67, 24, 255, 0.4);
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: #3311db;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(67, 24, 255, 0.5);
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .login-box {
                max-width: 85%;
                padding: 40px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="circle large"></div>
        <div class="circle large1"></div>
        <div class="circle dot1"></div>
        <div class="circle dot2"></div>
    </div>

    <div class="login-container">
        <div class="login-box">
            <img src="gambar/logo.png" alt="Logo">
            <h2>Login</h2>
            <form method="POST" action="{{ route('login.process') }}">
                @csrf
            
                <div class="input-container">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
            
                <div class="input-container">
                    <input type="password" name="password" placeholder="Password" id="password" required>
                    <i class="fa-solid fa-eye-slash" id="togglePassword"></i>
                </div>
            
                <div class="options">
                    <label><input type="checkbox" name="remember"> Remember me?</label>
                </div>
            
                <button class="btn-login" type="submit">Login</button>
            </form>            
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById("togglePassword");
        const password = document.getElementById("password");

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    </script>
</body>
</html>

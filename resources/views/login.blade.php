<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: #f5f8fa;
            height: 100vh;
            overflow: hidden;
            position: relative;
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
            opacity: 0.8;
        }
        .circle.large {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #304c89, #4361ee);
            top: 20px;
            right: 400px;
            animation: floatUpDown 8s ease-in-out infinite alternate;
        }
        .circle.large1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #0453a8, #1d8aff);
            bottom: 20px;
            left: 400px;
            animation: floatLeftRight 8s ease-in-out infinite alternate;
        }
        .circle.dot1 {
            width: 18px;
            height: 18px;
            background: #2d2dad;
            top: 30%;
            right: 25%;
            animation: floatDot 4.5s ease-in-out infinite alternate;
        }
        .circle.dot2 {
            width: 18px;
            height: 18px;
            background: #0467be;
            bottom: 30%;
            left: 25%;
            animation: floatDot 4.5s ease-in-out infinite alternate;
        }
        @keyframes floatUpDown {
            from { transform: translateY(0); }
            to   { transform: translateY(60px); }
        }
        @keyframes floatLeftRight {
            from { transform: translateX(0); }
            to   { transform: translateX(60px); }
        }
        @keyframes floatDot {
            from { transform: translateY(0); }
            to   { transform: translateY(-60px); }
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
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
            width: 100%;
            max-width: 300px;
            position: relative;
        }
        .login-box img {
            width: 150px;
            
        }
        .login-box h2 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
        }
        .input-container {
            display: flex;
            align-items: center;
            width: 100%;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            background: white;
            padding: 0 10px;
        }
        .input-container input {
            flex: 1;
            border: none;
            padding: 12px 0;
            font-size: 1em;
            outline: none;
            background: transparent;
        }
        .input-container i {
            color: #888;
            cursor: pointer;
            font-size: 1.1em;
        }
        .login-box .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            font-size: 0.9em;
        }
        .login-box .options input[type="checkbox"] {
            margin-right: 5px;
        }
        .login-box .options a {
            color: #1da1f2;
            text-decoration: none;
        }
        .login-box button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background:linear-gradient(135deg, #304c89, #4361ee);
            border: none;
            color: #fff;
            font-size: 1em;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-box button:hover {
            background:linear-gradient(135deg, #4361ee, #304c89);
        }
        .login-box .bottom-text {
            margin-top: 15px;
            font-size: 0.9em;
        }
        .login-box .bottom-text a {
            color: #1da1f2;
            text-decoration: none;
        }

        /* Responsive untuk HP */
        @media (max-width: 480px) {
            .login-box {
                max-width: 90%;
                padding: 30px 20px;
            }
            .login-box img {
                width: 70px;
            }
            .input-container input {
                font-size: 0.95em;
            }
            .login-box button {
                padding: 10px;
                font-size: 0.95em;
            }
            .login-box h2 {
                font-size: 1.5em;
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

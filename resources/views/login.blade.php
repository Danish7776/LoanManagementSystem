<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f0f2f5;
        font-family: Arial, sans-serif;
    }

    .login-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    .login-container h2 {
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    .btn {
        display: inline-block;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .text-center {
        text-align: center;
    }

    .mt-3 {
        margin-top: 15px;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-top: 10px;
    }
</style>

<div class="login-container">
    <h2>LOGIN</h2>
    <form method="POST" action="{{ route('loginUser') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            @if ($errors->has('email'))
                <div class="error">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            @if ($errors->has('password'))
                <div class="error">{{ $errors->first('password') }}</div>
            @endif
        </div>

        @if ($errors->has('credentials'))
            <div class="error">{{ $errors->first('credentials') }}</div>
        @endif

        @if ($errors->has('error'))
            <div class="error">{{ $errors->first('error') }}</div>
        @endif

        <button type="submit" class="btn">Login</button>

        <div class="text-center mt-3">
            <p>Don't have an account? <a href="{{ route('SignUp') }}">Sign Up</a></p>
        </div>
    </form>
</div>
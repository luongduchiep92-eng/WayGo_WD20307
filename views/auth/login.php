<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - WayGo Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            padding: 40px 30px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h3 {
            color: #4e73df;
            font-weight: 800;
            letter-spacing: 1px;
        }
        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            background-color: #f8f9fc;
            border: 1px solid #d1d3e2;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #4e73df;
            background-color: #fff;
        }
        .btn-login {
            border-radius: 25px;
            padding: 12px;
            font-weight: bold;
            background: #4e73df;
            border: none;
            width: 100%;
            color: white;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="fa-solid fa-plane-circle-check fa-3x text-primary mb-2"></i>
            <h3>WAYGO ADMIN</h3>
            <p class="text-muted">Đăng nhập để quản lý hệ thống</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger text-center py-2 rounded-pill"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Tên đăng nhập" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-login">ĐĂNG NHẬP</button>
        </form>
        
        <div class="text-center mt-4">
            <a href="index.php?action=register" class="text-decoration-none small text-secondary">Tạo tài khoản mới?</a>
        </div>
    </div>
</body>
</html>
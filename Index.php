<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haul Out .Co - Welcome</title>
    <link rel="stylesheet" href="config/style.css">
    <link rel="icon" type="image/x-icon" href="HaulOut.ico">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .landing-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            padding: 20px;
        }
        .landing-content > div {
            flex: 1;
            max-width: 200px;
        }
        header {
            background: var(--primary-color);
            color: white;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: white;
            margin: 0;
        }

        footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: gray;
            margin-top: auto;
        }

        @media (max-width: 600px) {
            .landing-content {
                flex-direction: column;
                gap: 12px;
                padding: 16px;
            }

            .landing-content > div {
                width: 100%;
                max-width: none;
            }

            header {
                padding: 20px 16px;
            }

            .btn-auth {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <header>
        <h2>HAUL OUT .CO</h2>
    </header>

    <div class="landing-content">
        <div>
            <a href="login.php" class="btn-auth" style="display: block; text-decoration: none;">LOGIN</a>
        </div>
        <div>
            <a href="registrasi.php" class="btn-auth" style="display: block; text-decoration: none; background: var(--white); color: var(--primary-color); border: 2px solid var(--primary-color);">REGISTRASI</a>
        </div>
    </div>

    <footer>
        © 2026 Haul Out .Co. All rights reserved.
    </footer>
</body>
</html>
        &copy; 2026 Haul Out .Co - Sistem Peminjaman Truk Terintegrasi
    </footer>

</body>
</html>
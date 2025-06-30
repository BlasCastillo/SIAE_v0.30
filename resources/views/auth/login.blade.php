<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- STYLE -->
    <link rel="stylesheet" href="{{ asset('css/Index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Valores.css') }}">
</head>

<body>
    <div class="form-container">
        <div class="col col-1">
            <div class="image-layer">
                <img src="{{ asset('Imagenes/siae-login.png') }}" class="form-image">
            </div>
        </div>
        <div class="col col-2">
            <div class="login-form">
                <div class="form-title">
                    <span>Iniciar sesión</span>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-inputs">
                        <!-- Campo Usuario -->
                        <div class="input-box">
                            <input type="email" name="email" id="email" class="input-field" placeholder="Usuario" required autofocus>
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <!-- Campo Contraseña -->
                        <div class="input-box">
                            <input type="password" name="password" id="password" class="input-field" placeholder="Contraseña" required autocomplete="current-password">
                            <i class="bi bi-person-fill-lock"></i>
                        </div>
                        <!-- Botón Acceder -->
                        <div class="input-box">
                            <button type="submit" class="input-submit">
                                <span class="Btn">Acceder</span>
                                <i class="bi bi-box-arrow-in-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script></script>
</body>

</html>

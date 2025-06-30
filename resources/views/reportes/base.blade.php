<!DOCTYPE html>
<html>
<head>
    <title>{{ $titulo ?? 'Reporte' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            position: relative;
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 80px;
            height: auto;
        }
        .report-title {
            flex: 1;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        /* Marca de agua */
        .watermark {
            position: fixed;
            top: 30%;
            left: 15%;
            width: 70%;
            opacity: 0.5;
            z-index: 0;
        }
        .content {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body>
    {{-- Marca de agua --}}
    <img src="{{ public_path('imagenes/siae-welcome.png') }}" class="watermark" alt="Marca de Agua">

    <div class="content">
        <div class="header">
            {{-- Logo superior izquierdo --}}
            <img src="{{ public_path('imagenes/siae-login.png') }}" class="logo" alt="Logo">
            <div class="report-title">
                {{ $titulo ?? 'Reporte' }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    @foreach ($columnas as $col)
                        <th>{{ $col['label'] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($datos as $item)
                    <tr>
                        @foreach ($columnas as $col)
                            <td>
                                @if (is_callable($col['field']))
                                    {{ $col['field']($item) }}
                                @else
                                    {{ data_get($item, $col['field']) }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columnas) }}" style="text-align:center;">No hay datos para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
{{--
    Este archivo es una plantilla base para generar reportes en PDF utilizando Blade y Laravel.
    Se utiliza para mostrar un encabezado, una tabla con datos y una marca de agua.
    Las variables $titulo, $columnas y $datos deben ser pasadas desde el controlador al renderizar la vista.
    La marca de agua se coloca en una posición fija y con baja opacidad para no interferir con la lectura del contenido.
    El logo se coloca en la parte superior izquierda y el título del reporte se centra en la parte superior.
    La tabla se genera dinámicamente a partir de los datos proporcionados, y se maneja el caso en que no haya datos para mostrar.
--}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hoja de Costos - {{ $hoja->nombre }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 40px;
            position: relative;
        }

        .logo-container {
            position: absolute;
            top: -50px;
            right: 0;
        }

        .logo {
            width: 130px;
            height: auto;
        }

        .header {
            margin-bottom: 40px;
            padding-bottom: 10px;
            border-bottom: 2px solid #444;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            color: #1a202c;
        }

        .section-title {
            font-weight: bold;
            font-size: 16px;
            color: #2c3e50;
            border-bottom: 1px solid #999;
            margin-top: 25px;
            margin-bottom: 10px;
            padding-bottom: 4px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .table th {
            background-color: #e2e8f0;
            color: #000;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            border: 1px solid #ccc;
        }

        .table td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .right { text-align: right; }
        .bold { font-weight: bold; }

        .summary {
            margin-top: 30px;
            border-top: 2px solid #444;
            padding-top: 10px;
            font-size: 13px;
        }

        .summary .line {
            font-style: italic;
            color: #555;
        }

        strong {
            color: #1f2937;
        }
    </style>
</head>
<body>

    <div class="logo-container">
        <img src="{{ public_path('img/logo.png') }}" class="logo" alt="Logo Empresa">
    </div>

    <div class="header">
        <div class="title">Hoja de Costos</div>
    </div>

    <div><strong>Nombre del Producto:</strong> {{ $hoja->nombre }}</div>
    <div><strong>Cantidad de Producción:</strong> {{ $hoja->cantidad }}</div>

    <div class="section-title">Materiales</div>
    <table class="table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th class="right">Costo</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotal_materiales = 0; @endphp
            @foreach($hoja->materiales as $material)
                @php $subtotal_materiales += $material['costo']; @endphp
                <tr>
                    <td>{{ $material['descripcion'] }}</td>
                    <td class="right">${{ number_format($material['costo'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="bold">Subtotal Materiales</td>
                <td class="right bold">${{ number_format($subtotal_materiales, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Mano de Obra Directa</div>
    <table class="table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th class="right">Costo</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotal_labores = 0; @endphp
            @foreach($hoja->labores as $labor)
                @php $subtotal_labores += $labor['costo']; @endphp
                <tr>
                    <td>{{ $labor['descripcion'] }}</td>
                    <td class="right">${{ number_format($labor['costo'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="bold">Subtotal Mano de Obra</td>
                <td class="right bold">${{ number_format($subtotal_labores, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Costos Indirectos</div>
    <table class="table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th class="right">Costo</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotal_indirectos = 0; @endphp
            @foreach($hoja->indirectos as $indirecto)
                @php $subtotal_indirectos += $indirecto['costo']; @endphp
                <tr>
                    <td>{{ $indirecto['descripcion'] }}</td>
                    <td class="right">${{ number_format($indirecto['costo'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="bold">Subtotal Indirectos</td>
                <td class="right bold">${{ number_format($subtotal_indirectos, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Totales</div>
    <table class="table">
        <tbody>
            <tr>
                <td class="bold">Costo Total</td>
                <td class="right bold">${{ number_format($hoja->costo_total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Margen de Ganancia</td>
                <td class="right">{{ $hoja->margen }}%</td>
            </tr>
            <tr>
                <td class="bold">Costo Unitario</td>
                <td class="right bold">${{ number_format($hoja->costo_unitario, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hoja de Costos - {{ $hoja->nombre }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .section-title {
            font-weight: bold;
            font-size: 14px;
            border-bottom: 1px solid #000;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        .line {
            border-bottom: 1px dashed #aaa;
            margin: 10px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .table td, .table th {
            border: 1px solid #ccc;
            padding: 6px;
        }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .summary {
            margin-top: 15px;
            border-top: 2px solid #000;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="title">🧾 Hoja de Costos</div>

    <div><strong>Nombre del Producto:</strong> {{ $hoja->nombre }}</div>
    <div><strong>Cantidad de Producción:</strong> {{ $hoja->cantidad }}</div>

    <div class="section-title">🧱 Materiales</div>
    <table class="table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th class="right">Costo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hoja->materiales as $material)
                <tr>
                    <td>{{ $material['descripcion'] }}</td>
                    <td class="right">${{ number_format($material['costo'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">🧍 Mano de Obra Directa</div>
    <table class="table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th class="right">Costo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hoja->labores as $labor)
                <tr>
                    <td>{{ $labor['descripcion'] }}</td>
                    <td class="right">${{ number_format($labor['costo'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">🏠 Costos Indirectos</div>
    <table class="table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th class="right">Costo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hoja->indirectos as $indirecto)
                <tr>
                    <td>{{ $indirecto['descripcion'] }}</td>
                    <td class="right">${{ number_format($indirecto['costo'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">📊 Totales</div>
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

    <div class="summary">
        <p><strong>Fórmula utilizada:</strong></p>
        <p class="line">Precio Unitario = (Costo Total / Cantidad) × (1 + Margen%)</p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - Orden #{{ $orden->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #ec4899;
        }
        
        .company-info {
            flex: 1;
        }
        
        .company-info h1 {
            font-size: 24px;
            color: #ec4899;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .company-info p {
            margin: 2px 0;
            color: #666;
        }
        
        .invoice-info {
            text-align: right;
            flex: 1;
        }
        
        .invoice-info h2 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .invoice-info p {
            margin: 2px 0;
        }
        
        .invoice-number {
            font-size: 20px;
            font-weight: bold;
            color: #ec4899;
        }
        
        .billing-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .billing-info, .shipping-info {
            flex: 1;
            margin-right: 20px;
        }
        
        .billing-info:last-child, .shipping-info:last-child {
            margin-right: 0;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #ec4899;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-pagado {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-enviado {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .status-completado {
            background: #fce7f3;
            color: #be185d;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .items-table th {
            background: #ec4899;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .items-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }
        
        .items-table tr:last-child td {
            border-bottom: none;
        }
        
        .items-table tr:nth-child(even) {
            background: #fafafa;
        }
        
        .product-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
        }
        
        .product-details {
            color: #666;
            font-size: 10px;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .total-section {
            margin-top: 30px;
            text-align: right;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        
        .total-row:last-child {
            border-bottom: 2px solid #ec4899;
            font-weight: bold;
            font-size: 16px;
            color: #ec4899;
        }
        
        .total-label {
            font-weight: bold;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .thank-you {
            background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 100%);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 30px 0;
            border: 1px solid #ec4899;
        }
        
        .thank-you h3 {
            color: #ec4899;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .payment-info {
            background: #f0f9ff;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #0284c7;
            margin-bottom: 20px;
        }
        
        .reference-code {
            font-family: 'Courier New', monospace;
            background: #fff;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
            display: inline-block;
            margin-top: 5px;
            font-weight: bold;
        }
        
        @media print {
            .container {
                padding: 0;
            }
            
            body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>{{ $empresa['nombre'] }}</h1>
                <p>{{ $empresa['direccion'] }}</p>
                <p>Tel: {{ $empresa['telefono'] }}</p>
                <p>Email: {{ $empresa['email'] }}</p>
                <p>{{ $empresa['website'] }}</p>
            </div>
            <div class="invoice-info">
                <h2>FACTURA</h2>
                <p class="invoice-number">#{{ $orden->id }}</p>
                <p><strong>Fecha:</strong> {{ $orden->created_at->format('d/m/Y') }}</p>
                <p><strong>Generada:</strong> {{ $fecha_generacion->format('d/m/Y H:i') }}</p>
                <p>
                    <span class="status-badge status-{{ $orden->status }}">
                        {{ ucfirst($orden->status) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Información del cliente y envío -->
        <div class="billing-section">
            <div class="billing-info">
                <div class="section-title">DATOS DEL CLIENTE</div>
                <div class="info-box">
                    <p><strong>{{ $usuario->name }}</strong></p>
                    <p>{{ $usuario->email }}</p>
                    @if($usuario->phone)
                        <p>{{ $usuario->phone }}</p>
                    @endif
                </div>
            </div>
            
            <div class="shipping-info">
                <div class="section-title">DIRECCIÓN DE ENVÍO</div>
                <div class="info-box">
                    <p>{{ $orden->direccion_envio }}</p>
                </div>
            </div>
        </div>

        <!-- Información de pago -->
        @if($orden->payment && $orden->payment->referencia)
        <div class="payment-info">
            <div class="section-title">INFORMACIÓN DE PAGO</div>
            <p><strong>Método:</strong> {{ $orden->payment->paymentType->nombre ?? 'No especificado' }}</p>
            <p><strong>Referencia:</strong></p>
            <div class="reference-code">{{ $orden->payment->referencia }}</div>
        </div>
        @endif

        <!-- Tabla de productos -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%">Producto</th>
                    <th style="width: 10%" class="text-center">Talla</th>
                    <th style="width: 10%" class="text-center">Cantidad</th>
                    <th style="width: 15%" class="text-right">Precio Unit.</th>
                    <th style="width: 15%" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orden->orderItems as $item)
                <tr>
                    <td>
                        <div class="product-name">
                            {{ $item->product->nombre ?? 'Producto eliminado' }}
                        </div>
                        @if($item->product && $item->product->descripcion)
                        <div class="product-details">
                            {{ Str::limit($item->product->descripcion, 100) }}
                        </div>
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $item->size->etiqueta ?? '—' }}
                    </td>
                    <td class="text-center">
                        {{ $item->cantidad }}
                    </td>
                    <td class="text-right">
                        ${{ number_format($item->precio_unitario, 2) }}
                    </td>
                    <td class="text-right">
                        <strong>${{ number_format($item->precio_unitario * $item->cantidad, 2) }}</strong>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totales -->
        <div class="total-section">
            <div style="width: 300px; margin-left: auto;">
                @php
                    $subtotal = $orden->orderItems->sum(function($item) {
                        return $item->precio_unitario * $item->cantidad;
                    });
                    $impuestos = $subtotal * 0.16; // Ejemplo: 16% de impuestos
                    $envio = 0; // Puedes agregar lógica para calcular envío
                @endphp
                
                <div class="total-row">
                    <span class="total-label">Subtotal:</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                
                @if($envio > 0)
                <div class="total-row">
                    <span class="total-label">Envío:</span>
                    <span>${{ number_format($envio, 2) }}</span>
                </div>
                @endif
                
                <div class="total-row">
                    <span class="total-label">TOTAL:</span>
                    <span>${{ number_format($orden->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Mensaje de agradecimiento -->
        <div class="thank-you">
            <h3>¡Gracias por tu compra!</h3>
            <p>Esperamos que disfrutes de tus productos. Si tienes alguna pregunta, no dudes en contactarnos.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Esta factura fue generada automáticamente el {{ $fecha_generacion->format('d/m/Y \a \l\a\s H:i') }}</p>
            <p>{{ $empresa['nombre'] }} - Todos los derechos reservados</p>
        </div>
    </div>
</body>
</html>
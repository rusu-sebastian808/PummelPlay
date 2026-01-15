<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} - PummelPlay</title>
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'DejaVu Sans', Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #1f2937;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
        }
        

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        

        .invoice-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            position: relative;
            overflow: hidden;
        }
        
        .invoice-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            z-index: 1;
        }
        
        .company-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo-image {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #8b5cf6, #3b82f6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: white;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }
        
        .company-info h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }
        
        .company-tagline {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 300;
        }
        
        .invoice-title {
            text-align: right;
        }
        
        .invoice-title h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .invoice-number {
            font-size: 18px;
            font-weight: 500;
            opacity: 0.9;
        }
        
 
        .invoice-body {
            padding: 40px 30px;
        }
        

        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .detail-section {
            background: #f9fafb;
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid #8b5cf6;
        }
        
        .detail-section h3 {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 5px 0;
        }
        
        .detail-label {
            font-weight: 500;
            color: #6b7280;
        }
        
        .detail-value {
            font-weight: 600;
            color: #1f2937;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-completed {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }
        
        .status-pending {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        
        .status-cancelled {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        

        .billing-address {
            background: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
        }
        
        .billing-address h3 {
            color: #8b5cf6;
            margin-bottom: 15px;
        }
        
        .address-line {
            margin-bottom: 5px;
            color: #374151;
        }
        
        .customer-name {
            font-weight: 600;
            font-size: 16px;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .items-section {
            margin: 40px 0;
        }
        
        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #8b5cf6;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .items-table th {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: white;
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .items-table th:last-child,
        .items-table td:last-child {
            text-align: right;
        }
        
        .items-table th:nth-child(3),
        .items-table td:nth-child(3),
        .items-table th:nth-child(4),
        .items-table td:nth-child(4) {
            text-align: center;
        }
        
        .items-table td {
            padding: 18px 15px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }
        
        .items-table tr:last-child td {
            border-bottom: none;
        }
        
        .items-table tr:nth-child(even) {
            background: #f9fafb;
        }
        
        .game-title {
            font-weight: 600;
            color: #1f2937;
            font-size: 15px;
            margin-bottom: 5px;
        }
        
        .game-description {
            color: #6b7280;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .genre-badge {
            background: #e0e7ff;
            color: #3730a3;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .price-cell {
            font-weight: 600;
            color: #1f2937;
        }
        
        .totals-section {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }
        
        .totals-table {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            min-width: 300px;
        }
        
        .totals-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .totals-table td {
            padding: 8px 0;
            border: none;
        }
        
        .totals-table .total-label {
            font-weight: 500;
            color: #6b7280;
        }
        
        .totals-table .total-value {
            text-align: right;
            font-weight: 600;
            color: #1f2937;
        }
        
        .totals-table .grand-total {
            border-top: 2px solid #8b5cf6;
            padding-top: 12px;
            margin-top: 8px;
        }
        
        .totals-table .grand-total .total-label,
        .totals-table .grand-total .total-value {
            font-size: 18px;
            font-weight: 700;
            color: #8b5cf6;
        }
        
        .free-badge {
            color: #047857;
            font-weight: 600;
        }
        
        .info-box {
            margin: 30px 0;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid;
        }
        
        .info-box.payment {
            background: #f0f9ff;
            border-color: #0ea5e9;
        }
        
        .info-box.delivery {
            background: #ecfdf5;
            border-color: #10b981;
        }
        
        .info-box h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-box.payment h4 {
            color: #0369a1;
        }
        
        .info-box.delivery h4 {
            color: #047857;
        }
        
        .info-list {
            list-style: none;
            padding: 0;
        }
        
        .info-list li {
            margin-bottom: 6px;
            color: #374151;
        }
        
        .info-list li::before {
            content: "✓";
            color: #10b981;
            font-weight: bold;
            margin-right: 8px;
        }
        
        .invoice-footer {
            background: #1f2937;
            color: #e5e7eb;
            padding: 30px;
            text-align: center;
        }
        
        .footer-content {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .thank-you-message {
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 15px;
        }
        
        .footer-info {
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #9ca3af;
        }
        
        .footer-note {
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #374151;
            padding-top: 15px;
            margin-top: 15px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 12px;
            }
            
            .invoice-container {
                box-shadow: none;
                border-radius: 0;
            }
            
            .invoice-header::before {
                display: none;
            }
        }
        
        @page {
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">

        <div class="invoice-header">
            <div class="header-content">
                <div class="company-logo">
                    <div class="logo-image">
                        🎮
                    </div>
                    <div class="company-info">
                        <h1>PUMMELPLAY</h1>
                        <div class="company-tagline">Your Ultimate Gaming Destination</div>
                    </div>
                </div>
                <div class="invoice-title">
                    <h2>INVOICE</h2>
                    <div class="invoice-number">#{{ $order->id }}</div>
                </div>
            </div>
        </div>


        <div class="invoice-body">

            <div class="invoice-details">
     
                <div class="detail-section">
                    <h3>Invoice Details</h3>
                    <div class="detail-row">
                        <span class="detail-label">Invoice Date:</span>
                        <span class="detail-value">{{ $order->created_at->format('F j, Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Invoice Time:</span>
                        <span class="detail-value">{{ $order->created_at->format('g:i A T') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Order Status:</span>
                        <span class="detail-value">
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Payment Method:</span>
                        <span class="detail-value">Credit Card</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Transaction ID:</span>
                        <span class="detail-value">PMP-{{ $order->id }}-{{ $order->created_at->format('Ymd') }}</span>
                    </div>
                </div>


                <div class="billing-address">
                    <h3>Bill To</h3>
                    <div class="customer-name">{{ $order->user->name }}</div>
                    <div class="address-line">{{ $order->user->email }}</div>
                    <div class="address-line">1234 Gaming Street</div>
                    <div class="address-line">Gamer City, GC 12345</div>
                    <div class="address-line">United States</div>
                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e7eb;">
                        <div class="detail-row">
                            <span class="detail-label">Customer ID:</span>
                            <span class="detail-value">#{{ str_pad($order->user->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Member Since:</span>
                            <span class="detail-value">{{ $order->user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="items-section">
                <h2 class="section-title">Games Purchased</h2>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width: 45%;">Game Details</th>
                            <th style="width: 15%;">Genre</th>
                            <th style="width: 10%;">Qty</th>
                            <th style="width: 15%;">Unit Price</th>
                            <th style="width: 15%;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>
                                <div class="game-title">{{ $item->game->title }}</div>
                                <div class="game-description">{{ Str::limit($item->game->description, 80) }}</div>
                            </td>
                            <td>
                                <span class="genre-badge">{{ $item->game->genre }}</span>
                            </td>
                            <td class="price-cell">{{ $item->quantity }}</td>
                            <td class="price-cell">${{ number_format($item->price, 2) }}</td>
                            <td class="price-cell">${{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="totals-section">
                <div class="totals-table">
                    <table>
                        @php
                            $subtotal = $order->orderItems->sum(fn($item) => $item->quantity * $item->price);
                            $itemCount = $order->orderItems->sum('quantity');
                            $tax = 0; // No tax for digital games
                            $shipping = 0; // Free shipping for digital
                        @endphp
                        <tr>
                            <td class="total-label">Subtotal ({{ $itemCount }} {{ Str::plural('item', $itemCount) }}):</td>
                            <td class="total-value">${{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="total-label">Sales Tax:</td>
                            <td class="total-value">${{ number_format($tax, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="total-label">Shipping & Handling:</td>
                            <td class="total-value free-badge">FREE</td>
                        </tr>
                        <tr class="grand-total">
                            <td class="total-label">TOTAL AMOUNT:</td>
                            <td class="total-value">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="info-box payment">
                <h4>💳 Payment Information</h4>
                <div class="detail-row">
                    <span class="detail-label">Payment Status:</span>
                    <span class="detail-value">
                        @if($order->status === 'completed')
                            <span style="color: #047857; font-weight: 600;">✅ PAID IN FULL</span>
                        @elseif($order->status === 'pending')
                            <span style="color: #92400e; font-weight: 600;">⏳ PAYMENT PENDING</span>
                        @else
                            <span style="color: #b91c1c; font-weight: 600;">❌ PAYMENT CANCELLED</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Processed On:</span>
                    <span class="detail-value">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</span>
                </div>
            </div>

            @if($order->status === 'completed')
            <div class="info-box delivery">
                <h4>🎮 Digital Delivery Confirmation</h4>
                <ul class="info-list">
                    <li>Your games are immediately available in your library</li>
                    <li>No physical shipping required - instant access</li>
                    <li>Download links never expire</li>
                    <li>24/7 technical support available</li>
                    <li>Lifetime game updates included</li>
                </ul>
            </div>
            @endif
        </div>

        <div class="invoice-footer">
            <div class="footer-content">
                <div class="thank-you-message">Thank you for choosing PummelPlay! 🎮</div>
                <div class="footer-info">
                    We're thrilled to be part of your gaming journey. Your satisfaction is our priority,
                    and we're here to support you every step of the way.
                </div>
                
                <div class="contact-info">
                    <div class="contact-item">
                        <span>📧</span>
                        <span>support@pummelplay.com</span>
                    </div>
                    <div class="contact-item">
                        <span>🌐</span>
                        <span>www.pummelplay.com</span>
                    </div>
                    <div class="contact-item">
                        <span>📞</span>
                        <span>1-800-PUMMEL-1</span>
                    </div>
                </div>

                <div class="footer-note">
                    This invoice was automatically generated on {{ now()->format('F j, Y \a\t g:i A T') }}.
                    For any questions about this invoice, please contact our support team.
                </div>
            </div>
        </div>
    </div>
</body>
</html> 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice #{{ $order->order_number }} – Nayan Mart</title>
  <style>
    body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; color: #1e293b; margin: 0; padding: 40px; background: #f8fafc; font-size: 14px; }
    .invoice-box { max-width: 800px; margin: auto; padding: 36px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .header-row { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #0f7a3f; padding-bottom: 20px; margin-bottom: 24px; }
    .logo h1 { color: #0f7a3f; font-size: 28px; margin: 0 0 4px; font-weight: 800; }
    .logo p { margin: 0; color: #64748b; font-size: 12px; }
    .invoice-meta { text-align: right; }
    .invoice-meta h2 { margin: 0 0 6px; font-size: 20px; color: #0f172a; }
    .details-row { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; font-size: 13px; line-height: 1.6; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
    th { background: #f1f5f9; color: #475569; text-align: left; padding: 10px 14px; font-size: 12px; font-weight: 700; text-transform: uppercase; border-bottom: 1px solid #cbd5e1; }
    td { padding: 12px 14px; border-bottom: 1px solid #e2e8f0; }
    .totals-wrap { display: flex; justify-content: flex-end; }
    .totals-table { width: 280px; font-size: 13px; line-height: 1.8; }
    .totals-table tr td:last-child { text-align: right; font-weight: 600; }
    .grand-total { font-size: 16px; font-weight: 800 !important; color: #0f7a3f; border-top: 2px solid #e2e8f0; }
    .print-btn { background: #0f7a3f; color: #fff; border: none; padding: 10px 20px; font-size: 13px; font-weight: 700; border-radius: 6px; cursor: pointer; margin-bottom: 20px; }
    @media print { .print-btn { display: none; } body { padding: 0; background: #fff; } .invoice-box { border: none; box-shadow: none; padding: 0; } }
  </style>
</head>
<body>

  <div style="max-width: 800px; margin: auto; text-align: right;">
    <button class="print-btn" onclick="window.print()">🖨️ Print / Save as PDF</button>
  </div>

  <div class="invoice-box">
    <div class="header-row">
      <div class="logo">
        <h1>Nayan Mart</h1>
        <p>“আপনার ঘরের বাজার, এখন হাতের মুঠোয়”</p>
        <p>Quality Products • Best Price • Fast Delivery</p>
        <p>Phone: {{ \App\Models\Setting::get('phone', '7550807912') }} | Email: {{ \App\Models\Setting::get('email', 'skrousonali2024@gmail.com') }}</p>
      </div>
      <div class="invoice-meta">
        <h2>TAX INVOICE</h2>
        <div><strong>Invoice #:</strong> INV-{{ $order->order_number }}</div>
        <div><strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}</div>
        <div><strong>Order ID:</strong> #{{ $order->order_number }}</div>
      </div>
    </div>

    <div class="details-row">
      <div>
        <strong style="color: #0f7a3f;">Customer Details:</strong><br>
        <strong>{{ $order->customer_name }}</strong><br>
        Phone: {{ $order->customer_phone }}<br>
        @if($order->customer_email) Email: {{ $order->customer_email }}<br> @endif
      </div>
      <div>
        <strong style="color: #0f7a3f;">Delivery Address:</strong><br>
        @if($order->house_flat) {{ $order->house_flat }}, @endif
        {{ $order->street_area }}<br>
        {{ $order->city }}, {{ $order->state }} – {{ $order->pincode }}<br>
        Payment: <strong>{{ $order->payment_method_name }}</strong> ({{ ucfirst($order->payment_status) }})
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Product Item</th>
          <th>Weight / Unit</th>
          <th>Price</th>
          <th>Qty</th>
          <th style="text-align: right;">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $idx => $item)
          <tr>
            <td>{{ $idx + 1 }}</td>
            <td><strong>{{ $item->product_name }}</strong></td>
            <td>{{ $item->weight }}</td>
            <td>₹{{ number_format($item->price, 2) }}</td>
            <td>{{ $item->quantity }}</td>
            <td style="text-align: right;">₹{{ number_format($item->subtotal, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="totals-wrap">
      <table class="totals-table">
        <tr>
          <td>Subtotal:</td>
          <td>₹{{ number_format($order->subtotal, 2) }}</td>
        </tr>
        @if($order->discount > 0)
          <tr style="color: #16a34a;">
            <td>Discount Coupon:</td>
            <td>- ₹{{ number_format($order->discount, 2) }}</td>
          </tr>
        @endif
        <tr>
          <td>Delivery Charge:</td>
          <td>{{ $order->delivery_charge == 0 ? 'FREE' : '₹' . number_format($order->delivery_charge, 2) }}</td>
        </tr>
        <tr class="grand-total">
          <td>Grand Total:</td>
          <td>₹{{ number_format($order->total, 2) }}</td>
        </tr>
      </table>
    </div>

    <div style="margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 16px; font-size: 12px; color: #64748b; text-align: center;">
      Thank you for shopping with Nayan Mart! For any queries, call 7550807912 or WhatsApp skrousonali2024@gmail.com.
    </div>
  </div>

</body>
</html>

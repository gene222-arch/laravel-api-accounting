<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Invoice number</th>
                <th>Order number</th>
                <th>Date</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Items</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Category</th>
                <th>Customer</th>
                <th>Customer email</th>
                <th>Customer tax number</th>
                <th>Customer phone</th>
                <th>Customer address</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td align="right">{{ $invoice->id }}</td>
                    <td align="center">{{ $invoice->invoice_number }}</td>
                    <td align="center">{{ $invoice->order_no }}</td>
                    <td align="center">{{ \Carbon\Carbon::parse($invoice->date)->format('d F Y') }}</td>
                    <td align="center">{{ \Carbon\Carbon::parse($invoice->due_date)->format('d F Y') }}</td>
                    <td align="center">{{ $invoice->status }}</td>
                    <td align="center">{{ $invoice->items()->count() }}</td>
                    <td align="right">{{ \number_format($invoice->items->map->pivot->map->amount->sum(), 2) }}</td>
                    <td align="center">{{ $invoice->currency->code }}</td>
                    <td align="center">{{ $invoice->incomeCategory->name }}</td>
                    <td align="center">{{ $invoice->customer->name }}</td>
                    <td align="center">{{ $invoice->customer->tax_number }}</td>
                    <td align="center">{{ $invoice->customer->phone }}</td>
                    <td align="center">{{ $invoice->customer->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
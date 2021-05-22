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
                <th>Bill number</th>
                <th>Order number</th>
                <th>Date</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Items</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Category</th>
                <th>Vendor</th>
                <th>Vendor email</th>
                <th>Vendor tax number</th>
                <th>Vendor phone</th>
                <th>Vendor address</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bills as $bill)
                <tr>
                    <td align="right">{{ $bill->id }}</td>
                    <td align="center">{{ $bill->bill_number }}</td>
                    <td align="center">{{ $bill->order_no }}</td>
                    <td align="center">{{ \Carbon\Carbon::parse($bill->date)->format('d F Y') }}</td>
                    <td align="center">{{ \Carbon\Carbon::parse($bill->due_date)->format('d F Y') }}</td>
                    <td align="center">{{ $bill->status }}</td>
                    <td align="center">{{ $bill->items()->count() }}</td>
                    <td align="right">{{ \number_format($bill->items->map->details->map->amount->sum(), 2) }}</td>
                    <td align="center">{{ $bill->currency->code }}</td>
                    <td align="center">{{ $bill->expenseCategory->name }}</td>
                    <td align="center">{{ $bill->vendor->name }}</td>
                    <td align="center">{{ $bill->vendor->tax_number }}</td>
                    <td align="center">{{ $bill->vendor->phone }}</td>
                    <td align="center">{{ $bill->vendor->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
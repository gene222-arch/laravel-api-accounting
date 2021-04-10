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
                <th>SKU</th>
                <th>Barcode</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Cost</th>
                <th>Sold by</th>
                <th>In stock</th>
                <th>Incoming stock</th>
                <th>Bad stock</th>
                <th>Stock in</th>
                <th>Stock out</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td align="right">{{ $transaction->id }}</td>
                    <td align="center">{{ $transaction->sku }}</td>
                    <td align="center">{{ $transaction->barcode }}</td>
                    <td align="center">{{ $transaction->name }}</td>
                    <td align="center">{{ $transaction->category->name }}</td>
                    <td align="right">{{ $transaction->price }}</td>
                    <td align="center">{{ $transaction->cost }}</td>
                    <td align="center">{{ $transaction->sold_by }}</td>
                    <td align="right">{{ $transaction->stock->in_stock }}</td>
                    <td align="right">{{ $transaction->stock->incoming_stock }}</td>
                    <td align="right">{{ $transaction->stock->bad_stock }}</td>
                    <td align="right">{{ $transaction->stock->stock_in }}</td>
                    <td align="right">{{ $transaction->stock->stock_out }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
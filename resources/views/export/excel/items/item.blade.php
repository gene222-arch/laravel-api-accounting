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
            @foreach ($items as $item)
                <tr>
                    <td align="right">{{ $item->id }}</td>
                    <td align="center">{{ $item->sku }}</td>
                    <td align="center">{{ $item->barcode }}</td>
                    <td align="center">{{ $item->name }}</td>
                    <td align="center">{{ $item->category->name }}</td>
                    <td align="right">{{ $item->price }}</td>
                    <td align="center">{{ $item->cost }}</td>
                    <td align="center">{{ $item->sold_by }}</td>
                    <td align="right">{{ $item->stock->in_stock }}</td>
                    <td align="right">{{ $item->stock->incoming_stock }}</td>
                    <td align="right">{{ $item->stock->bad_stock }}</td>
                    <td align="right">{{ $item->stock->stock_in }}</td>
                    <td align="right">{{ $item->stock->stock_out }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
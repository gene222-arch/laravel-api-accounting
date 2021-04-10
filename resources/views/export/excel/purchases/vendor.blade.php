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
                <th>Name</th>
                <th>Email</th>
                <th>Tax number</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Website</th>
                <th>Currency code</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendors as $vendor)
                <tr>
                    <td align="right">{{ $vendor->id }}</td>
                    <td align="center">{{ $vendor->name }}</td>
                    <td align="center">{{ $vendor->email }}</td>
                    <td align="center">{{ $vendor->tax_number }}</td>
                    <td align="right">{{ $vendor->phone }}</td>
                    <td align="center">{{ $vendor->address }}</td>
                    <td align="center">{{ $vendor->website }}</td>
                    <td align="right">{{ $vendor->currency->code }}</td>
                    <td align="center">{{ $vendor->reference }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
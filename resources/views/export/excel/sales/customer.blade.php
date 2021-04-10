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
            @foreach ($customers as $customer)
                <tr>
                    <td align="right">{{ $customer->id }}</td>
                    <td align="center">{{ $customer->name }}</td>
                    <td align="center">{{ $customer->email }}</td>
                    <td align="center">{{ $customer->tax_number }}</td>
                    <td align="right">{{ $customer->phone }}</td>
                    <td align="center">{{ $customer->address }}</td>
                    <td align="center">{{ $customer->website }}</td>
                    <td align="right">{{ $customer->currency->code }}</td>
                    <td align="center">{{ $customer->reference }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
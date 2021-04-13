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
                <th>Paid at</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Account</th>
                <th>Number</th>
                <th>Customer</th>
                <th>Customer email</th>
                <th>Category</th>
                <th>Description</th>
                <th>Payment method</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($revenues as $revenue)
                <tr>
                    <td align="right">{{ $revenue->id }}</td>
                    <td align="center">{{ \Carbon\Carbon::parse($revenue->date)->format('Y d M') }}</td>
                    <td align="center">{{ $revenue->amount }}</td>
                    <td align="center">{{ $revenue->currency->code }}</td>
                    <td align="center">{{ $revenue->account->name }}</td>
                    <td align="center">{{ $revenue->number }}</td>
                    <td align="right">{{ $revenue->customer->name }}</td>
                    <td align="center">{{ $revenue->customer->email }}</td>
                    <td align="center">{{ $revenue->incomeCategory->name }}</td>
                    <td align="center">{{ $revenue->description }}</td>
                    <td align="center">{{ $revenue->paymentMethod->name }}</td>
                    <td align="right">{{ $revenue->reference }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
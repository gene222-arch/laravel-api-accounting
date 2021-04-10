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
                <th>Transferred at</th>
                <th>Amount</th>
                <th>From currency code</th>
                <th>From Account</th>
                <th>To currency code</th>
                <th>To Account</th>
                <th>Description</th>
                <th>Payment method</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transfers as $transfer)
                <tr>
                    <td align="right">{{ $transfer->id }}</td>
                    <td align="center">{{ $transfer->amount }}</td>
                    <td align="center">{{ $transfer->from->currency->code }}</td>
                    <td align="center">{{ $transfer->from->name }}</td>
                    <td align="center">{{ $transfer->to->currency->code }}</td>
                    <td align="center">{{ $transfer->to->name }}</td>
                    <td align="center">{{ $transfer->description }}</td>
                    <td align="center">{{ $transfer->paymentMethod->name }}</td>
                    <td align="center">{{ $transfer->reference }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
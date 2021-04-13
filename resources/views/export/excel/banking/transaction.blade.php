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
                <th>Type</th>
                <th>Paid at</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Account</th>
                <th>Number</th>
                <th>Contact</th>
                <th>Category</th>
                <th>Description</th>
                <th>Payment method</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td align="right">{{ $transaction->id }}</td>
                    <td align="center">{{ $transaction->type }}</td>
                    <td align="center">{{ $transaction->amount }}</td>
                    <td align="center">{{ $transaction->currency->code }}</td>
                    <td align="center">{{ $transaction->account->name }}</td>
                    <td align="right">{{ $transaction->number }}</td>
                    <td align="center">{{ $transaction->contact }}</td>
                    <td align="center">{{ $transaction->category }}</td>
                    <td align="right">{{ $transaction->description }}</td>
                    <td align="right">{{ $transaction->paymentMethod->name }}</td>
                    <td align="right">{{ $transaction->reference }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
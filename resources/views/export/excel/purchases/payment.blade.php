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
                <th>Vendor</th>
                <th>Vendor email</th>
                <th>Category</th>
                <th>Description</th>
                <th>Payment method</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td align="right">{{ $payment->id }}</td>
                    <td align="center">{{ \Carbon\Carbon::parse($payment->date)->format('Y d M') }}</td>
                    <td align="center">{{ $payment->amount }}</td>
                    <td align="center">{{ $payment->currency->code }}</td>
                    <td align="center">{{ $payment->account->name }}</td>
                    <td align="center">{{ $payment->number }}</td>
                    <td align="right">{{ $payment->vendor->name }}</td>
                    <td align="center">{{ $payment->vendor->email }}</td>
                    <td align="center">{{ $payment->expenseCategory->name }}</td>
                    <td align="center">{{ $payment->description }}</td>
                    <td align="center">{{ $payment->paymentMethod->name }}</td>
                    <td align="right">{{ $payment->reference }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
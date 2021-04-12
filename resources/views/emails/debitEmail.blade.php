<!DOCTYPE html>
<html>
<head>
 <title>Debit Credit</title>
</head>
<body>

 <h1>Export Done Successfully</h1>
 <p>Amount Debited : {{ $deduct }}</p>
 <p>Remaining Credit : {{ $user->credit->balance }}</p>
 <p>Thank you {{ $user->email  }}</p>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Customer Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #3b82f6; color: white; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Customer Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>First</th>
                <th>Last</th>
                <th>Address</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Gender</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $index => $customer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $customer->cust_fname }}</td>
                <td>{{ $customer->cust_lname }}</td>
                <td>{{ $customer->address }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->contact_number }}</td>
                <td>{{ ucfirst($customer->gender) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Service Report {{ $report_date }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 4px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Service Report - {{ $report_date }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Queue Code</th>
                <th>Customer</th>
                <th>Service</th>
                <th>Status</th>
                <th>Queue Date</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $t)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ strtoupper($t->service->code ?? '') . $t->queue_number }}</td>
                <td>{{ $t->user->name ?? '-' }}</td>
                <td>{{ $t->service->name ?? '-' }}</td>
                <td>{{ ucfirst($t->status) }}</td>
                <td>{{ $t->queue_date }}</td>
                <td>{{ $t->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

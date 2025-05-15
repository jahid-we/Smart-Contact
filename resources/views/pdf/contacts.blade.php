<!DOCTYPE html>
<html>
<head>
   <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 11px;
    }

    .watermark {
        position: absolute;
        top: 40%;
        left: 10%;
        width: 80%;
        text-align: center;
        font-size: 50px;
        color: rgba(200, 0, 0, 0.05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 5px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
</style>
</head>
<body>

    <!-- 👇 Watermark displaying your app name from .env -->
    <div class="watermark">{{ config('app.name') }}</div>

    <!-- Your report content -->
    <h2>{{ config('app.name') }} - Contacts Report</h2>
    <p>Generated at: {{ \Carbon\Carbon::now()->format('F d, Y h:i A') }}</p>

    <table>
        <thead>
            <tr>
                <th>Name</th><th>Phone</th><th>Email</th><th>Address</th><th>Nationality</th><th>Gender</th><th>DOB</th><th>Designation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->phone }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->address }}</td>
                <td>{{ $contact->nationality }}</td>
                <td>{{ $contact->gender }}</td>
                <td>{{ $contact->dob }}</td>
                <td>{{ $contact->designation }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

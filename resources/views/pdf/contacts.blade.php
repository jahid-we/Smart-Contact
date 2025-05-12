<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            position: relative;
        }

        .watermark {
            position: fixed;
            top: 35%;
            left: 10%;
            width: 90%;
            text-align: center;
            font-size: 60px;
            color: rgba(230, 0, 0, 0.07);
            transform: rotate(-30deg);
            z-index: -1;
            pointer-events: none;
        }

        /* Example styles for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f3f3f3;
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

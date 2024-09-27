<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Race Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }
        .container {
            margin: 20px;
        }
        .race-info, .race-results {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Race Results</h1>
        <div class="race-info">
            <h2>Students</h2>
            <ul>
                @foreach ($race['students'] as $student)
                    <li>{{ $student['name'] }} (Lane: {{ $student['lane'] }})</li>
                @endforeach
            </ul>
        </div>

        <div class="race-results">
            <h2>Results</h2>
            @if (!empty($race['results']))
                <table>
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Result (Place)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($race['results'] as $student => $result)
                            <tr>
                                <td>{{ $student }}</td>
                                <td>{{ $result }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No results available.</p>
            @endif
        </div>
    </div>
</body>
</html>
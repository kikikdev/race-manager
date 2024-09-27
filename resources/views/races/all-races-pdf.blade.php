<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Races Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }
        .container {
            margin: 20px;
        }
        .race-section {
            margin-bottom: 40px;
        }
        .race-info, .race-results {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>All Races Results</h1>

        @foreach ($races as $index => $race)
            <div class="race-section">
                <h2>Race #{{ $index + 1 }}</h2>
                <div class="race-info">
                    <h3>Students</h3>
                    <ul>
                        @foreach ($race['students'] as $student)
                            <li>{{ $student['name'] }} (Lane: {{ $student['lane'] }})</li>
                        @endforeach
                    </ul>
                </div>

                <div class="race-results">
                    <h3>Results</h3>
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
        @endforeach
    </div>
</body>
</html>
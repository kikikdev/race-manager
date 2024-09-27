@extends('adminlte::page')

@section('title', 'Race List')

@section('content_header')
    <h1>Race List</h1>
@endsection

@section('content')
    <div class="container">
    <h1>Races</h1>
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ url('races/create') }}" class="btn btn-success">Create Races</a>
            <a href="{{ route('races.export-pdf') }}" class="btn btn-info">Download All Races PDF</a>
        </div>
        <br>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (is_array($races) && count($races) > 0)
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Students</th>
                        <th>Results</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($races as $index => $race)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach ($race['students'] as $student)
                                        <li>{{ $student['name'] }} (Lane: {{ $student['lane'] }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                @if (!empty($race['results']))
                                    @php
                                        asort($race['results']);
                                    @endphp
                                    <ul class="list-unstyled">
                                        @foreach ($race['results'] as $student => $result)
                                            <li><strong>{{ $student }}:</strong> Place {{ $result }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="badge badge-warning">Results not available</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('races.edit', $index) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('races.download-pdf', $index) }}" class="btn btn-sm btn-success">Download PDF</a>
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $index }})">Delete</button>
                                <form id="delete-form-{{ $index }}" action="{{ route('races.destroy', $index) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                No races found.
            </div>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{ asset('vendor/adminlte/dist/js/sweetalert.js') }}"></script>
    <script>
        function confirmDelete(index) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + index).submit();
                }
            })
        }
    </script>
@endsection
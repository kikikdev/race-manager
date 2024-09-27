@extends('adminlte::page')

@section('title', 'Submit Results')

@section('content_header')
    <h1>Submit Race Results</h1>
@endsection

@section('content')
    <form action="{{ route('races.update', $raceId) }}" method="POST" id="resultsForm">
        @csrf
        
        <div class="form-group">
            <label for="students">Edit Lane Assignments and Results:</label>
            <div class="input-group mb-2 student-input">
                <label for="students" class="form-control font-weight-bold" style="background-color: #f4f6f9;border: 0px;">Student Name:</label>
                <label for="lane" class="form-control font-weight-bold ml-2" style="background-color: #f4f6f9;border: 0px;">Lane:</label>
                <label for="result" class="form-control font-weight-bold ml-2" style="background-color: #f4f6f9;border: 0px;">Result Place:</label>
            </div>
            
            @foreach ($race['students'] as $student)
                <div class="input-group mb-2 student-input">
                    <input type="text" name="students[]" class="form-control student-name" value="{{ $student['name'] }}" disabled>
                    <input type="number" name="lane_{{ $student['name'] }}" class="form-control ml-2" placeholder="Lane" value="{{ $student['lane'] }}" required readonly>
                    <input type="number" name="{{ $student['name'] }}" class="form-control ml-2 race-place" placeholder="Result (Place)" value="{{ $race['results'][$student['name']] ?? '' }}" required autocomplete="off">
                </div>
            @endforeach
        </div>

        <div class="alert alert-danger d-none" id="errorMessage">
            Each student must have a unique place.
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Submit Results</button>
            <a href="{{ url('races') }}" class="btn btn-danger">Cancel</a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const resultsForm = document.getElementById('resultsForm');
            const errorMessage = document.getElementById('errorMessage');

            function hasDuplicatePlaces() {
                const places = Array.from(document.querySelectorAll('.race-place')).map(input => input.value.trim());
                const uniquePlaces = new Set(places);
                return uniquePlaces.size !== places.length;
            }

            resultsForm.addEventListener('submit', function(event) {
                if (hasDuplicatePlaces()) {
                    errorMessage.classList.remove('d-none');
                    event.preventDefault();
                } else {
                    errorMessage.classList.add('d-none');
                }
            });
        });
    </script>
@endsection
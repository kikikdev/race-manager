@extends('adminlte::page')

@section('title', 'Create Race')

@section('content_header')
    <h1>Create a New Race</h1>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('races.store') }}" method="POST" id="raceForm">
            @csrf
            <div class="form-group">
                <label for="students">Students (Enter student names and lane):</label>
                <div id="studentInputs">
                    <div class="input-group mb-2 student-input">
                        <input type="text" name="students[]" class="form-control student-name" placeholder="Student Name" required>
                        <input type="number" name="lanes[]" class="form-control ml-2" placeholder="Lane" min="1" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger remove-student-btn" disabled>&times;</button>
                        </div>
                    </div>
                    <div class="input-group mb-2 student-input">
                        <input type="text" name="students[]" class="form-control student-name" placeholder="Student Name" required>
                        <input type="number" name="lanes[]" class="form-control ml-2" placeholder="Lane" min="1" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger remove-student-btn" disabled>&times;</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary mt-2" id="addStudentBtn">Add Another Student</button>
            </div>

            <div class="alert alert-danger d-none" id="errorMessage">
                Duplicate student names or lanes are not allowed.
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Create Race</button>
                <a href="{{ url('races') }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const studentInputs = document.getElementById('studentInputs');
            const addStudentBtn = document.getElementById('addStudentBtn');
            const errorMessage = document.getElementById('errorMessage');
            const raceForm = document.getElementById('raceForm');

            function updateRemoveButtons() {
                const studentCount = studentInputs.querySelectorAll('.student-input').length;
                const removeButtons = studentInputs.querySelectorAll('.remove-student-btn');

                removeButtons.forEach(button => {
                    button.disabled = studentCount <= 2;
                });
            }

            function hasDuplicateNamesOrLanes() {
                const studentNames = Array.from(document.querySelectorAll('.student-name')).map(input => input.value.trim().toLowerCase());
                const lanes = Array.from(document.querySelectorAll('input[name="lanes[]"]')).map(input => input.value.trim());
                const uniqueNames = new Set(studentNames);
                const uniqueLanes = new Set(lanes);
                return uniqueNames.size !== studentNames.length || uniqueLanes.size !== lanes.length;
            }

            addStudentBtn.addEventListener('click', function() {
                if (hasDuplicateNamesOrLanes()) {
                    errorMessage.classList.remove('d-none');
                } else {
                    errorMessage.classList.add('d-none');
                    const newStudentInput = document.createElement('div');
                    newStudentInput.classList.add('input-group', 'mb-2', 'student-input');
                    newStudentInput.innerHTML = `
                        <input type="text" name="students[]" class="form-control student-name" placeholder="Student Name" required>
                        <input type="number" name="lanes[]" class="form-control ml-2" placeholder="Lane" min="1" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger remove-student-btn">&times;</button>
                        </div>
                    `;
                    studentInputs.appendChild(newStudentInput);
                    updateRemoveButtons();
                }
            });

            studentInputs.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-student-btn')) {
                    const studentCount = studentInputs.querySelectorAll('.student-input').length;
                    if (studentCount > 2) {
                        event.target.closest('.student-input').remove();
                    }
                    updateRemoveButtons();
                }
            });

            raceForm.addEventListener('submit', function(event) {
                if (hasDuplicateNamesOrLanes()) {
                    errorMessage.classList.remove('d-none');
                    event.preventDefault();
                } else {
                    errorMessage.classList.add('d-none');
                }
            });

            updateRemoveButtons();
        });
    </script>
@endsection
@extends('layout')

@php
    $subjects = App\Models\Subject::all();
@endphp

@section('head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5">

    <!-- Display user's email and username -->
    @if(Auth::user()->user_type == 1)
    <h2 class="text-center mt-5">User Information</h2>
    <table class="table table-striped table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Is Active</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ Auth::user()->name }}</td>
                <td>{{ Auth::user()->email }}</td>
                <td>
                    @if(Auth::user()->user_active == 1)
                        <span class="text-success">&#9679; Active</span>
                    @else
                        <span class="text-danger">&#9679; Inactive</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @endif

    @if(auth::user()->user_type == 1)
    <!-- Display subjects and grades for the logged-in user -->
    <h2 class="text-center mt-5">Subjects and Grades</h2>
    <table class="table table-striped table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>Subject Name</th>
                <th>Pass Grade</th>
                <th>User Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach(Auth::user()->userSubjects as $userSubject)
            <tr>
                <td>{{ $userSubject->subject->subject_name }}</td>
                <td>{{ $userSubject->subject->pass_grade }}</td>
                <td>{{ $userSubject->user_grade }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Display students' subjects and grades if user is admin -->
    @if(Auth::user()->user_type == 2)
        <h2 class="text-center mt-5">All Students</h2>
        <button class="btn btn-success mb-3" onclick="openAddStudentModal()">Add Student</button>
        <button class="btn btn-primary mb-3" onclick="openAddSubjectModal()">Add Subject</button>
        <table class="table table-striped table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Student Name</th>
                    <th>Is Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>
                        @if($student->user_active == 1)
                            <span class="text-success">&#9679; Active</span>
                        @else
                            <span class="text-danger">&#9679; Inactive</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-primary" onclick="openEditModal({{ $student->id }})">Edit</button>
                        <button class="btn btn-danger" onclick="openDeleteModal({{ $student->id }})">Delete</button>
                        <button class="btn btn-secondary" onclick="openAssignSubjectModal({{ $student->id }})">Assign Subject</button>
                        <form id="delete-form-{{ $student->id }}" action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStudentForm" method="POST" action="{{ route('students.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="newStudentName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="newStudentName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="newStudentEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="newStudentEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="newStudentPassword" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newStudentPassword" name="password" required>
                            <span class="input-group-text" id="toggleNewStudentPassword">
                                <i class="bi bi-eye" id="toggleNewStudentPasswordIcon"></i>
                            </span>
                        </div>
                        <div id="newStudentPasswordHelp" class="form-text">
                            Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.
                        </div>
                        <div id="newStudentPasswordError" class="form-text text-danger" style="display: none;">Password does not meet the required criteria.</div>
                    </div>
                    <div class="mb-3">
                        <label for="newStudentPasswordConfirmation" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newStudentPasswordConfirmation" name="password_confirmation" required>
                            <span class="input-group-text" id="toggleNewStudentPasswordConfirmation">
                                <i class="bi bi-eye" id="toggleNewStudentPasswordConfirmationIcon"></i>
                            </span>
                        </div>
                        <div id="newStudentRepeatPasswordError" class="form-text text-danger" style="display: none;">Passwords do not match.</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Student</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubjectModalLabel">Add Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addSubjectForm" method="POST" action="{{ route('subjects.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="subjectName" class="form-label">Subject Name</label>
                        <input type="text" class="form-control" id="subjectName" name="subject_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="passGrade" class="form-label">Pass Grade</label>
                        <input type="number" class="form-control" id="passGrade" name="pass_grade" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Subject</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Assign Subject Modal -->
<div class="modal fade" id="assignSubjectModal" tabindex="-1" aria-labelledby="assignSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignSubjectModalLabel">Assign Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignSubjectForm" method="POST" action="{{ route('userSubjects.store') }}">
                    @csrf
                    <input type="hidden" id="assignStudentId" name="student_id">
                    <div class="mb-3">
                        <label for="subjectId" class="form-label">Subject</label>
                        <select class="form-control" id="subjectId" name="subject_id" required>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="userGrade" class="form-label">User Grade</label>
                        <input type="number" class="form-control" id="userGrade" name="user_grade" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Assign Subject</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="studentName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="studentEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="studentEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="studentIsActive" class="form-label">Is Active</label>
                        <button type="button" id="studentIsActiveButton" class="btn btn-outline-secondary" onclick="toggleActiveStatus()">
                            <span id="activeStatusDot" class="text-success">&#9679;</span> <span id="activeStatusText">Active</span>
                        </button>
                        <input type="hidden" id="studentIsActive" name="user_active" value="1">
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
function openAddStudentModal() {
    new bootstrap.Modal(document.getElementById('addStudentModal')).show();
}

function openAddSubjectModal() {
    new bootstrap.Modal(document.getElementById('addSubjectModal')).show();
}

function openAssignSubjectModal(studentId) {
    document.getElementById('assignStudentId').value = studentId;
    new bootstrap.Modal(document.getElementById('assignSubjectModal')).show();
}

function openEditModal(studentId) {
    // Fetch student data and populate the form
    fetch(`/students/${studentId}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('studentName').value = data.name;
            document.getElementById('studentEmail').value = data.email;
            document.getElementById('studentIsActive').value = data.user_active ? 1 : 0;
            document.getElementById('activeStatusDot').className = data.user_active ? 'text-success' : 'text-danger';
            document.getElementById('activeStatusText').textContent = data.user_active ? 'Active' : 'Inactive';
            document.getElementById('editForm').action = `/students/${studentId}`;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        })
        .catch(error => console.error('Error:', error));
}

function toggleActiveStatus() {
    const activeStatusDot = document.getElementById('activeStatusDot');
    const activeStatusText = document.getElementById('activeStatusText');
    const studentIsActive = document.getElementById('studentIsActive');

    if (studentIsActive.value == 1) {
        activeStatusDot.classList.remove('text-success');
        activeStatusDot.classList.add('text-danger');
        activeStatusText.textContent = 'Inactive';
        studentIsActive.value = 0;
    } else {
        activeStatusDot.classList.remove('text-danger');
        activeStatusDot.classList.add('text-success');
        activeStatusText.textContent = 'Active';
        studentIsActive.value = 1;
    }
}

function openDeleteModal(studentId) {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.getElementById('confirmDeleteButton').onclick = function() {
        document.getElementById(`delete-form-${studentId}`).submit();
    };
    deleteModal.show();
}

document.getElementById('addStudentForm').addEventListener('submit', function(event) {
    var password = document.getElementById('newStudentPassword').value;
    var repeatPassword = document.getElementById('newStudentPasswordConfirmation').value;
    var passwordError = document.getElementById('newStudentPasswordError');
    var repeatPasswordError = document.getElementById('newStudentRepeatPasswordError');
    var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (password !== repeatPassword) {
        event.preventDefault();
        repeatPasswordError.style.display = 'block';
    } else {
        repeatPasswordError.style.display = 'none';
    }

    if (!passwordPattern.test(password)) {
        event.preventDefault();
        passwordError.style.display = 'block';
    } else {
        passwordError.style.display = 'none';
    }
});

document.getElementById('toggleNewStudentPassword').addEventListener('click', function() {
    var passwordField = document.getElementById('newStudentPassword');
    var passwordIcon = document.getElementById('toggleNewStudentPasswordIcon');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordIcon.classList.remove('bi-eye');
        passwordIcon.classList.add('bi-eye-slash');
    } else {
        passwordField.type = 'password';
        passwordIcon.classList.remove('bi-eye-slash');
        passwordIcon.classList.add('bi-eye');
    }
});

document.getElementById('toggleNewStudentPasswordConfirmation').addEventListener('click', function() {
    var repeatPasswordField = document.getElementById('newStudentPasswordConfirmation');
    var repeatPasswordIcon = document.getElementById('toggleNewStudentPasswordConfirmationIcon');
    if (repeatPasswordField.type === 'password') {
        repeatPasswordField.type = 'text';
        repeatPasswordIcon.classList.remove('bi-eye');
        repeatPasswordIcon.classList.add('bi-eye-slash');
    } else {
        repeatPasswordField.type = 'password';
        repeatPasswordIcon.classList.remove('bi-eye-slash');
        repeatPasswordIcon.classList.add('bi-eye');
    }
});
</script>
@endsection
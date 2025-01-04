@extends('layout')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
@endsection

@php
    $subjects = App\Models\Subject::all();
@endphp

@section('content')
<div class="container mt-5">

    <!-- Display user's email and username -->
    @if(Auth::user()->user_type == 1)
    <h2 class="text-center mt-5">User Information</h2>
    <div id="userInfoLoading" class="text-center">
        <i class="bi bi-arrow-repeat loading-icon"></i> Loading...
    </div>
    <table class="table table-striped table-hover mt-3" style="display: none;">
        <thead class="table-dark">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Is Active</th>
            </tr>
        </thead>
        <tbody id="userInfoTableBody">
            <!-- User info will be populated via AJAX -->
        </tbody>
    </table>
    @endif

    @if(auth::user()->user_type == 1)
    <!-- Display subjects and grades for the logged-in user -->
    <h2 class="text-center mt-5">Subjects and Grades</h2>
    <div id="subjectsLoading" class="text-center">
        <i class="bi bi-arrow-repeat loading-icon"></i> Loading...
    </div>
    <table class="table table-striped table-hover mt-3" style="display: none;">
        <thead class="table-dark">
            <tr>
                <th>Subject Name</th>
                <th>Pass Grade</th>
                <th>Student Grade</th>
            </tr>
        </thead>
        <tbody id="subjectsTableBody">
            <!-- Subjects and grades will be populated via AJAX -->
        </tbody>
    </table>

    <h6 class="text-center mt-5 mb-5 p-3 bg-light border rounded shadow-sm position-relative celebratory-message">
        Your effort is what matters the most. Whether it’s a high grade or a low one, let’s use this as a learning opportunity.
        <span class="emoji">🎉 Hover over me!</span>
    </h6>

    <style>
        
    </style>

    <script>
        document.querySelector('.celebratory-message').addEventListener('mouseover', function() {
            const emojis = ['🎉', '🎊', '✨', '🎈', '🥳'];
            const emojiCount = 5;
            const particleCount = 50;
            const colors = ['red', 'green', 'blue', 'purple', 'orange'];

            for (let i = 0; i < emojiCount; i++) {
                const emoji = document.createElement('span');
                emoji.classList.add('emoji');
                emoji.textContent = emojis[Math.floor(Math.random() * emojis.length)];
                emoji.style.left = `${Math.random() * 100}%`;
                this.appendChild(emoji);
            }

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle', colors[Math.floor(Math.random() * colors.length)]);
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.animationDelay = `${Math.random()}s`;
                this.appendChild(particle);
            }

            setTimeout(() => {
                document.querySelectorAll('.emoji').forEach(e => e.remove());
                document.querySelectorAll('.particle').forEach(p => p.remove());
            }, 2000);
        });

        $(document).ready(function() {
            if ({{ Auth::user()->user_type }} == 1) {
                fetchUserInfo();
                fetchUserSubjects();
            }
        });

        function fetchUserInfo() {
            $.ajax({
                url: '{{ route("user.info") }}',
                method: 'GET',
                success: function(data) {
                    let userInfoTableBody = `
                        <tr>
                            <td>${data.name}</td>
                            <td>${data.email}</td>
                            <td>
                                ${data.user_active == 1 ? '<span class="text-success">&#9679; Active</span>' : '<span class="text-danger">&#9679; Inactive</span>'}
                            </td>
                        </tr>
                    `;
                    $('#userInfoTableBody').html(userInfoTableBody);
                    $('#userInfoLoading').hide();
                    $('#userInfoTableBody').closest('table').show();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function fetchUserSubjects() {
            $.ajax({
                url: '{{ route("user.subjects") }}',
                method: 'GET',
                success: function(data) {
                    let subjectsTableBody = '';
                    data.forEach(userSubject => {
                        subjectsTableBody += `
                            <tr>
                                <td>${userSubject.subject.subject_name}</td>
                                <td>${userSubject.subject.pass_grade}</td>
                                <td>${userSubject.user_grade}</td>
                            </tr>
                        `;
                    });
                    $('#subjectsTableBody').html(subjectsTableBody);
                    $('#subjectsLoading').hide();
                    $('#subjectsTableBody').closest('table').show();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
    @endif

    <!-- Display students' subjects and grades if user is admin -->
    @if(Auth::user()->user_type == 2)
        <h2 class="text-center mt-5">All Students</h2>
        <button class="btn btn-success mb-3" onclick="openAddStudentModal()">
            <i class="bi bi-person-plus"></i> Add Student
        </button>
        <button class="btn btn-primary mb-3" onclick="openAddSubjectModal()">
            <i class="bi bi-book"></i> Add Subject
        </button>
        <div id="studentsLoading" class="text-center">
            <i class="bi bi-arrow-repeat loading-icon"></i> Loading...
        </div>
        <table class="table table-striped table-hover mt-3" style="display: none;">
            <thead class="table-dark">
                <tr>
                    <th>Student Name</th>
                    <th>Is Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="studentsTableBody">
                <!-- Student rows will be populated via AJAX -->
            </tbody>
        </table>
    @endif
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-none">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">
                    <i class="bi bi-person-plus"></i> Add Student
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStudentForm" method="POST" action="{{ route('students.store') }}" class="shadow-none">
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
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus"></i> Add Student
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-none">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubjectModalLabel">
                    <i class="bi bi-book"></i> Add Subject
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addSubjectForm" method="POST" action="{{ route('subjects.store') }}" class="shadow-none">
                    @csrf
                    <div class="mb-3">
                        <label for="subjectName" class="form-label">Subject Name</label>
                        <input type="text" class="form-control" id="subjectName" name="subject_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="passGrade" class="form-label">Pass Grade</label>
                        <input type="number" class="form-control" id="passGrade" name="pass_grade" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-book"></i> Add Subject
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Assign Subject Modal -->
<div class="modal fade" id="assignSubjectModal" tabindex="-1" aria-labelledby="assignSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-none">
            <div class="modal-header">
                <h5 class="modal-title" id="assignSubjectModalLabel">
                    <i class="bi bi-plus-circle"></i> Assign Subject
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignSubjectForm" method="POST" action="{{ route('userSubjects.storeWithoutGrade') }}" class="shadow-none">
                    @csrf
                    <input type="hidden" id="assignStudentId" name="student_id">
                    <div class="mb-3">
                        <label for="subjectId" class="form-label">Subject</label>
                        <select class="form-control" id="subjectId" name="subject_id" required>
                            <!-- Options will be populated via AJAX -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Assign Subject
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Grade Modal -->
<div class="modal fade" id="updateGradeModal" tabindex="-1" aria-labelledby="updateGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-none">
            <div class="modal-header">
                <h5 class="modal-title" id="updateGradeModalLabel">
                    <i class="bi bi-bar-chart"></i> Update Grades
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Subject Name</th>
                            <th>Pass Grade</th>
                            <th>User Grade</th>
                        </tr>
                    </thead>
                    <tbody id="studentSubjectsTableBody">
                        <!-- Subject rows will be populated via AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="updateAllGrades()">
                    <i class="bi bi-arrow-repeat"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-none">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="bi bi-pencil"></i> Edit Student
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" class="shadow-none">
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
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Save changes
                    </button>
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
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-trash"></i> Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    if ({{ Auth::user()->user_type }} == 2) {
        refreshStudentsTable();
    }

    // Set initial background color based on active status
    const studentIsActive = $('#studentIsActive').val();
    const studentIsActiveButton = $('#studentIsActiveButton');
    if (studentIsActive == 1) {
        studentIsActiveButton.addClass('custom-active');
    } else {
        studentIsActiveButton.addClass('custom-inactive');
    }
});

function openAddStudentModal() {
    new bootstrap.Modal(document.getElementById('addStudentModal')).show();
}

function openAddSubjectModal() {
    new bootstrap.Modal(document.getElementById('addSubjectModal')).show();
}

function openAssignSubjectModal(studentId) {
    document.getElementById('assignStudentId').value = studentId;
    getSubjects();
    new bootstrap.Modal(document.getElementById('assignSubjectModal')).show();
}

function getSubjects() {
    const studentId = document.getElementById('assignStudentId').value;
    $.ajax({
        url: `/students/${studentId}/available-subjects`,
        method: 'GET',
        success: function(data) {
            let subjectOptions = '';
            data.forEach(subject => {
                subjectOptions += `<option value="${subject.id}">${subject.subject_name}</option>`;
            });
            $('#subjectId').html(subjectOptions);
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
}

function openUpdateGradeModal(studentId) {
    $.ajax({
        url: `/students/${studentId}/subjects`,
        method: 'GET',
        success: function(data) {
            let subjectsTableBody = '';
            data.forEach(subject => {
                subjectsTableBody += `
                    <tr>
                        <td>${subject.subject.subject_name}</td>
                        <td>${subject.subject.pass_grade}</td>
                        <td>
                            <input type="number" class="form-control" id="newGrade-${subject.subject_id}" value="${subject.user_grade}">
                        </td>
                    </tr>
                `;
            });
            $('#studentSubjectsTableBody').html(subjectsTableBody);
            $('#updateGradeModal').data('studentId', studentId);
            new bootstrap.Modal(document.getElementById('updateGradeModal')).show();
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
}

function updateAllGrades() {
    const studentId = $('#updateGradeModal').data('studentId');
    const grades = [];

    $('#studentSubjectsTableBody tr').each(function() {
        const subjectId = $(this).find('input').attr('id').split('-')[1];
        const userGrade = $(this).find('input').val();
        grades.push({ subject_id: subjectId, user_grade: userGrade });
    });

    grades.forEach(grade => {
        $.ajax({
            url: `/students/${studentId}/subjects/${grade.subject_id}`,
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({
                user_grade: grade.user_grade,
                _token: $('meta[name="csrf-token"]').attr('content')
            }),
            success: function(data) {
                console.log(`Grade for subject ${grade.subject_id} updated successfully.`);
            },
            error: function(error) {
                console.error(`Error updating grade for subject ${grade.subject_id}:`, error);
                if (error.responseJSON && error.responseJSON.errors) {
                    console.error('Validation errors:', error.responseJSON.errors);
                    alert('Validation errors: ' + JSON.stringify(error.responseJSON.errors));
                }
            }
        });
    });

    $('#updateGradeModal').modal('hide');
}

function openEditModal(studentId) {
    // Fetch student data and populate the form
    $.ajax({
        url: `/students/${studentId}/edit`,
        method: 'GET',
        success: function(data) {
            $('#studentName').val(data.name);
            $('#studentEmail').val(data.email);
            $('#studentIsActive').val(data.user_active ? 1 : 0);
            $('#activeStatusDot').attr('class', data.user_active ? 'text-success' : 'text-danger');
            $('#activeStatusText').text(data.user_active ? 'Active' : 'Inactive');
            $('#editForm').attr('action', `/students/${studentId}`);
            $('#studentIsActive').data('studentId', studentId); // Ensure studentId is set
            new bootstrap.Modal(document.getElementById('editModal')).show();
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
}

function toggleActiveStatus() {
    const activeStatusDot = $('#activeStatusDot');
    const activeStatusText = $('#activeStatusText');
    const studentIsActive = $('#studentIsActive');
    const studentIsActiveButton = $('#studentIsActiveButton');

    const newStatus = studentIsActive.val() == 1 ? 0 : 1;
    if (newStatus == 1) {
        activeStatusDot.removeClass('text-danger').addClass('text-success');
        activeStatusText.text('Active');
        studentIsActiveButton.removeClass('custom-inactive').addClass('custom-active');
    } else {
        activeStatusDot.removeClass('text-success').addClass('text-danger');
        activeStatusText.text('Inactive');
        studentIsActiveButton.removeClass('custom-active').addClass('custom-inactive');
    }
    studentIsActive.val(newStatus);
}

document.getElementById('editForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: this.action,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            $('#editModal').modal('hide');
            refreshStudentsTable();
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
});

function openDeleteModal(studentId) {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    $('#confirmDeleteButton').off('click').on('click', function() {
        $.ajax({
            url: `/students/${studentId}`,
            method: 'DELETE',
            success: function(data) {
                deleteModal.hide();
                refreshStudentsTable();
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
    deleteModal.show();
}

function refreshStudentsTable() {
    $.ajax({
        url: '{{ route("students.index") }}',
        method: 'GET',
        success: function(data) {
            let studentsTableBody = '';
            data.forEach(student => {
                studentsTableBody += `
                    <tr>
                        <td>${student.name}</td>
                        <td>
                            ${student.user_active == 1 ? '<span class="text-success">&#9679; Active</span>' : '<span class="text-danger">&#9679; Inactive</span>'}
                        </td>
                        <td>
                            <button class="btn btn-primary" onclick="openEditModal(${student.id})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-danger" onclick="openDeleteModal(${student.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                            <button class="btn btn-secondary" onclick="openAssignSubjectModal(${student.id})">
                                <i class="bi bi-plus-circle"></i> Assign Subject
                            </button>
                            <button class="btn btn-info" onclick="openUpdateGradeModal(${student.id})">
                                <i class="bi bi-bar-chart"></i> Grades
                            </button>
                            <form id="delete-form-${student.id}" action="/students/${student.id}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                `;
            });
            $('#studentsTableBody').html(studentsTableBody);
            $('#studentsLoading').hide();
            $('#studentsTableBody').closest('table').show();
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
}

document.getElementById('addStudentForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);
    var password = document.getElementById('newStudentPassword').value;
    var repeatPassword = document.getElementById('newStudentPasswordConfirmation').value;
    var passwordError = document.getElementById('newStudentPasswordError');
    var repeatPasswordError = document.getElementById('newStudentRepeatPasswordError');
    var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (password !== repeatPassword) {
        repeatPasswordError.style.display = 'block';
        return;
    } else {
        repeatPasswordError.style.display = 'none';
    }

    if (!passwordPattern.test(password)) {
        passwordError.style.display = 'block';
        return;
    } else {
        passwordError.style.display = 'none';
    }

    $.ajax({
        url: '{{ route("students.store") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            $('#addStudentModal').modal('hide');
            refreshStudentsTable();
            refreshSubjectsForUser(data.student.id);
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
});

function refreshSubjectsForUser(studentId) {
    $.ajax({
        url: `/students/${studentId}/subjects`,
        method: 'GET',
        success: function(data) {
            let subjectsTableBody = '';
            data.forEach(subject => {
                subjectsTableBody += `
                    <tr>
                        <td>${subject.subject.subject_name}</td>
                        <td>${subject.subject.pass_grade}</td>
                        <td>${subject.user_grade}</td>
                    </tr>
                `;
            });
            $('#studentSubjectsTableBody').html(subjectsTableBody);
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
}

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

document.getElementById('addSubjectForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: '{{ route("subjects.store") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            $('#addSubjectModal').modal('hide');
            // Optionally refresh the subjects list or perform other actions
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
});
</script>

<style>
    .btn-outline-secondary.custom-active {
        border-color: transparent;
        background-color: rgba(0, 255, 0, 0.1); /* Hint of green */
    }

    .btn-outline-secondary.custom-active:hover {
        border-color: transparent;
        background-color: rgba(0, 255, 0, 0.2); /* Slightly more green on hover */
    }

    .btn-outline-secondary.custom-inactive {
        border-color: transparent;
        background-color: rgba(255, 0, 0, 0.1); /* Hint of pink */
    }

    .btn-outline-secondary.custom-inactive:hover {
        border-color: transparent;
        background-color: rgba(255, 0, 0, 0.2); /* Slightly more pink on hover */
    }
</style>
@endsection
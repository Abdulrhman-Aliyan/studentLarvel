@extends('layout')

@section('head')
    <title>Courses</title>
    <link rel="stylesheet" href="{{ asset('css/courses.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
@endsection

@section('content')

    <section class="landing-section">
        <div class="container d-flex h-100">
            <!-- Content for the static section -->
            <div class="flex-grow-1 d-flex flex-column justify-content-center w-50">
                <div class="flex-grow-1">
                    <h1 class="fw-bold" style="font-size: 5rem">Lets learn togther for better <span style="color: #ff7500;">Future</span></h1>
                </div>
                <div class="flex-grow-1">
                    <h2 class="fw-light text-muted text-opacity-75">Start your learning journey with our courses for every subject and for every level.</h2>
                </div>
                <div class="flex-grow-1">
                    <a href="#" class="btn btn-primary rounded-pill px-4 py-3">get started</a>
                </div>
            </div>
            <div class="flex-grow-1 w-50 d-none d-md-block ">
                <div class="image-background">
                    <img class="w-100" src="{{ asset('assets/school-girl.png') }}" alt="School Girl">
                </div>
            </div>
        </div>
    </section>

    <section class="services">
        <div class="container h-100">
            <div class="d-flex justify-content-center align-items-center py-4 flex-wrap h-100">

                <div class="card m-4 pt-0 pb-4">
                    <div class="card-body">
                        <div class="icon mb-2 mx-0 aligen-items-center text-center">
                            <i class="bi bi-chat-left-dots"></i>
                        </div>
                        <h5 class="card-title mb-2 mx-0">Live Chat</h5>
                        <p class="card-text fw-normal">Engage in discussions with peers and instructors.</p>
                    </div>
                </div>

                <div class="card m-4 pt-0 pb-4">
                    <div class="card-body">
                        <div class="icon mb-2 mx-0 aligen-items-center text-center">
                            <i class="bi bi-file-text"></i>
                        </div>
                        <h5 class="card-title mb-2 mx-0">Examination</h5>
                        <p class="card-text fw-normal">Take exams to evaluate your knowledge and progress.</p>
                    </div>
                </div>

                <div class="card m-4 pt-0 pb-4">
                    <div class="card-body">
                        <div class="icon mb-2 mx-0 aligen-items-center text-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <h5 class="card-title mb-2 mx-0">Competition</h5>
                        <p class="card-text fw-normal">Participate in various competitions to test your skills.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="top-categories">
        <div class="container">
            <button class="course-arrow-btn left">
                <i class="bi bi-chevron-left"></i>
            </button>
            
            <button class="course-arrow-btn right">
                <i class="bi bi-chevron-right"></i>
            </button>

            <div class="d-flex flex-column h-100">
                <div class="mb-4">
                    <h2 class="fw-bold d-flex justify-content-center ">Top Cartegories</h2> 
                </div>
                <div class="see-all m-2 text-end">
                    <a href="#"><h4 class="fw-lighter">See all</h4></a>
                </div>
                <div id="courses-list" class=" d-flex flex-row row">
                    <!-- Top cartegory cards is here -->
                </div>
            </div>
        </div>
        <div>
            <!-- Content for the top categories cards with images -->
        </div>
    </section>

    <section class="filler-section">
            <div class="container d-flex h-100">
                <!-- Content for the static section -->
                <div class="flex-grow-1 w-50 d-none d-md-block ">
                    <div class="image-background">
                        <div class="card info-card d-flex flex-col">
                            <div class="icon mb-2 mx-0 aligen-items-center text-center">
                                <i class="bi bi-suitcase-lg"></i>
                            </div>
                            <div>
                                <span class="card-title" style="color: #ff7500; text-decoration: underline;">outstanding</span>
                            </div>
                            <div>
                                <span class="card-text" >Your job you opportuinty</span>
                            </div>
                        </div>
                        <div class="inner">
                            <img class="w-100" src="{{ asset('assets/school-girl2.png') }}" alt="School Girl">
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1 d-flex flex-column justify-content-center w-50">
                    <div class="flex-grow-1">
                        <h1 class="fw-bold" style="font-size: 5rem">We are <span style="color: #ff7500;">Expert</span>  learning institution </h1>
                    </div>
                    <div class="flex-grow-1">
                        <h2 class="fw-light text-muted text-opacity-75">Start your learning journey with our courses for every subject and for every level.</h2>
                    </div>
                    <div class="flex-grow-1">
                        <a href="#" class="btn btn-primary rounded-pill px-4 py-3">Enroll now</a>
                    </div>
                </div>
            </div>
    </section>

    <section class="populer-courses-section">
        <div class="container">
            <div class="section-title fw-bold">
                <div class="d-flex justify-content-center">
                    <h2 style="text-align: center">Explore our Popular Courses</h2>
                </div>
            </div>
            <div id="popular-courses" class="row">
                <!-- Popular courses will be appended here -->
            </div>
        </div>
    </section>

    <section class="filler-section">
        <div class="container d-flex h-100">
            <!-- Content for the static section -->
            <div class="flex-grow-1 d-flex flex-column justify-content-center w-50">
                <div class="flex-grow-1">
                    <h1 class="fw-bold" style="font-size: 5rem">Our online <span style="color: #ff7500;">Examination</span> is top-notch </h1>
                </div>
                <div class="flex-grow-1">
                    <h2 class="fw-light text-muted text-opacity-75">Start your learning journey with our courses for every subject and for every level.</h2>
                </div>
                <div class="flex-grow-1">
                    <a href="#" class="btn btn-primary rounded-pill px-4 py-3">Take a test</a>
                </div>
            </div>
            <div class="flex-grow-1 w-50 d-none d-md-block ">
                <div class="image-background left">
                    <div class="card info-card d-flex flex-col left">
                        <div class="icon mb-2 mx-0 aligen-items-center text-center">
                            <i class="bi bi-suitcase-lg"></i>
                        </div>
                        <div>
                            <span class="card-title" style="color: #ff7500; text-decoration: underline;">outstanding</span>
                        </div>
                        <div>
                            <span class="card-text" >Your job you opportuinty</span>
                        </div>
                    </div>
                    <div class="inner">
                        <img class="w-100" src="{{ asset('assets/school-boy.png') }}" alt="School Girl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="populer-Examination">
        <div class="container">
            <button class="examantion-arrow-btn left">
                <i class="bi bi-chevron-left"></i>
            </button>
            
            <button class="examantion-arrow-btn right">
                <i class="bi bi-chevron-right"></i>
            </button>

            <div class="d-flex flex-column h-100">
                <div class="mb-4">
                    <h2 class="fw-bold d-flex justify-content-center ">Populer Examnation</h2> 
                </div>
                <div class="see-all m-2 text-end">
                    <a href="#"><h4 class="fw-lighter">See all</h4></a>
                </div>
                <div id="examantion-list" class=" d-flex flex-row row">
                    <!-- Top cartegory cards is here -->
                </div>
            </div>
        </div>
        <div>
            <!-- Content for the top categories cards with images -->
        </div>
    </section>

    <section class="filler-section">
        <div class="container d-flex h-100">
            <!-- Content for the static section -->
            <div class="flex-grow-1 w-50 d-none d-md-block ">
                <div class="image-background">
                    <div class="card info-card d-flex flex-col">
                        <div class="icon mb-2 mx-0 aligen-items-center text-center">
                            <i class="bi bi-suitcase-lg"></i>
                        </div>
                        <div>
                            <span class="card-title" style="color: #ff7500; text-decoration: underline;">outstanding</span>
                        </div>
                        <div>
                            <span class="card-text" >Your job you opportuinty</span>
                        </div>
                    </div>
                    <div class="inner">
                        <img class="w-100" src="{{ asset('assets/school-girl3.png') }}" alt="School Girl">
                    </div>
                </div>
            </div>
            <div class="flex-grow-1 d-flex flex-column justify-content-center w-50">
                <div class="card card-form">
                    <div class="card-body">
                        <form id="registrationForm" method="POST" action="{{ route('students.store') }}">
                            <div>
                                <h5 class="text-center fs-6 fw-bolder mb-4 mt-2" style="color: darkgray">Registration to get notified about new competition and article we publish.</h5>
                            </div>
                            @csrf
                            <div class="mb-3">
                                <input type="text" class="form-control p-3" id="username" name="name" placeholder="User Name">
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control p-3" id="email" name="email" placeholder="Email">
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="password" class="form-control p-3" id="password" name="password" placeholder="Password">
                                    <span class="input-group-text" id="togglePassword">
                                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="password" class="form-control p-3" id="repeatPassword" name="password_confirmation" placeholder="Repeat Password">
                                    <span class="input-group-text" id="toggleRepeatPassword">
                                        <i class="bi bi-eye" id="toggleRepeatPasswordIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 mb-1 p-2 rounded-pill" style="border-radius: 1rem">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
@endsection

@section('scripts')
    <script>
        let offsetCourse= 0;
        let offsetExamantion= 0;
        let totalCourses = 0;
        let totalExamantion = 0;

        $(document).ready(function() {
            fetchCourses(offsetCourse);
            fetchPopularCourses();
            fetchAdditionalCourses();
            fetchExamnations(offsetExamantion);

            $('.course-arrow-btn.left').click(function() {
                if (offsetCourse > 0) {
                    offsetCourse -= 1;
                    fetchCourses(offsetCourse);
                }
            });

            $('.course-arrow-btn.right').click(function() {
                if (offsetCourse + 4 < totalCourses) {
                    offsetCourse += 1;
                    fetchCourses(offsetCourse);
                }
            });

            $('.examantion-arrow-btn.left').click(function() {
                if (offsetExamantion > 0) {
                    offsetExamantion -= 1;
                    fetchExamnations(offsetExamantion);
                }
            });

            $('.examantion-arrow-btn.right').click(function() {
                if (offsetExamantion + 4 < totalExamantion) {
                    offsetExamantion += 1;
                    fetchExamnations(offsetExamantion);
                }
            });

            $('#registrationForm').submit(function(event) {
                event.preventDefault();

                var formData = {
                    name: $('#username').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#repeatPassword').val(),
                    _token: $('input[name="_token"]').val()
                };

                $.ajax({
                    url: '{{ route("students.store") }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        alert('Registration successful!');
                        $('#registrationForm')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Registration failed. Please try again.');
                    }
                });
            });

            $('#togglePassword').click(function() {
                const passwordField = $('#password');
                const passwordIcon = $('#togglePasswordIcon');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                passwordIcon.toggleClass('bi-eye bi-eye-slash');
            });

            $('#toggleRepeatPassword').click(function() {
                const repeatPasswordField = $('#repeatPassword');
                const repeatPasswordIcon = $('#toggleRepeatPasswordIcon');
                const type = repeatPasswordField.attr('type') === 'password' ? 'text' : 'password';
                repeatPasswordField.attr('type', type);
                repeatPasswordIcon.toggleClass('bi-eye bi-eye-slash');
            });
        });

        function fetchCourses(offset) {
            $.ajax({
                url: '{{ route('ajax.limited-courses') }}',
                method: 'GET',
                data: { offset: offset },
                success: function(data) {
                    console.log(data);
                    let coursesList = $('#courses-list');
                    coursesList.empty();
                    totalCourses = data.total;
                    data.courses.forEach(course => {
                        let courseItem = $('<div>').addClass('col-md-3 mb-4 course-item');
                        let imageUrl = '{{ asset('assets/courses') }}/' + course.image;
                        courseItem.html(`
                            <div class="card bg-img" style="background-image: url('${imageUrl}'); background-size: cover;">
                                <div class="card dark-layer">
                                    <div class="card-body">
                                    </div>
                                    <div class="card-footer">
                                        <h2 class="card-title">${course.name}</h2>
                                    </div>
                                </div>
                            </div>
                        `);
                        coursesList.append(courseItem);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching courses:', error);
                }
            });
        }

        function fetchPopularCourses() {
            $.ajax({
                url: '{{ route('ajax.popular-courses') }}',
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    let popularCoursesSection = $('#popular-courses');
                    popularCoursesSection.empty();
                    data.forEach(course => {
                        let courseCard = createCourseCard(course);
                        popularCoursesSection.append(courseCard);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching popular courses:', error);
                }
            });
        }

        function fetchAdditionalCourses() {
            $.ajax({
                url: '{{ route('ajax.additional-courses') }}',
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    let additionalCoursesSection = $('#additional-courses');
                    additionalCoursesSection.empty();
                    data.forEach(course => {
                        let courseCard = createCourseCard(course);
                        additionalCoursesSection.append(courseCard);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching additional courses:', error);
                }
            });
        }

        function formatStudentsCount(count) {
            if (count >= 1000) {
                return (count / 1000).toFixed(1) + 'k';
            }
            return count;
        }

        function createCourseCard(course) {
            return `
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('assets/courses') }}/${course.image}" class="card-img-top" alt="${course.name}">
                        <div class="card-body d-flex flex-row">
                            <p class="card-text">${course.description}</p>
                            <div class="d-flex justify-content-between align-items-center align-self-start ms-4">
                                    <i style="color:#ffb343" class="bi bi-star-fill"></i> ${course.rating}
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <span>6 weeks</span>
                            <span>
                                <i class="bi bi-people fw-bolder" style="color:#ff7500"></i>
                                ${formatStudentsCount(course.num_of_students)} students
                            </span>
                            
                            <span class="fw-bolder" style="color:#ff7500">
                                ${course.price}
                                <span>$</span>
                            </span>
                        </div>
                    </div>
                </div>
            `;
        }

        function fetchExamnations(offset) {
            $.ajax({
                url: '{{ route('ajax.limited-courses') }}',
                method: 'GET',
                data: { offset: offset },
                success: function(data) {
                    console.log(data);
                    let coursesList = $('#examantion-list');
                    coursesList.empty();
                    totalExamantion = data.total;
                    data.courses.forEach(course => {
                        let courseItem = $('<div>').addClass('col-md-3 mb-4 course-item');
                        let imageUrl = '{{ asset('assets/courses') }}/' + course.image;
                        courseItem.html(`
                            <div class="card bg-img" style="background-image: url('${imageUrl}'); background-size: cover;">
                                <div class="card dark-layer">
                                    <div class="card-body">
                                    </div>
                                    <div class="card-footer">
                                        <h2 class="card-title">${course.name}</h2>
                                    </div>
                                </div>
                            </div>
                        `);
                        coursesList.append(courseItem);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching courses:', error);
                }
            });
        }
    </script>
@endsection


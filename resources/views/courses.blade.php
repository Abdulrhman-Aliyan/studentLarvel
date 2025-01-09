@extends('layout')

@section('head')
    <title>Courses</title>
    <link rel="stylesheet" href="{{ asset('css/courses.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <h1 class="fw-bold d-flex justify-content-center">Top Cartegories</h1> 
                </div>
                <div class="see-all mt-2 text-end">
                    <a href="#"><h4 class="fw-lighter">See all</h4></a>
                </div>
                <div class="card bg-img" style="background-image: url('{{ asset('assets/courses/tech.jpg') }}'); background-size: cover;">
                    <div class="card dark-layer">
                        <div class="card-body">
                            {{-- card body --}}
                        </div>
                        <div class="card-footer ">
                            <h2 class="card-title">course</h2>
                        </div>
                    </div>
                </div>
                <div id="courses-list" class="row">
                    
                </div>
            </div>
        </div>
        <div>
            <!-- Content for the top categories cards with images -->
        </div>
    </section>
    <section>
        <!-- Content for the second section -->
    </section>
    <section>
        <!-- Content for the third section -->
    </section>
    <section class="courses-section">
        
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            fetchCourses();
        });

        function fetchCourses() {
            $.ajax({
                url: '{{ route('ajax.courses') }}',
                method: 'GET',
                success: function(data) {
                    let coursesList = $('#courses-list');
                    coursesList.empty();
                    data.forEach(course => {
                        let courseItem = $('<div>').addClass('col-md-4 mb-4');
                        courseItem.html(`
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">${course.name}</h5>
                                    <p class="card-text">${course.description}</p>
                                    <p class="card-text"><strong>Price:</strong> $${course.price}</p>
                                    <p class="card-text"><strong>Rating:</strong> ${course.rating}</p>
                                    <p class="card-text"><strong>Number of Students:</strong> ${course.num_of_students}</p>
                                </div>
                            </div>
                        `);
                        coursesList.append(courseItem);
                    });
                }
            });
        }
    </script>
@endsection


@extends('layout')

@section('head')
    <title>Courses</title>
    <link rel="stylesheet" href="{{ asset('css/courses.css') }}">
@endsection

@section('content')
    <section class="landing-section">
        <div class="container d-flex h-100">
            <!-- Content for the static section -->
            <div class="flex-grow-1 d-flex flex-column justify-content-center w-50">
                <div class="flex-grow-1">
                    <h1 class="fw-bold" style="font-size: 5rem">Lets learn togther for better <span style="color: #ff7500">future</span></h1>
                </div>
                <div class="flex-grow-1">
                    <h2 class="fw-light text-muted text-opacity-75">Start your learning journey with our courses for every subject and for every level.</h2>
                </div>
                <div class="flex-grow-1">
                    <a href="#" class="btn btn-primary rounded-pill px-4 py-3">get started</a>
                </div>
            </div>
            <div class="flex-grow-1 w-50">
                <div class="image-background">
                    <img class="w-100" src="{{ asset('assets/school-girl.png') }}" alt="School Girl">
                </div>
            </div>
        </div>
    </section>
    <section class="services">
        <div class="container h-100">
            <div class="d-flex justify-content-center align-items-center py-4 flex-wrap h-100">

                <div class="card mx-4 pt-0 pb-4">
                    <div class="card-body">
                        <div class="icon aligen-items-center text-center">
                            <i class="bi bi-chat-left-dots"></i>
                        </div>
                        <h5 class="card-title">Live Chat</h5>
                        <p class="card-text fw-light">Engage in discussions with peers and instructors.</p>
                    </div>
                </div>

                <div class="card mx-4 pt-0 pb-4">
                    <div class="card-body">
                        <div class="icon aligen-items-center text-center">
                            <i class="bi bi-file-text"></i>
                        </div>
                        <h5 class="card-title">Examination</h5>
                        <p class="card-text fw-light">Take exams to evaluate your knowledge and progress.</p>
                    </div>
                </div>

                <div class="card mx-4 pt-0 pb-4">
                    <div class="card-body">
                        <div class="icon aligen-items-center text-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <h5 class="card-title">Competition</h5>
                        <p class="card-text fw-light">Participate in various competitions to test your skills.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section>
        <!-- Content for the first section -->
    </section>
    <section>
        <!-- Content for the second section -->
    </section>
    <section>
        <!-- Content for the third section -->
    </section>
@endsection

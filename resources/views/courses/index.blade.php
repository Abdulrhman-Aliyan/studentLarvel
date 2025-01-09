@extends('layout')

@section('content')
    <div class="container">
        <h1>Courses</h1>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">Add Course</a>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Subject</th>
                    <th>Instructor</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->description }}</td>
                        <td>{{ $course->subject->name }}</td>
                        <td>{{ $course->user->name }}</td>
                        <td>
                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

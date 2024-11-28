@extends('layouts.app')

@section('content')
    <div class="card-body ml-3"> <!-- ml= margin-left=3rem -->
        @include('dashboard')
        @include('errors')
        @auth
            <form action="/tasks" method="post" class="form-horizontal">
                @csrf
                <div class="row">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xl-9 mt-2">
                                <input type="text" name="body" id="body" class="form-control">
                            </div>
                            <div class="col-sm-3 mt-2">
                                <button type="submit" class="btn btn-success">Add task</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if (count($tasks) > 0)
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped task-table">
                        <thead>
                            <th>Current tasks</th>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="table-text">
                                        <div>{{ $task->body }}</div>
                                    </td>
                                    <td>
                                        @can('delete', $task)
                                            <form action=" {{ url('task/' . $task->id) }}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endauth

    @guest
        <h3 style="color:red">You are not allowed to be here</h3>
    @endguest
@endsection

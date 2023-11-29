@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Hello, <mark>{{ Auth::user()->name }}</mark>.</div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @else
                    <div class="alert alert-success">
                        You are logged in!
                    </div>       
                @endif                
            </div>
        </div>
    </div>    
</div>

<div class="container mt-3">
    <div class="row">
        <div class="col-md-6">
            <h2>Your Tasks</h2>
        </div>
        <div class="col-md-6  d-flex justify-content-end">
            <div class="mt-3">
                <input type="text" id="task-description" placeholder="Enter task description">
                <button id="add-task-btn" class="btn btn-primary">Add Task</button>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover mt-3" id="datatable">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" scope="col">#</th>
                <th class="text-center" scope="col">Task</th>
                <th class="text-center" scope="col">Status</th>
                <th class="text-center" scope="col">Action</th>
                <th class="text-center" scope="col">Delete Task</th>
            </tr>
        </thead>
        <tbody id="task-list">
            @foreach($tasks as $index => $task)
                <tr data-task-id="{{ $task->id }}" data-task-status="{{ $task->status }}">
                    <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                    <td class="text-center">{{ $task->task }}</td>
                    <td class="text-center">
                        @if ($task->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-success">Done</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($task->status == 'pending')
                            <button class="btn btn-success mark-done">Mark as Done</button>
                        @else
                            <button class="btn btn-warning mark-pending">Mark as Pending</button>
                        @endif
                    </td>
                    <td class="text-center">
                        <button class="btn btn-danger delete-task"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function showPopupMessage(message, type) {
        var alertElement = $('<div class="position-fixed top-0 end-0 p-3" style="z-index: 1051">' +
            '<div class="toast align-items-center text-white bg-' + type + ' border-0" role="alert" aria-live="assertive" aria-atomic="true">' +
            '<div class="d-flex">' +
            '<div class="toast-body">' +
            message +
            '</div>' +
            '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
            '</div>' +
            '</div>' +
            '</div>');

        $('body').append(alertElement);

        var toast = new bootstrap.Toast(alertElement.find('.toast')[0]);
        toast.show();

        setTimeout(function () {
            alertElement.remove();
        }, 5000);
    }

    $(document).ready(function () {
        $('.mark-done').click(function () {
            let taskId = $(this).closest('tr').data('task-id');
            let currentStatus = $(this).closest('tr').data('task-status');

            $.ajax({
                url: 'api/todo/status',
                type: 'POST',
                headers: {
                    'api-key': 'helloatg',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    task_id: taskId,
                    status: currentStatus === 'pending' ? 'done' : 'pending'
                },
                success: function (response) {
                    console.log(response);
                    showPopupMessage('Task updated successfully: ' + response.message, 'success');
                    location.reload();
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });

        $('.mark-pending').click(function () {
            let taskId = $(this).closest('tr').data('task-id');
            let currentStatus = $(this).closest('tr').data('task-status');

            $.ajax({
                url: 'api/todo/status',
                type: 'POST',
                headers: {
                    'api-key': 'helloatg',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    task_id: taskId,
                    status: currentStatus === 'pending' ? 'done' : 'pending'
                },
                success: function (response) {
                    console.log(response);
                    showPopupMessage('Task updated successfully: ' + response.message, 'success');
                    location.reload();
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });

        $('#add-task-btn').click(function () {
            let taskDescription = $('#task-description').val();

            $.ajax({
                url: 'api/todo/add',
                type: 'POST',
                headers: {
                    'api-key': 'helloatg',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    user_id: {{ Auth::id() }},
                    task: taskDescription
                },
                success: function (response) {
                    console.log(response);
                    showPopupMessage('Task added successfully: ' + response.message, 'success');
                    location.reload();
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });

        $('.delete-task').click(function () {
            if (confirm('Are you sure you want to delete this task?')) {
                let taskId = $(this).closest('tr').data('task-id');

                $.ajax({
                    url: 'api/todo/delete',
                    type: 'POST',
                    headers: {
                        'api-key': 'helloatg',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        task_id: taskId
                    },
                    success: function (response) {
                        console.log(response);
                        showPopupMessage('Task deleted successfully: ' + response.message, 'success');
                        location.reload();
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            }
        });
    });
</script>

@endsection

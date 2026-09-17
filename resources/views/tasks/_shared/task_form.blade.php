<form id="create-task-form">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ isset($task) ? $task->title : '' }}">
    </div>
    <input type="hidden" id="task-id" value="{{ isset($task) ? $task->id : '' }}">
    <div class="mb-3">
        <label for="" class="form-label">Assigned To</label>
        <select class="form-select" id="user_id" name="user_id">
            <option value="">Select User</option>
            @foreach ($users as $user)
                <option {{ (isset($task) && $task->user_id == $user->id) ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3" >
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description">{{ isset($task) ? $task->description : '' }}</textarea>
    </div>

    <div class="mb-3">
        <label for="due_date" class="form-label">Due Date</label>
        <input type="date" class="form-control" id="due_date" name="due_date" value="{{ isset($task) ? $task->due_date->format('Y-m-d') : '' }}">
    </div>

    <div class="mb-3">
        <label for="estimated_time" class="form-label">Estimated Time</label>
        <input type="text" class="form-control" id="estimated_time" name="estimated_time" value="{{ isset($task) ? $task->estimated_time : '' }}">
    </div>

    <button type="submit" class="btn btn-primary">Save</button>

    <div class="mt-3" id="form-errors">

    </div>
</form>

<!-- Start::add task modal -->
<div class="modal" id="create-task" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add Task</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('/corrective/store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4">
                    <div class="row gy-2">
                        <div class="col-xl-6">
                            <label for="task-id" class="form-label">Task #</label>
                            <input type="text" class="form-control" id="task-id" placeholder="Task ID" value="This is auto-generated" disabled>
                        </div>
                        <div class="col-xl-6">
                            <label for="name" class="form-label">Created by</label>
                            <input type="text" name="created_by" class="form-control" id="name" value="{{ auth()->user()->name }}" disabled>
                        </div>
                        <div class="col-xl-6">
                            <label for="viberNumber" class="form-label">Viber Number</label>
                            <input type="tel" name="viber_number" class="form-control @if($errors->has('viber_number')) is-invalid @endif" id="viberNumber" value="{{ old('viber_number') }}">
                            @if($errors->has('viber_number'))
                                <span class="invalid-feedback">{{ $errors->first('viber_number') }}</span>
                            @endif
                        </div>
                        <div class="col-xl-6">
                            <label for="task-name" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control @if($errors->has('title')) is-invalid @endif" id="task-name" value="{{ old('title') }}">
                            @if($errors->has('title'))
                                <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" class="form-control @if($errors->has('due_date')) is-invalid @endif" value="{{ old('due_date') }}">
                            @if($errors->has('due_date'))
                                <span class="invalid-feedback">{{ $errors->first('due_date') }}</span>
                            @endif
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label">Assign building</label>
                            <select class="form-control" data-trigger name="building">
                                <option value="">Select building</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}" @if(old('building') == $building->id) selected @endif>{{ $building->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label">Priority</label>
                            <select class="form-control @if($errors->has('due_date')) is-invalid @endif" data-trigger name="priority" id="choices-single-default1">
                                <option value="High" @if(old('priority') == "High") selected @endif>High</option>
                                <option value="Medium" @if(old('priority') == "Medium") selected @endif>Medium</option>
                                <option value="Low" @if(old('priority') == "Low") selected @endif>Low</option>
                            </select>
                        </div>
                        <div class="col-xl-12">
                            <label class="form-label">Attachments</label>
                            <input type="file" class="blog-images @if($errors->has('attachments')) is-invalid @endif" name="attachments[]" multiple data-allow-reorder="true" data-max-file-size="3MB" data-max-files="6">
                            @if($errors->has('attachments'))
                                <span class="invalid-feedback">{{ $errors->first('attachments') }}</span>
                            @endif
                        </div>
                        <div class="col-xl-12">
                            <label class="form-label">Task</label>
                            <textarea name="task" class="summernote form-control @if($errors->has('task')) is-invalid @endif" cols="30" rows="10">{{ old('task') }}</textarea>
                            @if($errors->has('task'))
                                <span class="invalid-feedback">{{ $errors->first('task') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End::add task modal -->
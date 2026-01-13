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
                            <label for="typeOfIssues" class="form-label">Type of issues</label>
                            <select name="type_of_issues" id="typeOfIssues" class="form-control @if($errors->has('type_of_issues')) is-invalid @endif">
                                <option value="">Select type of issues</option>
                            </select>
                            @if($errors->has('type_of_issues'))
                                <span class="invalid-feedback">{{ $errors->first('type_of_issues') }}</span>
                            @endif
                        </div>
                        <div class="col-xl-6">
                            <label for="task-name" class="form-label">Affected Locations</label>
                            <select class="form-control @if($errors->has('affected_locations')) is-invalid @endif" name="affected_locations">
                                <option value="">Select building</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}" @if(old('affected_locations') == $building->id) selected @endif>{{ $building->code }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('affected_locations'))
                                <span class="invalid-feedback">{{ $errors->first('affected_locations') }}</span>
                            @endif
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label">Quantity <span style="font-style: italic;">(if applicable)</span></label>
                            <input type="number" name="quantity" class="form-control @if($errors->has('quantity')) is-invalid @endif" value="{{ old('quantity') }}">
                            @if($errors->has('quantity'))
                                <span class="invalid-feedback">{{ $errors->first('quantity') }}</span>
                            @endif
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label">Date & Time identified</label>
                            <input type="datetime-local" name="time_identified" class="form-control @if($errors->has('time_identified')) is-invalid @endif">
                            @if($errors->has('time_identified'))
                                <span class="invalid-feedback">{{ $errors->first('time_identified') }}</span>
                            @endif
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label">Priority</label>
                            <select class="form-control @if($errors->has('priority')) is-invalid @endif" data-trigger name="priority" id="choices-single-default1">
                                <option value="High" @if(old('priority') == "High") selected @endif>High</option>
                                <option value="Medium" @if(old('priority') == "Medium") selected @endif>Medium</option>
                                <option value="Low" @if(old('priority') == "Low") selected @endif>Low</option>
                                <option value="Project" @if(old('priority') == "Project") selected @endif>Project</option>
                            </select>
                            @if($errors->has('priority'))
                                <span class="invalid-feedback">{{ $errors->first('priority') }}</span>
                            @endif
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
@extends('layouts.header')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/libs/filepond/filepond.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.css') }}">
<style>
    textarea.is-invalid + .note-editor .note-editing-area
    {
        border: 1px solid red;
    }
</style>
@endsection

@section('content')
<div class="card custom-card mt-2">
    <div class="card-header d-flex flex-row align-items-center gap-3">
        <a href="{{ url('/corrective') }}" class="btn btn-danger">
            <i class="ri-arrow-left-line"></i>
            Back
        </a>
        <h5 class="m-0 card-title">Create corrective</h5>
    </div>
    <form method="POST" action="{{ url('/corrective/store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card-body">
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
                    <select data-placeholder="Select type of issues" name="type_of_issues" id="typeOfIssues" class="form-control select2 @if($errors->has('type_of_issues')) is-invalid @endif">
                        <option value=""></option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if(old('type_of_issues') == $category->id) selected @endif>{{ $category->category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('type_of_issues'))
                        <span class="invalid-feedback">{{ $errors->first('type_of_issues') }}</span>
                    @endif
                </div>
                <div class="col-xl-6" id="subtypeContainer" hidden>
                    <label for="subTypeIssues" class="form-label">Subtype of issues</label>
                    <select data-placeholder="Select type of issues" name="subtype_issues" id="subTypeIssues" class="form-control select2 @if($errors->has('subtype_issues')) is-invalid @endif">
                        <option value=""></option>
                    </select>
                    @if($errors->has('subtype_issues'))
                        <span class="invalid-feedback">{{ $errors->first('subtype_issues') }}</span>
                    @endif
                </div>
                <div class="col-xl-6" id="descriptionContainer" hidden>
                    <label for="" class="form-label @if($errors->has('description')) description @endif">Description</label>
                    <textarea name="description" class="form-control" cols="30"></textarea>
                    @if($errors->has('description'))
                        <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="col-xl-6">
                    <label for="task-name" class="form-label">Affected Locations</label>
                    <select data-placeholder="Select building" class="form-control select2 @if($errors->has('affected_locations')) is-invalid @endif" name="affected_locations">
                        <option value=""></option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}" @if(old('affected_locations') == $building->id) selected @endif>{{ $building->code }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('affected_locations'))
                        <span class="invalid-feedback">{{ $errors->first('affected_locations') }}</span>
                    @endif
                </div>
                <div class="col-xl-6" id="qtyColumn" hidden>
                    <label class="form-label">Quantity <span style="font-style: italic;">(if applicable)</span></label>
                    <input type="number" name="quantity" class="form-control @if($errors->has('quantity')) is-invalid @endif" value="{{ old('quantity') }}">
                    @if($errors->has('quantity'))
                        <span class="invalid-feedback">{{ $errors->first('quantity') }}</span>
                    @endif
                </div>
                <div class="col-xl-6">
                    <label class="form-label">Date & Time identified</label>
                    <input type="datetime-local" name="time_identified" value="{{ old('time_identified') }}" class="form-control @if($errors->has('time_identified')) is-invalid @endif">
                    @if($errors->has('time_identified'))
                        <span class="invalid-feedback">{{ $errors->first('time_identified') }}</span>
                    @endif
                </div>
                <div class="col-xl-6">
                    <label class="form-label">Priority</label>
                    <select data-placeholder="Select priority" class="form-control select2 @if($errors->has('priority')) is-invalid @endif" data-trigger name="priority" id="choices-single-default1">
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
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Add Task</button>
        </div>
    </form>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
<script src="{{ asset('assets/libs/filepond/filepond.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-image-transform/filepond-plugin-image-transform.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,
            placeholder: "Write task..."
        });

        const MultipleElement = document.querySelector('.blog-images');
        FilePond.create(MultipleElement, {
            storeAsFile: true
        });

        // $('.modal').on('shown.bs.modal', function() {
        //     $(this).find('.select2').select2({
        //         dropdownParent: $(this)
        //     })
        // })
        $(".select2").select2()

        $("#typeOfIssues").on('change', function() {
            const value = $(this).val()

            $.ajax({
                type:"POST",
                url:"{{ url('/corrective/refresh-corrective') }}",
                data: {
                    category: value,
                    _token:"{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    
                    if (response.data) {
                        $("#qtyColumn").prop('hidden', false)
                    }
                    else {
                        $("#qtyColumn").prop('hidden', true)
                    }

                    if (response.haveOptions) {
                        $("#subtypeContainer").prop('hidden', false)
                        $("#descriptionContainer").prop('hidden', false)

                        $("#subTypeIssues").html(response.options)
                    }
                    else {
                        $("#subtypeContainer").prop('hidden', true)
                        $("#descriptionContainer").prop('hidden', true)
                    }
                }
            })
        })
    });
</script>
@endsection
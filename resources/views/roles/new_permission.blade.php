<div class="modal" id="newPermission">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add new permissions</h6>
            </div>
            <form method="POST" action="{{ url('/permissions/store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        {{-- <div class="col-md-12">
                            <label>Code :</label>
                            <input type="text" name="code" class="form-control form-control-sm @if($errors->has('code')) is-invalid @endif" value="{{ old('code') }}">
                            @if($errors->has('code'))
                            <span class="invalid-feedback">{{ $errors->first('code') }}</span>
                            @endif
                        </div> --}}
                        <div class="col-md-12">
                            <label>Name :</label>
                            <input type="text" name="name" class="form-control form-control-sm @if($errors->has('name')) is-invalid @endif" value="{{ old('name') }}">
                            @if($errors->has('name'))
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="edit{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Edit users</h6>
            </div>
            <form method="POST" action="{{ url('/users/update/'.$user->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Building :</label>
                            <select name="building" class="form-control select2 @if($errors->has('building')) is-invalid @endif">
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}" @if(old('building', $user->building_id) == $building->id) selected @endif>{{ $building->code.' - '.$building->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('building'))
                            <span class="invalid-feedback d-block m-0">{{ $errors->first('building') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <label>Name :</label>
                            <input type="text" name="name" class="form-control form-control-sm @if($errors->has('name')) is-invalid @endif" value="{{ old('name', $user->name) }}">
                            @if($errors->has('name'))
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <label>Email :</label>
                            <input type="email" name="email" class="form-control form-control-sm @if($errors->has('email')) is-invalid @endif" value="{{ old('email', $user->email) }}">
                            @if($errors->has('email'))
                            <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <label>Role :</label>
                            <select name="role" class="form-control select2 @if($errors->has('role')) is-invalid @endif">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" @if(old('role') == $role->name) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('role'))
                            <span class="invalid-feedback d-block">{{ $errors->first('role') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
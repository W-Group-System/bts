<div class="modal" id="new">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add new category</h6>
            </div>
            <form method="POST" action="{{ url('/categories/store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row gy-2">
                        <div class="col-md-12">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control form-control-sm @if($errors->has('category')) is-invalid @endif" value="{{ old('category') }}">
                            @if($errors->has('category'))
                            <span class="invalid-feedback">{{ $errors->first('category') }}</span>
                            @endif
                        </div>
                        {{-- <div class="col-md-12">
                            <label class="form-label">Sub-category <i>(if applicable)</i></label>
                            <input type="text" name="subcategory" class="form-control form-control-sm @if($errors->has('subcategory')) is-invalid @endif" value="{{ old('subcategory') }}">
                            @if($errors->has('subcategory'))
                            <span class="invalid-feedback">{{ $errors->first('subcategory') }}</span>
                            @endif
                        </div> --}}
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" name="have_quantity" type="checkbox" id="quantity">
                                <label class="form-check-label" for="quantity">
                                    Quantity
                                </label>
                            </div>
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
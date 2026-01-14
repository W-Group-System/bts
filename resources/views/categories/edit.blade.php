<div class="modal" id="edit{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Edit category</h6>
            </div>
            <form method="POST" action="{{ url('/categories/update/'.$category->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="row gy-2">
                        <div class="col-md-12">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control form-control-sm @if($errors->has('category')) is-invalid @endif" value="{{ old('category', $category->category) }}">
                            @if($errors->has('category'))
                            <span class="invalid-feedback">{{ $errors->first('category') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" name="have_quantity" type="checkbox" id="quantity" @if($category->have_qty) checked @endif>
                                <label class="form-check-label" for="quantity">
                                    Quantity
                                </label>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <button type="button" class="btn btn-sm btn-success" onclick="addSubCat({{ $category->id }})">
                                <i class="ri-add-line"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeSubCat({{ $category->id }})">
                                <i class="ri-subtract-line"></i>
                            </button>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Sub-category</label>
                            @if(count($category->subcategory) == 0)
                            <div id="subCategoryContainer{{ $category->id }}">
                                {{-- <div class="row" id="1">
                                    <div class="col-md-2">
                                        <p class="num">1</p>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="subcategory[]" class="form-control form-control-sm @if($errors->has('subcategory')) is-invalid @endif" value="{{ old('subcategory') }}">
                                    </div>
                                </div> --}}
                            </div>
                            @else 
                            <div id="subCategoryContainer{{ $category->id }}">
                                @foreach ($category->subcategory as $key=> $subcategory)
                                <div class="row" id="{{ $key+1 }}">
                                    <div class="col-md-2">
                                        <p class="num">{{ $key+1 }}</p>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="subcategory[]" class="form-control form-control-sm @if($errors->has('subcategory')) is-invalid @endif" value="{{ old('subcategory', $subcategory->subcategory) }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            {{-- @if($errors->has('subcategory'))
                            <span class="invalid-feedback">{{ $errors->first('subcategory') }}</span>
                            @endif --}}
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
<!-- Start::add task modal -->
<div class="modal" id="attachment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Upload Attachment</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('/corrective/attach-comments/'.$corrective->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4">
                    <div class="row gy-2">
                        <div class="col-xl-12">
                            <label class="form-label">Attachments</label>
                            <input type="file" class="blog-images @if($errors->has('attachments')) is-invalid @endif" name="attachments[]" multiple data-allow-reorder="true" data-max-file-size="3MB" data-max-files="6">
                            @if($errors->has('attachments'))
                                <span class="invalid-feedback">{{ $errors->first('attachments') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload attachment</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End::add task modal -->
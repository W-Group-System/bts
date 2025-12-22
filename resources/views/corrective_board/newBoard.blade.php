<!-- Start::add board modal -->
<div class="modal" id="add-board" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add Board</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('/corrective-board/store') }}">
                @csrf
                <div class="modal-body px-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <label for="board-title" class="form-label">Task Board Title</label>
                            <input type="text" name="board_title" class="form-control @if($errors->has('board_title')) is-invalid @endif" id="board-title" placeholder="Board Title">
                            @if($errors->has('board_title'))
                            <span class="fw-semibold invalid-feedback">{{ $errors->first('board_title') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Board</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End::add board modal -->
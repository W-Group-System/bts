<div class="modal" id="cancel{{ $c->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Are you sure you want to cancel ?</h6>
            </div>
            <form method="post" action="{{ url('/corrective/cancel/'.$c->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Remarks :</label>
                            <textarea name="remarks" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
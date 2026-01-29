<!-- Start::add board modal -->
<div class="modal" id="updateTask" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Update task</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('/corrective/update-status') }}">
                @csrf

                <input type="hidden" name="corrective_id" value="{{ $corrective->id }}">
                
                @php
                    $excludedRoles = ["Building Administrator", "Security Quality Assurance"];
                    $role = auth()->user()->getRoleNames()->first();
                @endphp

                <div class="modal-body g-3">
                    <div class="row">
                        <div class="col-xl-12">
                            <label for="board-title" class="form-label">Select action</label>
                            <select name="action" class="form-select @if($errors->has('action')) is-invalid @endif">
                                <option value="" disabled selected value>Select action</option>
                                @if(!in_array($role, $excludedRoles))
                                <option value="Ongoing">Ongoing</option>
                                <option value="For Review">For Review</option>
                                @endif
                                @role('Building Administrator')
                                <option value="Acknowledge">Acknowledge</option>
                                <option value="Returned to Resolver">Returned to Resolver</option>
                                <option value="For Verification">For Verification</option>
                                @endrole
                                @role("Security Quality Assurance")
                                <option value="Done">Done</option>
                                <option value="Returned to Resolver">Returned to Resolver</option>
                                @endrole
                            </select>
                            @if($errors->has('action'))
                            <span class="fw-semibold invalid-feedback">{{ $errors->first('action') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End::add board modal -->
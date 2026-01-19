@extends('layouts.header')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/filepond/filepond.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.css') }}">
@endsection

@section('content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0">Task Details</h1>
    {{-- <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Task</a></li>
                <li class="breadcrumb-item active" aria-current="page">Task Details</li>
            </ol>
        </nav>
    </div> --}}
</div>
<!-- Page Header Close -->

<!-- Start::row-1 -->
<div class="row">
    <div class="col-xl-9">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">Task Summary</div>
                @if($corrective->corrective_board_id == 1)
                <div class="btn-list">
                    <button class="btn btn-success btn-sm btn-wave me-0" data-bs-toggle="modal" data-bs-target="#assignTask{{ $corrective->id }}"><i
                            class="ri-edit-line me-1 align-middle" ></i>Assign Task</button>
                </div>
                @endif
                @include('corrective.assign')
            </div>
            <div class="card-body">
                <div class="fs-15 fw-semibold mb-2">Task Description :</div>
                <p class="text-muted task-description">{!! $corrective->task !!}</p>
                {{-- <div class="fs-15 fw-semibold mb-2">Key tasks :</div>
                <div>
                    <ul class="task-details-key-tasks mb-0">
                        <li>Conducting a comprehensive analysis of the existing website design.</li>
                        <li>Collaborating with the UI/UX team to develop wireframes and mockups.</li>
                        <li>Iteratively refining the design based on feedback.</li>
                        <li>Implementing the finalized design changes using HTML, CSS, and JavaScript.</li>
                        <li>Testing the website across different devices and browsers.</li>
                        <li>Conducting a final review to ensure all design elements are consistent and visually
                            appealing.</li>
                    </ul>
                </div> --}}
            </div>
            <div class="card-footer">
                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                    <div>
                        <span class="d-block text-muted fs-12">Assigned By</span>
                        @if($corrective->assignBy)
                        <div class="d-flex align-items-center">
                            <div class="me-2 lh-1">
                                <span class="avatar avatar-xs avatar-rounded">
                                    <img src="{{ asset('image/user.png') }}" alt="">
                                </span>
                            </div>
                            <span class="d-block fs-14 fw-semibold">
                                {{ $corrective->assignBy->name }}
                            </span>
                        </div>
                        @else
                        <span class="d-block fs-14 fw-semibold">No assign yet</span>
                        @endif
                    </div>
                    <div>
                        <span class="d-block text-muted fs-12">Assigned Date</span>
                        @if($corrective->date_assign)
                        <span class="d-block fs-14 fw-semibold">0000-00-00</span>
                        @else
                        <span class="d-block fs-14 fw-semibold">No assign date</span>
                        @endif
                    </div>
                    <div>
                        <span class="d-block text-muted fs-12">Due Date</span>
                        <span class="d-block fs-14 fw-semibold">{{ date('d, M Y', strtotime($corrective->due_date)) }}</span>
                    </div>
                    <div class="task-details-progress">
                        <span class="d-block text-muted fs-12 mb-1">Progress</span>
                        @php
                            $progress = 0;
                            if ($corrective->correctiveBoard->name == "todo")
                            {
                                $progress = 0;
                            }
                            elseif($corrective->correctiveBoard->name == "inprogress")
                            {
                                $progress = 30;
                            }
                            elseif($corrective->correctiveBoard->name == "review")
                            {
                                $progress = 60;
                            }
                            elseif($corrective->correctiveBoard->name == "done")
                            {
                                $progress = 100;
                            }
                        @endphp
                        <div class="d-flex align-items-center">
                            <div class="progress progress-xs progress-animate flex-fill me-2" role="progressbar"
                                aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-primary" style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="text-muted fs-11">{{ $progress }}%</div>
                        </div>
                    </div>
                    {{-- <div>
                        <span class="d-block text-muted fs-12">Efforts</span>
                        <span class="d-block fs-14 fw-semibold">45H : 35M : 45S</span>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Task Discussions</div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled profile-timeline">
                    @if(count($corrective->comment) > 0)
                        @foreach ($corrective->comment as $comment)
                            <li>
                                <div>
                                    <span
                                        class="avatar avatar-sm bg-primary-transparent avatar-rounded profile-timeline-avatar">
                                        @php
                                            $name = auth()->user()->name;
                                            $first_letter = substr($name, 0,1);
                                        @endphp
                                        {{ strtoupper($first_letter) }}
                                    </span>
                                    <p class="mb-2">
                                        <b>{{ auth()->user()->name }}</b><a class="text-secondary"
                                            href="javascript:void(0);"></a><span
                                            class="float-end fs-11 text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                                    </p>
                                    <p class="text-muted mb-0">
                                        @if($comment->attachment)
                                            @if($comment->attachment_type == "pdf")
                                            <a href="{{ url($comment->attachment) }}" target="_blank">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                                Attachment
                                            </a>
                                            @else 
                                            {{-- <a href="{{ url($comment->attachment) }}" target="_blank">
                                                <i class="bi bi-file-image"></i>
                                            </a> --}}
                                            <img src="{{ url($comment->attachment) }}" alt="" class="img-thumbnail">
                                            @endif
                                        @else
                                        <p class="fw-normal">{!! $comment->comment !!}</p>
                                        @endif
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    @else 
                        <p class="text-muted fw-semibold" style="font-style: italic;">No comment...</p>   
                    @endif
                </ul>
            </div>
            <div class="card-footer">
                <div class="d-flex align-items-center lh-1">
                    <div class="me-3">
                        <span class="avatar avatar-md avatar-rounded">
                            <img src="{{ asset('image/user.png') }}" alt="">
                        </span>
                    </div>
                    <div class="flex-fill me-2">
                        <form method="POST" action="{{ url('/corrective/comments/'.$corrective->id) }}">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control w-50 @if($errors->has('comment')) is-invalid @endif" name="comment" placeholder="Post Anything" aria-label="Recipient's username with two button addons">
                                {{-- <button class="btn btn-outline-light btn-wave waves-effect waves-light" type="button"><i
                                        class="bi bi-emoji-smile"></i></button> --}}
                                <button class="btn btn-outline-light btn-wave waves-effect waves-light" type="button" data-bs-toggle="modal" data-bs-target="#attachment"><i class="bi bi-paperclip"></i></button>
                                {{-- <button class="btn btn-outline-light btn-wave waves-effect waves-light" type="button"><i
                                        class="bi bi-camera"></i></button> --}}
                                <button class="btn btn-primary btn-wave waves-effect waves-light" type="submit">Post</button>
                                @if($errors->has('comment'))
                                <span class="invalid-feedback">{{ $errors->first('comment') }}</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    Additional Details
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <tbody>
                            <tr>
                                <td><span class="fw-semibold">Task ID :</span></td>
                                <td>{{ $corrective->series_number }}</td>
                            </tr>
                            {{-- <tr>
                                <td><span class="fw-semibold">Task Tags :</span></td>
                                <td>
                                    <span class="badge bg-primary-transparent">UI/Ux</span>
                                    <span class="badge bg-primary-transparent">Designing</span>
                                    <span class="badge bg-primary-transparent">Development</span>
                                </td>
                            </tr> --}}
                            <tr>
                                <td><span class="fw-semibold">Date Created :</span></td>
                                <td>
                                    {{ date('M d, Y', strtotime($corrective->created_at)) }}
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">Created by :</span></td>
                                <td>
                                    {{ $corrective->createdBy->name }}
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">Project Status :</span></td>
                                <td>
                                    <span class="fw-semibold text-secondary">{{ $corrective->correctiveBoard->name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">Project Priority :</span></td>
                                <td>
                                    @if($corrective->priority == "High")
                                    <span class="badge bg-danger-transparent">High</span>
                                    @elseif($corrective->priority == "Medium")
                                    <span class="badge bg-warning-transparent">High</span>
                                    @elseif($corrective->priority == "Low")
                                    <span class="badge bg-info-transparent">High</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">Assigned To :</span></td>
                                <td>
                                    @if($corrective->assignTo)
                                    <span class="fw-semibold">{{ $corrective->assignTo->name }}</span>
                                    @else
                                    <span class="fw-semibold">No assign personnel</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">Category :</span></td>
                                <td><span class="fw-semibold">{{ $corrective->category->category }}</span></td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">Subcategory :</span></td>
                                <td><span class="fw-semibold">{{ optional($corrective->subcategory)->subcategory }}</span></td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">Description :</span></td>
                                <td><span class="fw-semibold">{{ $corrective->description }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="card custom-card overflow-hidden">
            <div class="card-header justify-content-between">
                <div class="card-title">Sub Tasks</div>
                <div>
                    <button class="btn btn-secondary-light btn-sm btn-wave"><i
                            class="ri-add-line me-1 align-middle"></i>Sub Task</button>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="me-2"><input class="form-check-input form-checked-success" type="checkbox"
                                    value="" id="successChecked1" checked=""></div>
                            <div class="fw-semibold">Conduct Website Design Analysis</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="me-2"><input class="form-check-input form-checked-success" type="checkbox"
                                    value="" id="successChecked2"></div>
                            <div class="fw-semibold">Collaborate with UI/UX Team</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="me-2"><input class="form-check-input form-checked-success" type="checkbox"
                                    value="" id="successChecked3"></div>
                            <div class="fw-semibold">Refine Design Iteratively</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="me-2"><input class="form-check-input form-checked-success" type="checkbox"
                                    value="" id="successChecked4"></div>
                            <div class="fw-semibold">Implement Design Changes</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="me-2"><input class="form-check-input form-checked-success" type="checkbox"
                                    value="" id="successChecked5" checked=""></div>
                            <div class="fw-semibold">Test Responsive and Cross-Browser Compatibility</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="me-2"><input class="form-check-input form-checked-success" type="checkbox"
                                    value="" id="successChecked6" checked=""></div>
                            <div class="fw-semibold">Review and Polish Design Elements</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="me-2"><input class="form-check-input form-checked-success" type="checkbox"
                                    value="" id="successChecked77" checked=""></div>
                            <div class="fw-semibold">Incorporate Branding Elements</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="me-2"><input class="form-check-input form-checked-success" type="checkbox"
                                    value="" id="successChecked7"></div>
                            <div class="fw-semibold">Documentation and Handover</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div> --}}
        <div class="card custom-card overflow-hidden">
            <div class="card-header">
                <div class="card-title">
                    Attachments
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach ($corrective->correctiveAttachment as $attachment)
                    <li class="list-group-item">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <div class="lh-1">
                                <span class="avatar avatar-rounded p-2 bg-light">
                                    <img src="{{ asset('assets/images/media/file-manager/1.png') }}" alt="">
                                </span>
                            </div>
                            <div class="flex-fill">
                                <a href="{{ url($attachment->attachment) }}" target="_blank"><span class="d-block fw-semibold">{{ $attachment->name }}</span></a>
                                <span class="d-block text-muted fs-12 fw-normal">
                                    @php
                                        $fileSize = $attachment->size / 1024;
                                    @endphp
                                    {{ number_format($fileSize) }} MB
                                </span>
                            </div>
                            {{-- <div class="btn-list">
                                <button class="btn btn-sm btn-icon btn-info-light btn-wave"><i
                                        class="ri-edit-line"></i></button>
                                <button class="btn btn-sm btn-icon btn-danger-light btn-wave"><i
                                        class="ri-delete-bin-line"></i></button>
                            </div> --}}
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<!--End::row-1 -->

@include('corrective.upload_attachment')
@endsection

@section('js')
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
        const MultipleElement = document.querySelector('.blog-images');
        FilePond.create(MultipleElement, {
            storeAsFile: true
        });
    });
</script>
@endsection
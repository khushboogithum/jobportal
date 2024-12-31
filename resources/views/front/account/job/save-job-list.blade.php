@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('front.account.sidebar');
                </div>
                <div class="col-lg-9">
                    @include('front.message')
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">My Jobs</h3>
                                </div>
                                <div style="margin-top: -10px;">
                                    <a href="{{ route('account.createJob') }}" class="btn btn-primary">Post a Job</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Job Created</th>
                                            <th scope="col">Applicants</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if ($savejobs->isNotEmpty())
                                            @foreach ($savejobs as $savejob)
                                                <tr class="active">
                                                    <td>
                                                        <div class="job-name fw-500">{{ $savejob->job->title }}</div>
                                                        <div class="info1">{{ $savejob->job->jobType->name }} . {{ $savejob->job->location }}
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($savejob->created_at)->format('d M,Y') }}
                                                    </td>
                                                    <td>{{ $savejob->job->applications->count() }} Applications</td>
                                                    <td>
                                                        @if ($savejob->job->status == 1)
                                                            <div class="job-status text-capitalize">Active</div>
                                                        @else
                                                            <div class="job-status text-capitalize">Block</div>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        <div class="action-dots float-end">
                                                            <button class="btn" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('jobDetail', $savejob->job->id) }}"> <i
                                                                            class="fa fa-eye" aria-hidden="true"></i>
                                                                        View</a></li>
                                                                
                                                                <li><a class="dropdown-item" href="#"
                                                                        onclick="saveDeleteJob({{ $savejob->id }})"><i
                                                                            class="fa fa-trash" aria-hidden="true"></i>
                                                                        Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $savejobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        function saveDeleteJob(savejobId) {
           // alert(savejobId);
            if (confirm("Are you sure you want to delete this save job?")) {
                $.ajax({
                    url: "{{ route('account.savedeletejob') }}",
                    type: 'post',
                    data: {
                        savejobId: savejobId
                    },
                    dataType: 'json',
                    success: function(response) {
                        // if (response.status == true) {
                        //   console.log(response.status);
                        // } else {
                        //    console.log(response.status);
                        // }
                        window.location.href = '{{ route('account.saveJobList') }}';
                    }

                });
            }
        }
    </script>
@endsection

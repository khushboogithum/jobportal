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
                    <form action="" method="post" id="editJobForm">

                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Job Details</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" value="{{ $job->title }}" placeholder="Job Title"
                                            id="title" name="title" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select a Category</option>
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $job->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Type<span class="req">*</span></label>
                                        <select name="jobType" id="jobType" class="form-select">
                                            <option value="">Select Type</option>
                                            @if ($jobtype->isNotEmpty())
                                                @foreach ($jobtype as $jobtypes)
                                                    <option value="{{ $jobtypes->id }}"
                                                        {{ $job->job_type_id == $jobtypes->id ? 'selected' : '' }}>
                                                        {{ $jobtypes->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>

                                        <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" value="{{ $job->vacancy }}" min="1"
                                            placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Salary</label>
                                        <input type="text" value="{{ $job->salary }}" placeholder="Salary"
                                            id="salary" name="salary" class="form-control">
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text" value="{{ $job->location }}" placeholder="location"
                                            id="location" name="location" class="form-control">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="form-control" name="description" id="description" cols="5" rows="5"
                                        placeholder="Description">{{ $job->description }}</textarea>
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Benefits</label>
                                    <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $job->benefits }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Responsibility</label>
                                    <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5"
                                        placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Qualifications</label>
                                    <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5"
                                        placeholder="Qualifications">{{ $job->qualifications }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Keywords</label>
                                    <input type="text" value="{{ $job->keywords }}" placeholder="keywords"
                                        id="keywords" name="keywords" class="form-control">
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Experience<span class="req">*</span></label>
                                    <select name="experience" id="experience" class="form-control">
                                        <option value="1" {{ $job->experience == '1' ? 'selected' : '' }}>1 Year
                                        </option>
                                        <option value="2" {{ $job->experience == '2' ? 'selected' : '' }}>2 Year
                                        </option>
                                        <option value="3" {{ $job->experience == '3' ? 'selected' : '' }}>3 Year
                                        </option>
                                        <option value="4" {{ $job->experience == '4' ? 'selected' : '' }}>4 Year
                                        </option>
                                        <option value="5" {{ $job->experience == '5' ? 'selected' : '' }}>5 Year
                                        </option>
                                        <option value="6" {{ $job->experience == '6' ? 'selected' : '' }}>6 Year
                                        </option>
                                        <option value="7" {{ $job->experience == '7' ? 'selected' : '' }}>7 Year
                                        </option>
                                        <option value="8" {{ $job->experience == '8' ? 'selected' : '' }}>8 Year
                                        </option>
                                        <option value="9" {{ $job->experience == '9' ? 'selected' : '' }}>9 Year
                                        </option>
                                        <option value="10" {{ $job->experience == '10' ? 'selected' : '' }}>10 Year
                                        </option>
                                        <option value="10_plus" {{ $job->experience == '10_plus' ? 'selected' : '' }}>10+
                                            Years</option>
                                    </select>
                                    <p></p>
                                </div>
                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Name<span class="req">*</span></label>
                                        <input type="text" value="{{ $job->company_name }}"
                                            placeholder="Company Name" id="company_name" name="company_name"
                                            class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location</label>
                                        <input type="text" placeholder="Location"
                                            value="{{ $job->company_location }}" id="location" name="location"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Website</label>
                                    <input type="text" placeholder="Website" value="{{ $job->company_website }}"
                                        id="website" name="website" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update Job</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
        $("#editJobForm").submit(function(e) {
            e.preventDefault();
            //console.log($("#createJobForm").serializeArray());
            // return false;
            $("button[type='submit']").prop('disabled', true);
            $.ajax({
                url: '{{ route('account.updateJob', $job->id) }}',
                type: 'post',
                dataType: 'json',
                data: $("#editJobForm").serializeArray(),
                success: function(response) {
                    $("button[type='submit']").prop('disabled', false);
                    if (response.status == true) {
                        $("#title").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html('');
                        $("#category").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html('');
                        $("#jobTypes").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html('');
                        $("#vacancy").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html('');
                        $("#location").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html('');
                        $("#description").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html('');
                        $("#company_name").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html('');
                        window.location.href = "{{ route('account.myJobs') }}";
                    } else {
                        var errors = response.errors;
                        if (errors.title) { // Add an opening brace here
                            $("#title").addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.title);
                        } else {
                            $("#title").removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }
                        if (errors.category) { // Add an opening brace here
                            $("#category").addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.category);
                        } else {
                            $("#category").removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }
                        if (errors.jobType) { // Add an opening brace here
                            $("#jobType").addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.jobType);
                        } else {
                            $("#jobType").removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }
                        if (errors.vacancy) { // Add an opening brace here
                            $("#vacancy").addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.vacancy);
                        } else {
                            $("#vacancy").removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }
                        if (errors.location) { // Add an opening brace here
                            $("#location").addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.location);
                        } else {
                            $("#location").removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }
                        if (errors.description) { // Add an opening brace here
                            $("#description").addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.description);
                        } else {
                            $("#description").removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }
                        if (errors.company_name) { // Add an opening brace here
                            $("#company_name").addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.company_name);
                        } else {
                            $("#company_name").removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }
                    }
                }
            });
        });
    </script>
@endsection

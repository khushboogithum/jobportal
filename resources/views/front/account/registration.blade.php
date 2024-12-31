@extends('front.layouts.app')

@section('main')

<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>
                    <form action="" id="registrationForm" name="registrationForm">
                    <div class="mb-3">
                        <label for="name" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" autocomplete="name">
                            <p></p>
                        </div>

                        
                        <div class="mb-3">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" autocomplete="email">
                            <p></p>
                        </div> 
                        <div class="mb-3">
                            <label for="password" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                            <p></p>
                        </div> 
                        <div class="mb-3">
                            <label for="confirm_password" class="mb-2">Confirm Password*</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Enter Confirm Password">
                            <p></p>
                        </div> 
                        <button class="btn btn-primary mt-2 register" type="submit">Register</button>
                    </form>                    
                </div>
                <div class="mt-4 text-center">
                    <p>Have an account? <a  href="{{ route('account.login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')

<script>
    $(document).ready(function(){
        // Attach submit event to the form
        $('#registrationForm').submit(function(e){
            e.preventDefault(); // Prevents the default form submission
            $.ajax({
                url: '{{ route("account.processRegistration") }}',
                type: 'post',
                data: $("#registrationForm").serializeArray(),
                dataType: 'json', // Add a comma here
                success: function(response){
                    if(response.status == false){
                        var errors = response.errors;
                        if(errors.name){ // Add an opening brace here
                            $("#name").addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.name);
                        }else{
                            $("#name").removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }
                        if(errors.email){ // Add an opening brace here
                            $("#email").addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.email);
                        }else{
                            $("#email").removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }
                        if(errors.password){ // Add an opening brace here
                            $("#password").addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.password);
                        }else{
                            $("#password").removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }
                        if(errors.confirm_password){ // Add an opening brace here
                            $("#confirm_password").addClass('is-invalid')
                                .siblings('p').addClass('invalid-feedback')
                                .html(errors.confirm_password);
                        }else{
                            $("#confirm_password").removeClass('is-invalid')
                                .siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }
                    }else{
                        $("#name").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html('');
                        $("#email").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html(''); 
                        $("#password").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html('');   
                        $("#confirm_password").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html('');   
                        window.location.href='{{ route("account.login") }}';         
                    }
                }
            });
        });
    });
</script>

@endsection



    @extends('layout')

    @section('content')
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">Signup form</span>
            </div>

            <div class="panel-body">
                {{--Errors--}}
                @if(is_array($signupErrors) && count($signupErrors))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($signupErrors as $error)
                            <li>{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{--Successfull signup--}}
                @if($signupSuccessful === true)
                    <div class="alert alert-success">
                        {!! get_option('tamkeen_signup_success_message'); !!}
                    </div>
                @endif

                <p class="small">
                    Please fill and submit the form below with your information, and we will contact you as soon as possible.
                    Thanks.
                </p>

                {{--Form--}}
                <form action="{!! tamkeen_url('?view=signup&course=' . $course->id) !!}"
                    method="POST" name="signupForm" class="form-horizontal">

                    <input type="hidden" name="course_id" value="{!! $course->id !!}" />

                    {{--Course--}}
                    <div class="row">
                        <div class="control-label col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Selected course</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <h5>
                                <a href="{!! tamkeen_get_course_url($course) !!}">{!! $course->name !!}</a>
                            </h5>
                        </div>
                    </div>

                    {{--Name--}}
                    <div class="row">
                        <div class="control-label col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Name *</label>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <input name="name" value="{!! @$_POST['name'] !!}"
                                   type="text" class="form-control" required/>
                        </div>
                    </div>

                    {{--Phone number--}}
                    <div class="row">
                        <div class="control-label col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Phone number *</label>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <input name="phone_number" value="{!! @$_POST['phone_number'] !!}"
                                   type="tel" dir="ltr" lang="en_US"
                                   class="form-control" required/>
                        </div>
                    </div>

                    {{--Email--}}
                    <div class="row">
                        <div class="control-label col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Email</label>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <input name="email" value="{!! @$_POST['email'] !!}"
                                   type="email" dir="ltr" lang="en_US" class="form-control"/>
                        </div>
                    </div>

                    {{--Job title--}}
                    <div class="row">
                        <div class="control-label col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Job title</label>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <input name="job_title" value="{!! @$_POST['job_title'] !!}"
                                   type="text" class="form-control"/>
                        </div>
                    </div>

                    {{--Notes--}}
                    <div class="row">
                        <div class="control-label col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Notes</label>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <textarea name="note" rows="3" class="form-control">
                                {!! @$_POST['note'] !!}
                            </textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <button class="btn btn-primary" type="submit">
                                Submit
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    @endsection
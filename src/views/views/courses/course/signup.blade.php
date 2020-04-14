
    @extends('layout')

    @section('content')
        {{--Google reCaptcha--}}
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        {{--This prevents the form from being re-submitted with refresh--}}
        <script>
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>

        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">
                    {!! tamkeen_trans('Signup form', 'نموذج التسجيل') !!}
                </span>
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
                        {!! get_option('tamkeen_signup_success_message') !!}
                    </div>
                @endif

                <p class="small">
                    {!!
                        tamkeen_trans(
                            'Please fill and submit the form below with your information, and we will contact you as soon as possible. Thanks.',
                            'رجاءاً قم بملئ النموذج بالأسفل وسنقوم بالتواصل معك بالخطوات التالية.'
                        )
                    !!}
                </p>

                {{--Form--}}
                <form action="{!! tamkeen_url('?view=signup&course=' . $course->id) !!}"
                    method="POST" name="signupForm" class="form-horizontal">

                    <input type="hidden" name="course_signup_form" value="true" />
                    <input type="hidden" name="course_id" value="{!! $course->id !!}" />

                    {{--Course--}}
                    <div class="row">
                        <div class="control-label col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>{!! tamkeen_trans('Selected course', 'الدورة المختارة') !!}</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <h5>
                                <a href="{!! tamkeen_get_course_url($course) !!}">{!! $course->course->name !!}</a>
                            </h5>
                        </div>
                    </div>

                    {{--Name--}}
                    <div class="row">
                        <div class="control-label col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>{!! tamkeen_trans('name', 'الإسم') !!} *</label>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <input name="tamkeen_name" value="{!! @$_POST['tamkeen_name'] !!}"
                                   type="text" class="form-control" required/>
                        </div>
                    </div>

                    {{--Phone number--}}
                    <div class="row">
                        <div class="control-label col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>{!! tamkeen_trans('Phone number', 'رقم الهاتف') !!} *</label>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <input name="tamkeen_phone_number" value="{!! @$_POST['tamkeen_phone_number'] !!}"
                                   type="tel" dir="ltr" lang="en-US"
                                   class="form-control" required/>
                        </div>
                    </div>

                    {{--Email--}}
                    <div class="row">
                        <div class="control-label col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>{!! tamkeen_trans('Email', 'البريد الإلكتروني') !!}</label>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <input name="tamkeen_email" value="{!! @$_POST['tamkeen_email'] !!}"
                                   type="email" dir="ltr" lang="en-US" class="form-control"/>
                        </div>
                    </div>

                    {{--Job title--}}
                    <div class="row">
                        <div class="control-label col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>{!! tamkeen_trans('Job title', 'الوظيفة') !!}</label>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <input name="tamkeen_job_title" value="{!! @$_POST['tamkeen_job_title'] !!}"
                                   type="text" class="form-control"/>
                        </div>
                    </div>

                    {{--Notes--}}
                    <div class="row">
                        <div class="control-label col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>{!! tamkeen_trans('Notice', 'ملحوظات') !!}</label>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <textarea name="tamkeen_note" rows="3" class="form-control">
                                {!! @$_POST['tamkeen_note'] !!}
                            </textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="g-recaptcha" data-sitekey="{!! get_option('tamkeen_recaptcha_key') !!}"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <button class="btn btn-primary" type="submit">
                                {!! tamkeen_trans('Submit', 'إرسال') !!}
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    @endsection
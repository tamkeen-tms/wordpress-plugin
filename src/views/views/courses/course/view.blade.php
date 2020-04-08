
    @extends('layout')

    @section('content')
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="text-center">
                    <h4>{!! $course->course->name !!}</h4>

                    <ul class="list-inline">
                        <li>
                            <b>{!! $course->course->duration !!}</b>
                            {!! $course->course->_duration_unit_translated !!}
                        </li>

                        <li>
                            <b>{!! $course->course->cost !!}</b>

                            @if($course->course->cost_basis != 'trainee')
                                <span class="small">
                                    {!! $course->course->_cost_bases_translated !!}
                                </span>
                            @endif
                        </li>
                    </ul>
                </div>

                <blockquote>{!! $course->about !!}</blockquote>

                <div class="text-center">
                    <a href="{!! tamkeen_url('?view=signup&course=' . $course->id) !!}"
                       class="btn btn-sm btn-default">
                        Signup
                    </a>
                </div>
            </div>
        </div>
    @endsection
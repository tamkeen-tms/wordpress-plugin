
    @extends('layout')

    @section('content')
        {{--Breadcrumb--}}
        <ol class="breadcrumb">
            <li><a href="{!! tamkeen_url('?') !!}">Courses</a></li>
        	<li><a href="{!! tamkeen_url('?branch=' . $branch->id) !!}">{!! $branch->name !!}</a></li>
        	<li class="active">{!! $category->name !!}</li>
        </ol>

        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">{!! $category->name !!}</span>
            </div>

            <div class="panel-body">

                @if($courses->total == 0)
                    <div class="alert alert-info">
                        <span class="glyphicon glyphicon-info-sign"></span>
                        No courses under the selected category! Pick another category to view other courses.
                    </div>

                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Course</th>
                                <th width="120px">Duration</th>
                                <th width="120px">Cost</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($courses->data as $course)
                                <tr>
                                    <td>
                                        <a href="?view=course&course={!! $course->course->id !!}">
                                            {!! $course->course->name !!}
                                        </a>
                                    </td>

                                    <td>
                                        {!! $course->course->duration !!}
                                        <div class="small">
                                            {!! $course->course->_duration_unit_translated !!}
                                        </div>
                                    </td>

                                    <td>
                                        {!! $course->course->cost !!}

                                        @if($course->course->cost_basis != 'trainee')
                                            <div class="small">
                                                {!! $course->course->_cost_bases_translated !!}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    @endsection
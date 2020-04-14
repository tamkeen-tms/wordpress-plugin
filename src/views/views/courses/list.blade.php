
    @extends('layout')

    @section('content')
        {{--Breadcrumb--}}
        <ol class="breadcrumb">
            <li><a href="{!! tamkeen_url('?') !!}">{!! tamkeen_trans('Courses', 'الدورات') !!}</a></li>
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
                        {!! tamkeen_trans(
                            'No courses under the selected category! Pick another category to view other courses.',
                            'ليس هناك دورات تدريبية متاحة اسفل هذا التصنيف. إختر تصنيف آخر لعرض الدورات الآخري المتاحة.'
                        ) !!}
                    </div>

                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{!! tamkeen_trans('Course', 'الدورة') !!}</th>
                                <th width="120px">{!! tamkeen_trans('Duration', 'المدة') !!}</th>
                                <th width="120px">{!! tamkeen_trans('Cost', 'التكلفة') !!}</th>
                                <th width="120px"></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($courses->data as $course)
                                <tr>
                                    <td>
                                        <a href="{!! tamkeen_get_course_url($course) !!}">
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

                                    <td>
                                        <a href="{!! tamkeen_url('?view=signup&course=' . $course->id) !!}"
                                           class="btn btn-sm btn-default">
                                            {!! tamkeen_trans('Signup', 'التسجيل') !!}
                                        </a>
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
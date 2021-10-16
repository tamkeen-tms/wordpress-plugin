
    @extends('layout')

    @section('content')
        {{--Breadcrumb--}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{!! tamkeen_url('?') !!}">Courses</a></li>
                <li class="breadcrumb-item"><a href="{!! tamkeen_url('?branch=' . $branch->id) !!}">{!! $branch->name !!}</a></li>
                <li class="breadcrumb-item"><a href="{!! tamkeen_url('?view=category&id=' . $category->id) !!}">{!! $category->name !!}</a></li>
            </ol>
        </nav>

        <?php
            $coverImage = $course->catalog->cover_image_url;
        ?>

        <style>
            #course-cover-image{
                height: 300px;
                background: white url('{!! $coverImage !!}') center center;
                background-size: cover;
            }
        </style>

        @if($coverImage)
            <div id="course-cover-image" class="mb-4 rounded shadow"></div>
        @endif

        <header id="course-header" class="my-4 d-flex align-items-center">
            <div class="me-4">
                <img src="{!! $course->catalog->thumbnail_url !!}" style="max-height: 130px" class="rounded shadow"
                     alt="{!! $course->name !!}"/>
            </div>
            <div>
                <h3>{!! $course->name !!}</h3>

                <div class="mt-2">
                    <p class="small">Code: <b>{!! $course->code !!}</b></p>
                    <p class="text-muted small">{!! $course->description !!}</p>
                </div>

                @if($course->catalog->featured)
                    <div class="badge bg-primary extra-small">
                        <i class="bi bi-star"></i> Featured
                    </div>
                @endif
            </div>
        </header>

        <ul class="list-inline text-center">
            <li class="list-inline-item">
                <i class="bi bi-cash-stack"></i>
                <b>{!! $course->cost !!}</b>
                <span>{!! $course->currency !!}</span>

                @if($course->cost_basis != 'trainee')
                    <span class="text-muted">({!! $course->display_cost_basis !!})</span>
                @endif
            </li>

            @if($course->duration)
                <li class="list-inline-item">
                    <i class="bi bi-clock"></i>
                    <b>{!! $course->duration !!}</b>
                    <span>{!! $course->display_duration_unit !!}</span>
                </li>
            @endif
        </ul>

        @if($course->catalog->about)
            <div class="my-4">
                {!! $course->catalog->about !!}
            </div>
        @endif

    @endsection
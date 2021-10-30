
    @extends('layout')

    @section('breadcrumb')
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{!! tamkeen_url('?') !!}">{!! tamkeen_trans('global.breadcrumb_courses') !!}</a></li>
                <li class="breadcrumb-item"><a href="{!! tamkeen_url('?branch=' . $branch->id) !!}">{!! $branch->name !!}</a></li>
            </ol>
        </nav>
    @endsection

    @section('content')
        <header class="d-flex align-items-center my-4">
            <div class="me-4">
                <img src="{!! $category->thumbnail_url !!}" style="max-height: 100px"
                     alt="{!! $category->name !!}"/>
            </div>
            <div>
                <h3>{!! $category->name !!}</h3>
                <p class="text-muted small">{!! $category->description !!}</p>
            </div>
        </header>

        @if(count($courses) == 0)
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                {!! tamkeen_trans('category.no_courses') !!}
            </div>

        @else
            @include('courses.category.courses')
        @endif
    @endsection
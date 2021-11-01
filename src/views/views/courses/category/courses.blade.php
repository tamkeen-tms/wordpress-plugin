
    <div id="category-courses" class="row row-cols-1 row-cols-md-{!! get_option('tamkeen_grid_items_per_row', 3) !!} g-4">
        @foreach($courses as $course)
            <?php $url = tamkeen_url('?view=course&id=' . $course->id) ?>

            <div class="col course">
                <div class="card shadow">
                    <a href="{!! $url !!}">
                        @if($course->catalog->featured)
                            <div class="badge bg-primary small m-3 position-absolute" style="z-index: 100">
                                <i class="bi bi-star"></i> {!! tamkeen_trans('global.course_is_featured') !!}
                            </div>
                        @endif

                        <img src="{!! $course->catalog->thumbnail_url !!}" class="card-img-top" alt="{!! $course->name !!}">
                    </a>

                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{!! $url !!}" class="text-primary">
                                {!! $course->name !!}
                            </a>
                        </h5>

                        <b class="card-text extra-small">{!! $course->code !!}</b>

                        <p class="card-text extra-small text-muted">{!! $course->description !!}</p>

                        <ul class="list-inline extra-small mt-2">
                            <li class="list-inline-item">
                                <b>{!! $course->cost !!}</b>
                                <span>{!! $course->currency !!}</span>

                                @if($course->cost_basis != 'trainee')
                                    <span class="text-muted">({!! $course->display_cost_basis !!})</span>
                                @endif
                            </li>

                            @if($course->duration)
                            <li class="list-inline-item">
                                <b>{!! $course->duration !!}</b>
                                <span>{!! $course->display_duration_unit !!}</span>
                            </li>
                            @endif
                        </ul>

                        @if(is_array($_SESSION['tamkeen-cart']) && array_search($course->id, $_SESSION['tamkeen-cart']) !== false)
                            <a href="{!! tamkeen_url('?view=cart-remove&courseId=' . $course->id) !!}"
                               class="d-block mt-2 btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x-circle-fill"></i>
                                {!! tamkeen_trans('global.button_cancel_course_request') !!}
                            </a>

                        @elseif($course->catalog->accepts_requests == true)
                            <a href="{!! tamkeen_url('?view=cart-add&courseId=' . $course->id) !!}" 
                               class="d-block mt-2 btn btn-sm btn-outline-primary">
                                <i class="bi bi-cart3"></i>
                                {!! tamkeen_trans('global.button_request_course') !!}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <div id="category-courses" class="row row-cols-1 row-cols-md-4 g-4">
        @foreach($courses as $course)
            <?php $url = tamkeen_url('?view=course&id=' . $course->id) ?>

            <div class="col course">
                <div class="card shadow">
                    <a href="{!! $url !!}">
                        @if($course->catalog->featured)
                            <div class="badge bg-primary small m-3 position-absolute">
                                <i class="bi bi-star"></i> Featured
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

                        <div class="d-grid gap-2 mt-3">
                            <a href="" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-cart3"></i> Request now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

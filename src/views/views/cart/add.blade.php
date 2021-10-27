
    @extends('layout')

    @section('content')
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill"></i>
            {!! tamkeen_trans('cart.item_added') !!}

            <div class="mt-2">
                <a href="{!! $requestUrl !!}" class="btn btn-primary">
                    <i class="bi bi-check-circle-fill"></i>
                    {!! tamkeen_trans('cart.submit_requested') !!}
                </a>

                <a href="" onclick="history.back(); return false;" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-right"></i>
                    {!! tamkeen_trans('cart.continue_browsing') !!}
                </a>
            </div>
        </div>
    @endsection

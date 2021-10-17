
    @extends('layout')

    @section('content')
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill"></i>
            Selected course was added to your cart. Click the buttons below to submit your requested course(s) or continue browsing.

            <div class="mt-2">
                <a href="{!! $requestUrl !!}" class="btn btn-primary">
                    <i class="bi bi-check-circle-fill"></i>
                    Submit Requested
                </a>

                <a href="" onclick="history.back(); return false;" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-right"></i>
                    Continue browsing
                </a>
            </div>
        </div>
    @endsection

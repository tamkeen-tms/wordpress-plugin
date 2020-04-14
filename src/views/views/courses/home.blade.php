
    @extends('layout')

    @section('content')
        @if(!$selectedBranch)
            <p>
                {!! tamkeen_trans(
                    'Select the branch to view the available courses.',
                    'إختر الفرع الذي تريد عرض الدورات المتاحة عليه.'
                ) !!}
            </p>
        @endif

        {{--Branches--}}
        @if(count(get_object_vars($categories)) > 1)
            <div class="row">
                @foreach($categories as $branchId => $branch)
                    <div class="col-xs-12 col-md-3">
                        <div class="thumbnail <?=($selectedBranch && $selectedBranch->id == $branchId) ?'active' :''?>">
                            <h4>
                                <a href="?branch={!! $branch->branch->id !!}">
                                    {!! $branch->branch->name !!}
                                </a>
                            </h4>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{--Categories--}}
        @if($selectedBranch)
            <h3>{!! tamkeen_trans('Categories', 'التصنيفات') !!}</h3>

            <div class="card-columns">
                @foreach($categories->{$selectedBranch->id}->categories as $category)
                    <div class="card">
                        <img src="{!! $category->iconUrl !!}"
                             class="card-img-top" alt="{!! $category->name !!}">

                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="?view=courses&branch={!! $category->branch_id !!}&category={!! $category->id !!}">
                                    {!! $category->name !!}</a>
                            </h5>
                            <p class="card-text">
                                {!! $category->description !!}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

        @endif

    @endsection
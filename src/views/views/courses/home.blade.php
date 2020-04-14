
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">
                        {!! tamkeen_trans('Categories', 'التصنيفات') !!}
                    </span>
                </div>

                <div class="panel-body">
                    <div class="row">
                        @foreach($categories->{$selectedBranch->id}->categories as $category)
                            <div class="col-xs-12 col-md-3">
                                <div class="caption">
                                    <h5>
                                        <a href="?view=courses&branch={!! $category->branch_id !!}&category={!! $category->id !!}">
                                            {!! $category->name !!}</a>
                                    </h5>
                                    <p>
                                        {!! $category->description !!}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    @endsection
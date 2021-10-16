
    @extends('layout')

    @section('content')
        <style>
            #course-categories .category:not(.visible){ display: none; }
        </style>

        <script>
            let selectedBranchId = {!! $branchId ?: 'null' !!};

            jQuery(function(){
                let categories = jQuery('#course-categories'),
                    branchMenu = jQuery('#branch-select');

                // Watch the branch menu [change]
                branchMenu.on('change', function(){
                    // Get the selected branch
                	let id = jQuery(this).val();

                    categories.find('.category').removeClass('visible');

                    if(!!id){
                        categories.find('.category[data-branch-id=' + id + ']').addClass('visible');
                    }
                });

                if(!!selectedBranchId){
                    branchMenu.val(selectedBranchId)
                        .trigger("change");
                }
            });
        </script>

        @if(count($branches) > 0 && count($categories) > 0)
            <div class="row mb-4">
                <div class="col-sm-12 col-md-6">
                    <select id="branch-select" name="branch" class="form-control">
                        <option value="">{!! tamkeen_trans('home.select_branch') !!}</option>

                        @foreach($branches as $branch)
                            <option value="{!! $branch->id !!}">{!! $branch->name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle-fill"></i>
                {!! tamkeen_trans('home.no_categories') !!}
            </div>
        @endif

        @if(count($categories) > 0)
            <div id="course-categories" class="row row-cols-1 row-cols-md-4 g-4">
                @foreach($categories as $category)
                    <?php $url = tamkeen_url('?view=category&id=' . $category->id) ?>

                    <div class="col category" data-branch-id="{!! $category->branch_id !!}">
                        <div class="card shadow">
                            <a href="{!! $url !!}">
                                <img src="{!! $category->thumbnail_url !!}" class="card-img-top" alt="{!! $category->name !!}">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{!! $url !!}">
                                        {!! $category->name !!}
                                    </a>
                                </h5>
                                <p class="card-text small text-muted">{!! $category->description !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endsection
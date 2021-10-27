
    @extends('layout')

    @section('content')
        <script>
            let selectedBranchId = {!! $branchId ?: 'null' !!},
                baseUrl = '{!! tamkeen_url() !!}';

            jQuery(function(){
                let branchMenu = jQuery('#branch-select');

                // Watch the branch menu [change]
                branchMenu.on('change', function(){
                    // Get the selected branch
                	let id = jQuery(this).val();

                    if(!!id){
                        location.href = baseUrl + '?branch=' + id;
                    }
                });

                if(!!selectedBranchId){
                    branchMenu.val(selectedBranchId);
                }
            });
        </script>

        @if(count($branches) > 1)
            <div class="row mb-5">
                <div class="col-sm-12 col-md-6">
                    <label class="form-label" for="branch-select">{!! tamkeen_trans('home.select_branch') !!}</label>
                    <select id="branch-select" name="branch" class="form-control">
                        <option value=""></option>

                        @foreach($branches as $branch)
                            <option value="{!! $branch->id !!}">{!! $branch->name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        @if(!empty($branchId))
            <div class="mb-4">
                <h4>{!! tamkeen_trans('home.categories_list') !!}</h4>
                <p class="small">{!! tamkeen_trans('home.pick_category_hint') !!}</p>
            </div>

            @if(count($categories) > 0)
                <div id="course-categories" class="row row-cols-1 row-cols-md-{!! get_option('tamkeen_grid_items_per_row', 4) !!} g-4">
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
                                    <p class="card-text extra-small text-muted">{!! $category->description !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill"></i>
                    {!! tamkeen_trans('home.no_categories') !!}
                </div>
            @endif
        @endif
    @endsection
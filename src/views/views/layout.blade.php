
    <style>
        #tamkeen-plugin {max-width: none;}
        #tamkeen-plugin .extra-small{ font-size: .9rem; line-height: 24px }
        #tamkeen-plugin .bi{ margin: 0 5px; }
    </style>

    <script type="text/javascript">
        // Reload the page when the user hits the back button
        window.addEventListener("pageshow", function(event){
            var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window.performance.navigation.type === 2);
            if(historyTraversal){
                // Handle page restore.
                window.location.reload();
            }
        });
    </script>

    <div id="tamkeen-plugin" class="container-fluid">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                @yield('breadcrumb')
            </div>

            <div>
                <?php
                $numCartItems = isset($_SESSION['tamkeen-cart']) ?count($_SESSION['tamkeen-cart']) :0;
                ?>

                <i class="bi bi-cart3"></i>

                @if($numCartItems > 0)
                    {!! $numCartItems !!} {!! tamkeen_trans('cart.num_items') !!}

                    <div>
                        <a href="{!! tamkeen_url('?view=cart-request') !!}" class="btn btn-sm btn-success">
                            <i class="bi bi-check-circle-fill"></i>
                            {!! tamkeen_trans('cart.submit_request') !!}
                        </a>

                        <a href="{!! tamkeen_url('?view=cart-empty') !!}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-x-circle-fill"></i>
                            {!! tamkeen_trans('cart.empty') !!}
                        </a>
                    </div>

                @else
                    {!! tamkeen_trans('cart.is_empty') !!}
                @endif
            </div>
        </div>

        @yield('content')
    </div>

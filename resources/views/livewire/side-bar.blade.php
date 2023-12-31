
<style>
    .o-hidden{
        overflow-y: hidden !important;
    }

</style>



<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 o-hidden"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard') }}">
            <span class="ms-3 font-weight-bold">{{__('Administración')}}</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: 100%">
        <ul class="navbar-nav">
            <li class="nav-item pb-2">
                <a class="nav-link {{ Route::currentRouteName() == 'user-management' ? 'active' : '' }}"
                    style="cursor: pointer" id="menu">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center
                        {{ in_array(request()->route()->getName(),['user-management']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('DB')}}</span>
                </a>
            </li>

            @foreach ($tables as $table)
                <?php 
                    $link = str_replace(" ", "_", $table->label);
                ?>
                <li class="nav-item pb-2 item-bd" style="display: none;">
                    <a class="nav-link {{ Route::currentRouteName() == 'user-management' ? 'active' : '' }}"
                        href="/table-management/{{$link}}" id="menu">
                        <span class="nav-link-text ms-1">{{$table->label}}</span>
                    </a>
                </li>
            @endforeach

            <li class="nav-item pb-2">
                <a class="nav-link {{ Route::currentRouteName() == 'user-management' ? 'active' : '' }}"
                    style="cursor: pointer" id="menu2">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center
                        {{ in_array(request()->route()->getName(),['user-management']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Productos')}}</span>
                </a>
            </li>

            @foreach ($tables2 as $table)
                <?php 
                    $link = str_replace(" ", "_", $table->label);
                ?>
                <li class="nav-item pb-2 item-bd2" style="display: none;">
                    <a class="nav-link {{ Route::currentRouteName() == 'user-management' ? 'active' : '' }}"
                        href="/table-management/{{$link}}" id="menu">
                        <span class="nav-link-text ms-1">{{$table->label}}</span>
                    </a>
                </li>
            @endforeach

            <li class="nav-item pb-2">
                <a class="nav-link {{ Route::currentRouteName() == 'user-management' ? 'active' : '' }}"
                    href="/table-management/Tiendas">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center
                        {{ in_array(request()->route()->getName(),['user-management']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Tiendas')}}</span>
                </a>
            </li>

            <li class="nav-item pb-2">
                <a class="nav-link {{ Route::currentRouteName() == 'user-management' ? 'active' : '' }}"
                    href="/table-management/Usuarios">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center
                        {{ in_array(request()->route()->getName(),['user-management']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Usuarios')}}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}"
                    href="{{ route('profile') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>customer-support</title>
                            <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Rounded-Icons" transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF"
                                    fill-rule="nonzero">
                                    <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                                        <g id="customer-support" transform="translate(1.000000, 0.000000)">
                                            <path class="color-background"
                                                d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z"
                                                id="Path" opacity="0.59858631"></path>
                                            <path class="color-foreground"
                                                d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z"
                                                id="Path"></path>
                                            <path class="color-foreground"
                                                d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z"
                                                id="Path"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Mi perfil')}}</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    $("#menu").click(() => {
        if($("#menu").attr('class').includes('act')){
            $("#menu").removeClass('act');
            $(".item-bd").fadeOut();
        }else{
            $("#menu").addClass('act');
            $(".item-bd").fadeIn();
        }
    });

    $("#menu2").click(() => {
        if($("#menu2").attr('class').includes('act')){
            $("#menu2").removeClass('act');
            $(".item-bd2").fadeOut();
        }else{
            $("#menu2").addClass('act');
            $(".item-bd2").fadeIn();
        }
    });
</script>


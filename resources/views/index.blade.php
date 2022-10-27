<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Task</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <style>
        .products {
            display: flex;
            flex-wrap: wrap;
        }

        .product {
            background: #fefe;
            width: 17%;
            text-align: center;
            padding: 15px;
            border-radius: 15px;
            margin: 15px;
        }
    </style>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">Start Bootstrap</div>
            <div class="list-group list-group-flush">
                <input type="text" name="search" id="search" placeholder="Search...">

                <div class="categories">
                    <h4>Categories</h4>

                    <div class="categories-list">
                        @foreach ($categories as $key => $category)
                            <div class="row"
                                style="justify-content: left;
                        margin-left: 20px;">
                                <input type="checkbox" style="width: auto"id="category_{{ $key }}"
                                    name="categories[]" class="category-input" value="{{ $category }}">
                                <label for="category_{{ $key }}"
                                    style="width: auto">{{ $category }}</label>
                            </div>
                        @endforeach


                    </div>
                </div>


                <div class="brands">

                    <h4>Brans</h4>
                    <div class="brands-list">
                        @foreach ($brands as $key => $brand)
                            <div class="row"
                                style="justify-content: left;
                        margin-left: 20px;">
                                <input type="checkbox" style="width: auto" id="brand_{{ $key }}"
                                    name="brands[]" class="brands-input" value="{{ $brand }}">
                                <label for="brand_{{ $key }}" style="width: auto">{{ $brand }}</label>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"><span
                            class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="#!">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Link</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#!">Action</a>
                                    <a class="dropdown-item" href="#!">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#!">Something else here</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <div class="container-fluid">



                <div class="products">
                    {{-- <div class="product">
                        <h1> Product 1</h1>
                    </div> --}}



                </div>


            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>


    <script>
        $(document).ready(function() {

            load_data('');
            let l = [];
            $(".brands-input,.category-input").change(function() {

                var checked = $('input:checked');

                checked.each(function() {
                    l.push($(this).val())
                });

                $('.products').empty()
                
                load_data('', l);
            })

            $("#search").keyup(function() {
                $('.products').empty()
                load_data('', l, $(this).val());
            })

            function load_data(id = "", filter, search) {
                $.ajax({
                    url: "{{ route('products.index') }}",
                    method: "POST",
                    data: {
                        id: id,
                        filter: filter,
                        search: search,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('#more').remove();
                        $('.products').append(data);
                    }
                })
            }

            $(document).on('click', '#more', function() {
                var id = $(this).data('id');
                $('#more').html('<b>Loading...</b>');
                load_data(id);
            });

        });
    </script>
</body>

</html>

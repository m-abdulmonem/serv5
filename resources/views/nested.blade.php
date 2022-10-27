@php
    $cats = \App\Models\Category::with(['parent', 'children', 'Ads'])
        ->whereNull('parent_id')
        ->get();
    function tree($cats, $child = false)
    {
        $html = $child ? '<li class=dropdown-submenu>' : '<li>';

        if ($cats->Ads->count() > 0 || $cats->children->count() > 0) {
            // if($child){
            $html .= "<a class='test' tabindex='-1'>{$cats->name} <span class=caret></span></a>";
            // }
            // $html .= "<li>{$cats->name}</li>";
        }

        if ($cats->children->count() > 0) {
            foreach ($cats->children as $cat) {
                if ($cat->ads->count() > 0) {
                    $html .= ' <ul class="dropdown-menu">';
                    $html .= "<li>{$cat->id}: {$cat->name}</li>";
                    $html .= '</ul>';
                }
                if ($cat->children->count() > 0) {
                    $html .= ' <ul class="dropdown-menu">';
                    $html .= '<li>' . tree($cat, true) . '</li>';
                    $html .= '</ul>';
                }
            }
        }
        return "$html </li>";
    }

    // foreach ($cats as $cat) {
    //     $htmlG .= tree($cat);
    // }

    // return  "$htmlG";

@endphp

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="dropdown">
            @foreach ($cats as $cat)
                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Tutorials
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">

                    {!! tree($cat, true) !!}
                    {{--
                    <li><a tabindex="-1" href="#">HTML</a></li>
                    <li><a tabindex="-1" href="#">CSS</a></li>
                    <li class="dropdown-submenu">
                        <a class="test" tabindex="-1" href="#">New dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="#">2nd level dropdown</a></li>
                            <li><a tabindex="-1" href="#">2nd level dropdown</a></li>
                            <li class="dropdown-submenu">
                                <a class="test" href="#">Another dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">3rd level dropdown</a></li>
                                    <li><a href="#">3rd level dropdown</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> --}}

                </ul>
            @endforeach
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.dropdown-submenu a.test').on("click", function(e) {
                $(this).next('ul').toggle();
                e.stopPropagation();
                e.preventDefault();
            });
        });
    </script>

</body>

</html>

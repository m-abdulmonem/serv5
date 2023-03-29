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

    function flatten(array $array)
    {
        $return = [];
        array_walk_recursive($array, function ($a) use (&$return) {
            $return[] = $a;
        });
        return $return;
    }

    function tree1($cats, $child = false)
    {
        $var = [];

        if ($cats->children->count() > 0) {
            foreach ($cats->children as $cat) {
                $var[$cats->id][$cat->id] = $cat->Ads->count() > 0 ? $cat->name : null;

                // if (array_key_exists($cats->id, $var) && array_key_exists($cat->id, $var) && empty(($a = $var[$cats->id])) || $var[$cats->id][$cat->id] == null || $var[$cats->id][$cat->id] == [] || empty(($var[$cats->id][$cats->id]) ||empty($var[$cat->id][$cat->id])) ) {
                //     unset($var[$cats->id][$cat->id]);
                // }

                if ($cat->children->count() > 0) {
                    // if (array_key_exists($cats->id, $var) && array_key_exists($cat->id, $var)) {
                        $var[$cats->id][$cat->id] = tree1($cat, true, $var);
                    // }
                }
            }
        }
        return $var;
    }
    $f = [];
    foreach ($cats as $cat) {
        $f[] = tree1($cat, false);
    }

    dd($f);
    function re($value)
    {
        $var = [];
        foreach ($value as $key => $item) {
            if (array_key_exists($key,$item)) {
                $var[$key] = $item[$key];
            }
        }
        return $var;
    }
    $ff= [];
    foreach ($f as $key => $value) {
       if(array_key_exists($key,$value)){
        $ff[] = re($value);
       }
    }

    dd($ff);

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
        <ul id="tree1">

            @foreach ($cats as $category)
                <li>

                    {{ $category->name }}

                    @if (count($category->children))
                        {!! tree($category) !!}
                        {{-- @include('manageChild', ['childs' => $category->children]) --}}
                    @endif

                </li>
            @endforeach

        </ul>
    </div>


    <div class="container">

        <div class="dropdown">
            @foreach ($cats as $key => $cat)
                @if (count($cat->children))
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                        {{ $cat->name }}
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu">
                        <li>
                            @include('manageChild', ['childs' => $cat->children, 'isFirst' => true])
                        </li>

                        {{-- {!! tree($cat, true) !!} --}}
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
                @elseif (count($cat->Ads))
                    <button class="btn btn-default ">
                        {{ $cat->name }}
                    </button>
                @endif
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

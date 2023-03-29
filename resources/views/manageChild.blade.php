    @foreach ($childs as $child)
        <ul class="{{ !$isFirst ? 'dropdown-menu' : 'dropdown-submenu' }}" a="{{ $child->children->pluck('Ads') }}">

            @if ($child->Ads->count() && !$child->children->pluck('Ads')->count())
                <li>
                    {{ $child->name }}
                </li>

            @endif

            @if ($child->children->count() )
                <li>
                    <a class="test" tabindex="-1" href="#">{{ $child->name }}<span class="caret"></span></a>

                    @include('manageChild', ['childs' => $child->children, 'isFirst' => false])
                </li>

            @endif

        </ul>
    @endforeach


    {{-- @foreach ($childs as $child)
        <ul class="{{ !$isFirst ? 'dropdown-menu' : 'dropdown-submenu' }}">

            @if ($child->Ads->count())
                <li>
                    {{ $child->name }}
                </li>
            @endif
            @if (count($child->children))
                <li>
                    <a class="test" tabindex="-1" href="#">{{ $child->name }}<span class="caret"></span></a>

                    @include('manageChild', ['childs' => $child->children, 'isFirst' => false])
                </li>
            @endif

        </ul>
    @endforeach --}}

@props(['category'])
        <li>{{ $category->title_persian }}</li>
        @foreach ($category->children as $child)
            <x-category-child :category="$child" />
        @endforeach

    


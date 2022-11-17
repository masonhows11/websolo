@foreach($child as $sub)
    <div class="card  item-category d-flex justify-content-between ">
        <div class="card-header">
            {{--start category content --}}
            <div class="item-category-title">
                @if(count($sub->children))
                    <a class="btn my-3" href="#collapse{{ $sub->id }}"
                       data-bs-toggle="collapse"><h6>{{ $sub->title_persian }}</h6></a>

                @else
                    <a class="btn my-3" href="#collapse{{ $sub->id }}"
                       data-bs-toggle="collapse">{{ $sub->title_persian }}</a>

                @endif
            </div>


            <div class="item-category-actions my-4">
                <a href="{{ route('admin.categoryActivate',[$sub]) }}"
                   class="mx-5 btn {{ $sub->is_active == 1 ? 'btn-success' : 'btn-danger' }} btn-sm"  >{{ $sub->is_active == 1 ? 'فعال' : 'غیر فعال' }}</a>
                @if($sub->parent_id == null)
                    <a href="{{ route('admin.categoryEdit',[$sub]) }}" class="mx-4"><i class="fas fa-edit"></i></a>

                @else
                    <a href="{{ route('admin.categoryEdit',[$sub]) }}" class="mx-4"><i class="fas fa-edit"></i></a>
                    <a href="{{ route('admin.categoryDetach',[$sub]) }}" class="mx-4"><i class="fa fa-unlink"></i></a>
                    <a href="#"><i class="fas fa-trash" id="delete_item" data-cat="{{ $sub->id }}"></i></a>
                @endif
            </div>
            {{--end category content --}}
        </div>
    </div>
    <div class="collapse show" id="collapse{{$sub->id}}">
        @if(!$sub->chlidren)
            @include('dash.admin_category.child_category',['child'=>$sub->children])
        @endif
    </div>
@endforeach

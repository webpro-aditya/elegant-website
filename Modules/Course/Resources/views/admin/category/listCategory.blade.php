@section('title', 'List Course Categories')

@push('script')
    <script src="{{ mix('js/admin/category/listCategory.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/category/listCategory.css') }}">
@endpush


<x-layout>

    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
            <a href="{{ route('course_category_add') }}" class="btn btn-primary">Add Category</a>
        </x-toolbar>
    @endsection

    <div>
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 active" href="#" id="category-tab"><span
                        id="overview-span">Category</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6" href="#" id="subcategory-tab">Sub
                    category</a>
            </li>
        </ul>
    </div>
    <div class="mt-6">
        <div id="categoryTabContent">
            <div class="card-body">
                @include('course::admin.category.tabViews.categoryTab')
            </div>
        </div>
        <div id="subcategoryTabContent" style="display: none;">
            <div class="card-body">
                @include('course::admin.category.tabViews.subCategory')
            </div>
        </div>
    </div>

</x-layout>

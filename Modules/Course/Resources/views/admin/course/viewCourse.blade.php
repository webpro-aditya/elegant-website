@section('title', 'View Course')

@push('script')
<script src="{{ mix('js/admin/course/listCourse.js') }}"></script>
@endpush

@push('style')
<link rel="stylesheet" type="text/css" href="{{ mix('css/admin/course/listCourse.css') }}">
@endpush

<x-layout>


    @section('toolbar')
    <x-toolbar :breadcrumbs="$breadcrumbs">
    </x-toolbar>
    @endsection
    @include('course::admin.course.courseInfo', ['activeMenu' => 'overview' , 'course' => $course,  'mainModuleCount'=> $mainModuleCount])


</x-layout>

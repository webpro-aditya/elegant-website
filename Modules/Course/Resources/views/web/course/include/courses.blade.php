@foreach ($courses as $course)
    <div class="col-6 col-lg-4 col-xxl-3 mt-5 list-grid">
        <div class="course-list p-5">
            <a href="{{ route('web_course_detail', ['course' => $course->slug, 'locale' => app()->getLocale()]) }}"
                class="position-relative">
                <img src="{{ $course->thumbnail_url && Storage::disk('elegant')->exists($course->thumbnail_url)
                    ? Storage::disk('elegant')->url($course->thumbnail_url)
                    : asset('images/web/course-image.png') }}"
                    alt="{{ $course->name }}" class="w-100 mb-3">

                <span>
                    {{ $course->categories->title ?? null }}
                </span>
                <h2 class="mt-4">{{ $course->name }}</h2>
                <div class="content">{{ $course->defaultLocale->short_description ?? '' }}</div>
                {{-- <div class="price-div">
                    @if ($course->pricing_format == 'free')
                        Free
                    @else
                        AED {{ $course->fee }}
                    @endif
                </div> --}}
            </a>
        </div>
    </div>
@endforeach

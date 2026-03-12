<div class="members-list bg-white rounded p-5 mb-5">
    @foreach ($careers as $career)
        <div class="row"> 
            <div class="col-lg-8">
                <div class="row m-0">
                    <h3 class="p-0 mb-5">{{ $career->defaultLocale->name }}</h3>
                    <ul class="p-0 hiring-details">
                        <li class="h-30px"><img src="{{ asset('images/web/digital-marketing.png') }}" alt="">
                            {{ $career->localized_category_name }}
                        <!-- <li class="h-30px"><img src="{{ asset('images/web/digital-marketing.png') }}" alt="">
                            {{ $career->localized_category_name }}
                        </li> -->
                        <li class="h-30px"><img src="{{ asset('images/web/clock-icon.png') }}" alt="">
                        {{ app()->getLocale() == 'en' ? $translations[$career->employment]['value_en'] : $translations[$career->employment]['value_ar'] }}
                          </li>
                        <!-- <li class="h-30px"><img src="{{ asset('images/web/user.png') }}" alt=""> -->
                        <!-- <li class="h-30px"><img src="{{ asset('images/web/clock-icon.png') }}" alt="">
                        {{ app()->getLocale() == 'en' ? $translations[$career->employment]['value_en'] : $translations[$career->employment]['value_ar'] }} -->
                        <li class="h-30px"><img src="{{ asset('images/web/user.png') }}" alt="">
                            {{ $career->vaccancy }} {{ app()->getLocale() == 'en' ? $translations['vacancies']['value_en'] : $translations['vacancies']['value_ar'] }}
                              </li>
                        <li class="h-30px"><img src="{{ asset('images/web/map.png') }}" alt="">
                            {{ $career->defaultLocale->location }}</li>
                    </ul>
                </div>
                <div class="row m-0 mt-5">
                    <h3 class="p-0 mb-5">Skills</h3>
                    <div class="d-flex p-0">
                        <ul class="p-0 skills-list mb-0">
                            @foreach (json_decode($career->defaultLocale->skill, true) as $skill)
                                <li class="mb-2">{{ $skill['value'] }}</li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row m-0 justify-content-lg-end">
                    <div class="experience btn rounded py-3 w-auto">
                        {{ $career->experience }} {{ app()->getLocale() == 'en' ? $translations['years_of']['value_en'] : $translations['years_of']['value_ar'] }}  {{ app()->getLocale() == 'en' ? $translations['experience']['value_en'] : $translations['experience']['value_ar'] }}  
                    </div>
                </div>
                <div class="row m-0 justify-content-lg-end">
                    <button type="button" class="apply-now btn rounded py-3 mt-5 mt-lg-10 w-auto" data-url="{{ route('web_apply_hiring', ['career_id' => $career->id]) }}">
                    {{ app()->getLocale() == 'en' ? $translations['apply_now']['value_en'] : $translations['apply_now']['value_ar'] }}  <i class="ki-outline ki-plus fs-3 text-inverse-dark"></i>
                    </button>
                </div>
            </div>
        </div>
        @if (!$loop->last)
            <hr>
        @endif
    @endforeach


    <div class="modal fade" id="careerEnquiryModal" tabindex="-1" aria-labelledby="careerEnquiryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="careerEnquiryModalLabel">
                    {{ app()->getLocale() == 'en' ? $translations['apply_now']['value_en'] : $translations['apply_now']['value_ar'] }} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Dynamic content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    
</div>

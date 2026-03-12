<form novalidate="novalidate" id="seoForm"
    class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework"
    action="{{ route('seo_update') }}" enctype="multipart/form-data" method="POST">
    @csrf
    <input type="hidden" name="seo_id" id="seo_id" value="{{$seo->id}}">
    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>SEO Details</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label class="required form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control mb-2" placeholder="meta_title"
                        value="{{ $seo->meta_title }}" id="meta_title">
                    @error('meta_title')
                        <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label class=" form-label">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" 
                        class="form-control min-h-200px mb-2">{{ old('meta_description', $seo->meta_description) }}</textarea>
                </div>
                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label class=" form-label">Meta Contents</label>
                    <textarea id="meta_contents" name="meta_contents" 
                        class="form-control min-h-200px mb-2">{{ old('meta_contents', $seo->meta_contents) }}</textarea>
                </div>
                
                 <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label class="form-label">Canonical Tag URL</label>
                    <textarea id="canonical_tag_url" name="canonical_tag_url" 
                        class="form-control min-h-100px mb-2">{{ old('canonical_tag_url', $seo->canonical_tag_url) }}</textarea>
                </div>

                @if (isset($type))
                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label class=" form-label">Google Analytics Header</label>
                    <textarea id="google_analytics_head" name="google_analytics_head" 
                        class="form-control min-h-200px mb-2">{{ old('google_analytics_head', $seo->google_analytics_head) }}  </textarea>
                </div>

                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label class=" form-label">Google Analytics Body</label>
                    <textarea id="google_analytics_body" name="google_analytics_body" 
                        class="form-control min-h-200px mb-2">{{ old('google_analytics_body', $seo->google_analytics_body) }} </textarea>
                </div>

                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label class=" form-label">Google Analytics Footer</label>
                    <textarea id="google_analytics_footer" name="google_analytics_footer" 
                        class="form-control min-h-200px mb-2">{{ old('google_analytics_footer', $seo->google_analytics_footer) }}  </textarea>
                </div>
                @endif
            </div>
        </div>
       
    </div>
</form>

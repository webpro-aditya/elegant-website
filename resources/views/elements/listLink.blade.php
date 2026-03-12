@if (isset($data['url']) && $data['url'])
    <a href="{{ $data['url'] }}" class="menu-link">
        @if (isset($data['image']) && $data['image'])
            <img src="{{ $data['image'] }}" width="35px" class="list-image">
        @endif
        {{ $data['text'] }}
    </a>
@elseif(isset($data['url_remote']) && $data['url_remote'])
    <div class="menu-item px-3">
        <button type="button" class="menu-link border-0 w-100" kt-load-remote-init="false" kt-load-remote-html="true" data-url="{{ $data['url_remote'] }}">{{ $data['text'] }}</button>
    </div>
@else
    {{ $data['text'] }}
@endif

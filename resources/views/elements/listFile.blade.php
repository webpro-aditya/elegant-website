@if ($data['src'])
    @php
        $extension = pathinfo($data['src'], PATHINFO_EXTENSION);
        $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $isImage = in_array(strtolower($extension), $allowedImageExtensions);
    @endphp
    @if ($isImage)
        <a href="{{ Storage::disk('fas')->url($data['src']) }}" target="_blank">
            <img src="{{ Storage::disk('fas')->url($data['src']) }}" width="35px">
        </a>
    @else
        <a href="{{ Storage::disk('fas')->url($data['src']) }}" target="_blank">
            <img src="{{ asset('images/icons/duotune/files/fil003.svg') }}" width="35px">
        </a>
    @endif
@endif

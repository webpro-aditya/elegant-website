<div class="card-title">
    <div class="d-flex align-items-center position-relative my-1">
        <span class="svg-icon svg-icon-1 position-absolute ms-6">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
            </svg>
        </span>
        <input type="text" data-kt-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search" />
    </div>
</div>
<div class="card-toolbar">
    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
        <button type="button" class="btn btn-light-primary me-3 p-4" data-kt-table-filter="refresh">
            <span class="svg-icon svg-icon-2">
                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 2A14 14 0 0 0 2 16a14 14 0 0 0 14 14 14 14 0 0 0 10-4l-2.75-3A10 10 0 0 1 16 26 10 10 0 0 1 6 16 10 10 0 0 1 16 6a10 10 0 0 1 7.25 3L19 13h11V2l-4 4a14 14 0 0 0-10-4" data-name="refresh" fill="currentColor" />
                </svg>
            </span>
        </button>
        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <span class="svg-icon svg-icon-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
                </svg>
            </span>
            Filter
        </button>
        {{ $slot }}
    </div>
</div>

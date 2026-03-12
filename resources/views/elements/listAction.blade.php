@if ((isset($data['view_url']) && $data['view_url']) || (isset($data['edit_url']) && $data['edit_url']) || (isset($data['delete_url']) && $data['delete_url']) || (isset($data['renewal_url']) && $data['renewal_url']))
    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start">
        <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primarymenu-link">Actions
            <span class="svg-icon svg-icon-5 m-0">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                </svg>
            </span>
        </a>
    </div>
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
        @if (isset($data['view_url']) && $data['view_url'])
            <div class="menu-item px-3">
                <a href="{{ $data['view_url'] }}" class="menu-link px-3">View</a>
            </div>
        @endif

        @if (isset($data['edit_url']) && $data['edit_url'])

            <div class="menu-item px-3">
                @if ($data['drawer'] ?? false)
                    <a href="javascript:void(0);" class="menu-link px-3" data-kt-load-drawer="true" data-url="{{ $data['edit_url'] }}">Edit </a>
                @else
                    <a href="{{ $data['edit_url'] }}" class="menu-link px-3 ">Edit</a>
                @endif
            </div>
        @endif
        @if (isset($data['delete_url']) && $data['delete_url'])
            <div class="menu-item px-3">
                <a href="javascript:void(0);" data-url="{{ $data['delete_url'] }}" class="menu-link px-3" data-kt-table-delete="delete_row">Delete</a>
            </div>
        @endif
        @if (isset($data['edit_remote_url']) && $data['edit_remote_url'])
            <div class="menu-item px-3">
                <button type="button" class="menu-link px-3 border-0 w-100" kt-load-remote-init="false" kt-load-remote-html="true" data-url="{{ $data['edit_remote_url'] }}">Edit</button>
            </div>
        @endif
        @if (isset($data['renewal_url']) && $data['renewal_url'])
            <div class="menu-item px-3">
                @if ($data['drawer'] ?? false)
                    <a href="javascript:void(0);" class="menu-link px-3" data-kt-load-drawer="true" data-url="{{ $data['renewal_url'] }}">Renew </a>
                @else
                    <a href="{{ $data['renewal_url'] }}" class="menu-link px-3">Renew</a>
                @endif
            </div>
        @endif
    </div>
@endif

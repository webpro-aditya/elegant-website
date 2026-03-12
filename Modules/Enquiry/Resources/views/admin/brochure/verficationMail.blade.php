<div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
    <!--begin::Email template-->
    <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
    <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
        <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                <tbody>
                    <tr>
                        <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                            <!--begin:Email content-->
                            <div style="text-align:center; margin:0 15px 34px 15px">
                                <!--begin:Logo-->
                                {{-- <div style="margin-bottom: 10px">
                                    <a href="" rel="noopener" target="_blank">
                                        <img alt="Logo" src="{{Storage::disk('tracez')->url('app/logo_light.png')}}" style="height: 35px" />
                                    </a>
                                </div> --}}

                                <!--begin:Text-->
                                <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                    <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hey {{$brochure->name}}, thanks for joining with us!</p>

                                </div>
                                <!--end:Text-->
                                <!--begin:Action-->
                                <a href='{{url('/verify-email?token=' . $brochure->verification_token )}}' target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">Verify Account</a>
                                <!--begin:Action-->
                            </div>
                            <!--end:Email content-->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                            <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px">It’s all about customers!</p>
                            <p style="margin-bottom:2px">Call our customer care number: {{$settings['phone']->value}}</p>
                            <p style="margin-bottom:4px">You may reach us at
                            <a href="mailto:{{ $settings['email']->value }}" rel="noopener" target="_blank" style="font-weight: 600">{{$settings['email']->value}}</a>.</p>
                            <p>We serve Mon-Fri, 9AM-18AM</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                            <p>&copy; Copyright .
                            <a href="" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp; from newsletter.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!--end::Email template-->
</div>

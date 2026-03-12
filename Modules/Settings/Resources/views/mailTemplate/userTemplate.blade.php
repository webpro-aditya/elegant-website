<div style="background: #f2f2f2; margin: 0; font-family: sans-serif; line-height: 26px;">
    <div class="content-section" style="width: 100%;max-width: 680px;margin: auto;">
        <div class="header" style="background-color: #000000;box-shadow: 0 5px 30px 0 rgba(0,0,0,.1); background-image: url({{asset('images/frontend/layouts/header-bg-email.png')}});background-repeat: no-repeat;background-position: center;background-size: cover;">
        <img style="width:160px;margin:auto; display:table; padding:10px" src="{{asset('storage/app/logo_light.png')}}">
        </div>
        <div class="content" style="background-color: #fff;min-height: 400px; padding: 20px 10%;background-image: url({{asset('images/frontend/layouts/content-bg-email.png')}});background-repeat: no-repeat;background-position: center;background-size: cover;">
         {@{{ body }}}
        </div>
        <div class="footer" style="background: #e1dfe9; text-align: center; padding: 20px 5px;">
            <p style="margin: 0; font-size: 12px;">
                2024 Elegant LMS. All Rights Reserved
            </p>
            <!-- <ul style="margin:0;padding:0;">
                <li style="float: left; display: contents;">
                <a style="color: #333; font-size: 12px;" href="{{route('')}}">Privacy Policy</a>
                </li>
                <li style="float: left; display: contents;">
                <a style="color: #333; font-size: 12px;" href="{{route('')}}">Terms and Conditions</a>
                </li>
            <ul> -->
        </div>
    </div>
</div>
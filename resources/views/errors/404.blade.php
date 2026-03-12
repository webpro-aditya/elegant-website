<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
        text-align: center;
    }

    img {
        max-width: 600px;
        width: 92%;
    }

a{
    border-radius: 30px;
    background-color: #0F75BC;
    color: #fff;
    display: inline-block;
    text-decoration: none;
    padding: 15px 30px;
    margin-top: 30px;
}

.error-img{
max-width: 600px;
width: 95%;
}
h1{
    font-size: 42px;
    margin-bottom: 0;
}
p{
    color: #3B1528;
    font-size: 14px;
    line-height: 24px;
}
.error{
    position: relative;
    margin-bottom: 80px
}
.not-found{
    /* position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 0;
    right: 0; */
    padding: 5px;
}
.content{
    margin-top: 20px;
}
@media all and (max-width: 767px) {

    h1{
        font-size: 28px
    }
}
</style>

<div class="error-container">
    <div class="error">
        <div class="not-found">
            <img src="{{ asset('images/web/oops.png') }}" alt="">
            <h1>404 - PAGE NOT FOUND</h1>
            <div class="content">The page you are looking for might have been removed<br> had its name changed or is temporarily unavailable.</div>
            <a href="{{ route('web_home', ['locale' => app()->getLocale()]) }}">GO TO HOMEPAGE</a>
        </div>
    </div>
</div>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title></title>
        <link href="{{asset('css/achievement/demo.css')}}" rel="stylesheet">
    <body>
    <div class="content">
        <div class="box-white text-center">
            <p><img src="{{asset('images/achievement/icon.png')}}" width="70"></p>
            <h3>{{$achievement->description}}<br></h3>
            ({{$percent}}% yêu cầu được chấp nhận)

        </div>
        <div class="box-white">
            <div class="div-overflow">
                <div class="div-left">Số chuyến đi đã hoàn tất</div>
                <div class="div-right"><h4>{{$total}} chuyến đi</h4></div>
            </div>
            <div class="progress">
                <span style="width: {{$percent}}%"></span>
            </div>
        </div>
        <div class="box-white">
            <div class="div-overflow">
                <div class="div-left">
                    Chuyến đi
                    <h4>{{$meta['conditionsToReward']['tripCounts']}} Chuyến đi</h4>
                </div>
                <div class="div-right">
                    Thu nhập thêm
                    <h4>{{$meta['reward']['wallet']}}Đ</h4>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>

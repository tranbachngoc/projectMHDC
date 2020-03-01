<?php if (is_object($ad) && !empty($ad)) { ?>
    <?php if ($ad->ad_image != "" && $ad->ad_status == 1) { ?>
        <div class="trangtinchitiet-content-item khuyenmai-muagiangsinh bg-overlay pt00 has-bg-img" style="background:url(<?php echo $item->sLinkFolderImage . '/' . $ad->ad_image ?>) no-repeat center / cover;">

            <?php if ($ad->ad_content) { ?>
                <div id="postad" class="owl-carousel">
                    <?php foreach ($ad->ad_content as $key => $value) { ?>
                        <div class="tit text-center">                               
                            <h2 class="text-uppercase" style="margin-bottom:20px;"><?php echo $value->title ?></h2>                                
                            <p style="font-size:18px;"><?php echo $value->desc ?></p>                                                              
                        </div>                                    
                    <?php } ?> 
                </div>
            <?php } ?>
            <div class="adbanner">
                <?php if($ad->ad_display == 1 ) { ?>
                    <div class="">
                        <section id="anaclock">                     
                            <div id="clock">
                                <div id="hour"></div>
                                <div id="minute"></div>
                                <div id="second"></div>
                                <div id="center"></div>                 
                            </div>
                            <div class="textclock" class="text-center">Thời gian còn lại</div>                      
                            <div class="countdown" class="text-center"></div>
                        </section>
                    </div>
                <?php } else { ?>
                    <div class="countdown2" class="text-center"></div>
                <?php } ?>
                <?php if($ad->ad_link) { ?>        
                    <div style="position: relative; margin: 80px 0 0; text-align: center;">
                        <a href="<?php echo $ad->ad_link ?>" target="_blank" class="btn_ad_link">Xem chi tiết</a>
                    </div> 
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#postad').owlCarousel({ animateOut: 'fadeOutDown', animateIn: 'zoomIn', items: 1, loop: true, margin: 0, nav: false, dots: false, autoplay: true, autoplayTimeout: 3000, autoplayHoverPause: true });

                $('.countdown,.countdown2').countdown('<?php echo $ad->ad_time ?>', function(event) {
                        $(this).html(event.strftime('<span><strong>%D</strong><br>Ngày</span> <span><strong>%H</strong><br>Giờ</span> <span><strong>%M</strong><br>Phút</span> <span><strong>%S</strong><br>Giây</span>'));
                });

                if (!window.requestAnimationFrame) {
                      window.requestAnimationFrame = window.mozRequestAnimationFrame ||
                        window.webkitRequestAnimationFrame ||
                        window.msRequestAnimationFrame ||
                        window.oRequestAnimationFrame ||
                        function (cb) { setTimeout(cb, 1000/60); };
                }

              var $h = $("#hour"),
                      $m = $("#minute"),
                      $s = $("#second");

              function computeTimePositions($h, $m, $s) {
                    var now = new Date(),
                            h = now.getHours(),
                            m = now.getMinutes(),
                            s = now.getSeconds(),
                            ms = now.getMilliseconds(),
                            degS, degM, degH;

                    degS = (s * 6) + (6 / 1000 * ms);
                    degM = (m * 6) + (6 / 60 * s) + (6 / (60 * 1000) * ms);
                    degH = (h * 30) + (30 / 60 * m);

                    $s.css({ "transform": "rotate(" + degS + "deg)" });
                    $m.css({ "transform": "rotate(" + degM + "deg)" });
                    $h.css({ "transform": "rotate(" + degH + "deg)" });

                    requestAnimationFrame(function () {
                      computeTimePositions($h, $m, $s);
                    });
              }

            function setUpFace() {
                for (var x = 1; x <= 60; x += 1) {
                  addTick(x); 
                }

                function addTick(n) {
                  var tickClass = "smallTick",
                          tickBox = $("<div class=\"faceBox\"></div>"),
                          tick = $("<div></div>"),
                          tickNum = "";

                  if (n % 5 === 0) {
                        tickClass = (n % 15 === 0) ? "largeTick" : "mediumTick";
                        tickNum = $("<div class=\"tickNum\"></div>").text(n / 5).css({ "transform": "rotate(-" + (n * 6) + "deg)" });
                        if (n >= 50) {
                          tickNum.css({"left":"-0.5em"});
                        }
                  }


                  tickBox.append(tick.addClass(tickClass)).css({ "transform": "rotate(" + (n * 6) + "deg)" });
                  tickBox.append(tickNum);

                  $("#clock").append(tickBox);
                }
            }

            function setSize() {
                var b = $(this), //html, body
                        w = b.width(),
                        x = Math.floor(w / 30) - 1,
                        px = (x > 25 ? 26 : x) + "px";

                $("#clock").css({"font-size": px });

                if (b.width() !== 400) {
                  setTimeout(function() { $("._drag").hide(); }, 500);
                }
            }

            setUpFace();
            computeTimePositions($h, $m, $s);
            $("section#anaclock").on("resize", setSize).trigger("resize");
        });
    </script>
<?php } ?>

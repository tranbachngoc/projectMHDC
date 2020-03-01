<div class="list-branchs js-list-branchs">
    <div class="container">
        <div class="js-list-branchs-slider list-branchs-slider">
            <?php foreach ($list_branch['data'] as $key => $branch) { ?>
            <a href="<?=shop_url($branch)?>">
            <div class="item">
                <img src="<?=$branch['banner_shop']?>" class="object-fit-cover" alt="">
                <div class="avata"><img src="<?=$branch['logo_shop']?>" class="object-fit-cover" alt=""></div>
                <div class="name"><?=$branch['shop_name']?></div>
            </div>
            </a>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.js-list-branchs-slider').slick({
        infinite: false,
        slidesToShow: 6.2,
        slidesToScroll: 5,
        responsive: [
        {
            breakpoint: 1025,
            settings: {
            slidesToShow: 4.2,
            slidesToScroll: 4
            }
        },
        {
            breakpoint: 768,
            settings: {
            slidesToShow: 2.2,
            slidesToScroll: 4
            }
        },
        ]
    });
    $('.icon-show-list-branchs').click(function(){
        $(this).toggleClass('show-list-branchs-opened');
        if ($(this).hasClass('show-list-branchs-opened')) {
            $('.js-list-branchs-slider').slick('unslick'); //unslick it
            $('.js-list-branchs-slider').fadeIn(); //change display none to //display block
            $('.js-list-branchs-slider').slick({
            infinite: false,
            slidesToShow: 6.2,
            slidesToScroll: 5,
            responsive: [
            {
                breakpoint: 1025,
                settings: {
                slidesToShow: 4.2,
                slidesToScroll: 4
                }
            },
            {
                breakpoint: 768,
                settings: {
                slidesToShow: 2.2,
                slidesToScroll: 4
                }
            },
            ]
            });
            $(".js-list-branchs-slider").delay( 100 ).animate({"opacity":"1"},1000  );
        } else {
            $('.js-list-branchs-slider').fadeOut();
        }
    })
    });
    
</script>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
#008c8c #ff80ab #1fc0d8 #66bb6a #2196f3 #ffbf58 #8284c7 #F08080
$color = $resume->color;
?>
<style>


.btn-custom,.btn-custom:hover {
    border: 1px solid <?php echo $color ?>;
}
.pace,.title-border::before,.title-border::after{
    border: 2px solid <?php echo $color ?>;
}
.navbar,.title-border,.rs-round,.time-line:before,.btn-custom,.btn-custom:hover,.pace .pace-progress {
    background-color: <?php echo $color ?>;
}

.presonal-inform i,.skill i,.rex-item h3,#work  .lrs-list-protfolio .fil-cat.active,
#work .lrs-projects .lrs-project .lrs-project-content,.section-title h2,.pace .pace-progress {
    color: <?php echo $color ?>;
}

#work  .lrs-list-protfolio .fil-cat.active {
    border-bottom: 2px solid <?php echo $color ?>;
}

.form-control:focus {
    border-color:<?php echo $color ?>;
    box-shadow: <?php echo $color ?>;
}
/*azibai css*/
.btn-primary {
    color: #fff;
    background-color: <?php echo $color ?>;
    border-color: <?php echo $color ?>;
}
.btn-primary:focus,
.btn-primary:hover {
    background-color: <?php echo $color ?>;
    border-color: <?php echo $color ?>;
    opacity: .8   
}
.owl-theme .owl-nav [class*=owl-] {
    background: <?php echo $color ?>;
    border: 1px solid <?php echo $color ?>;
}
.customer-say {
    border: 1px solid <?php echo $color ?>;
}

.statistic_number div {
    color:<?php echo $color ?>;
	border-color:<?php echo $color ?>;
}
#owl_customers .owl-nav button {position: absolute; top: 50%; margin-top:-18px; color:<?php echo $color ?>; border:1px solid <?php echo $color ?>; border-radius: 50%; font-size: 30px; line-height: 30px; padding: 0px 13px 5px;}
#owl_customers .owl-nav button:focus {outline:none;}
#owl_customers .owl-nav button.owl-next { right: 0; }
#owl_customers .owl-nav button.owl-prev { left: 0; }
</style>
// jQuery Initialization
jQuery(document).ready(function($){
"use strict"; 

        if ($('.lightbox, .button-fullsize, .fullsize').length > 0) {
        $('.lightbox, .button-fullsize, .fullsize').fancybox({
            padding    : 0,
            margin    : 0,
            maxHeight  : '90%',
            maxWidth   : '90%',
            loop       : true,
            fitToView  : false,
            mouseWheel : false,
            autoSize   : false,
            closeClick : false,
            overlay    : { showEarly  : true },
            helpers    : { media : {} }
        });
    }



    
     $('#gototop').click(function(e){
        jQuery('html, body').animate({scrollTop:0}, 750, 'linear');
        e.preventDefault();
        return false;
    });
    

    $("#subscribe_btn_1").click(function() { 
        //get input field values
        var user_email      = $('.pixfort_normal_1 input[name=email]').val();

        //var user_message    = $('textarea[name=message]').val();
        
        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        
        if(user_email==""){ 

            $('.pixfort_normal_1 input[name=email]').css('border-color','red'); 
            proceed = false;
        }
//       $.fancybox("#hidden_pix_1");

        //everything looks good! proceed...
        if(proceed) 
        {
            //data to be sent to server
            var post_data;
            var output;
            post_data = {'userEmail':user_email};
            //Ajax post data to server
            $.post('pix_mail/contact_me_1.php', post_data, function(response){  

                //load json data from server and output message     
                if(response.type == 'error')
                {
                    output = '<div class="error">'+response.text+'</div>';
                }else{
                    $.fancybox("#hidden_pix_1");
                    output = '<div class="success">'+response.text+'</div>';
                    
                    //reset values in all input fields
                    $('#contact_form input').val(''); 
                    $('#contact_form textarea').val(''); 
                }
                
                $("#result").hide().html(output).slideDown();
            }, 'json');
            
        }
    });



    
});
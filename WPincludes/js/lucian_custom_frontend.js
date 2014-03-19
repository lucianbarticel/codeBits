var $ = jQuery.noConflict();

(function($) {
    $.fn.hasScrollBar = function() {
        return this.get(0) ? this.get(0).scrollHeight > this.innerHeight() : false;
    }
})(jQuery);

function set_mod_margins(obj){
    var $ = jQuery.noConflict();
    var gmf_screen_width = $(window).width();
    //var gmf_screen_height = $(window).height();
    var gmf_mod_width = $(obj).width();
    //var gmf_mod_height = $(obj).height();
    var gmf_mod_left_margin = (gmf_screen_width - gmf_mod_width)/2;
    var gmf_mod_top_margin = 100;
    $(obj).css('left', gmf_mod_left_margin);
    $(obj).css('top', gmf_mod_top_margin);
}

function resize_slider(slider){
    var $ = jQuery.noConflict();
    var gmf_screen_width = $(window).width();
    $(slider +'img').css('width', gmf_screen_width);
    $(slider +'img').css('height', 'auto');
}

$(window).resize(function(){
    var $ = jQuery.noConflict();
    set_mod_margins('.center_module');
    resize_slider('.responsive-slider');
})

$(document).ready(function(){
    var $ = jQuery.noConflict();
    $( "#tabs" ).tabs();
    
    $("#select_poker_club").change(function(){
        $("form#select_poker_club_form").submit();
    });
    
    
    $("li.not_active_menu > a").click(function(e){
        e.preventDefault(); 
    })
    
    $("#datepicker").datepicker({
        dateFormat: "dd-mm-yy", 
        changeMonth: true, 
        changeYear: true, 
        yearRange : 'c-100:c'
    });
    $("#datepicker2").datepicker({
        dateFormat: "dd-mm-yy", 
        changeMonth: true, 
        changeYear: true, 
        yearRange : 'c-100:c'
    });
    
    var window_width = $(window).width();
    var module_width = $('.center_module').width();
    var module_left = (window_width - module_width)/2;
    $('.center_module').css('left', module_left);
    
    //inchide fereastra modala
    $('.close_module_btn').click(function(){
        if($('#c_log_form').is(":visible")) {
            $('#c_log_form').fadeOut('fast')
        };
        if($('#upload_photo_form').is(":visible")) {
            $('#upload_photo_form').fadeOut('fast')
        };
        if($('#upload_id_paper').is(":visible")) {
            $('#upload_id_paper').fadeOut('fast')
        };
        if($('#notifications_module').is(":visible")) {
            $('#notifications_module').fadeOut('fast')
        };
        $('.center_module').fadeOut('fast');
        $('.backblack').fadeOut('fast');
    })
    
    //deschide fereastra modala pentru login
    $('#show_login').click(function(){
        $('.backblack').fadeIn('fast');
        set_mod_margins(".center_module");
        $('.center_module').fadeIn('fast');
        $('#c_log_form').fadeIn('fast');
        $(".close_module_btn").css('right', '4px');
    })
    
    //deschide fereastra modala pentru upload profile picture
    $("#upload_profile_picture_btn").click(function(){
        $('.backblack').fadeIn('fast');
        set_mod_margins(".center_module");
        $('.center_module').fadeIn('fast');
        $('#upload_photo_form').fadeIn('fast');
        $(".close_module_btn").css('right', '4px');
    })
    //deschide fereastra modala pentru upload act de identitate
    $("#change_pass_btn").click(function(){
        $('.backblack').fadeIn('fast');
        set_mod_margins(".center_module");
        $('.center_module').fadeIn('fast');
        $('#change_pass').fadeIn('fast');
        $(".close_module_btn").css('right', '4px');
    })
    
    $("#upload_id_paper_btn").click(function(){
        $('.backblack').fadeIn('fast');
        set_mod_margins(".center_module");
        $('.center_module').fadeIn('fast');
        $('#upload_id_paper').fadeIn('fast');
        $(".close_module_btn").css('right', '4px');
    })
    //deschide fereastra modala pentru notificari
    $("#notifications_button").click(function(){
        $('.backblack').fadeIn('fast');
        set_mod_margins(".center_module");
        $('.center_module').fadeIn('fast');
        $('#notifications_module').fadeIn('fast');
        $(".close_module_btn").css('right', '22px');
        //apeleaza functia de ajax
        $.ajax({
            type:"POST",
            url: "/wp-admin/admin-ajax.php",
            data:{
                action: "mark_notification_as_seen"
            },
            success:function(resp){
                $("#notifications_button").html('Nici o noua notificare');
                    
            },
            error: function(errorThrown){
                alert(errorThrown);
            }  
        });
        
    })


    $("input#submit_leaderboard_interval").click(function(e){
        e.preventDefault();
        if($("input#datepicker").val() == "" || $("input#datepicker2").val() == ""){
            alert("Cel putin unul din campuri este gol...")
        }else{
            $("form#leaderboard_period_form").submit();
        }
    })

      
        
})
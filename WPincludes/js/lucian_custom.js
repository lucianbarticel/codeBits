var $ = jQuery.noConflict();
//var $ = jQuery.noConflict();
$(document).ready(function(){
    var $ = jQuery.noConflict();
    //alert('cmon');
    
    $("#datepicker").datetimepicker({
        dateFormat: "dd-mm-yy", 
        changeMonth: true, 
        changeYear: true, 
        yearRange : 'c-100:c'
    });
    
    $("#submit_locuri_premiate").click(function(e){
        e.preventDefault();
        var nr_pozitii = $("#locuri_premiate_input").val();
        if(nr_pozitii ==""){
            nr_pozitii = 0;
        }
        var post_id = $("#post_ID").val();
        jQuery.ajax({ 
            type: 'POST',  
            url: 'http://pokerfestclub.ro/wp-admin/admin-ajax.php',  
            data: {  
                action: 'save_show_results',  
                positions : nr_pozitii,
                post_id: post_id
            },
            success: function(data, textStatus, XMLHttpRequest){
                /*var returned_positions = data;
                $("#postbox-container-2 #normal-sortables").append("<div id='turneu_rezultate_pozitii' class='postbox'><div class='handlediv'><br /></div><h3 class='hndle'><span>Clasament rezultate</span></h3><div class='inside'></div></div>");
                for(var i =1; i<=returned_positions; i++){
                    $("#turneu_rezultate_pozitii .inside").append('<label for="turneu_'+post_id+'_loc_premiat_'+i+'">Pozitia #'+i+': </label><input type="text" name="turneu_'+post_id+'_loc_premiat_'+i+'"  value=""><br /><br />');
                }*/
                location.reload();
            },  
            error: function(MLHttpRequest, textStatus, errorThrown){  
                alert(errorThrown);  
            } 
        });
    });
    
    
    $("#submit_zile_turneu").click(function(e){
        $("form#post").submit();
        /*
        e.preventDefault();
        var nr_zile = $("#zile_turneu_input").val();
        if(nr_zile ==""){
            nr_zile = 0;
        }
        var post_id = $("#post_ID").val();
        jQuery.ajax({ 
            type: 'POST',  
            url: 'http://pokerfestclub.ro/wp-admin/admin-ajax.php',  
            data: {  
                action: 'save_festival_days',  
                days : nr_zile,
                post_id: post_id
            },
            success: function(data, textStatus, XMLHttpRequest){
                
                window.location.replace(data);
                
                
            },  
            error: function(MLHttpRequest, textStatus, errorThrown){  
                alert(errorThrown);  
            } 
        });
        */
    });
    
    $(".auto_jucator").autocomplete({
      source: availableNames
    });
    
    
    $(".submit_no_turnee_zi").click(function(e){
        e.preventDefault();
        var input_name = $(this).attr('id');
        var nr_turnee = $("input[name='"+input_name+"']").val();
        if(nr_turnee ==""){
            nr_turnee = 0;
        }
        var post_id = $("#post_ID").val();
        jQuery.ajax({ 
            type: 'POST',  
            url: 'http://pokerfestclub.ro/wp-admin/admin-ajax.php',  
            data: {  
                action: 'add_tournament_no_per_day', 
                var_name: input_name,
                no_turnee : nr_turnee,
                post_id: post_id
            },
            success: function(data, textStatus, XMLHttpRequest){
                /*var returned_positions = data;
                $("#postbox-container-2 #normal-sortables").append("<div id='turneu_rezultate_pozitii' class='postbox'><div class='handlediv'><br /></div><h3 class='hndle'><span>Clasament rezultate</span></h3><div class='inside'></div></div>");
                for(var i =1; i<=returned_positions; i++){
                    $("#turneu_rezultate_pozitii .inside").append('<label for="turneu_'+post_id+'_loc_premiat_'+i+'">Pozitia #'+i+': </label><input type="text" name="turneu_'+post_id+'_loc_premiat_'+i+'"  value=""><br /><br />');
                }*/
                location.reload();
               //alert(data)
            },  
            error: function(MLHttpRequest, textStatus, errorThrown){  
                alert(errorThrown);  
            } 
        });
    });
    
    
    $('select.active_user').change(function(){
        var full_id = $(this).parents('tr').attr('id');
        var idarr = full_id.split('-');
        var id = idarr[1];
        var self = $(this);
        var value = $(this).val();
        jQuery.ajax({  
            type: 'POST',  
            url: 'http://pokerfestclub.ro/wp-admin/admin-ajax.php',  
            data: {  
                action: 'update_active_user',  
                user_id: id,
                value: value
            },  
            success: function(data, textStatus, XMLHttpRequest){
                if(self.parent().children().length > 1){
                    self.parent().children('.updated').remove();
                    self.parent().append(data);
                }else{
                    self.parent().append(data);
                }
                
            },  
            error: function(MLHttpRequest, textStatus, errorThrown){  
                alert(errorThrown);  
            }  
        });
        
        
    }) 
    
    $('.notif_list_item').toggle(function(){
        $(this).children('input:checkbox').attr('checked','checked');
    },function(){
        $(this).children('input:checkbox').removeAttr('checked');     
    })
    $("button#select_all").click(function(e){
        e.preventDefault();
        if($(this).hasClass('sel')){
            $('.notif_list_item').each(function(){
                $(this).children('input:checkbox').removeAttr('checked'); 
            })
            $(this).removeClass('sel');
            $(this).html('Selecteaza pe toti');
        }else{
            $(".notif_list_item").each(function(){
                $(this).children('input:checkbox').attr('checked','checked');
            })
            $(this).addClass('sel');
            $(this).html('Deselecteaza pe toti');        
        }
    })
    

    
})
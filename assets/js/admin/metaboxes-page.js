(function($) {
    $(document).ready(function (){
            
    		/* Image opts selection */
            $('body').on('click', 'img.herald-img-select', function(e){
                e.preventDefault();
                
                //alert('click');

                if ( !$(this).parent().hasClass('herald-disabled')){
                    $(this).closest('ul').find('img.herald-img-select').removeClass('selected');
                    $(this).addClass('selected');
                    $(this).closest('ul').find('input').removeAttr('checked');
                    $(this).closest('li').find('input').attr('checked','checked');
                }

                if( $(this).closest('ul').hasClass('herald-col-dep-control') ){
                   
                    var $wrap = $(this).closest('.herald-opt').parent();
                    var col_dep = $(this).closest('li').find('input').val();
                    
                    $wrap.find('.herald-col-dep').each( function() {
                        var reset_layout = false;
                        $( this ).find('img.herald-img-select').each( function() {
                            var col = $( this ).attr('data-col');
                            $( this ).parent().removeClass('herald-disabled');
                            if( col && col_dep % col){
                                $( this ).parent().addClass('herald-disabled');
                                if( $(this ).hasClass('selected')){
                                    $(this ).removeClass('selected');
                                    reset_layout = true;
                                }
                            }
                        });

                        if(reset_layout){
                             $( this ).find('img.herald-img-select').each( function() {
                                var col = $( this ).attr('data-col');
                                    if( col_dep % col == false ){
                                        //alert($( this ).html());
                                        $( this ).click();
                                        return false;
                                    }
                            });
                        }
                    });
                }

            });

            /* Hack to dynamicaly apply select value */
            $('body').on('change', '.herald-opt-select', function(e){
                //e.preventDefault();
                var sel = $(this).val();
                $(this).find('option').removeAttr('selected');
                $(this).find('option[value='+sel+']').attr('selected','selected');
            });

            /* Module form tabs */
            $('body').on('click', '.herald-opt-tabs a', function(e){
                e.preventDefault();
                $(this).parent().find('a').removeClass('active');
                $(this).addClass('active');
                $(this).closest('.herald-module-form').find('.herald-tab').hide();
                $(this).closest('.herald-module-form').find('.herald-tab').eq($(this).index()).show();
                
            });

            /* Show/hide */
            $('body').on('click', '.herald-next-hide', function(e){
                
                if($(this).is(':checked')){
                    $(this).closest('.herald-opt').next().fadeIn(400);
                } else {
                    $(this).closest('.herald-opt').next().fadeOut(400);
                }
            });
           
           
            /* Make sections sortable */
            $( "#herald-sections" ).sortable({
              revert: false,
              cursor: "move",
              placeholder: "herald-section-drop"
            });

             /* Make modules sortable */
                $( ".herald-modules" ).sortable({
                  revert: false,
                  cursor: "move",
                  placeholder: "herald-module-drop"
                });

             var herald_current_section;
             var herald_current_module;
             var herald_module_type;


            /* Add new section */
            $('body').on('click', '.herald-add-section', function(e){
                e.preventDefault(); 
                var $modal = $($.parseHTML('<div class="herald-section-form">' + $("#herald-section-clone .herald-section-form").html() + '</div>'));               
                herald_dialog( $modal, 'Add New Section', 'herald-save-section' );

            });
            
            /* Edit section */
            $('body').on('click', '.herald-edit-section', function(e){
                e.preventDefault();
                herald_current_section = parseInt($(this).closest('.herald-section').attr('data-section'));
                var $modal = $(this).closest('.herald-section').find('.herald-section-form').clone();
                herald_dialog( $modal, 'Edit Section', 'herald-save-section' );
            });

             /* Remove section */
            $('body').on('click', '.herald-remove-section', function(e){
                e.preventDefault();
                remove = herald_confirm();
                if(remove){
                    $(this).closest('.herald-section').fadeOut(300, function(){
                        $(this).remove();
                    });
                }
            });


            /* Save section */
            
            $('body').on('click', 'button.herald-save-section', function(e){
                
                e.preventDefault();
                
                var $herald_form = $(this).closest('.wp-dialog').find('.herald-section-form').clone();

                if($herald_form.hasClass('edit')){
                    $herald_form = herald_fill_form_fields( $herald_form );    
                    var $section = $('#herald-sections .herald-section-'+herald_current_section);
                    $section.find('.herald-section-form').html($herald_form.html());
                    $section.find('.herald-sidebar').text( $herald_form.find('.sec-sidebar:checked').val());
                
                } else {
                    var count = $('#herald-sections-count').attr('data-count');
                    $herald_form = herald_fill_form_fields( $herald_form, 'herald[sections]['+ count +']');
                    $('#herald-sections').append($('#herald-section-clone').html());
                    var $new_section = $('#herald-sections .herald-section').last();
                    $new_section.addClass('herald-section-' + parseInt(count)).attr('data-section', parseInt(count) ).find('.herald-section-form').addClass('edit').html($herald_form.html());
                    $new_section.find('.herald-sidebar').text( $herald_form.find('.sec-sidebar:checked').val());
                    $('#herald-sections-count').attr('data-count', (parseInt(count)+1));

                    $( "#herald-sections .herald-section-" + count + " .herald-modules" ).sortable({
                      revert: false,
                      cursor: "move",
                      placeholder: "herald-module-drop"
                    });
                }

            });

            
            /* Add new module */
            $('body').on('click', '.herald-add-module', function(e){
                e.preventDefault();
                herald_module_type = $(this).attr('data-type');
                herald_current_section = parseInt($(this).closest('.herald-section').attr('data-section'));
                var $modal = $($.parseHTML('<div class="herald-module-form">' + $('#herald-module-clone .' + herald_module_type +' .herald-module-form').html() + '</div>'));           
                herald_dialog( $modal, 'Add New Module', 'herald-save-module' );
            });

            /* Edit module */
            $('body').on('click', '.herald-edit-module', function(e){
                e.preventDefault();
                herald_current_section = parseInt($(this).closest('.herald-section').attr('data-section'));
                herald_current_module = parseInt($(this).closest('.herald-module').attr('data-module'));
                var $modal = $(this).closest('.herald-module').find('.herald-module-form').clone();
                herald_dialog( $modal, 'Edit Module', 'herald-save-module' );
            });

            /* Remove module */
            $('body').on('click', '.herald-remove-module', function(e){
                e.preventDefault();
                remove = herald_confirm();
                if(remove){
                    $(this).closest('.herald-module').fadeOut(300, function(){
                        $(this).remove();
                    });
                }
            });

             /* Save module */
            
            $('body').on('click', 'button.herald-save-module', function(e){
                
                e.preventDefault();
                
                var $herald_form = $(this).closest('.wp-dialog').find('.herald-module-form').clone();
                
                /* Nah, jQuery clone bug, clone text area manually */
                var txt_content = $(this).closest('.wp-dialog').find('.herald-module-form').find("textarea").first().val();
                if(txt_content !== undefined){
                    $herald_form.find("textarea").first().val(txt_content);
                }

                if($herald_form.hasClass('edit')){
                    $herald_form = herald_fill_form_fields( $herald_form );    
                    var $module = $('.herald-section-'+herald_current_section+' .herald-module-'+herald_current_module); 
                    $module.find('.herald-module-form').html($herald_form.html());
                    $module.find('.herald-module-title').text($herald_form.find('.mod-title').val());
                    $module.find('.herald-module-columns').text($herald_form.find('.mod-columns:checked').closest('li').find('span').text());
                } else {
                    var $section = $('.herald-section-'+herald_current_section);
                    var count = $section.find('.herald-modules-count').attr('data-count');
                    $herald_form = herald_fill_form_fields( $herald_form, 'herald[sections]['+herald_current_section+'][modules]['+ count +']');
                    $section.find('.herald-modules').append($('#herald-module-clone .'+herald_module_type).html());
                    var $new_module = $section.find('.herald-modules .herald-module').last();
                    $new_module.addClass('herald-module-' + parseInt(count)).attr('data-module', parseInt(count) ).find('.herald-module-form').addClass('edit').html($herald_form.html());
                    $new_module.find('.herald-module-title').text($herald_form.find('.mod-title').val());
                    $new_module.find('.herald-module-columns').text($herald_form.find('.mod-columns:checked').closest('li').find('span').text());
                    $section.find('.herald-modules-count').attr('data-count', parseInt(count)+1);
                }

            });

            /* Open our dialog modal */
             function herald_dialog( obj, title, action ){

                obj.dialog({
                    'dialogClass'   : 'wp-dialog',
                    'appendTo': false,         
                    'modal'         : true,
                    'autoOpen'      : false, 
                    'closeOnEscape' : true,
                    'draggable'     : false,
                    'resizable': false,
                    'width': 800,
                    'height': $(window).height() - 60,
                    'title': title,
                    'close': function(event, ui) { $('body').removeClass('modal-open'); },
                    'buttons': [ { 'text': "Save", 'class': 'button-primary '+ action , 'click': function() { $(this).dialog('close'); } } ] 
                });

                obj.dialog('open');

                $('body').addClass('modal-open');
            }
            
            
            /* Fill form fields dynamically */
            function herald_fill_form_fields( $obj, name){
                
                $obj.find('.herald-count-me').each( function( index ) {
                        
                        if( name !== undefined && !$(this).is('option')){
                            $(this).attr('name', name + $(this).attr('name'));
                        }

                        if($(this).is('textarea')){
                            $(this).html($(this).val());
                        }

                        
                        if(!$(this).is('select')){
                            $(this).attr('value',$(this).val());
                        }
                        
                        
                        
                        if($(this).is(":checked")){
                                $(this).attr('checked','checked');
                        } else {
                             $(this).removeAttr('checked');
                        }
   
                });

                return $obj;
            }

            function herald_confirm(){
               var ret_val = confirm("Are you sure?");
               return  ret_val;
            }

            /* Metabox switch - do not show every metabox for every template */
            
            herald_template_metaboxes(false);

            $('#page_template').change(function(e){
                    herald_template_metaboxes( true );
            });
            
            function herald_template_metaboxes(scroll){


                var template = $('select#page_template').val();
                
                if( template == 'template-modules.php' ){
                    $('#herald_page_layout').fadeOut(300);
                    $('#herald_sidebar').fadeOut(300);
                    $('#herald_modules').fadeIn(300);
                    $('#herald_pagination').fadeIn(300);
                    if(scroll){
                        var target = $('#herald_modules').attr('id');
                            $('html, body').stop().animate({
                                'scrollTop': $('#'+target).offset().top
                            }, 900, 'swing', function () {
                                window.location.hash = target;
                        });
                    }
                } else if ( template == 'template-full-width.php') {
                    $('#herald_page_layout').fadeOut(300);
                    $('#herald_sidebar').fadeOut(300);
                    $('#herald_modules').fadeOut(300);
                    $('#herald_pagination').fadeOut(300);
                } else{
                    $('#herald_page_layout').fadeIn(300);
                    $('#herald_sidebar').fadeIn(300);
                    $('#herald_modules').fadeOut(300);
                    $('#herald_pagination').fadeOut(300);                    
                }
            
            }

          
   
    });


    
})(jQuery);
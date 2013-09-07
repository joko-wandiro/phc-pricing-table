( function($){
$(document).ready( function(){
    Feedback= {
		selector: {},
        'default': function(data){
			console.log(data);
        },
        'alert': function(data){
			alert(data);
        },
        'get_province': function(data){
			$(this.selector).html(data.html);
        },
        'get_button_url': function(data){
			console.log("get_button_url");
			console.log(data);
			$(this.selector).next('.button_url').remove();
			$(data.html).insertAfter(this.selector);
        }
    }
	
    Ajax= {		
		'form': '',
        'type': "default",
		'extra': "default",
		container: '',
        send: function(url, data){
            AjaxObj= this;
            $.ajax({
				async: false,
                dataType: 'json',
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function(){
					AjaxObj.blockUI();
                },
                complete: function(){
					AjaxObj.unBlock();
                },
                success: function(data){
                    type= AjaxObj.type;
                    Feedback[type](data);
                }
            });
        },
		loading: function(url, data){
			container= this.container;
			$(container).load(url + ' ' + container, data);
		},
		blockUI: function(){
			$.blockUI({ 
//				message: '<h1>Loading...</h1>'
				message: phc_pricing_table_admin_js_params.loading_text,
			});
		},
		unBlock: function(){
			$.unblockUI(); 
		},
		get_data_based_province: function(key){
			data= {
			action: 'phc_branches_post_type_ajax',
			province: key
			}
			// Feedback.selector= $('#feedback_selector');
			Feedback.selector= phc_pricing_table_admin_js_params.feedback_selector;		
			Ajax.type= "get_province";
			Ajax.send(phc_pricing_table_admin_js_params.ajaxurl, data);
		}
	}

	PHC_Accordion= {
		setting_accordion: function($obj){
	    $obj
		.accordion({
		active: false,
		collapsible: true,
		header: "> div > h3",
		})
		.sortable({
		placeholder: "ui-state-highlight",
//		axis: "y",
		handle: "h3",
		stop: function( event, ui ) {
		// IE doesn't register the blur when sorting
		// so trigger focusout handlers to remove .ui-state-focus
		ui.item.children("h3").triggerHandler("focusout");
		}
		});
		}
	}
	
	PHC_Accordion.setting_accordion($('#pricing-table-accordion'));
	$('#btn-new-plan').live('click', function(){
		$template_form= $('.template-pricing-table-form').clone();
		template_form_html= $template_form.html();
		number_of_section= $('#pricing-table-accordion .widget').length;
		if( number_of_section ){
			number_of_section= $('#pricing-table-accordion .widget:last').attr('data-plan-number');
		}
//		number_of_section++;
		template_form_html= template_form_html.replace(/{plan_number}/g, number_of_section);
		plan_number_title= number_of_section;
		plan_number_title++;
		console.log(plan_number_title);
		$template_form.html(template_form_html.replace(/{plan_number_title}/g, plan_number_title));
		$pricing_table_accordion= $('#pricing-table-accordion');
		$template_form.attr({'data-plan-number': plan_number_title}).appendTo($pricing_table_accordion)
		.removeClass('template-pricing-table-form').find('input, select, textarea').removeAttr('disabled');
		$pricing_table_accordion.accordion('destroy');
		PHC_Accordion.setting_accordion($pricing_table_accordion);
		
		$('input[name^=button_url_type]:checked').not(':disabled').trigger('change');
	});
	
	$('.btn-remove-plan').live('click', function(){
		$(this).parent().parent().remove();
	});
	
	$('#pricing-table-accordion input[name^=title]').live('keyup', function(){
		$obj= $(this);
		title= $obj.val();
		console.log(title);
		if( title != undefined && title != "" ){
			$obj.parent().parent().prev().find('span:eq(1)').html(title);
		}
	});
	
	$('.btn-add-feature-plan').live('click', function(){
		$obj= $(this);
		plan_id= $obj.attr('data-plan-id');
		$template= $('.template-pricing-table-features-element').clone();
		template_html= $template.removeClass('template-pricing-table-features-element').html();
		$template.html(template_html.replace(/{id_plan_features}/g, plan_id));
		console.log($template);
		$parent_feature= $obj.parent().next();
		$template.appendTo($parent_feature).find('input, select, textarea').removeAttr('disabled');
	});
	
	$('.btn-remove-feature-plan').live('click', function(){
		$(this).parent().remove();
	});
	
	$('#pricing-table-accordion .widget').each( function(){
		$obj= $(this);
		button_url_type= $obj.find('input[name^=button_url_type]:checked').val();
//		console.log(button_url_type);
		$obj.find('input[name^="button_url["], select[name^=button_url]').hide();
		$obj.find('input[name^="button_url["][data-type=' + button_url_type + '], ' + 
		'select[name^="button_url["][data-type=' + button_url_type + ']').show();
	})
	
	$('input[name^=button_url_type]').live('change', function(){
		$obj= $(this);
		$feedback_selector= $obj.parent().parent();
		$widget= $feedback_selector.parent();		
		button_url_type= $obj.val();
		post_id= $('#pricing-table-extras').attr('data-post-id');
		current_plan_id= $widget.find('input[name^=plan_id]').val();
//		console.log($obj);
//		console.log(button_url_type);
		data= {
		action: 'phc_pricing_table_ajax',
		button_url_type: button_url_type,
		post_id: post_id,
		current_plan_id: current_plan_id,
		}
		Feedback.selector= $feedback_selector;
		Ajax.type= "get_button_url";
//		Ajax.type= "default";
		Ajax.send(phc_pricing_table_admin_js_params.ajaxurl, data);
//		button_url_type= $obj.val();
//		console.log(button_url_type);
//		$container_selection= $obj.parent().parent().next();
//		$container_selection.find('input[name^="button_url["], select[name^=button_url]').hide();
//		$container_selection.find('input[name^="button_url["][data-type=' + button_url_type + '], ' + 
//		'select[name^="button_url["][data-type=' + button_url_type + ']').show();
	})
	
	$('#theme').live('change', function(){
		$obj= $(this);
		theme_name= $obj.val();
		$('#theme-preview img').attr({'src': phc_pricing_table_admin_js_params.theme_url + theme_name + 
		'/preview.png' })
	})
})
})(jQuery);
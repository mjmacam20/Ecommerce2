$(document).ready(function(){
	$(".loader").hide();
	$("#getPrice").change(function(){
		var size = $(this).val();
		var product_id = $(this).attr("product-id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			url:'/get-product-price',
			data:{size:size,product_id:product_id},
			type:'post',
			success:function(resp){
                //if ever na di ko maayos ung orignal price ung pinakauna ang original price nalang ilalagay 
				if(resp['discount']>0){
					$(".getAttributePrice").html("<div class='price'><h4>₱ "+resp['final_price']+"</h4></div><div class='original-price'><span>Original Price: </span><span>₱ "+resp['product_price']+"</span></div>");
				}//else if(selectedSize !== ""){             
				//	$(".getAttributePrice").html("<div class='price'><h4>₱ {{ $productDetails['product_price'] }}</h4></div>");
				//}
                else{                    
                    $(".getAttributePrice").html("<div class='price'><h4>₱ "+resp['final_price']+"</h4></div>");
                }
            
			},error:function(){
				alert("Error");
			}
		});
	});

	// Update Cart Item Quantity
	$(document).on('click','.updateCartItem',function(){
		if($(this).hasClass('plus-a')){
			//Get quantity
			var quantity = $(this).data('qty');
			//Increase the quantity by 1
			new_qty = parseInt(quantity) + 1;
			/*alert(new_qty);*/
		}
		if($(this).hasClass('minus-a')){
			//Get quantity
			var quantity = $(this).data('qty');
			// Check if quantity is atleast 1
			if(quantity<=1){
				alert("Item quantity must be 1 or greater!");
				return false;
			}

			//Increase the quantity by 1
			new_qty = parseInt(quantity) - 1;
			/*alert(new_qty);*/
		}
		var cartid = $(this).data('cartid');
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			data:{cartid:cartid,qty:new_qty },
			url:'/cart/update',
			type:'post',
			success:function(resp){
				if(resp.status==false){
					alert(resp.message);
				}
				$("#appendCartItems").html(resp.view);
			},error:function(){
				alert("Error");
			}
		});
	});

	// Delete Cart Items 
	$(document).on('click','.deleteCartitem',function(){
		var cartid = $(this).data('cartid');
		var result = confirm("Are you sure to delete this Cart Item?");
		if(result){
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data:{cartid:cartid},
				url:'/cart/delete',
				type:'post',
				success:function(resp){
	
					$("#appendCartItems").html(resp.view);
				},error:function(){
					alert("Error");
				}
	
			})
		}
	});

	// Register Form Validation
	$("#registerForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			  		
			url:"/user/register",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#register-"+i).attr('style','color:red');
						$("#register-"+i).html(error);
			
					setTimeout(function(){
						$("#register-"+i).css({
							'display':'none'
						});
					},3000);
				});	
				}else if(resp.type=="success"){
					/*alert(resp.message);*/
					$(".loader").hide();
					$("#register-success").attr('style','color:green');
					$("#register-success").html(resp.message);				

				}			
			},error:function(){
				alert("Error");
			}
		})
	});	

	// Login Form Validation
	$("#loginForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			
			url:"/user/login",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#login-"+i).attr('style','color:red');
						$("#login-"+i).html(error);
			
					setTimeout(function(){
						$("#login-"+i).css({
							'display':'none'
						});
					},3000);
				});	
				}else if(resp.type=="incorrect"){
					$(".loader").hide();
					$("#login-error	").attr('style','color:red');
					$("#login-error	").html(resp.message);
				}else if(resp.type=="inactive"){
					$(".loader").hide();
					$("#login-error	").attr('style','color:red');
					$("#login-error	").html(resp.message);
				}else if(resp.type=="success"){
					$(".loader").hide();
					window.location.href = resp.url;
				}		
							
			},error:function(){
				alert("Error");
			}
		})
	});	

});


function get_filter(class_name){
    var filter = [];
    $('.'+class_name+':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}

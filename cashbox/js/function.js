//Login Page Function
	$("#username").change(function(){ 
		$('#username_error').html('');
	});
	$("#password").change(function(){ 
		$('#password_error').html('');
	});
	
	$( "#login_btn" ).on( "click", function() {
		$username = $('#username').val();
		$password = $('#password').val();
		$cpatchaTextBox = $('#cpatchaTextBox').val();
		
		var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
		
		if($username == ''){
			$('#username_error').html('Please Enter Username');
		}else if($password == ''){
			$('#password_error').html('Please Enter password');
		}else{			
			$.ajax({
			  method: "POST",
			  url: "assets/php/function.php",
			  data: { fn: "doLogin", username: $username, password: $password }
			})
			  .done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					window.location.href = '?p=dashboard';
				}else{
					$('#error_text').html('Wrong username or password');
				}
			});
			return false;
		}//end if else
	});

	//////////////////// ITEM FUNCTION START //////////////////////////
	//Show Modal
	function openItemModal(){
		console.log('Open the Item Modal');
		modal.style.display = "block";
	}
	function openPaySlipModal(){
		console.log('Open the payslip Modal');
		$('#emp_sal_id').val('0');
		$('#month_name').val('0').trigger('change');
		$('#emp_name').val('0').trigger('change');
		$('#emp_basic_pay').val('0');
		$('#attendance_count').val('0');

		$('#allounce_1').val('0');
		$('#allounce_2').val('0');
		$('#allounce_3').val('0');
		$('#allounce_4').val('0');
		
		$('#deduction_1').val('0');
		$('#deduction_2').val('0');
		$('#deduction_3').val('0');
		$('#deduction_4').val('0');

		$('#net_pay').val('0');
		modal.style.display = "block";
	}

	//Close Modal
	function closeItemModal(){
		console.log('Close the Item Modal');
		$('#item_id').val('0');
		$('#item_name').val('');
		$('#first_tunch').val('');
		$('#second_tunch').val('00.00');
		$('#total_tunch').val('');
		modal.style.display = "none";
	}

	//Close Employee Modal
	function closeEmployeeModal(){
		console.log('Close the Emp Modal');
		$('#emp_name').val('');
		$('#emp_ph_primary').val('');
		$('#emp_ph_secondary').val('');
		$('#emp_email').val('');
		$('#emp_aadhar_no').val('');
		$('#emp_pan_no').val('');				
		$('#emp_pf_no').val('');
		$('#emp_basic_pay').val('');
		$('#payment_type').val('0').trigger('change');
		$('#emp_address').val('');
		$('#emp_id').val('0');
		
		modal.style.display = "none";
	}

	$("#item_name").change(function(){ 
		$('#item_name_error').html('');
	});
	//Calculation
	$("#first_tunch, #second_tunch").blur(function(){ 
		$first_tunch = $('#first_tunch').val();
		$second_tunch = $('#second_tunch').val();
		$total_tunch = 0;
		$total_tunch = parseFloat($first_tunch) + parseFloat($second_tunch);
		$('#total_tunch').val($total_tunch.toFixed(2));
		$('#first_tunch_error').html('');
	});

	//Save Employee Function
	$("#saveEmployee").click(function(){
		$emp_id = $('#emp_id').val();
		$emp_name = $('#emp_name').val();
		$emp_ph_primary = $('#emp_ph_primary').val();
		$emp_ph_secondary = $('#emp_ph_secondary').val();
		$emp_email = $('#emp_email').val();
		$emp_aadhar_no = $('#emp_aadhar_no').val();
		$emp_pan_no = $('#emp_pan_no').val();		
		$emp_pf_no = $('#emp_pf_no').val();		
		$emp_basic_pay = $('#emp_basic_pay').val();
		$payment_type = $('#payment_type').val();
		$emp_address = $('#emp_address').val();
		$created_by = $('#created_by').val();

		$('#emp_form_error').html('');

		if($emp_name == ''){
			$('#emp_name_error').html('Please Enter Employee Name');
		}else if($emp_ph_primary == ''){
			$('#emp_ph_primary_error').html('Please Enter Primary Phone Number');
		}else if($emp_basic_pay == ''){
			$('#emp_basic_pay_error').html('Please Enter Basic Pay');
		}else if($payment_type == 0){
			$('#payment_type_error').html('Please Select Payment Type');
		}else if($emp_address == ''){
			$('#emp_address_error').html('Please Enter Address');
		}else{
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "saveEmployee", emp_id: $emp_id, emp_name: $emp_name, emp_ph_primary: $emp_ph_primary, emp_ph_secondary: $emp_ph_secondary, emp_email: $emp_email, emp_aadhar_no: $emp_aadhar_no, emp_pan_no: $emp_pan_no, emp_pf_no: $emp_pf_no, emp_basic_pay: $emp_basic_pay, payment_type: $payment_type, emp_address: $emp_address, created_by: $created_by }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){					
					$('#emp_name_error').html('');
					$('#emp_ph_primary_error').html('');
					$('#emp_aadhar_no_error').val('0');
					$('#emp_basic_pay_error').html('');
					$('#payment_type_error').val('');
					$('#emp_address_error').val('');
					$('#emp_id').val('0');
					
					if($emp_id == '0'){	
						//start
						const table = $("#dataTable").DataTable();
						// or using tr
						const tr = $("<tr id=emp_id_"+$res1.emp_id+"> <td>1</td> <td>"+$emp_name+"</td><td>"+$emp_ph_primary+" / "+$emp_ph_secondary+"</td><td>"+$emp_email+"</td><td>"+$emp_address+"</td> <td><a style='cursor: pointer;' onclick=updateEmpModal("+$res1.emp_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;' onclick=deleteEmployee("+$res1.emp_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>");
						table.row.add(tr[0]).draw();
					} else{
						console.log('Updatre the table row');
						$('#emp_id_'+$emp_id).html('');

						$('#emp_id_'+$emp_id).html("<td>1</td> <td>"+$emp_name+"</td><td>"+$emp_ph_primary+" / "+$emp_ph_secondary+"</td><td>"+$emp_email+"</td><td>"+$emp_address+"</td> <td><a style='cursor: pointer;' onclick=updateEmpModal("+$emp_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;' onclick=deleteEmployee("+$emp_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td>");
					}	
					modal.style.display = "none";
					//closeEmployeeModal();
				}else{
					$('#emp_form_error').html($res1.message);
				}
			});//end ajax
		}//end if
	});//end save Employee function

	//Save Function
	$("#saveItem").click(function(){
		$item_id = $('#item_id').val();
		$item_name = $('#item_name').val();
		$hs_code = $('#hs_code').val();
		$cgst_rate = $('#cgst_rate').val();
		$sgst_rate = $('#sgst_rate').val();
		$item_rate = 0;//$('#item_rate').val();
		$item_quantity = $('#item_quantity').val();		
		$hidden_stock_lower_limit = $('#hidden_stock_lower_limit').val();
		
		$stokist_price = $('#stokist_price').val();
		$dealer_price = $('#dealer_price').val();
		$wholesaler_price = $('#wholesaler_price').val();
		$retailer_price = $('#retailer_price').val();
		$net_weight = $('#net_weight').val();
		$login_id = $('#login_id').val();
		console.log('login_id: '+$login_id);

		if($item_name == ''){
			$('#item_name_error').html('Please Enter Item Name');
		}else if($hs_code == ''){
			$('#hs_code_error').html('Please Enter HS Code');
		}else if(parseInt($item_quantity) < parseInt($hidden_stock_lower_limit)){
			$('#item_quantity_error').html('Please Enter Quantity');
		}else if($stokist_price < 1){
			$('#stokist_price_error').html('Please Enter Stokist Price');
		}else if($dealer_price < 1){
			$('#dealer_price_error').html('Please Enter Dealer Price');
		}else if($wholesaler_price < 1){
			$('#wholesaler_price_error').html('Please Enter Wholesaler Price');
		}else if($retailer_price < 1){
			$('#retailer_price_error').html('Please Enter Retailer Price');
		}else if($net_weight < 1){
			$('#net_weight_error').html('Please Enter Net Weight/Packet');
		}else{
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "saveItem", item_id: $item_id, item_name: $item_name, hs_code: $hs_code, cgst_rate: $cgst_rate, sgst_rate: $sgst_rate, item_quantity: $item_quantity, stokist_price: $stokist_price, dealer_price: $dealer_price, wholesaler_price: $wholesaler_price, retailer_price: $retailer_price, net_weight: $net_weight, login_id: $login_id }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){					
					$('#item_name_error').html('');
					$('#hs_code_error').html('');
					$('#item_quantity').val('0');
					$('#item_quantity_error').html('');
					$('#item_name').val('');
					$('#hs_code').val('');
					$('#cgst_rate').val('2.50');
					$('#sgst_rate').val('2.50');
					$('#item_rate').val('');
					
					$('#stokist_price').val('0.00');
					$('#dealer_price').val('0.00');
					$('#wholesaler_price').val('0.00');
					$('#retailer_price').val('0.00');
					$('#net_weight').val('0.00');

					$('#stokist_price_error').html('');
					$('#dealer_price_error').html('');
					$('#wholesaler_price_error').html('');
					$('#retailer_price_error').html('');
					
					if($item_id == '0'){	
						//start
						const table = $("#dataTable").DataTable();
						// or using tr
						const tr = $("<tr id=item_id_"+$res1.item_id+"> <td>"+$item_name+"<br>"+$hs_code+"</td><td style='text-align: right;'>"+$cgst_rate+"<br>"+$sgst_rate+"</td><td style='text-align: right;'>"+$item_quantity+"</td> <td style='text-align: right;'>"+$stokist_price+"</td> <td style='text-align: right;'>"+$dealer_price+"</td> <td style='text-align: right;'>"+$wholesaler_price+"</td> <td style='text-align: right;'>"+$retailer_price+"</td> <td><a style='cursor: pointer;' onclick=updateItemModal("+$res1.item_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;' onclick=deleteItem("+$res1.item_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>");
						table.row.add(tr[0]).draw();
					} else{
						console.log('Updatre the table row');
						$('#item_id_'+$item_id).html('');

						$('#item_id_'+$item_id).html("<td>"+$item_name+"<br>"+$hs_code+"</td><td style='text-align: right;'>"+$cgst_rate+"<br>"+$sgst_rate+"</td><td style='text-align: right;'>"+$item_quantity+"</td> <td style='text-align: right;'>"+$stokist_price+"</td> <td style='text-align: right;'>"+$dealer_price+"</td> <td style='text-align: right;'>"+$wholesaler_price+"</td> <td style='text-align: right;'>"+$retailer_price+"</td> <td><a style='cursor: pointer;' onclick=updateItemModal("+$item_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;' onclick=deleteItem("+$item_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td>");
					}	
					modal.style.display = "none";
				}else{
					$('#item_name_error').html('Item Name already exists');
				}
			});//end ajax
		}//end if
	});//end saveItem function

	//Update function	
	function updateItemModal($item_id){		
		$login_id = $('#login_id').val();
		$user_type = $('#user_type').val();
		$created_by = $('#created_by').val();
		//Fetch data
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getItem", item_id: $item_id, login_id: $login_id, user_type: $user_type, created_by: $created_by }
		})
		.done(function( res ) {
			//console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){
				$('#item_id').val($res1.item_id);
				$('#item_name').val($res1.item_name);
				$('#hs_code').val($res1.hs_code);
				$('#cgst_rate').val($res1.cgst_rate);
				$('#sgst_rate').val($res1.sgst_rate);
				$('#item_quantity').val($res1.item_quantity);
				
				$('#stokist_price').val($res1.stokist_price);
				$('#dealer_price').val($res1.dealer_price);
				$('#wholesaler_price').val($res1.wholesaler_price);
				$('#retailer_price').val($res1.retailer_price);
				$('#net_weight').val($res1.net_weight);

				modal.style.display = "block";
			}else{
				$('#item_name_error').html('Item Name already exists');
			}
		});//end ajax
	}

	//Update employee function	
	function updateEmpModal($emp_id){
		$('#emp_id').val($emp_id)
		//Fetch data
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getEmployee", emp_id: $emp_id }
		})
		.done(function( res ) {
			//console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){
				$('#emp_name').val($res1.emp_name);
				$('#emp_ph_primary').val($res1.emp_ph_primary);
				$('#emp_ph_secondary').val($res1.emp_ph_secondary);
				$('#emp_email').val($res1.emp_email);
				$('#emp_aadhar_no').val($res1.emp_aadhar_no);
				$('#emp_pan_no').val($res1.emp_pan_no);				
				$('#emp_pf_no').val($res1.emp_pf_no);
				$('#emp_basic_pay').val($res1.emp_basic_pay);
				$('#payment_type').val($res1.payment_type).trigger('change');
				$('#emp_address').val($res1.emp_address);

				modal.style.display = "block";
			}else{
				$('#item_name_error').html('Item Name already exists');
			}
		});//end ajax
	}//end fun

	//Delete Employee function	
	function deleteEmployee($emp_id){
		console.log('Delete Item: '+$emp_id);
		if (confirm('Are you sure to delete the Employee?')) {
			$login_id = $('#login_id').val();
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deleteEmployee", emp_id: $emp_id }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#emp_id_'+$emp_id).remove();
				}
			});//end ajax
		}		
	}//end Employee delete

	//Delete function	
	function deleteItem($item_id){
		console.log('Delete Item: '+$item_id);
		if (confirm('Are you sure to delete the Item?')) {
			$login_id = $('#login_id').val();
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deleteItem", item_id: $item_id, login_id: $login_id }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#item_id_'+$item_id).remove();
				}
			});//end ajax
		}		
	}//end delete

	//////////////////// ITEM FUNCTION END //////////////////////////

	/////////////////// ZONE MANAGEMENT ////////////////////////
	//Show Modal
	function openZoneModal(){
		console.log('Open the Zone Modal');
		modal.style.display = "block";
	}
	function openHolidayModal(){
		console.log('Open Holiday Modal');
		modal.style.display = "block";
	}
	//Close Modal
	function closeZoneModal(){
		console.log('Close the Zone Modal');
		$('#zone_id').val('0');
		$('#zone_name').val('');
		$('#zone_area').val('');
		$('#zone_pincode').val('');
		modal.style.display = "none";
	}
	function closeHolidayModal(){
		console.log('Close the Holiday Modal');
		$('#h_id').val('0');
		$('#holiday_title').val('');
		$('#holiday_date').val(''); 
		modal.style.display = "none";
	}

	//Save Function
	$("#saveZone").click(function(){	
		$login_id = $('#login_id').val();
		$zone_id = $('#zone_id').val();
		$zone_name = $('#zone_name').val();
		$zone_area = $('#zone_area').val();
		$zone_pincode = $('#zone_pincode').val();

		if($zone_name == ''){
			$('#zone_name_error').html('Please Enter Zone Name');
		}else if($zone_area == ''){
			$('#zone_area_error').html('Please Enter Area or Location');
		}else if($zone_pincode == ''){
			$('#zone_pincode_error').html('Please Enter Quantity');
		}else{
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "saveZone", zone_id: $zone_id, zone_name: $zone_name, zone_area: $zone_area, zone_pincode: $zone_pincode, login_id: $login_id }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){					
					$('#zone_name_error').html('');
					$('#zone_area_error').html('');
					$('#zone_pincode_error').html('');
					
					if($zone_id == '0'){	
						//start
						const table = $("#dataTable").DataTable();
						// or using tr
						const tr = $("<tr id=zone_id_"+$res1.zone_id+"><td>0</td> <td>"+$zone_name+"</td><td>"+$zone_area+"</td><td>"+$zone_pincode+"</td><td><a style='cursor: pointer;' onclick=updateZoneModal("+$res1.zone_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;' onclick=deleteItem("+$res1.zone_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>");
						table.row.add(tr[0]).draw();
					} else{
						console.log('Updatre the table row');
						$('#zone_id_'+$zone_id).html('');

						$('#zone_id_'+$zone_id).html("<td>0</td><td>"+$zone_name+"</td><td>"+$zone_area+"</td><td>"+$zone_pincode+"</td><td><a style='cursor: pointer;' onclick=updateZoneModal("+$zone_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;' onclick=deleteItem("+$zone_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td>");
					}	
					modal.style.display = "none";
				}else{
					$('#zone_name_error').html('Zone Name already exists');
				}
			});//end ajax
		}//end if
	});//end saveZone function

	//Update function	
	function updateZoneModal($zone_id){		
		$login_id = $('#login_id').val();
		$user_type = $('#user_type').val();
		$created_by = $('#created_by').val();
		//Fetch data
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getZone", zone_id: $zone_id, login_id: $login_id, user_type: $user_type, created_by: $created_by }
		})
		.done(function( res ) {
			//console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){
				$('#zone_id').val($res1.zone_id);
				$('#zone_name').val($res1.zone_name);
				$('#zone_area').val($res1.zone_area);
				$('#zone_pincode').val($res1.zone_pincode);

				modal.style.display = "block";
			}else{
				$('#zone_name_error').html('Zone Name already exists');
			}
		});//end ajax
	}

	//Delete function	
	function deleteZone($zone_id){
		console.log('Delete zone: '+$zone_id);
		if (confirm('Are you sure to delete the Zone?')) {
			$login_id = $('#login_id').val();
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deleteZone", zone_id: $zone_id, login_id: $login_id }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#zone_id_'+$zone_id).remove();
				}
			});//end ajax
		}		
	}//end delete

	//Holiday List	

	//Save Function
	$("#saveHoliday").click(function(){	
		$h_id = $('#h_id').val();
		$holiday_title = $('#holiday_title').val();
		$holiday_date = $('#holiday_date').val(); 

		if($holiday_title == ''){
			$('#holiday_title_error').html('Please Enter Title');
		}else if($holiday_date == ''){
			$('#holiday_date_error').html('Please Enter Date');
		}else{
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "saveHoliday", h_id: $h_id, holiday_title: $holiday_title, holiday_date: $holiday_date }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){					
					$('#holiday_title_error').html('');
					$('#holiday_date_error').html(''); 
					
					if($h_id == '0'){	
						//start
						const table = $("#dataTable").DataTable();
						var rowCount = $('#dataTable tr').length;
						// or using tr
						const tr = $("<tr id=h_id_"+$res1.h_id+"><td>"+rowCount+"</td> <td>"+$holiday_title+"</td><td>"+$holiday_date+"</td><td><a style='cursor: pointer;' onclick=updateHolidayModal("+$res1.h_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;' onclick=deleteHoliday("+$res1.h_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>");
						table.row.add(tr[0]).draw();
					} else{
						console.log('Updatre the table row');
						$('#h_id_'+$h_id).html('');

						$('#h_id_'+$h_id).html("<td>0</td><td>"+$holiday_title+"</td><td>"+$holiday_date+"</td><td><a style='cursor: pointer;' onclick=updateHolidayModal("+$h_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;' onclick=deleteHoliday("+$h_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td>");
					}	
					$('#holiday_title').val('');
					$('#holiday_date').val(''); 
					modal.style.display = "none";
				}else{
					$('#holiday_date_error').html($res1.message);
				}
			});//end ajax
		}//end if
	});//end function

	//get edit holiday data		
	function updateHolidayModal($h_id){			
		//Fetch data
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getHoliday", h_id: $h_id }
		})
		.done(function( res ) {
			//console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){
				$('#h_id').val($res1.h_id);
				$('#holiday_title').val($res1.holiday_title);
				$('#holiday_date').val($res1.holiday_date); 

				modal.style.display = "block";
			} 
		});//end ajax
	}//end if

	//Delete holiday list
	function deleteHoliday($h_id){ 
		if (confirm('Are you sure to delete the Holiday?')) { 
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deleteHoliday", h_id: $h_id }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#h_id_'+$h_id).remove();
				}
			});//end ajax
		}		
	}//end delete

	//user zone add
	function updateUserZone($login_id){
		$zone_id = $('#zone_id_'+$login_id).val();
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "updateUserZone", zone_id: $zone_id, login_id: $login_id }
		})
		.done(function( res ) {
			//console.log(res);			
		});//end ajax
	}//end fun

	function printZoneCollectionReport(){
		$from_date = $('#from_date').val();
		$search_zone_id = $('#search_zone_id').val();	
		$zone_name = $("#search_zone_id option:selected").text();
		$search_cu_id = $('#search_cu_id').val();
		$ser_user_type = $('#ser_user_type').val();
		$ser_created_by = $('#ser_created_by').val();
		$ser_login_id = $('#ser_login_id').val();
		
		if($search_zone_id == '0'){
			alert('Please select Zone from the list')
		}else{
			window.open('pages/bill_printer/zone_report_pdf.php?from_date='+$from_date+'&search_zone_id='+$search_zone_id+'&search_cu_id='+$search_cu_id+'&user_type='+$ser_user_type+'&created_by='+$ser_created_by+'&login_id='+$ser_login_id+'&zone_name='+$zone_name, '_blank');
		}
	}//end function

	function zoneReportWithBill(){
		$from_date = $('#from_date').val();
		$search_zone_id = $('#search_zone_id').val();	
		$zone_name = $("#search_zone_id option:selected").text();
		$search_cu_id = $('#search_cu_id').val();
		$ser_user_type = $('#ser_user_type').val();
		$ser_created_by = $('#ser_created_by').val();
		$ser_login_id = $('#ser_login_id').val();
		
		if($search_zone_id == '0'){
			alert('Please select Zone from the list')
		}else{
			window.open('pages/bill_printer/zone_report_with_bill_pdf.php?from_date='+$from_date+'&search_zone_id='+$search_zone_id+'&search_cu_id='+$search_cu_id+'&user_type='+$ser_user_type+'&created_by='+$ser_created_by+'&login_id='+$ser_login_id+'&zone_name='+$zone_name, '_blank');
		}
	}//end function

	function zoneDataSheet(){
		//$from_date = $('#from_date').val();
		$search_zone_id = $('#search_zone_id').val();	
		$zone_name = $("#search_zone_id option:selected").text();
		$search_cu_id = $('#search_cu_id').val();
		$ser_user_type = $('#ser_user_type').val();
		$ser_created_by = $('#ser_created_by').val();
		$ser_login_id = $('#ser_login_id').val();
		
		if($search_zone_id == '0'){
			alert('Please select Zone from the list')
		}else{
			window.open('pages/bill_printer/zone_data_sheet_pdf.php?search_zone_id='+$search_zone_id+'&search_cu_id='+$search_cu_id+'&user_type='+$ser_user_type+'&created_by='+$ser_created_by+'&login_id='+$ser_login_id+'&zone_name='+$zone_name, '_blank');
		}
	}//end function
	////////////////// ZONE MANAGEMENT END ////////////////

	//////////////////// CUSTOMER FUNCTION START //////////////////////////
	//Show Modal
	function openCustomerModal(){
		modalCustomer.style.display = "block";
	}
	function cashBookNewEntry(){					
		$('#cb_date').val('');
		$('#receive_payment').val('');
		$('#cb_narration').val('');
		$('#cb_amount').val('');	
		$('#cb_id').val('0');	
		modalCustomer.style.display = "block";
	}

	function openCreateUserModal(user_type){
		console.log('user type:'+user_type);
		$('#user_type').val(user_type);
		
		$('modal_heading').html('');
		if(user_type == '0'){
			$('#modal_heading').html('Add/Update Super Admin');
		}else if(user_type == '1'){
			$('#modal_heading').html('Add/Update Stockist');
		}else if(user_type == '2'){
			$('#modal_heading').html('Add/Update Dealer');
		}else if(user_type == '3'){
			$('#modal_heading').html('Add/Update Wholesaler');
		}else if(user_type == '4'){
			$('#modal_heading').html('Add/Update Retailer');
		}else{
			$('#modal_heading').html('Add/Update Sales Man');
		}
	
		$('#update_login_id').val('0');	
		$('#org_name').val('');
		$('#contact_person').val('');
		$('#phone_number').val('');
		$('#whatsapp_number').val('');
		$('#email_id').val('');
		$('#address').val('');
		$('#pin_code').val('');
		$('#gstin_no').val('');

		modalCustomer.style.display = "block";
	}

	//Close Modal
	function closeCustomerModal(){
		console.log('Close the Item Modal');
		modalCustomer.style.display = "none";
	}

	$("#customer_name, #phone_number").blur(function(){ 
		$('#customer_name_error').html('');
		$('#phone_number_error').html('');
	});

	//Save user Function start
	$("#org_name").keypress(function() {
		$('#org_name_error').html('');
	});
	$("#contact_person").keypress(function() {
		$('#contact_person_error').html('');
	});
	$("#whatsapp_number").keypress(function() {
		$('#whatsapp_number_error').html('');
	});
	$("#address").keypress(function() {
		$('#address_error').html('');
	});
	$("#pin_code").keypress(function() {
		$('#pin_code_error').html('');
	});
	$("#gstin_no").keypress(function() {
		$('#gstin_no_error').html('');
	});
	
	$("#saveUser").click(function(){		
		$login_id = $('#login_id').val();	
		$logged_in_user_type = $('#logged_in_user_type').val();			
		$created_by = $('#created_by').val();

		$update_login_id = $('#update_login_id').val();		
		$user_type = $('#user_type').val();
		$org_name = $('#org_name').val();
		$contact_person = $('#contact_person').val();
		$phone_number = $('#phone_number').val();
		$whatsapp_number = $('#whatsapp_number').val();		
		$email_id = $('#email_id').val();		
		$address = $('#address').val();		
		$pin_code = $('#pin_code').val();		
		$gstin_no = $('#gstin_no').val();			
		$net_due_amount = $('#net_due_amount').val();
		

		if($org_name == ''){
			$('#org_name_error').html('Please Enter Organization Name');
		}else if($contact_person == ''){
			$('#contact_person_error').html('Please Enter Contact Person');
		}else if($address == ''){
			$('#address_error').html('Please Enter Address');
		}else if($pin_code == ''){
			$('#pin_code_error').html('Please Enter Pincode');
		}/*else if($gstin_no == ''){
			$('#gstin_no_error').html('Please Enter GSTIN');
		}*/else{
			$user_data = {
				'org_name': $org_name,
				'contact_person': $contact_person,
				'phone_number': $phone_number,
				'whatsapp_number': $whatsapp_number,
				'email_id': $email_id,
				'address': $address,
				'pin_code': $pin_code,
				'gstin_no': $gstin_no
			};

			console.log(JSON.stringify($user_data));

			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "saveUser", login_id: $login_id, user_data: $user_data, whatsapp_number: $whatsapp_number, update_login_id: $update_login_id, user_type: $user_type, logged_in_user_type: $logged_in_user_type, created_by: $created_by, net_due_amount: $net_due_amount }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){	
					$('#update_login_id').val('0');	
					$('#org_name').val('');
					$('#contact_person').val('');
					$('#phone_number').val('');
					$('#whatsapp_number').val('');
					$('#email_id').val('');
					$('#address').val('');
					$('#pin_code').val('');
					$('#gstin_no').val('');
					
					if($update_login_id == '0'){	
						const table = $("#dataTable").DataTable();
						const tr = $("<tr id=user_id_"+$res1.update_login_id+"><td>"+$res1.update_login_id+"</td><td>"+$org_name+"</td><td>"+$contact_person+"</td><td>"+$phone_number+"/"+$whatsapp_number+"</td><td>"+$address+"</td><td>"+$email_id+"</td><td>0.00</td><td><a style='cursor: pointer;' onclick=updateUserModal("+$res1.customer_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;' onclick=deleteUser("+$res1.customer_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>");
						table.row.add(tr[0]).draw();
					} else{
						console.log('Updatre the table row');
						$('#user_id_'+$update_login_id).html('');

						$('#user_id_'+$update_login_id).html("<td>"+$update_login_id+"</td><td>"+$org_name+"</td><td>"+$contact_person+"</td><td >"+$phone_number+"/"+$whatsapp_number+"</td><td>"+$address+"</td><td>"+$email_id+"</td><td>0.00</td><td><a style='cursor: pointer;'  onclick=updateUserModal("+$update_login_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;'  onclick=deleteUser("+$update_login_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td>");
						modalCustomer.style.display = "none";
					}	
					// modalCustomer.style.display = "none";
				}else{
					//$('#whatsapp_number_error').html('Whatsapp number already exists');
				}
			});//end ajax
		}//end if
	});
	//End save user function

	//Fetch User Data Start
	$("#clickSuperAdmin").click(function(){
		$fetchUserType = 0;	
		fetchUserData($fetchUserType);
	});
	$("#clickStockist").click(function(){
		$fetchUserType = 1;	
		fetchUserData($fetchUserType);
	});
	$("#clickDealer").click(function(){
		$fetchUserType = 2;	
		fetchUserData($fetchUserType);
	});
	$("#clickWholesaler").click(function(){
		$fetchUserType = 3;	
		fetchUserData($fetchUserType);
	});
	$("#clickRetailer").click(function(){
		$fetchUserType = 4;	
		fetchUserData($fetchUserType);
	});
	$("#clickSalesMan").click(function(){
		$fetchUserType = 5;	
		fetchUserData($fetchUserType);
	});

	function fetchUserData($fetchUserType){				
		$login_id = $('#login_id').val();	
		$logged_in_user_type = $('#logged_in_user_type').val();			
		$created_by = $('#created_by').val();

		//Fetch data
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getUserAll", fetchUserType: $fetchUserType, login_id: $login_id, logged_in_user_type: $logged_in_user_type, created_by: $created_by }
		})
		.done(function( res ) {
			$res1 = JSON.parse(res);
			//console.log(JSON.stringify($res1));

			if($res1.status == true){	
				$users = $res1.users;
				$zones = $res1.zones;

				const table = $("#dataTable").DataTable();
				table.clear();

				for($i = 0; $i < $users.length; $i++){
					$user_data = $users[$i].user_data;

					$options_string = "<option value='0'>Select Zone</option>";
					for($j = 0; $j < $zones.length; $j++){
						$selected_string = '';
						if($users[$i].zone_id == $zones[$j].zone_id){
							$selected_string = 'selected';
						}
						$options_string += "<option value="+$zones[$j].zone_id+" "+$selected_string+ ">"+$zones[$j].zone_name+"</option>";
					}//end $j

					const tr = $("<tr id=user_id_"+$users[$i].login_id+"><td>"+$users[$i].login_id+"</td><td>"+$user_data.org_name+"</td><td>"+$user_data.contact_person+"</td><td>"+$user_data.phone_number+"/"+$user_data.whatsapp_number+"</td><td>"+$user_data.address+"</td><td><select name=zone_id_"+$users[$i].login_id+" id=zone_id_"+$users[$i].login_id+" onChange=updateUserZone("+$users[$i].login_id+")>"+$options_string+"</select></td><td>"+$users[$i].net_due_amount+"</td><td><a style='cursor: pointer;' onclick=updateUserModal("+$users[$i].login_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;' onclick=deleteUser("+$users[$i].login_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>");
					table.row.add(tr[0]).draw();
				}//end for
			}else{
				console.log('else part');
				const table = $("#dataTable").DataTable();
				table.clear();
				const tr = $("<tr><td>#</td><td>-</td><td>No Data Available</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>");
				table.row.add(tr[0]).draw();
			}
		});//end ajax
	}//end function

	//Fetch User data end


	//Save Function
	$("#saveCustomer").click(function(){		
		$customer_id = $('#customer_id').val();
		$customer_name = $('#customer_name').val();
		$phone_number = $('#phone_number').val();
		$customer_address = $('#customer_address').val();
		$customer_gstin_no = $('#customer_gstin_no').val();
		$customer_email = $('#customer_email').val();

		if($customer_name == ''){
			$('#customer_name_error').html('Please Enter Customer Name');
		}else if($phone_number == ''){
			$('#phone_number_error').html('Please Enter Phone Number');
		}else{
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "saveCustomer", customer_id: $customer_id, customer_name: $customer_name, phone_number: $phone_number, customer_gstin_no: $customer_gstin_no, customer_address: $customer_address, customer_email: $customer_email }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){					
					$('#customer_name_error').html('');
					$('#phone_number_error').html('');
					$('#customer_name').val('');
					$('#customer_gstin_no').val('');
					$('#customer_address').val('');
					$('#customer_email').val('');
					
					if($customer_id == '0'){	
						const table = $("#dataTable").DataTable();
						const tr = $("<tr id=customer_id_"+$res1.customer_id+"><td>"+$customer_name+"</td><td>"+$phone_number+"</td><td>"+$customer_gstin_no+"</td><td>"+$customer_address+"</td><td>"+$customer_email+"</td><td><a style='cursor: pointer;' onclick=updateCustomerModal("+$res1.customer_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;' onclick=deleteCustomer("+$res1.customer_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>");
						table.row.add(tr[0]).draw();
					} else{
						console.log('Updatre the table row');
						$('#customer_id_'+$customer_id).html('');

						$('#customer_id_'+$customer_id).html("<td>"+$customer_name+"</td><td>"+$phone_number+"</td><td >"+$customer_gstin_no+"</td><td>"+$customer_address+"</td><td>"+$customer_email+"</td><td><a style='cursor: pointer;'  onclick=updateCustomerModal("+$customer_id+")><i class='fa fa-edit' aria-hidden='true'></i></a><a style='cursor: pointer;'  onclick=deleteCustomer("+$customer_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td>");
					}	
					modalCustomer.style.display = "none";
				}else{
					$('#customer_name_error').html('Customer Name already exists');
				}
			});//end ajax
		}//end if
	});

	//Update function	
	function updateCustomerModal($customer_id){	
		//Fetch data
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getCustomer", customer_id: $customer_id }
		})
		.done(function( res ) {
			//console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){
				$('#customer_id').val($res1.customer_id);
				$('#customer_name').val($res1.customer_name);
				$('#phone_number').val($res1.phone_number);
				$('#customer_address').val($res1.customer_address);
				$('#customer_gstin_no').val($res1.customer_gstin_no);
				$('#customer_email').val($res1.customer_email);
				modalCustomer.style.display = "block";
			}
		});//end ajax
	}

	//Update users	
	function updateUserModal($login_id){	
		//Fetch data
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getUser", login_id: $login_id }
		})
		.done(function( res ) {
			$res1 = JSON.parse(res);
			console.log(JSON.stringify($res1));

			if($res1.status == true){				
				$('#update_login_id').val($login_id);	
				$('#user_type').val($res1.user_type);
				$('#org_name').val($res1.user_data.org_name);
				$('#contact_person').val($res1.user_data.contact_person);
				$('#phone_number').val($res1.user_data.phone_number);
				$('#whatsapp_number').val($res1.user_data.whatsapp_number);
				$('#email_id').val($res1.user_data.email_id);
				$('#address').val($res1.user_data.address);
				$('#pin_code').val($res1.user_data.pin_code);
				$('#gstin_no').val($res1.user_data.gstin_no);
				$('#net_due_amount').val($res1.net_due_amount);

				if($res1.user_type == '0'){
					$('#modal_heading').html('Add/Update Super Admin');
				}else if($res1.user_type == '1'){
					$('#modal_heading').html('Add/Update Stockist');
				}else if($res1.user_type == '2'){
					$('#modal_heading').html('Add/Update Dealer');
				}else if($res1.user_type == '3'){
					$('#modal_heading').html('Add/Update Wholesaler');
				}else if($res1.user_type == '4'){
					$('#modal_heading').html('Add/Update Retailer');
				}else{
					$('#modal_heading').html('Add/Update Sales Man');
				}

				modalCustomer.style.display = "block";
			}
		});//end ajax
	}//end

	//Delete user	
	function deleteUser($login_id){
		if (confirm('Are you sure to delete the user?')) {
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deleteUser", login_id: $login_id }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#user_id_'+$login_id).remove();
					$("#alert_msg_txt").html('');
					$("#alert_msg").addClass("hide");
				}else{
					$("#alert_msg_txt").html('Already has many sub users');
					$("#alert_msg").removeClass("hide");
				}
			});//end ajax
		}		
	}//end delete user

	//Delete function	
	function deleteCustomer($customer_id){
		console.log('Delete Customer: '+$customer_id);
		if (confirm('Are you sure to delete the Customer?')) {
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deleteCustomer", customer_id: $customer_id }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#customer_id_'+$customer_id).remove();
				}
			});//end ajax
		}		
	}//end delete

	function miniStatement($customer_id){
		//Fetch data
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "miniStatement", customer_id: $customer_id }
		})
		.done(function( res ) {
			//console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){
				$('#tbody_ministatement').html('');
				if(parseInt($res1.i) > 0){
					var generatedRow = '';
					for(var j = 0; j < $res1.miniStatement.length; j++){
						generatedRow += "<tr><td>"+$res1.miniStatement[j].i+"</td><td>"+$res1.miniStatement[j].billId+"</td><td style='text-align: right;'>"+$res1.miniStatement[j].fineItemsTotalSubTotal+"</td><td style='text-align: right;'>"+$res1.miniStatement[j].jamaItemsSubTotal+"</td><td style='text-align: right;'>"+$res1.miniStatement[j].netMetalBalance+"</td><td style='text-align: right;'>"+$res1.miniStatement[j].netMetalBalance+"</td><td style='text-align: right;'>"+$res1.miniStatement[j].totalCash+"</td><td>"+$res1.miniStatement[j].create_date+"</td></tr>";
					}//end for

					if(parseInt($res1.i) > 1){
						generatedRow += "<tr style='font-weight: bold;'><td>&nbsp;</td><td>Total</td><td style='text-align: right;'>"+$res1.subTotalfineItemsTotalSubTotal+"</td><td style='text-align: right;'>"+$res1.subTotaljamaItemsSubTotal+"</td><td style='text-align: right;'>"+$res1.subTotalnetMetalBalance+"</td><td style='text-align: right;'>"+$res1.subTotalnetMetalBalance+"</td><td style='text-align: right;'>"+$res1.subTotaltotalCash+"</td><td>&nbsp;</td></tr>";
					}//end if

					$('#tbody_ministatement').html(generatedRow);
				}else{
					var generatedRow = "<tr><td colspan='7'>No Record Available</td></tr>";
					$('#tbody_ministatement').html(generatedRow);
				}
				
				miniSlip.style.display = "block";
			}
		});//end ajax

	}//end 
	//Close Modal
	function closeMiniSlipModal(){
		console.log('Close the minislip Modal');
		miniSlip.style.display = "none";
	}
	//////////////////// CUSTOMER FUNCTION END //////////////////////////

	//////////////////// BILL FUNCTION START //////////////////////////
	//Show Modal
	function openBillModal($current_bill_id){
		console.log('Open the Item Modal');
		$('#current_bill_id').val($current_bill_id);
		$user_type = $('#user_type').val();
		$login_id = $('#login_id').val();
		$created_by = $('#created_by').val();
		$customers = [];

		if($current_bill_id == '0'){
			$final_bill = 0;
			$bill_edit = 0;

			const d = new Date();		
			$billId = d.getDate() +''+ ( d.getMonth() + 1 )+''+ d.getFullYear()+''+ d.getHours()+''+ d.getMinutes()+''+ d.getSeconds();

			$billDetail = {
				billId: $billId,
				zone_id: '0',
				zone_name: '',
				customer_id: '0',
				customer_name: '',
				customer_address: '',
				customer_gstin_no: '',
				email_id: '',
				phone_number: '',
				guestUserPhone: '',
				fineItems: [],
				fineItemsSubTotal: '00.00',
				paymentType: '',
				subTotalQty: '0',
				subTotalAmount: '0',
				subTotalTaxValue: '0',
				subTotalCgst: '0',
				subTotalSgst: '0',
				roundedUpFineItemsSubTotal: '0.00',
				totalCash: '0.00',
				dueCash: '0.00',
				thisBillDue: '0.00',
				rate_type: '0',
				rate_type_text: '',
				b_user_type: '',
				createdBy: {
					org_name: '',
					address: '',
					contact_no: '',
					gstin_no: '',
					email: ''
				},
				discountType: '0',
				discountRate: '0',
				discountAmount: '0'
			}

			//Populate Customer List
			$populate_customer = false;
			$populate_item = false;
			$('#bill_customer_id_block1').show();
			$('#paymentHistoryList').hide();
			$('#discountHistory').hide();
			$('#bill_customer_id_block2').hide();
			$('#edit_customer_name').html('');

			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "getCustomerList", user_type: $user_type, login_id: $login_id, created_by: $created_by}
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$customers = $res1.customers;
					
					$('#bill_customer_id').html('');
					$options = "<option selected value='0'>Select Customer</option>";
					for(var i = 0; i < $customers.length; i++){						
						$b_user_data = $customers[i].b_user_data;
						$b_stock_quantity = $customers[i].b_stock_quantity;
						$org_name = $b_user_data.org_name;
						$contact_person1 = $b_user_data.contact_person;
						$contact_person = $contact_person1.replace(/ /g, "_");
						$phone_number = $b_user_data.phone_number? $b_user_data.phone_number: '9999999999';
						$whatsapp_number = $b_user_data.whatsapp_number? $b_user_data.whatsapp_number: '9999999999';
						$email_id = $b_user_data.email_id? $b_user_data.email_id: 'xxx@xxxx.com';
						$address1 = $b_user_data.address;
						$address = $address1.replace(/ /g, "_");
						$pin_code = $b_user_data.pin_code;
						$gstin_no = $b_user_data.gstin_no? $b_user_data.gstin_no: '0000000000';
						$b_user_type = $customers[i].b_user_type;

						$options += "<option value="+$customers[i].b_login_id+" customer_name="+$contact_person+" phone_number="+$phone_number+" whatsapp_number="+$whatsapp_number+" email_id="+$email_id+" pin_code="+$pin_code+" customer_gstin_no="+$gstin_no+" customer_address="+$address+" b_user_type="+$b_user_type+" net_due_amount="+$customers[i].net_due_amount+">"+$org_name+"</option>";
					}
					$('#bill_customer_id').html($options);					
					$('#bill_customer_id').prop('disabled', false);
					$populate_customer = true;
				}
			});//end ajax

			$('#old_balance_metal').val('');
			$('#old_balance_cash').val('');
			$("#tbody_billedItem").empty();
			$('#fineItemsSubTotal').html('0.00');
			$('#fineItemsTotalSubTotal').html('0.00');
			$('#old_due_amount').val('0.00');
			$("#tbody_jamaDetails").empty();
			$('#jamaItemsSubTotal').html('0.00');
			$('#netMetalBalance').html('0.00');
			$('#totalCash').val('0.00');
			$('#dueCash').val('0.00');
			$('#net_due_amount').val('0.00');
			document.getElementById('cash').checked = false;
			document.getElementById('due').checked = false;
			$('#createFinalBill').prop('disabled', true);												
			$('#rate_type').val('0');												
			$('#subTotalQty').html('0');											
			$('#subTotalAmount').html('0.00');											
			$('#subTotalTaxValue').html('0.00');											
			$('#subTotalCgst').html('0.00');											
			$('#subTotalSgst').html('0.00');
			$('#hidden_totalCash').val('0.00');
			//$('#discountType').val('0');
			$('#discountRate').val('0.00');
			$('#discountAmount').val('0.00');					
			
			$('#zone_id').val('0').trigger('change');
			$('#bill_customer_id').prop('disabled', false);

			modalCustomer.style.display = "block";
		}else{
			//Update Bill Section
			$final_bill = 0;
			$bill_edit = 1;

			$populate_customer = false;
			$populate_item = false;

			//Fetch data
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "getBillDetails", bill_id: $current_bill_id }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$billDetail = $res1.bill_description;	
					$payHistory = $res1.payHistory;

					//Populate Fine Item List
					$loopFineItems = $billDetail.fineItems;

					//Set the data into the table
					$new_row = "";
					$('#tbody_billedItem').html('');
					//("+$fine_item_obj+','+$net_value+','+$qty+','+$amount+','+$tax_value+','+$cgst_amount+','+$sgst_amount+")
					for(var i = 0; i < $loopFineItems.length; i++){
						$new_row += "<tr id=fine_item_obj_"+$loopFineItems[i].fine_item_obj+"><td>"+$loopFineItems[i].slno+"</td><td class='text-left'>"+$loopFineItems[i].products+"</td><td class='text-left'>"+$loopFineItems[i].hs_code+"</td><td class='text-right'>"+$loopFineItems[i].qty+"</td><td class='text-right'>"+$loopFineItems[i].rate+"</td><td class='text-right'>"+$loopFineItems[i].amount+"</td><td class='text-right'>"+$loopFineItems[i].tax_value+"</td><td class='text-right'>"+$loopFineItems[i].cgst_rate+"</td><td class='text-right'>"+$loopFineItems[i].cgst_amount+"</td><td class='text-right'>"+$loopFineItems[i].sgst_rate+"</td><td class='text-right'>"+$loopFineItems[i].sgst_amount+"</td><td class='text-right'>"+$loopFineItems[i].net_value+"</td><td><a type='button' style='cursor: pointer;' onclick=removeFineItems("+$loopFineItems[i].fine_item_obj+','+$loopFineItems[i].net_value+','+$loopFineItems[i].qty+','+$loopFineItems[i].amount+','+$loopFineItems[i].tax_value+','+$loopFineItems[i].cgst_amount+','+$loopFineItems[i].sgst_amount+','+$loopFineItems[i].item_id+")><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>";						
					}//end for	

					$('#create_date_new').val($billDetail.create_date_new);
					$('#tbody_billedItem').html($new_row);
					$('#fineItemsSubTotal').html($billDetail.fineItemsSubTotal);
					$('#subTotalQty').html($billDetail.subTotalQty);
					$('#subTotalAmount').html($billDetail.subTotalAmount);		
					$('#subTotalTaxValue').html($billDetail.subTotalTaxValue);			
					$('#subTotalCgst').html($billDetail.subTotalCgst);			
					$('#subTotalSgst').html($billDetail.subTotalSgst);
					$('#net_due_amount').val($res1.net_due_amount);					
					$('#old_due_amount').val($billDetail.dueCash);
					$('#totalCash').val($billDetail.totalCash);
					$('#hidden_totalCash').val($billDetail.totalCash);
					$('#discountType').val('0');
					$('#discountRate').val('0');
					$('#discountAmount').val('0');
					if($billDetail.zone_id){
						$('#zone_id').val($billDetail.zone_id).trigger('change');
						$('#bill_customer_id').prop('disabled', true);
					}
					

					//Payment Type Part
					if($billDetail.paymentType == 'due'){
						$('#due').attr('checked',true);
						$('#totalCashBlock').hide();
						$('#totalDueBlock').hide();
					}
					if($billDetail.paymentType == 'cash'){
						$('#cash').attr('checked',true);
						$('#totalCashBlock').show();
						$('#totalDueBlock').show();
						$('#dueCash').val($billDetail.dueCash);	
						
						$('#discountTypeBlock').show();
						$('#discountRateBlock').show();
						$('#discountAmountBlock').show();
						$('#discountType').prop('disabled', false);
						$('#discountRate').prop('disabled', false);
						$('#discountAmount').prop('disabled', false);
						
						if($billDetail.discountType != undefined){
							$('#discountType').val($billDetail.discountType);
							$('#discountRate').val($billDetail.discountRate);
							$('#discountAmount').val($billDetail.discountAmount);
						}
						console.log('discountType: '+$billDetail.discountType);
						if(parseInt($billDetail.discountType) > 0){
							$('#discountTypeBlock').show();
							$('#discountRateBlock').show();
							$('#discountAmountBlock').show();
							$('#discountType').prop('disabled', true);
							$('#discountRate').prop('disabled', true);
							$('#discountAmount').prop('disabled', true);
						}
					}			

					//Payment History
					$payHistoryText = '';
					for(var j = 0; j < $payHistory.length; j++){
						$payHistoryText += "<div class='col-md-12'>Amount Rs. "+$payHistory[j].cb_amount+"/- Paid on "+$payHistory[j].cb_date+"</div>";
					}//end for

					$discountText = '';
					if($billDetail.discountType == 1){
						$discountText += 'Fixed Discount Rs. '+$billDetail.discountAmount+'/-';
					}else if($billDetail.discountType == 2){
						$discountText += 'Discount Percentage Rs.'+ $billDetail.discountRate +'% Discounted Amount Rs. '+$billDetail.discountAmount+'/-';
					}

					$('#paymentHistoryList').html($payHistoryText);
					$('#discountHistory').html($discountText);

					$('#bill_customer_id_block1').hide();
					$('#paymentHistoryList').show();
					$('#discountHistory').show();
					$('#bill_customer_id_block2').show();
					$('#edit_customer_name').html($billDetail.customer_name);					

					//Populate Item List Bill Edit
					$.ajax({
						method: "POST",
						url: "assets/php/function.php",
						data: { fn: "populateItemList", b_user_type: $billDetail.b_user_type, login_id: $login_id, user_type: $user_type, created_by: $created_by }
					})
					.done(function( res ) {
						$res1 = JSON.parse(res);
						if($res1.status == true){
							$items = $res1.items;
							$('#bill_item_id').html('');
							$options = "<option selected value='0'>---- Select Item ----</option>";
							for(var i = 0; i < $items.length; i++){
								$options += "<option value="+$items[i].item_id+" item_name="+$items[i].item_name+" hs_code="+$items[i].hs_code+" cgst_rate="+$items[i].cgst_rate+" sgst_rate="+$items[i].sgst_rate+" item_rate="+$items[i].item_rate+" item_quantity="+$items[i].item_quantity+" net_weight="+$items[i].net_weight+" >"+$items[i].item_name+"</option>";
							}
							$('#bill_item_id').html($options);	
							$populate_item = true;
						}
					});//end ajax
					
					modalCustomer.style.display = "block";
				}
			});//end ajax
		}//end if

		
	}//end fnction

	//Close Bill Modal
	function closeBillModal(){
		console.log('Close the Item Modal');
		modalBill.style.display = "none";
	}
	
	$("#bill_customer_id").change(function(){ 
		if($billDetail.fineItems.length == 0){
			$('#rate_type_error').html('');
			$('#customer_id_error').html('');
			$('#guestUserPhone_error').html('');
			$bill_customer_id = $('#bill_customer_id').val();
			$customer_id_n = $('#bill_customer_id').val();
			var bill_customer_id = $('#bill_customer_id').find('option:selected'); 
			$b_user_type = bill_customer_id.attr("b_user_type"); 	
			$customer_name = $("#bill_customer_id option:selected").text();
			$phone_number = bill_customer_id.attr("phone_number");
			$net_due_amount = bill_customer_id.attr("net_due_amount");
			
			$customer_address = bill_customer_id.attr("customer_address");
			$customer_gstin_no = bill_customer_id.attr("customer_gstin_no");
			$email_id = bill_customer_id.attr("email_id");

			$('#net_due_amount').val($net_due_amount);

			$billDetail.customer_id = $customer_id_n;
			$billDetail.customer_name = $customer_name;
			$billDetail.phone_number = $phone_number;
			$billDetail.b_user_type = $b_user_type;

			$billDetail.customer_address = $customer_address;
			$billDetail.customer_gstin_no = $customer_gstin_no;
			$billDetail.email_id = $email_id;

			if($b_user_type == '1'){
				$rate_type_txt = 'stokist_price';
			}else if($b_user_type == '2'){
				$rate_type_txt = 'dealer_price';
			}else if($b_user_type == '3'){
				$rate_type_txt = 'wholesaler_price';
			}else if($b_user_type == '4'){
				$rate_type_txt = 'retailer_price';
			}else{
				$rate_type_txt = '';
			}
			$billDetail.rate_type = $b_user_type;
			$billDetail.rate_type_text = $rate_type_txt;

			$login_id = $('#login_id').val();
			$user_type = $('#user_type').val();
			$created_by = $('#created_by').val();

			//Populate Item List
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "populateItemList", b_user_type: $b_user_type, login_id: $login_id, user_type: $user_type, created_by: $created_by }
			})
			.done(function( res ) {
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$items = $res1.items;
					$('#bill_item_id').html('');
					$options = "<option selected value='0'>---- Select Item ----</option>";
					for(var i = 0; i < $items.length; i++){
						$options += "<option value="+$items[i].item_id+" item_name="+$items[i].item_name+" hs_code="+$items[i].hs_code+" cgst_rate="+$items[i].cgst_rate+" sgst_rate="+$items[i].sgst_rate+" item_rate="+$items[i].item_rate+" item_quantity="+$items[i].item_quantity+" net_weight="+$items[i].net_weight+">"+$items[i].item_name+"</option>";
					}
					$('#bill_item_id').html($options);	
					$populate_item = true;
				}
			});//end ajax
		}else{
			alert('You can not change Customer Name');
		}//end if
	});

	$("#bill_item_id").change(function(){ 
		$('#item_id_error').html('');
		var bill_item_id = $('#bill_item_id').find('option:selected'); 

        $bill_item_rate = bill_item_id.attr("item_rate"); 
        $bill_cgst_rate = bill_item_id.attr("cgst_rate");
        $bill_sgst_rate = bill_item_id.attr("sgst_rate");
        $bill_net_weight = bill_item_id.attr("net_weight");

		$('#bill_item_rate').val($bill_item_rate);
		$('#bill_cgst_rate').val($bill_cgst_rate);
		$('#bill_sgst_rate').val($bill_sgst_rate);
		$('#bill_net_weight').val($bill_net_weight);

		updateItemValue();
	});

	$("#bill_item_quantity, #bill_item_rate, #bill_cgst_rate, #bill_sgst_rate").blur(function(){ 		
		$('#bill_item_quantity_error').html('');
		updateItemValue();
	});

	function updateItemValue(){
        $bill_item_quantity = $('#bill_item_quantity').val(); 
        $bill_item_rate = $('#bill_item_rate').val(); 
		$bill_cgst_rate = $('#bill_cgst_rate').val();
		$bill_sgst_rate = $('#bill_sgst_rate').val();

		//bill_item_id
		var bill_item_id_str = $('#bill_item_id').find('option:selected'); 
		$item_quantity = bill_item_id_str.attr("item_quantity"); 

		if(parseInt($item_quantity) < parseInt($bill_item_quantity)){
			alert('Available Stock: '+$item_quantity);
			$('#bill_item_quantity').val($item_quantity); 
		}else{
			if($bill_item_quantity > 0){
				$total_tax = parseFloat($bill_cgst_rate) + parseFloat($bill_sgst_rate);
				$without_tax = parseFloat($bill_item_quantity) * parseFloat($bill_item_rate);
				$without_tax = toFixedTrunc($without_tax, 2);			
				$cgst_tax_value = ($without_tax * $bill_cgst_rate) / 100;
				$cgst_tax_value = toFixedTrunc($cgst_tax_value, 2);
				$sgst_tax_value = ($without_tax * $bill_sgst_rate) / 100;
				$sgst_tax_value = toFixedTrunc($sgst_tax_value, 2);
				$tax_value = parseFloat($cgst_tax_value) + parseFloat($sgst_tax_value);
				$tax_value = toFixedTrunc($tax_value, 2);
				console.log('tax_value: ' + $tax_value);
				$with_tax1 = parseFloat($without_tax) + parseFloat($tax_value);
				$with_tax = toFixedTrunc($with_tax1, 2);

				$('#bill_item_value').val($with_tax);
				$('#hidden_item_amount').val($without_tax);	
				$('#cgst_tax_value').val($cgst_tax_value);
				$('#sgst_tax_value').val($sgst_tax_value);
				$('#tax_value').val($tax_value);
			}	
		}//end else	
	}//end function

	//Add Fine Item	
	$("#addBillItem").click(function(){
		var bill_item_id_str = $('#bill_item_id').find('option:selected'); 
		$bill_item_id = $('#bill_item_id').val();
		//$products = bill_item_id_str.attr("item_name"); 
		$products = $("#bill_item_id option:selected").text();
        $hs_code = bill_item_id_str.attr("hs_code"); 
        $qty = $('#bill_item_quantity').val();
		$rate = $('#bill_item_rate').val();
		$bill_net_weight = $('#bill_net_weight').val();
		$amount = $('#hidden_item_amount').val();
		$tax_value = $('#tax_value').val();
		$cgst_rate = $('#bill_cgst_rate').val();
		$cgst_amount = $('#cgst_tax_value').val();
		$sgst_rate = $('#bill_sgst_rate').val();
		$sgst_amount = $('#sgst_tax_value').val();
		$net_value = $('#bill_item_value').val();

		if(parseInt($bill_item_id) == 0){
			$('#item_id_error').html('Please Select Item Name');
		}else if($qty == '' || parseFloat($qty) < 0.01){
			$('#bill_item_quantity_error').html('Item Quantity Required');
		}else{
			$('#item_id_error').html('');
			$('#bill_item_quantity_error').html('');

			$fine_item_obj = Math.floor(Math.random() * 100);

			$itemsLength = $billDetail.fineItems.length;
			console.log('itemsLength: '+$itemsLength);
			$itemsLength1 = parseInt($itemsLength) + 1;
			$net_weight_total = parseFloat($qty) * parseFloat($bill_net_weight);

			$fineItem = {
				fine_item_obj: $fine_item_obj,
				slno: $itemsLength1,
				item_id: $bill_item_id,
				products: $products,
				hs_code: $hs_code,
				qty: $qty,
				rate: $rate,
				amount: $amount,
				tax_value: $tax_value,
				cgst_rate: $cgst_rate,
				cgst_amount: $cgst_amount,
				sgst_rate: $sgst_rate,
				sgst_amount: $sgst_amount,
				net_value: $net_value,
				net_weight: $bill_net_weight,
				net_weight_total: $net_weight_total
			};
			$billDetail.fineItems.push($fineItem);			

			//Update stock Item Quantity
			$user_type = $('#user_type').val();
			$login_id = $('#login_id').val();
			$created_by = $('#created_by').val();
			$temp_bill_id = $('#current_bill_id').val();
			$customer_id = $billDetail.customer_id;

			//Created by user data update
			$billDetail.createdBy.org_name = $('#cb_org_name').val();
			$billDetail.createdBy.address = $('#cb_address').val();
			$billDetail.createdBy.contact_no = $('#cb_whatsapp_number').val();
			$billDetail.createdBy.gstin_no = $('#cb_gstin_no').val();
			$billDetail.createdBy.email = $('#cb_email_id').val();

			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "updateStockQtyMinus", bill_item_id: $bill_item_id, qty: $qty, user_type: $user_type, login_id: $login_id, created_by: $created_by, temp_bill_id: $temp_bill_id, bill_edit: $bill_edit, customer_id: $customer_id }
			})
			.done(function( res ) {
				$res1 = JSON.parse(res);
				if($res1.status == true){ }
			});//end ajax

			//Net Balance Total
			$fineItemsSubTotal1 = parseFloat($billDetail.fineItemsSubTotal) + parseFloat($net_value);
			$billDetail.fineItemsSubTotal = toFixedTrunc($fineItemsSubTotal1, 2);
			$billDetail.roundedUpFineItemsSubTotal = toFixedTrunc(Math.round($fineItemsSubTotal1), 2);				
			$('#fineItemsSubTotal').html($billDetail.fineItemsSubTotal);
			
			//Qty Total
			$subTotalQty = parseFloat($billDetail.subTotalQty) + parseFloat($qty);
			$billDetail.subTotalQty = $subTotalQty;			
			$('#subTotalQty').html($billDetail.subTotalQty);
			
			//Amount Total
			$subTotalAmount = parseFloat($billDetail.subTotalAmount) + parseFloat($amount);
			$billDetail.subTotalAmount = toFixedTrunc($subTotalAmount, 2);			
			$('#subTotalAmount').html($billDetail.subTotalAmount);
			
			//Tax Value Total
			$subTotalTaxValue = parseFloat($billDetail.subTotalTaxValue) + parseFloat($tax_value);
			$billDetail.subTotalTaxValue = toFixedTrunc($subTotalTaxValue, 2);			
			$('#subTotalTaxValue').html($billDetail.subTotalTaxValue);
			
			//CGST Total
			$subTotalCgst = parseFloat($billDetail.subTotalCgst) + parseFloat($cgst_amount);
			$billDetail.subTotalCgst = toFixedTrunc($subTotalCgst, 2);			
			$('#subTotalCgst').html($billDetail.subTotalCgst);
			
			//SGST Total
			$subTotalSgst = parseFloat($billDetail.subTotalSgst) + parseFloat($sgst_amount);
			$billDetail.subTotalSgst = toFixedTrunc($subTotalSgst, 2);			
			$('#subTotalSgst').html($billDetail.subTotalSgst);

			//Clear the Input fields
			$('#bill_item_id').val('0'); 
			$('#bill_item_quantity').val('0');
			$('#bill_item_rate').val('0.00');
			$('#hidden_item_amount').val('0.00');
			$('#tax_value').val('0.00');
			$('#bill_cgst_rate').val('0.00');
			$('#cgst_tax_value').val('0.00');
			$('#bill_sgst_rate').val('0.00');
			$('#sgst_tax_value').val('0.00');
			$('#bill_item_value').val('0.00');

			//console.log(JSON.stringify($billDetail));

			//Set the data into the table
			$new_row = "<tr id=fine_item_obj_"+$fine_item_obj+"><td>"+$itemsLength1+"</td><td class='text-left'>"+$products+"</td><td class='text-left'>"+$hs_code+"</td><td class='text-right'>"+$qty+"</td><td class='text-right'>"+$rate+"</td><td class='text-right'>"+$amount+"</td><td class='text-right'>"+$tax_value+"</td><td class='text-right'>"+$cgst_rate+"</td><td class='text-right'>"+$cgst_amount+"</td><td class='text-right'>"+$sgst_rate+"</td><td class='text-right'>"+$sgst_amount+"</td><td class='text-right'>"+$net_value+"</td><td><a href='#' style='cursor: pointer;'' onclick=removeFineItems("+$fine_item_obj+','+$net_value+','+$qty+','+$amount+','+$tax_value+','+$cgst_amount+','+$sgst_amount+','+$bill_item_id+")> <i class='fa fa-trash' aria-hidden='true'></i> </a></td></tr>";

			$('#billedItem').append($new_row);
			//$('#fineItemsTotalSubTotal').html($billDetail.fineItemsTotalSubTotal);
			calculateNetMetalQuantity();
		}//end if 
	});

	//Remove Fine Items from the table
	function removeFineItems($fine_item_obj, $net_value, $qty, $amount, $tax_value, $cgst_amount, $sgst_amount, $bill_item_id){
		$fineItemsTemp = [];
		for(var i = 0; i < $billDetail.fineItems.length; i++){
			if($billDetail.fineItems[i].fine_item_obj != $fine_item_obj){
				$fineItemsTemp.push($billDetail.fineItems[i]);
			}
		}//end for
		$billDetail.fineItems = [];
		$billDetail.fineItems = $fineItemsTemp;

		
		//Update stock Item Quantity
		$user_type = $('#user_type').val();
		$login_id = $('#login_id').val();
		$created_by = $('#created_by').val();
		$temp_bill_id = $('#current_bill_id').val();
		$customer_id = $billDetail.customer_id;
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "updateStockQtyAdd", bill_item_id: $bill_item_id, qty: $qty, user_type: $user_type, login_id: $login_id, created_by: $created_by, temp_bill_id: $temp_bill_id, bill_edit: $bill_edit, customer_id: $customer_id }
		})
		.done(function( res ) {
			$res1 = JSON.parse(res);
			if($res1.status == true){ }
		});//end ajax

		$fineItemsSubTotal1 = parseFloat($billDetail.fineItemsSubTotal) - parseFloat($net_value);	
		$billDetail.fineItemsSubTotal = toFixedTrunc($fineItemsSubTotal1, 2);
		$billDetail.roundedUpFineItemsSubTotal = toFixedTrunc(Math.round($fineItemsSubTotal1), 2);		
		$('#fineItemsSubTotal').html($billDetail.fineItemsSubTotal);
			
		//Qty Total
		$subTotalQty = parseFloat($billDetail.subTotalQty) - parseFloat($qty);
		$billDetail.subTotalQty = $subTotalQty;			
		$('#subTotalQty').html($billDetail.subTotalQty);
		
		//Amount Total
		$subTotalAmount = parseFloat($billDetail.subTotalAmount) - parseFloat($amount);
		$billDetail.subTotalAmount = toFixedTrunc($subTotalAmount, 2);			
		$('#subTotalAmount').html($billDetail.subTotalAmount);
		
		//Tax Value Total
		$subTotalTaxValue = parseFloat($billDetail.subTotalTaxValue) - parseFloat($tax_value);
		$billDetail.subTotalTaxValue = toFixedTrunc($subTotalTaxValue, 2);			
		$('#subTotalTaxValue').html($billDetail.subTotalTaxValue);
		
		//CGST Total
		$subTotalCgst = parseFloat($billDetail.subTotalCgst) - parseFloat($cgst_amount);
		$billDetail.subTotalCgst = toFixedTrunc($subTotalCgst, 2);			
		$('#subTotalCgst').html($billDetail.subTotalCgst);
		
		//SGST Total
		$subTotalSgst = parseFloat($billDetail.subTotalSgst) - parseFloat($sgst_amount);
		$billDetail.subTotalSgst = toFixedTrunc($subTotalSgst, 2);			
		$('#subTotalSgst').html($billDetail.subTotalSgst);

		$('#fine_item_obj_'+$fine_item_obj).remove();
		calculateNetMetalQuantity();
	}

	//Add Jama Details
	$("#adJamaDetail").click(function(){
		$jama_item_obj = Math.floor(Math.random() * 100);
		$jama_item = $('#jama_item').val();
		$jama_item_weight = $('#jama_item_weight').val();

		if(parseFloat($jama_item_weight) > 0){
			$('#jama_item_weight_error').html('');
			$jamaItem = {
				jama_item_obj: $jama_item_obj,
				jama_item: $jama_item,
				jama_item_weight: $jama_item_weight
			}
			$billDetail.jamaItems.push($jamaItem);
			//$('#jama_item').val('');
			$('#jama_item_weight').val('');

			$new_jama_row = "<tr id=jama_item_obj_"+$jama_item_obj+"> <td colspan='5'>"+$jama_item+"</td> <td class='text-right'>"+$jama_item_weight+"</td> <td> <button type='button' class='btn btn-secondary btn-sm' onclick=removeJamaDetails("+$jama_item_obj+','+$jama_item_weight+")>Delete</button> </td></tr>";
			$('#jamaDetails').append($new_jama_row);

			$jamaItemsSubTotal1 = parseFloat($billDetail.jamaItemsSubTotal) + parseFloat($jama_item_weight);
			$billDetail.jamaItemsSubTotal = toFixedTrunc($jamaItemsSubTotal1, 3);

			console.log('jama item weight'+$jama_item_weight)
			$('#jamaItemsSubTotal').html($billDetail.jamaItemsSubTotal);
			calculateNetMetalQuantity();
		}else{
			$('#jama_item_weight_error').html('Please enter Weight');
		}
	});

	//Remove Jama Details from the table
	function removeJamaDetails($jama_item_obj, $jama_item_weight){
		$jamaItemsTemp = [];
		for(var i = 0; i < $billDetail.jamaItems.length; i++){
			if($billDetail.jamaItems[i].jama_item_obj != $jama_item_obj){
				$jamaItemsTemp.push($billDetail.jamaItems[i]);
			}
		}//end for
		$billDetail.jamaItems = [];
		$billDetail.jamaItems = $jamaItemsTemp;

		$jamaItemsSubTotal1 = parseFloat($billDetail.jamaItemsSubTotal) - parseFloat($jama_item_weight);
		$billDetail.jamaItemsSubTotal = toFixedTrunc($jamaItemsSubTotal1, 3);		
		$('#jamaItemsSubTotal').html($billDetail.jamaItemsSubTotal);
		
		$('#jamaItemsSubTotal').html($billDetail.jamaItemsSubTotal);

		$('#jama_item_obj_'+$jama_item_obj).remove();
		calculateNetMetalQuantity();
	}

	//Calculate Net Metal Quantity
	function calculateNetMetalQuantity(){
		$bill_id = $('#current_bill_id').val();	

		if(parseInt($bill_id) == 0){
			var bill_customer_id = $('#bill_customer_id').find('option:selected'); 
			$customer_id_n = $('#bill_customer_id').val();
			$customer_name = $("#bill_customer_id option:selected").text();
			$phone_number = bill_customer_id.attr("phone_number");
			
			$billDetail.phone_number = $phone_number;
		}else{
			$customer_id_n = $billDetail.customer_id;
		}

		//calculate Due adjustment start
		$totalCash = $('#totalCash').val();	
		$net_due_amount = $('#net_due_amount').val();				
		$old_due_amount = $('#old_due_amount').val();

		$billDetail.totalCash = $totalCash;
		if($bill_id == 0){
			$dueCash = parseFloat($billDetail.roundedUpFineItemsSubTotal) - parseFloat($totalCash);
		}else{
			$dueCash = parseFloat($billDetail.roundedUpFineItemsSubTotal) - parseFloat($totalCash);
		}

		if(parseFloat($billDetail.discountAmount) > 0){
			$dueCash = parseFloat($dueCash) - parseFloat($billDetail.discountAmount);
		}
		
		$dueCash1 = toFixedTrunc($dueCash, 2);
		$billDetail.dueCash = $dueCash1;
		$('#dueCash').val($dueCash1);
		
		//calculate Due adjustment end

		$finePlusOldBalance = 0.00;
		$finalMetalStatus = '';
		$metal_jama = 0.000;
		$metal_due = 0.000;		
		$oldDue = 0;
		$oldJama = 0;

		console.log('fineItemsSubTotal: '+parseInt($billDetail.fineItemsSubTotal));

		if(parseInt($customer_id_n) == 0){
			$('#customer_id_error').html('Please select a customer');
		}else{
			$('#customer_id_error').html('');
			$('#addBillItem_error').html('');

			$user_type = $('#user_type').val();
			$login_id = $('#login_id').val();
			$created_by = $('#created_by').val();			
			$hidden_totalCash = $('#hidden_totalCash').val();							
			$old_due_amount = $('#old_due_amount').val();

			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "saveBill", customer_id: $billDetail.customer_id, bill_description: JSON.stringify($billDetail), bill_id: $bill_id, bill_edit: $bill_edit, paymentType: $billDetail.paymentType, final_bill: $final_bill, user_type: $user_type, login_id: $login_id, created_by: $created_by, old_due_amount: $old_due_amount, hidden_totalCash: $hidden_totalCash, totalCash: $totalCash }
			})
			.done(function( res ) {
				$res1 = JSON.parse(res);
				if($res1.status == true){	
					$current_bill_id = $res1.current_bill_id;
					//$create_date = $res1.create_date;
					$create_date = $('#create_date_new').val();
					$('#current_bill_id').val($current_bill_id);
					
					if($bill_id == '0'){
						const tr = $("<tr id=bill_row_"+$current_bill_id+" style='font-weight: bold;'><td>#0</td><td>"+$billDetail.billId+"</td><td>"+$billDetail.customer_name+"</td><td>"+$billDetail.phone_number+"</td><td style='text-align: right;'>"+$billDetail.roundedUpFineItemsSubTotal+"</td><td style='text-align: right;'>"+$billDetail.totalCash+"</td><td style='text-align: right;'>"+$billDetail.discountAmount+"</td><td style='text-align: right;'>"+$billDetail.dueCash+"</td><td>"+$create_date+"</td><td>  <a style='cursor: pointer;' target='_blank' href='pages/bill_printer/bill_pdf.php?bill_id="+$current_bill_id+"' ><i class='fa fa-print' aria-hidden='true'></i></a>  <a style='cursor: pointer;' onclick=openBillModal("+$current_bill_id+")><i class='fa fa-edit' aria-hidden='true'></i></a> <a style='cursor: pointer;' onclick=deleteBill("+$current_bill_id+")><i class='fa fa-trash' aria-hidden='true'></i></a> </td></tr>");
						
						$('#dataTable').prepend($(tr));

					} else{
						console.log('Updatre the table row');
						$('#bill_row_'+$current_bill_id).html('');

						$('#bill_row_'+$current_bill_id).html("<td style='font-weight: bold;'>#0</td><td style='font-weight: bold;'>"+$billDetail.billId+"</td><td style='font-weight: bold;'>"+$billDetail.customer_name+"</td><td style='font-weight: bold;'>"+$billDetail.phone_number+"</td><td style='text-align: right;font-weight: bold;'>"+$billDetail.roundedUpFineItemsSubTotal+"</td><td style='text-align: right;'>"+$billDetail.totalCash+"</td><td style='text-align: right;'>"+$billDetail.discountAmount+"</td><td style='text-align: right;'>"+$billDetail.dueCash+"</td><td>"+$create_date+"</td><td>  <a style='cursor: pointer;' target='_blank' href='pages/bill_printer/bill_pdf.php?bill_id="+$current_bill_id+"' ><i class='fa fa-print' aria-hidden='true'></i></a> <a style='cursor: pointer;' onclick=openBillModal("+$current_bill_id+")><i class='fa fa-edit' aria-hidden='true'></i></a> <a style='cursor: pointer;' onclick=deleteBill("+$current_bill_id+")><i class='fa fa-trash' aria-hidden='true'></i></a> </td>");
					}

					//Redirect to the printer page
					if($final_bill == 1){
						var URL = 'pages/bill_printer/bill_pdf.php?bill_id='+$current_bill_id;
						window.open(URL, '_blank');
					}
					
				}
			});//end ajax
		}//end if
		
	}//end function

	$("#jama_item_weight").blur(function(){ 
		updateJamaFine();
	});

	$("#jama_item_percentage").blur(function(){ 
		updateJamaFine();
	});

	function updateJamaFine(){ 
		$jama_item_weight = $('#jama_item_weight').val();
		$jama_item_percentage = $('#jama_item_percentage').val();

		if($jama_item_weight != undefined && $jama_item_percentage != undefined){
			$jama_fine_waight = ($jama_item_weight * $jama_item_percentage) / 100;
			$jama_fine_waight1 = toFixedTrunc($jama_fine_waight, 3);

			$('#jama_item_fine').val($jama_fine_waight1);
		}		
	}//end function


	//Payment Type Event
	$('#cash').change(function() {
        if($(this).is(":checked")) {
			//$('#rateBlock').show();
			$('#totalCashBlock').show();
			$('#totalDueBlock').show();
			$('#discountTypeBlock').show();
			$('#discountRateBlock').show();
			$('#discountAmountBlock').show();
			$billDetail.paymentType = 'cash';
			$('#createFinalBill').prop('disabled', false);			
        }    
    });

	$('#due').change(function() {
        if($(this).is(":checked")) {
			//$('#rateBlock').hide();
			$('#totalCashBlock').hide();
			$('#totalDueBlock').hide();
			$('#discountTypeBlock').hide();
			$('#discountRateBlock').hide();
			$('#discountAmountBlock').hide();
			$billDetail.paymentType = 'due';
			$('#createFinalBill').prop('disabled', false);
			//$billDetail.ratePerGm = '0.00';
			//$billDetail.totalCash = '0.00';
        }     
    });

	$("#totalCash, #discountType, #discountRate").blur(function(){
		console.log('call fun totalCash');		
		$bill_id = $('#current_bill_id').val();
		$totalCash = $('#totalCash').val();	
		$net_due_amount = $('#net_due_amount').val();				
		$old_due_amount = $('#old_due_amount').val();

		$billDetail.totalCash = $totalCash;
		if($bill_id == 0){
			$dueCash = parseFloat($net_due_amount) + parseFloat($billDetail.roundedUpFineItemsSubTotal) - parseFloat($totalCash);
		}else{
			$dueCash = parseFloat($billDetail.roundedUpFineItemsSubTotal) - parseFloat($totalCash);
		}

		if(parseInt($bill_id) > 0 && parseFloat($billDetail.discountAmount) > 0){
			$dueCash = parseFloat($dueCash) - parseFloat($billDetail.discountAmount);
		}
		//Discount and Rebate		
		if($dueCash > 0){			
			$discountType = $('#discountType').val();						
			$discountRate = $('#discountRate').val();					
			$discountAmount = $('#discountAmount').val();
			console.log('discountType:' + $discountType + ' discountRate: '+$discountRate+ ' discountAmount: ' + $discountAmount + 'discountAmount:'+$billDetail.discountAmount);
			if($billDetail.discountAmount == '0' || $billDetail.discountAmount == '0.00' || $billDetail.discountAmount == undefined){
				$billDetail.discountType = $discountType;
				$billDetail.discountRate = $discountRate;
			
				if(parseInt($discountType) == 1){
					$discountAmount = parseFloat($discountRate);
				}
				if(parseInt($discountType) == 2){
					$discountAmount = parseInt($billDetail.subTotalAmount) * parseFloat($discountRate) / 100;
				}	
				$dueCash = parseFloat($dueCash) - parseFloat($discountAmount);	
				$billDetail.discountAmount = $discountAmount;	
				$('#discountAmount').val($discountAmount);
			}//end if
		}//end if

		$dueCash1 = toFixedTrunc($dueCash, 2);
		$billDetail.dueCash = $dueCash1;
		$('#dueCash').val($dueCash1);
		
	});

	//Rate per Gm Calculation
	// $("#ratePerGm").blur(function(){ 
	// 	$ratePerGm = $('#ratePerGm').val();		
	// 	$netMetalBalance_roundoff = $billDetail.netMetalBalance;
	// 	$totalCash = parseFloat($netMetalBalance_roundoff) * parseFloat($ratePerGm);
		
	// 	$billDetail.ratePerGm = $ratePerGm;
	// 	$billDetail.totalCash = toFixedTrunc($totalCash, 2);
	// 	$('#totalCash').val($billDetail.totalCash);

	// 	calculateNetMetalQuantity();
	// });

	//Create Final Bill	
	$("#createFinalBill").click(function(){
		console.log('Close Bill Modal');
		$bill_customer_id = $('#bill_customer_id').val();
		$create_date_new = $('#create_date_new').val();
		$billDetail.create_date_new = $create_date_new;
		$final_bill = 1;
		if(parseInt($bill_customer_id) == 0){
			$('#customer_id_error').html('Please select Customer Name');
			//$('#guestUserPhone_error').html('Please select Ph.No.');			
		}else if(parseInt($billDetail.fineItemsSubTotal) < 1){
			$('#addBillItem_error').html('Please Add Item/product');
		}else{			
			calculateNetMetalQuantity();
			modalCustomer.style.display = "none";
			//closeCustomerModal();
		}
	});

	//Delete Bill	
	function deleteBill($bill_id){
		$user_type = $('#user_type').val();
		$login_id = $('#login_id').val();
		$created_by = $('#created_by').val();
		
		if (confirm('Are you sure to delete the Bill?')) {
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deleteBill", bill_id: $bill_id, user_type: $user_type, login_id: $login_id, created_by: $created_by }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#bill_row_'+$bill_id).remove();
				}else{
					alert('Sorry! Can Not be Deleted, Partial payment Done.')
				}
			});//end ajax
		}		
	}//end delete

	function printBillAll(){
		$from_date = $('#from_date').val();
		$to_date = $('#to_date').val();
		$search_cu_id = $('#search_cu_id').val();
		$ser_user_type = $('#ser_user_type').val();
		$ser_created_by = $('#ser_created_by').val();
		$ser_login_id = $('#ser_login_id').val();
		
		window.open('pages/bill_printer/all_bill_pdf.php?from_date='+$from_date+'&to_date='+$to_date+'&search_cu_id='+$search_cu_id+'&user_type='+$ser_user_type+'&created_by='+$ser_created_by+'&login_id='+$ser_login_id, '_blank');
	}//end function

	//////////////////// BILL FUNCTION END //////////////////////////
	
	/////////////////////////// SETTINGS //////////////////////////////
	$("#bank_name").change(function(){ 
		$('#bank_name_error').html('');
	});
	$("#branch_name").change(function(){ 
		$('#branch_name_error').html('');
	});
	$("#acc_no").change(function(){ 
		$('#acc_no_error').html('');
	});
	$("#ac_name").change(function(){ 
		$('#ac_name_error').html('');
	});
	$("#ifsc_code").change(function(){ 
		$('#ifsc_code_error').html('');
	});
	$("#branch_code").change(function(){ 
		$('#branch_code_error').html('');
	});
	$("#username").change(function(){ 
		$('#username_error').html('');
	});
	$("#password").change(function(){ 
		$('#password_error').html('');
	});

	//Save Function
	$("#updateSettings").click(function(){
		$bank_name = $('#bank_name').val();
		$branch_name = $('#branch_name').val();
		$acc_no = $('#acc_no').val();
		$ac_name = $('#ac_name').val();
		$ifsc_code = $('#ifsc_code').val();
		$branch_code = $('#branch_code').val();		
		$username = $('#username').val();		
		$password = $('#password').val();
		$login_id = $('#login_id').val();
		console.log('login_id: '+$login_id);

		if($bank_name == ''){
			$('#bank_name_error').html('Please Enter Bank Name');
		}else if($branch_name == ''){
			$('#branch_name_error').html('Please Enter Branch Name');
		}else if($acc_no == ''){
			$('#acc_no_error').html('Please Enter A/c. No');
		}else if($ac_name == ''){
			$('#ac_name_error').html('Please Enter A/c. Name');
		}else if($ifsc_code == ''){
			$('#ifsc_code_error').html('Please Enter IFSC Code');
		}else if($branch_code == ''){
			$('#branch_code_error').html('Please Enter Branch Code');
		}else if($username == ''){
			$('#username_error').html('Please Enter Username');
		}else if($password == ''){
			$('#password_error').html('Please Enter Password');
		}else{
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "updateSettings", login_id: $login_id, bank_name: $bank_name, branch_name: $branch_name, acc_no: $acc_no, ac_name: $ac_name, ifsc_code: $ifsc_code, branch_code: $branch_code, username: $username, password: $password }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){	
					$('#settings_update_msg').html('Settings Updated successfully');
				}else{
					$('#settings_update_msg').html('Not Saved');
				}
			});//end ajax
		}//end if
	});//end saveItem function

	////////////////////////// SETTINGS END ///////////////////////////



	//////////////////// CASHBOOK START /////////////////////////////
	$("#cb_date").change(function(){ 
		$('#cb_date_error').html('');
	});
	$("#receive_payment").change(function(){ 
		$('#receive_payment_error').html('');
	});
	$("#cb_narration").change(function(){ 
		$('#cb_narration_error').html('');
	});
	$("#cb_amount").change(function(){ 
		$('#cb_amount_error').html('');
	});

	//SAVE CASHBOOK
	$("#saveCashbook").click(function(){		
		$login_id = $('#login_id').val();
		$user_type = $('#user_type').val();
		$created_by = $('#created_by').val();

		$cb_date = $('#cb_date').val();
		$receive_payment = $('#receive_payment').val();
		$cb_narration = $('#cb_narration').val();
		$cb_amount = $('#cb_amount').val();
		$cb_id = $('#cb_id').val();

		console.log(parseFloat($cb_amount));

		if($cb_date == ''){
			$('#cb_date_error').html('Please Select a Date');
		}else if($receive_payment == ''){
			$('#receive_payment_error').html('Choose Type of transaction');
		}else if($cb_narration == ''){
			$('#cb_narration_error').html('Please enter Narration');
		}else if(parseFloat($cb_amount) <= 0){
			$('#cb_amount_error').html('Please enter Amount');
		}else{
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "saveCashbook", login_id: $login_id, user_type: $user_type, created_by: $created_by, cb_date: $cb_date, receive_payment: $receive_payment, cb_narration: $cb_narration, cb_amount: $cb_amount, cb_id: $cb_id }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				$receive = '';
				$payment = '';
				if($receive_payment == 0){
					$receive = $cb_narration;
				}else{
					$payment = $cb_narration;
				}
				if($res1.status == true){
					if($cb_id == '0'){						
						$('#cb_date').val('');
						$('#receive_payment').val('');
						$('#cb_narration').val('');
						$('#cb_amount').val('');	

						const table = $("#dataTable").DataTable();
						const tr = $("<tr id=cb_id_"+$res1.cb_id+"><td>"+$res1.cb_id+"</td><td>"+$cb_date+"</td><td>"+$payment+"</td><td>"+$receive+"</td><td style='text-align: right;'>"+$cb_amount+"</td><td><a style='cursor: pointer;' onclick=updateCashBookModal("+$res1.cb_id+")><i class='fa fa-edit' aria-hidden='true'></i></a></td></tr>");
						table.row.add(tr[0]).draw();
					} else{
						console.log('Updatre the table row');
						$('#cb_id_'+$cb_id).html('');

						$('#cb_id_'+$cb_id).html("<td>"+$res1.cb_id+"</td><td>"+$cb_date+"</td><td>"+$payment+"</td><td >"+$receive+"</td><td style='text-align: right;'>"+$cb_amount+"</td><td><a style='cursor: pointer;' onclick=updateCashBookModal("+$cb_id+")><i class='fa fa-edit' aria-hidden='true'></i></a></td>");
					}	
					modalCustomer.style.display = "none";					
				}				
			});//end ajax
		}//end if
	});

	//Update function	
	function updateCashBookModal($cb_id){	
		//Fetch data
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getCashBook", cb_id: $cb_id }
		})
		.done(function( res ) {
			//console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){
				$('#cb_id').val($cb_id);
				$('#cb_date').val($res1.cb_date);
				$('#receive_payment').val($res1.receive_payment);
				$('#cb_narration').val($res1.cb_narration);
				$('#cb_amount').val($res1.cb_amount);
				modalCustomer.style.display = "block";
			}
		});//end ajax
	}

	//Delete function	
	function deleteCashbook($cb_id){
		if (confirm('Are you sure to delete the record?')) {
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deleteCashbook", cb_id: $cb_id }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#cb_id_'+$cb_id).remove();
				}
			});//end ajax
		}		
	}//end delete	

	function csvDownload(){
		$from_date = $('#from_date').val();
		$to_date = $('#to_date').val();
		$ser_user_type = $('#ser_user_type').val();
		$ser_created_by = $('#ser_created_by').val();
		$ser_login_id = $('#ser_login_id').val();
		
		window.open('pages/cash_book/cash_book_csv.php?from_date='+$from_date+'&to_date='+$to_date+'&user_type='+$ser_user_type+'&created_by='+$ser_created_by+'&login_id='+$ser_login_id, '_blank');
	}//end function

	//////////////////// CASHBOOK END /////////////////////////////


	/////////////////// REPORT SECTION START //////////////////
	function printGSTReport(){
		$from_date = $('#from_date').val();
		$to_date = $('#to_date').val();
		$search_cu_id = 0;//$('#search_cu_id').val();
		$ser_user_type = $('#ser_user_type').val();
		$ser_created_by = $('#ser_created_by').val();
		$ser_login_id = $('#ser_login_id').val();
		
		window.open('pages/bill_printer/gst_report_pdf.php?from_date='+$from_date+'&to_date='+$to_date+'&search_cu_id='+$search_cu_id+'&user_type='+$ser_user_type+'&created_by='+$ser_created_by+'&login_id='+$ser_login_id, '_blank');
	}//end function

	function printProductReport(){
		$from_date = $('#from_date').val();
		$to_date = $('#to_date').val();
		$search_cu_id = 0;//$('#search_cu_id').val();
		$ser_user_type = $('#ser_user_type').val();
		$ser_created_by = $('#ser_created_by').val();
		$ser_login_id = $('#ser_login_id').val();
		
		window.open('pages/bill_printer/product_report_pdf.php?from_date='+$from_date+'&to_date='+$to_date+'&search_cu_id='+$search_cu_id+'&user_type='+$ser_user_type+'&created_by='+$ser_created_by+'&login_id='+$ser_login_id, '_blank');
	}//end function

	////////////////// REPORT SECTION END //////////////////


	//Item Modal Popup Start
	var modal = document.getElementById("myModal");
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
		modal.style.display = "none";
	  }
	}
	//Item Modal Popup end

	//Customer Modal Popup Start
	var modalCustomer = document.getElementById("myModalCustomer");
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modalCustomer) {
		modalCustomer.style.display = "none";
	  }
	}
	//Customer Modal Popup end

	//MiniSlip Modal Popup Start
	var miniSlip = document.getElementById("miniSlip");
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == miniSlip) {
		modalCustomer.style.display = "none";
	  }
	}
	//MiniSlip Modal Popup end

	//Bill Modal Popup Start
	var modalBill= document.getElementById("myModalBill");
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modalBill) {
		modalBill.style.display = "none";
	  }
	}
	//Bill Modal Popup end

	//Upto n th decimal without Round up
	function toFixedTrunc(x, n) {
		return x.toFixed(n);
		// const v = (typeof x === 'string' ? x : x.toString()).split('.');
		// if (n <= 0) return v[0];
		// let f = v[1] || '';
		// if (f.length > n) return `${v[0]}.${f.substr(0,n)}`;
		// while (f.length < n) f += '0';
		// return `${v[0]}.${f}`
	}


	//Attendance page function
	$('#search_present_date').on('change', function(){
		$search_present_date = $('#search_present_date').val();
		$('#present_date').val($search_present_date);
	});	
	
	//Attendance Check uncheck
	$('#myTable').on('click', '.check_class', function(){
		$emp_id = $(this).data('emp_id');
		console.log('checkbox emp_id: ' + $emp_id);
		
		if ($('#attendance_' + $emp_id).is(':checked')) {
		// The checkbox is checked
			console.log('checked');	
			$val = 1;
			$('#present_status_text_' + $emp_id).val($val);
			$('#full_day_text_' + $emp_id).val($val);
			$('#full_day_' + $emp_id).prop('checked', true);
		} else {
		// The checkbox is not checked
			console.log('unchecked: ');
			$val = 0;
			$('#present_status_text_' + $emp_id).val($val);
			$('#half_day_text_' + $emp_id).val($val);
			$('#full_day_text_' + $emp_id).val($val);
			$('#half_day_' + $emp_id).prop('checked', false);
			$('#full_day_' + $emp_id).prop('checked', false);
		}
	});	
	//Half Day
	$('#myTable').on('click', '.check_class_hd', function(){
		$emp_id = $(this).data('emp_id');
		console.log('checkbox emp_id: ' + $emp_id);
		
		if ($('#half_day_' + $emp_id).is(':checked')) {
		// The checkbox is checked
			console.log('checked');	
			$val = 1;
			$('#half_day_text_' + $emp_id).val($val);
		} else {
		// The checkbox is not checked
			console.log('unchecked: ');
			$val = 0;
			$('#half_day_text_' + $emp_id).val($val);
		}
	});	
	//Full Day
	$('#myTable').on('click', '.check_class_fd', function(){
		$emp_id = $(this).data('emp_id');
		console.log('checkbox emp_id: ' + $emp_id);
		
		if ($('#full_day_' + $emp_id).is(':checked')) {
		// The checkbox is checked
			console.log('checked');	
			$val = 1;
			$('#full_day_text_' + $emp_id).val($val);
		} else {
		// The checkbox is not checked
			console.log('unchecked: ');
			$val = 0;
			$('#full_day_text_' + $emp_id).val($val);
		}
	});	
	
	//Attendance Report
	function attendanceReport(){
		$sr_month_name = $('#sr_month_name').val();	
		$sr_month_name_text = $("#sr_month_name option:selected").text();
		$sr_emp_name = $('#sr_emp_name').val();	
		$sr_emp_name_text = $("#sr_emp_name option:selected").text();
		
		if($sr_month_name == '0' || $sr_emp_name == '0'){
			alert('Please select Month Name and Employee Name')
		}else{
			window.open('pages/bill_printer/attendance_pdf.php?sr_month_name='+$sr_month_name+'&sr_emp_name='+$sr_emp_name+'&sr_month_name_text='+$sr_month_name_text+'&sr_emp_name_text='+$sr_emp_name_text, '_blank');
		}
	}//end function

	//Pay: On Change Employee list
	$('#emp_name').on('change', function(){
		$emp_sal_id = $('#emp_sal_id').val();

		if($emp_sal_id == 0){
			$month_name = $('#month_name').val();
			$emp_id = $('#emp_name').val();
			var emp_name = $('#emp_name').find('option:selected'); 
			$emp_basic_pay = emp_name.attr("emp_basic_pay"); 
			console.log('emp_basic_pay: ' + $emp_basic_pay);
			$('#emp_basic_pay').val($emp_basic_pay);
			//ajax call from here
			
			if(parseInt($month_name) > 0 && parseInt($emp_id) > 0){
				$.ajax({
					method: "POST",
					url: "assets/php/function.php",
					data: { fn: "getUserAttendance", month_name: $month_name, emp_id: $emp_id, emp_basic_pay: $emp_basic_pay }
				})
				.done(function( res ) {
					//console.log(res);
					$res1 = JSON.parse(res);
					if($res1.status == true){					
						$('#working_days').val($res1.businessDays);
						$('#effective_working_days').val($res1.effective_working_days);
						$('#holi_days').val($res1.holi_days);
						$('#attendance_count').val($res1.total_attendance);
						$('#absent_count').val($res1.absent_count);
						$('#half_day').val($res1.half_day_count);
						$('#full_day').val($res1.full_day_count);
						$('#overtime_hours').val($res1.total_ot_hr);
						$('#effectiveBasicPay').val($res1.effectiveBasicPay);
						$('#overtime_amount').val($res1.overtime_amount);
					}
				});//end ajax
			}//end if
		}//end if
	});

	//Effective day calculation
	$('#holi_days').on('blur', function(){
		$effective_working_days = 0;
		$effectiveBasicPay = 0;
		$onedaypay = 0;
		$emp_basic_pay = $('#emp_basic_pay').val();
		$holi_days = $('#holi_days').val();
		$working_days = $('#working_days').val();
		$attendance_count = $('#attendance_count').val();
		$overtime_hours = $('#overtime_hours').val();
		$effective_working_days = parseInt($working_days) - parseInt($holi_days);
		$('#effective_working_days').val($effective_working_days);

		//Effective basic pay 
		$effectiveBasicPay = ($emp_basic_pay / $effective_working_days) * $attendance_count;
		$('#effectiveBasicPay').val($effectiveBasicPay.toFixed(2));

		//One day pay
		$onedaypay = $emp_basic_pay / $effective_working_days;
		$one_hour_pay = $onedaypay / 8;
		$overtime_amount = $one_hour_pay * $overtime_hours;
		$('#overtime_amount').val($overtime_amount.toFixed(2));

	});

	//Calculate PaySlip
	$("#calculatePaySlip").on("click", function() {
		$net_pay = 0;
		$effectiveBasicPay = $('#effectiveBasicPay').val();
		$attendance_count = $('#attendance_count').val();
		$overtime_amount = $('#overtime_amount').val();
		
		$emp_basic_pay = $('#emp_basic_pay').val();
		$effective_working_days = $('#effective_working_days').val();
		$attendance_count = $('#attendance_count').val();
		$half_day = $('#half_day').val();

		$allounce_1_percent = $('#allounce_1_percent').val();
		$allounce_2_percent = $('#allounce_2_percent').val();
		$allounce_3_percent = $('#allounce_3_percent').val();
		$allounce_4_percent = $('#allounce_4_percent').val();

		$allounce_1 = (parseFloat($effectiveBasicPay) * parseFloat($allounce_1_percent)) / 100;
		$allounce_2 = (parseFloat($effectiveBasicPay) * parseFloat($allounce_2_percent)) / 100;
		$allounce_3 = (parseFloat($effectiveBasicPay) * parseFloat($allounce_3_percent)) / 100;
		$allounce_4 = (parseFloat($effectiveBasicPay) * parseFloat($allounce_4_percent)) / 100;

		$('#allounce_1').val($allounce_1.toFixed(2));
		$('#allounce_2').val($allounce_2.toFixed(2));
		$('#allounce_3').val($allounce_3.toFixed(2));
		$('#allounce_4').val($allounce_4.toFixed(2));

		$allounce_1 = $('#allounce_1').val();
		$allounce_2 = $('#allounce_2').val();
		$allounce_3 = $('#allounce_3').val();
		$allounce_4 = $('#allounce_4').val();
		
		$deduction_1 = $('#deduction_1').val();
		$deduction_2 = $('#deduction_2').val();
		$deduction_3 = $('#deduction_3').val();
		$deduction_4 = $('#deduction_4').val();
		
		$total_allounce = parseFloat($allounce_1) + parseFloat($allounce_2) + parseFloat($allounce_3) + parseFloat($allounce_4);
		$total_deduction = parseFloat($deduction_1) + parseFloat($deduction_2) + parseFloat($deduction_3) + parseFloat($deduction_4);		

		//Effective basic pay = (Employee Basic Pay / Effective working days) * (Total Attensance + (Half Day Count * 0.5)))
		$effectiveBasicPay = ($emp_basic_pay / $effective_working_days) * (parseFloat($attendance_count) + (parseFloat($half_day) * 0.5));

		$net_pay = parseFloat($effectiveBasicPay) + parseFloat($total_allounce) + parseFloat($overtime_amount) - parseFloat($total_deduction);
		$net_pay = $net_pay.toFixed(2);
		$('#net_pay').val($net_pay);
	});//end function

	//Generate PaySlip
	$("#generatePaySlip").on("click", function() {
		$emp_sal_id = $('#emp_sal_id').val();
		$month_name = $('#month_name').val();
		$pay_year = $('#pay_year').val();
		$month_name_txt = $('#month_name option:selected').text();
		$emp_id = $('#emp_name').val();
		$emp_name = $('#emp_name option:selected').text();
		$emp_basic_pay = $('#emp_basic_pay').val();
		$attendance_count = $('#attendance_count').val();

		$working_days = $('#working_days').val();
		$holi_days = $('#holi_days').val();
		$effective_working_days = $('#effective_working_days').val();
		$effectiveBasicPay = $('#effectiveBasicPay').val();
		
		$half_day = $('#half_day').val();
		$full_day = $('#full_day').val();
		$overtime_hours = $('#overtime_hours').val();
		$late_hours = $('#late_hours').val();
		$overtime_amount = $('#overtime_amount').val(); 

		$net_pay = $('#net_pay').val();

		$allounce_1_percent = $('#allounce_1_percent').val();
		$allounce_2_percent = $('#allounce_2_percent').val();
		$allounce_3_percent = $('#allounce_3_percent').val();
		$allounce_4_percent = $('#allounce_4_percent').val();

		$allounce_1 = $('#allounce_1').val();
		$allounce_2 = $('#allounce_2').val();
		$allounce_3 = $('#allounce_3').val();
		$allounce_4 = $('#allounce_4').val();
		
		$deduction_1 = $('#deduction_1').val();
		$deduction_2 = $('#deduction_2').val();
		$deduction_3 = $('#deduction_3').val();
		$deduction_4 = $('#deduction_4').val();

		$('#net_pay_error').html('');
		console.log('net pay: '+parseFloat($net_pay))
		if(parseFloat($net_pay) <= 0){
			$('#net_pay_error').html('Please calculate Net Pay')
		}else{
			$salary_detail_data = {
				emp_name: $emp_name,
				month_name_txt: $month_name_txt,
				pay_year: $pay_year,				
				allounce_1_percent: $allounce_1_percent,
				allounce_2_percent: $allounce_2_percent,
				allounce_3_percent: $allounce_3_percent,
				allounce_4_percent: $allounce_4_percent,
				allounce_1: $allounce_1,
				allounce_2: $allounce_2,
				allounce_3: $allounce_3,
				allounce_4: $allounce_4,
				deduction_1: $deduction_1,
				deduction_2: $deduction_2,
				deduction_3: $deduction_3,
				deduction_4: $deduction_4,
				attendance_count: $attendance_count,
				working_days: $working_days,
				holi_days: $holi_days,
				effective_working_days: $effective_working_days,
				effectiveBasicPay: $effectiveBasicPay,
				half_day: $half_day,
				full_day: $full_day,
				overtime_hours: $overtime_hours,
				late_hours: $late_hours,
				overtime_amount: $overtime_amount,
				total_allounce: $total_allounce,
				total_deduction: $total_deduction
			};

			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "generatePaySlip", emp_sal_id: $emp_sal_id, month_name: $month_name, pay_year: $pay_year, emp_id: $emp_id, total_allounce: $total_allounce, total_deduction: $total_deduction, net_pay: $net_pay, emp_basic_pay: $emp_basic_pay, salary_detail_data: JSON.stringify($salary_detail_data)}
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					window.location.href = '?p=emp-pay-slip';
				}
			});//end ajax
		}//end if
	});//end function

	//Edit PaySlip	
	function editPaySlip($emp_sal_id){
		$('#emp_sal_id').val($emp_sal_id);
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getPaySlip", emp_sal_id: $emp_sal_id }
		})
		.done(function( res ) {
			//console.log(res);
			$res1 = JSON.parse(res);

			if($res1.status == true){
				$('#month_name').val($res1.month_name).trigger('change');
				$('#emp_name').val($res1.emp_id).trigger('change');
				$('#emp_basic_pay').val($res1.basic_pay);
				$salary_detail_data = JSON.parse($res1.salary_detail_data);
				$('#pay_year').val($salary_detail_data.pay_year).trigger('change');				

				$('#allounce_1_percent').val($salary_detail_data.allounce_1_percent);
				$('#allounce_2_percent').val($salary_detail_data.allounce_2_percent);
				$('#allounce_3_percent').val($salary_detail_data.allounce_3_percent);
				$('#allounce_4_percent').val($salary_detail_data.allounce_4_percent);

				$('#allounce_1').val($salary_detail_data.allounce_1);
				$('#allounce_2').val($salary_detail_data.allounce_2);
				$('#allounce_3').val($salary_detail_data.allounce_3);
				$('#allounce_4').val($salary_detail_data.allounce_4);
				
				$('#deduction_1').val($salary_detail_data.deduction_1);
				$('#deduction_2').val($salary_detail_data.deduction_2);
				$('#deduction_3').val($salary_detail_data.deduction_3);
				$('#deduction_4').val($salary_detail_data.deduction_4);
				

				$('#working_days').val($salary_detail_data.working_days);
				$('#holi_days').val($salary_detail_data.holi_days);
				$('#effective_working_days').val($salary_detail_data.effective_working_days);
				$('#effectiveBasicPay').val($salary_detail_data.effectiveBasicPay);
				$('#attendance_count').val($salary_detail_data.attendance_count);
				
				$('#half_day').val($salary_detail_data.half_day);
				$('#full_day').val($salary_detail_data.full_day);
				$('#overtime_hours').val($salary_detail_data.overtime_hours);
				$('#late_hours').val($salary_detail_data.late_hours);
				$('#overtime_amount').val($salary_detail_data.overtime_amount); 

				$('#net_pay').val($res1.net_pay);
				
				modal.style.display = "block";
			}
		});//end ajax
	}//end fun

	//Delete PaySlip	
	function deletePaySlip($emp_sal_id){
		console.log('Delete : '+$emp_sal_id);
		if (confirm('Are you sure to delete the record?')) {
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deletePaySlip", emp_sal_id: $emp_sal_id }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#emp_sal_id_'+$emp_sal_id).remove();
				}
			});//end ajax
		}		
	}//end PaySlip delete

	//Receive payment function start
	$('#myForm').on('submit', function(){
		$billNumber = $('#billNumber').val();
		if($billNumber != ''){
			getBillDetails($billNumber);
		}
		return false;
	})

	$('#myForm1').on('submit', function(){
		$billNumber = $('#billNumber').val();
		$collectionAmount = $('#collectionAmount').val();
		$collectionDate = $('#collectionDate').val();
		$collectionNote = $('#collectionNote').val();
		$customer_id = $('#customer_id').val();

		if($billNumber == ''){
			alert('Please enter bill number');
		}else{
			//Fetch data
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "updatepaymentInfo", billNumber: $billNumber, collectionAmount: $collectionAmount, collectionDate: $collectionDate, collectionNote: $collectionNote, customer_id: $customer_id }
			})
			.done(function (res) {
			//console.log(res);
				$res1 = JSON.parse(res);
				if ($res1.status == true) {
					$('#myForm1').trigger('reset');
					$('#paymentRcvDiv').removeClass('d-block');
					$('#paymentRcvDiv').addClass('d-none');
					$('#customerInfo').html("");
					alert('Payment Received Successfully');
				}else{
					alert('Bill Update error');
				}//end if
			}); //end ajax
		}//end if
		return false;
	})

	function getBillDetails(billNumber){
		$('#myForm1').trigger('reset');
		$('#paymentRcvDiv').removeClass('d-block');
		$('#paymentRcvDiv').addClass('d-none');

		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getBillDetails", bill_id: billNumber }
		})
		.done(function( res ) {
			//console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){  
				$billDetail = $res1.bill_description;	
				$payHistory = $res1.payHistory;					
				$customer_id = $res1.customer_id;
				$('#customer_id').val($customer_id);
				$('#customerInfo').html("");

				$html = "";
				$html += "<h5>Customer Info</h5>";
				$html += '<div class="col-md-12">';
					$html += 'Customer name: '+$billDetail.customer_name+'</br>'; 
					$html += 'Contact Number: '+$billDetail.phone_number+'</br>';
				$html += '</div>';

				//Payment History
				if($payHistory.length > 0){
					$html += "<h5>Payment History</h5>";
					for(var j = 0; j < $payHistory.length; j++){
						$html += "<div class='col-md-12'>Amount Rs. "+$payHistory[j].cb_amount+"/- Paid on "+$payHistory[j].cb_formated_date+" Note: "+$payHistory[j].cb_note+"</div>";
					}//end for
				}//end if
				$html += "<h6>Total Amount Paid: Rs. "+$billDetail.totalCash+"/- Total Amount Due: Rs. "+$billDetail.dueCash+"/-</h6>";

				$('#customerInfo').html($html);
				$('#paymentRcvDiv').removeClass('d-none');
				$('#paymentRcvDiv').addClass('d-block');
			}else{
				$('#customerInfo').html("");
				alert('Bill Number Not Found');
			}
		});//end ajax
	}//end fun

	//Return Product	
	$('#myFormRet').on('submit', function(){
		$billNumber = $('#billNumber').val();
		if($billNumber != ''){
			getBillDetailsWProd($billNumber);
		}
		return false;
	})

	function getBillDetailsWProd(billNumber){
		$('#myForm1').trigger('reset');
		$('#paymentRcvDiv').removeClass('d-block');
		$('#paymentRcvDiv').addClass('d-none');

		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getBillDetails", bill_id: billNumber }
		})
		.done(function( res ) {
			//console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){  
				$billDetail = $res1.bill_description;	
				$payHistory = $res1.payHistory;					
				$customer_id = $res1.customer_id;
				$fineItems = $res1.bill_description.fineItems;

				$('#customer_id').val($customer_id);
				$('#customerInfo').html("");

				$html = "";
				$html += "<h5>Customer Info</h5>";
				$html += '<div class="col-md-12">';
					$html += 'Customer name: '+$billDetail.customer_name+'</br>'; 
					$html += 'Contact Number: '+$billDetail.phone_number+'</br>';
				$html += '</div>';

				//Product History
				if($fineItems.length > 0){
					$html += "<h5>Product Details</h5>";
					for(var p = 0; p < $fineItems.length; p++){
						$html += "<div class='col-md-12'>"+$fineItems[p].qty+" X "+$fineItems[p].products+" Rs."+$fineItems[p].net_value+"</div>";
					}//end for
				}//end if 

				//Payment History
				if($payHistory.length > 0){
					$html += "<h5>Payment History</h5>";
					for(var j = 0; j < $payHistory.length; j++){
						$html += "<div class='col-md-12'>Amount Rs. "+$payHistory[j].cb_amount+"/- Paid on "+$payHistory[j].cb_formated_date+" Note: "+$payHistory[j].cb_note+"</div>";
					}//end for
				}//end if
				$html += "<h6>Total Amount Paid: Rs. "+$billDetail.totalCash+"/- Total Amount Due: Rs. "+$billDetail.dueCash+"/-</h6>";

				$('#customerInfo').html($html);
				$('#paymentRcvDiv').removeClass('d-none');
				$('#paymentRcvDiv').addClass('d-block');
			}else{
				$('#customerInfo').html("");
				alert('Bill Number Not Found');
			}
		});//end ajax
	}//end fun

	$('#myFormRetu1').on('submit', function(){
		$billNumber = $('#billNumber').val();
		$returnAmount = $('#returnAmount').val();
		$returnDate = $('#returnDate').val();
		$returnNote = $('#returnNote').val();
		$customer_id = $('#customer_id').val();

		if($billNumber == ''){
			alert('Please enter bill number');
		}else{
			//Fetch data
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "returnProductAmount", billNumber: $billNumber, returnAmount: $returnAmount, returnDate: $returnDate, returnNote: $returnNote, customer_id: $customer_id }
			})
			.done(function (res) {
			//console.log(res);
				$res1 = JSON.parse(res);
				if ($res1.status == true) {
					$('#myFormRetu1').trigger('reset');
					$('#paymentRcvDiv').removeClass('d-block');
					$('#paymentRcvDiv').addClass('d-none');
					$('#customerInfo').html("");
					alert('Product Amount Return Successfully');
				}else{
					alert('Bill Update error');
				}//end if
			}); //end ajax
		}//end if
		return false;
	})
	//Return payment function end

	function populateZoneDD(){		
		$login_id = $('#login_id').val();
		$user_type = $('#user_type').val();
		$created_by = $('#created_by').val();

		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "populateZoneDD", user_type: $user_type, login_id: $login_id, created_by: $created_by}
		})
		.done(function( res ) {
			//console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){
				$zones = $res1.zones;
				
				$('#zone_id').html('');
				$options = "<option selected value='0'>Select Zone</option>";
				for(var i = 0; i < $zones.length; i++){						
					$zone_id = $zones[i].zone_id;
					$zone_name = $zones[i].zone_name; 

					$options += "<option value="+$zone_id+">"+$zone_name+"</option>";
				}
				$('#zone_id').html($options); 
			}
		});//end ajax
	}//end fun

	$('#zone_id').on('change', function(){
		$zone_id = $('#zone_id').val();
		$zone_name = $("#zone_id option:selected").text();	
		$billDetail.zone_id = $zone_id;
		$billDetail.zone_name = $zone_name;

		if($zone_id != '' && $customers.length > 0){
			$('#bill_customer_id').html('');
			$options = "<option selected value='0'>Select Customer</option>";
			for(var i = 0; i < $customers.length; i++){	
				$zone_id_temp = 0;
				$zone_id_temp = $customers[i].zone_id;
				if(parseInt($zone_id_temp) == parseInt($zone_id)){
					$b_user_data = $customers[i].b_user_data;
					$b_stock_quantity = $customers[i].b_stock_quantity;
					$org_name = $b_user_data.org_name;
					$contact_person1 = $b_user_data.contact_person;
					$contact_person = $contact_person1.replace(/ /g, "_");
					$phone_number = $b_user_data.phone_number? $b_user_data.phone_number: '9999999999';
					$whatsapp_number = $b_user_data.whatsapp_number? $b_user_data.whatsapp_number: '9999999999';
					$email_id = $b_user_data.email_id? $b_user_data.email_id: 'xxx@xxxx.com';
					$address1 = $b_user_data.address;
					$address = $address1.replace(/ /g, "_");
					$pin_code = $b_user_data.pin_code;
					$gstin_no = $b_user_data.gstin_no? $b_user_data.gstin_no: '0000000000';
					$b_user_type = $customers[i].b_user_type;

					$options += "<option value="+$customers[i].b_login_id+" customer_name="+$contact_person+" phone_number="+$phone_number+" whatsapp_number="+$whatsapp_number+" email_id="+$email_id+" pin_code="+$pin_code+" customer_gstin_no="+$gstin_no+" customer_address="+$address+" b_user_type="+$b_user_type+" net_due_amount="+$customers[i].net_due_amount+">"+$org_name+"</option>";
				}//end if
			}//end for
			$('#bill_customer_id').html($options);					
			$('#bill_customer_id').prop('disabled', false);
			$populate_customer = true;
		}//end if
	});//end if

	$(document).ready(function() {
		populateZoneDD();
	});

	//Loading screen
	$body = $("body");
	$(document).on({
		ajaxStart: function() { $body.addClass("loading");    },
		ajaxStop: function() { $body.removeClass("loading"); }    
	});
	
				
				
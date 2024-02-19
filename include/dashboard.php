<h2>Welcome</h2>
<hr>
<h3>Please Insert your contact information</h3>
<p id="submit_info"></p>
<p id="error_info"></p>
<table>
	<tr>
		<td>Name: </td>
		<td><input type="text" id="contact_name"/></td>
	</tr>
	<tr>
		<td>Phone: </td>
		<td><input type="text" id="contact_phone"/></td>
	</tr>
	<tr>
		<td></td>
		<td><button id="ajax_submit">Submit</button></td>
	</tr>
</table>

<script>
	jQuery(document).ready(function($){
		$("#ajax_submit").on("click", function(){
			var contact_name = $("#contact_name").val();
			var contact_phone = $("#contact_phone").val();
			if(contact_name == "" || contact_phone == ""){
				$("#error_info").show().html("<span style='color:red;'>All fields are required</span>");
				setTimeout(function(){
					$("#error_info").hide();
				}, 4000);
			}else{
				$.ajax({
					url: "<?php echo admin_url('admin-ajax.php'); ?>",
					type: "POST",
					data: {
						action: "my_ajax_crud_action",
						contact_name : contact_name,
						contact_phone: contact_phone
					},
					success: function(data){
						$("#submit_info").append(data);
						setTimeout(function(){
							$("#submit_info").hide();
						}, 4000);
					}
				});
			}
		});
	});
</script>

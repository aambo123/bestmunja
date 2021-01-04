<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>CI PUSHER</title>
	</head>
	<body>
		<form class="form" action="<?php echo base_url(); ?>welcome/process" method="post">
			<input type="text" name="message" value="">
			<button type="submit" name="button">Submit</button>
		</form>
		<div id="message">

		</div>

		<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
		<script type="text/javascript">

			$('.form').submit(function(e){
				e.preventDefault();

				$.ajax({
					url: $(this).attr('action'),
					type: 'post',
					data: new FormData($(this)[0]),
					contentType: false,
					processData: false,
					success: function(data){
					}
				})
			})
			//Enable pusher logging - don't include this in production
			Pusher.logToConsole = true;

			var pusher = new Pusher('86886ac93a23bc33e419', {
			cluster: 'ap3',
			forceTLS: true
			});

			var channel = pusher.subscribe('lcdns');
			channel.bind('my-event', function(data) {
			$('#message').append('<div>'+data.message+'</div>');

			});
		</script>
	</body>
</html>

$(document).ready(function () {
	$('#searcResult').on('keyup', function (e) {
              if ($(this).val().length >0 && e.keyCode === 13) {
                   location.href = '/users/SmsSearch/'+$(this).val()
              }
	});
	$('#per_pg').on('change', function(event) {
		val = $(this).children('option:selected').val();
		console.log(val);
		$.ajax({
			url: '/users/setPerpg',
			type: "POST",
			cache: false,
			data: {data:val},
			success: function(){
				location.reload();
			}
		})
	})
     // toggle overline class
     $('input[type=checkbox').change(function(){
          this.checked ? $(this).closest('tr').addClass('checked') : $(this).closest('tr').removeClass('checked')
     });

     // check all
     $('#checkAll').on('click',function(){
          $('.delete').prop('checked',$(this).context.checked)
          $(this).context.checked ? $('.delete').closest('tr').addClass('checked') : $('.delete').closest('tr').removeClass('checked')
     });


    $('#delete-all').on('click', function(){

        
        var conf = confirm('정말로 삭제 하시겠습니까?');
        if(!conf){
            return false;
        }
        var arr = [];
        $('input[type=checkbox]').each(function(){
            arr.push(this.id);
        })

        $.ajax({
            url: '/users/SmsRequestsDelete',
            type: "POST",
            data: {'id':arr},
            dataType:'html',
            async: true,
            success: function(data){

                
                console.log(data);
                location.reload();


            }
        });

    });

    $('#delete-checked').on('click', function(){
        var conf = confirm('정말로 삭제 하시겠습니까?');
        if(!conf){
            return false;
        }

        var arr = [];
        $('input.delete:checked').each(function(){
            arr.push($(this).val());

        })
        $.ajax({
            url: '/users/SmsRequestsDelete',
            type: "POST",
            data: {'id':arr},
            dataType:'html',
            async: true,
            success: function(data){
                console.log(data);
                location.reload();
            }
        });

    });
});

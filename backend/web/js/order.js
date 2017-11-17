
$(function() {

});

function myEmail(id){

  $.ajax({

     url: '?r=order/email&id='+id,
      type: 'POST',

      success: function(data){
        alert('Email sent to customer');
      },
      error: function(xhr, ajaxOptions, thrownError){
        alert('Email not sent');
      },
      timeout: 10000

  });

}

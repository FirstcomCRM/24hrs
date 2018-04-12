/*
  JS for purchase offline orders
*/

$(document).ready(function(){


});

//at views/offline-order/gift.php, trigger mechaniasm for Select Occassion dropdownlist
function mocc(){
  var occassion = $('#occassions').val();
  $.post("?r=offline-order/ajax-gift",{
        occassion:occassion,
    },
    function(data, status){
      //$('#'+newTotalText).val(data);
      $("#moptions").html(data);
    });


}
//at views/offline-order/_form.php, trigger mechanias for close button modal
function mclose(){
  var mgift = $('#moptions').val();
  //offlineorder-gift_message
  $('#offlineorder-gift_message').val(mgift);
//  console.log(mgift);
}

function getTotal(item){
//offlineorderproduct-0-total_amount_text
  index  = item.attr("id").replace(/[^0-9.]/g, "");
  newTotal = "offlineorderproduct-"+index+"-total_amount";
  newQty = "offlineorderproduct-"+index+"-quantity";
  newPrice= "offlineorderproduct-"+index+"-unit_price";
  newTotalText ="offlineorderproduct-"+index+"-total_amount_text";
  var nprice = $('#'+newPrice).val();
  var nqty = $('#'+newQty).val();
  var ntotal = 0;
  if($.isNumeric(nprice) && $.isNumeric(nqty) ){
      ntotal  = parseFloat((parseFloat(nprice) * parseFloat(nqty))).toFixed(2);
      $('#'+newTotal).val(ntotal);
      $.post("?r=offline-order/ajax-amount",{
            ntotal:ntotal,
        },
        function(data, status){
          $('#'+newTotalText).val(data);

        });

      getSubTotal();
      getGrandTotal();
  }else{
      ntotal = 0.00;
      $('#'+newTotal).val(ntotal);
      $('#'+newTotalText).val(ntotal);
  }
}

function getCharge(){
    var test = $('#offlineorder-charge').val();
    var dummy  = parseFloat(test).toFixed(2);
    $('#ids').val(dummy);

}

function getSubTotal(){
  var items = $('.item');
  var total = 0;
  var ntotal = 0;
  var q = 0;

  items.each(function(index, elem){
    var totalPart = $(elem).find(".sumPart").val();
    if ($.isNumeric(totalPart) ) {
      total = parseFloat(total) + parseFloat(totalPart);
      total = parseFloat(total).toFixed(2);
      ntotal = total;
    //  console.log(typeof ntotal);
    }

  });
  $.ajaxSetup({async: false});
  $.post("?r=offline-order/ajax-amount",{
      ntotal:ntotal,

    },
    function(data, status){
    //    $('#offlineorder-subtotal').val(data);
      $('#offlineorder-subtotal').val(data);
    //  console.log(data);
    //  var sq = data;
    //    $('.selected-item-list').append(data);
        // console.log(status);
    });

  //  $('#offlineorder-subtotal').val(total);
    //console.log(data+'data');
  //  console.log(q+'out');
  //  $('#offlineorder-subtotal').val(q);
  //quoTotalGst();
}

function getGrandTotal(){
//  var del_charge = $('#ids').val();
  var del_charge = $('#offlineorder-charge').val();
  var subtot  = $('#offlineorder-subtotal').val();
  //var a='1,125.01';
  //a=a.replace(/\,/g,''); // 1125, but a string, so convert it to number
//  a=parseFloat(a,2);
//  console.log(a);
  subtot = subtot.replace(/\,/g,'');
  subtot=parseFloat(subtot);
//  console.log(subtot);

  //console.log(del_charge+'delivery');
  if(!$.isNumeric(del_charge) ){
    del_charge = 0.00;
  }
  if(!$.isNumeric(subtot) ){
    subtot = 0.00;
  }
  //  console.log(subtot+'subtotal-below');
    var grandtot = parseFloat(subtot)+parseFloat(del_charge);
    grandtot = parseFloat(grandtot).toFixed(2);

    var ntotal = grandtot;
    $.post("?r=offline-order/ajax-amount",{
        ntotal:ntotal,

      },
      function(data, status){
      //    $('#offlineorder-subtotal').val(data);
        $('#offlineorder-grand_total').val(data);
      //  console.log(data);
      //  var sq = data;
      //    $('.selected-item-list').append(data);
          // console.log(status);
      });


//    console.log(grandtot);
//  var total = $('#quotationheader-total_amount').val();
//  var agst = ((parseFloat(gst)/ parseFloat(100))+1.00);
//  var totalgst= parseFloat(parseFloat(total) * parseFloat(agst) ).toFixed(2);
//  console.log(totalgst.toLocaleString('en'));
//console.log(grandtot);
//  $('#offlineorder-grand_total').val(grandtot);
}


function offRecalc(item){
  var index =  item.attr("id").replace(/[^0-9.]/g, "");
  removeTotal = "offlineorderproduct-"+index+"-total_amount";
  removePrice = "offlineorderproduct-"+index+"-unit_price";
  removeQty = "offlineorderproduct-"+index+"-quantity";
  $('#'+removeTotal).val(0.00);
  $('#'+removePrice).val(0.00);
  $('#'+removeQty).val(0);
  getSubTotal();
}

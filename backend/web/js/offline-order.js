/*
  JS for purchase offline orders
*/


$(document).ready(function(){

});

function getTotal(item){

  index  = item.attr("id").replace(/[^0-9.]/g, "");
  newTotal = "offlineorderproduct-"+index+"-total_amount";
  newQty = "offlineorderproduct-"+index+"-quantity";
  newPrice= "offlineorderproduct-"+index+"-unit_price";
  var nprice = $('#'+newPrice).val();
  var nqty = $('#'+newQty).val();
  var ntotal = 0;
  if($.isNumeric(nprice) && $.isNumeric(nqty) ){
      ntotal  = parseFloat((parseFloat(nprice) * parseFloat(nqty))).toFixed(2);
      $('#'+newTotal).val(ntotal);
  //    getTotalAmt();
      getSubTotal();
  }else{
      ntotal = 0.00;
      $('#'+newTotal).val(ntotal);
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
  items.each(function(index, elem){
    var totalPart = $(elem).find(".sumPart").val();
    if ($.isNumeric(totalPart) ) {
      total = parseFloat(total) + parseFloat(totalPart);
      total = parseFloat(total).toFixed(2);
    //  total = parseFloat(total).toFixed(2) + parseFloat(totalPart).toFixed(2);
    }
  });
  $('#offlineorder-subtotal').val(total);
  //quoTotalGst();
}

function getGrandTotal(){
  var del_charge = $('#ids').val();
  var subtot  = $('#offlineorder-subtotal').val();
  if(!$.isNumeric(del_charge) ){
    del_charge = 0.00;
  }
  if(!$.isNumeric(subtot) ){
    subtot = 0.00;
  }
    var grandtot = parseFloat(subtot)+parseFloat(del_charge);
    grandtot = parseFloat(grandtot).toFixed(2);
//    console.log(grandtot);
//  var total = $('#quotationheader-total_amount').val();
//  var agst = ((parseFloat(gst)/ parseFloat(100))+1.00);
//  var totalgst= parseFloat(parseFloat(total) * parseFloat(agst) ).toFixed(2);
//  console.log(totalgst.toLocaleString('en'));
  $('#offlineorder-grand_total').val(grandtot);
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

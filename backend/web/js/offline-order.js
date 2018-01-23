/*
  JS for purchase offline orders
*/


$(document).ready(function(){

});

function getTotal(item){
  console.log('data test');
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
  }else{
      ntotal = 0.00;
      $('#'+newTotal).val(ntotal);
  }
}

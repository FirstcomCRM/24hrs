$(function(){
//  $('#modalButton').click(function(){ //#modalButton, changed to class when in gridview customer link

  $('.modalButton').click(function(e){
    e.preventDefault();
//    console.log('test');
    $('#modals').modal('show')
      .find('#modalContent')
      .load($(this).attr('value'));
  });

  $('.modalDelUp').click(function(e){
    e.preventDefault();
//    console.log('test');
    $('#modalsDelUp').modal('show')
      .find('#modalContentDel')
      .load($(this).attr('value'));




  });

});

$(function(){
//  $('#modalButton').click(function(){ //#modalButton, changed to class when in gridview customer link
  $('.modalButton').click(function(e){
    e.preventDefault();
    console.log('test');
    $('#modals').modal('show')
      .find('#modalContent')
      .load($(this).attr('value'));
  });

});

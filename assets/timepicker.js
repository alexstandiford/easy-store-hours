jQuery(document).ready(function($){
  $('.timepicker').timepicki({
    step_size_minutes: 15,
  });
  $('#sub-accordion-section-esh_store_hours').find('.button-secondary').on('click',function(e){
    e.preventDefault();
    var eshOpenField = $(this).next();
    var eshClosedField = $(eshOpenField).next();
    var eshClosedCheckbox = $(eshClosedField).next();

    eshOpenField.find('input').val("");
    eshClosedField.find('input').val("");
    eshClosedCheckbox.find('input').prop('checked',false);

  })
});
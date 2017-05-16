jQuery(document).ready(function($){
  $('.timepicker').timepicki({
    step_size_minutes: 15,
  });
  $('#sub-accordion-section-esh_store_hours').find('.button-secondary').on('click',function(e){
    e.preventDefault();
    var eshOpenField = $(this).next().find('input');
    var eshClosedField = $(eshOpenField).next().find('input');
    var eshClosedCheckbox = $(eshClosedField).next().find('input');

    eshOpenField.val("");
    wp.customize(eshOpenField.attr('id'),function(obj){
      obj.set("");
    });
    eshClosedField.val("");
    wp.customize(eshClosedField.attr('id'),function(obj){
      obj.set("");
    });
    eshClosedCheckbox.prop('checked',false);
    wp.customize(eshClosedCheckbox.attr('data-customize-setting-link'),function(obj){
      obj.set("");
    })
  })
});
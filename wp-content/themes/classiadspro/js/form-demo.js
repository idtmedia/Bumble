jQuery(function() {
  var buildWrap = document.querySelector('.build-wrap'),
    renderWrap = document.querySelector('.render-wrap'),
    editBtn = document.getElementById('edit-form'),
    formData = window.sessionStorage.getItem('formData'),
    editing = true,
    fbOptions = {
      dataType: 'json'
    };

  if (formData) {
    fbOptions.formData = JSON.parse(formData);
  }

  var toggleEdit = function() {
    document.body.classList.toggle('form-rendered', editing);
    editing = !editing;
  };

  var formBuilder = jQuery(buildWrap).formBuilder(fbOptions).data('formBuilder');

  jQuery('.form-builder-save').click(function() {
    toggleEdit();
    jQuery(renderWrap).formRender({
      dataType: 'json',
      formData: formBuilder.formData
    });

    window.sessionStorage.setItem('formData', JSON.stringify(formBuilder.formData));
  });

  editBtn.onclick = function() {
    toggleEdit();
  };
});

(function(){
  'use strict';

  //───────────────────────────────────────
  // Media selector
  //───────────────────────────────────────
  function bindMediaFields(){
    document.querySelectorAll('[data-oneup-media-field]').forEach(function(field){
      if(field.dataset.oneupBound){return;}
      field.dataset.oneupBound = '1';

      var input = field.querySelector('[data-oneup-media-input]');
      var preview = field.querySelector('[data-oneup-media-preview]');
      var select = field.querySelector('[data-oneup-media-select]');
      var clear = field.querySelector('[data-oneup-media-clear]');

      if(select){
        select.addEventListener('click', function(){
          if(!window.wp || !wp.media){return;}

          var frame = wp.media({
            title: 'Choose image',
            button: { text: 'Use image' },
            multiple: false
          });

          frame.on('select', function(){
            var attachment = frame.state().get('selection').first().toJSON();
            input.value = attachment.id || '';
            preview.innerHTML = attachment.sizes && attachment.sizes.medium
              ? '<img class="oneup-admin-media-preview__image" src="'+attachment.sizes.medium.url+'" alt="">'
              : '<span>'+String(attachment.filename || 'Selected image')+'</span>';
          });

          frame.open();
        });
      }

      if(clear){
        clear.addEventListener('click', function(){
          input.value = '';
          preview.innerHTML = '';
        });
      }
    });
  }

  document.addEventListener('DOMContentLoaded', bindMediaFields);
})();

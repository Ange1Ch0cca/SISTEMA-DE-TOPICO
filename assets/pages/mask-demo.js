/*
 Template Name: Xeloro - Admin & Dashboard Template
 Author: Angel Chocca
 File: Mask js
*/


$( document ).ready(function() {
  $('[data-toggle="input-mask"]').each(function (idx, obj) {
      var maskFormat = $(obj).data("maskFormat");
      var reverse = $(obj).data("reverse");
      if (reverse != null)
          $(obj).mask(maskFormat, {'reverse': reverse});
      else
          $(obj).mask(maskFormat);
  });
});

$(document).on('ready', function () {
  // Wait a 1.5 seconds for complete load and then
  // restore the checkboxes that are broken by jquery.uniform
  var timeout = setTimeout(function () {
    $.uniform.restore('.tota11y-plugin-checkbox');
  }, 1500);
});

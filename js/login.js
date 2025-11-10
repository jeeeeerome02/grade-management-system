// Client-side validation for auth forms
document.addEventListener('DOMContentLoaded', function () {
  function attachFormValidation(formId) {
    var form = document.getElementById(formId);
    if (!form) return;
    
    form.addEventListener('submit', function (e) {
      var inputs = form.querySelectorAll('input[required]');
      var valid = true;
      
      inputs.forEach(function (inp) {
        if (!inp.value.trim()) {
          valid = false;
          inp.style.borderColor = '#f87171';
        } else {
          inp.style.borderColor = '';
        }
      });
      
      if (!valid) {
        e.preventDefault();
      }
    });
  }

  attachFormValidation('loginForm');
  attachFormValidation('signupForm');
});

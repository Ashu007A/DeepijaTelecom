document.addEventListener("DOMContentLoaded", function() {
  const codes = document.querySelectorAll('.code');
  
  codes.forEach((code, idx) => {
      code.addEventListener('input', (e) => {
          if (e.target.value.length > 0) {
              if (idx < codes.length - 1) {
                  document.querySelector(`#code-${idx + 2}`).focus();
              }
          }
      });

      code.addEventListener('keydown', (e) => {
          if (e.key === 'Backspace' && !e.target.value) {
              if (idx > 0) {
                  document.querySelector(`#code-${idx}`).focus();
              }
          }
      });
  });
});
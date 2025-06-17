

  // 邮箱校验
  const emailInput = document.getElementById('email');
  const emailTip = document.getElementById('email-tip');
  let emailValid = false;
  emailInput.addEventListener('input', function() {
      const val = emailInput.value.trim();
      const re = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
      if (!re.test(val)) {
          emailTip.textContent = "Format d'email invalide.";
          emailValid = false;
      } else {
          emailTip.innerHTML = "<span style='color:#388e3c'>Adresse email valide ✔</span>";
          emailValid = true;
      }
  });

  // 密码非空校验
  const passwordInput = document.getElementById('password');
  const passwordTip = document.getElementById('password-tip');
  let passwordValid = false;
  passwordInput.addEventListener('input', function() {
      if (passwordInput.value.length < 1) {
          passwordTip.textContent = "Le mot de passe ne peut pas être vide.";
          passwordValid = false;
      } else {
          passwordTip.innerHTML = "<span style='color:#388e3c'>Mot de passe saisi ✔</span>";
          passwordValid = true;
      }
  });

  // 表单提交校验
  document.getElementById('loginForm').addEventListener('submit', function(e) {
    // 触发一次校验，确保最新状态
    emailInput.dispatchEvent(new Event('input'));
    passwordInput.dispatchEvent(new Event('input'));
    if (!emailValid || !passwordValid) {
      e.preventDefault();
      if (!emailValid) emailInput.focus();
      else if (!passwordValid) passwordInput.focus();
      return false;
    }
    return true;
  });

  // --- Script for the header hamburger menu (from accueil.html) ---
  document.addEventListener('DOMContentLoaded', function() {
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const navLinks = document.getElementById('nav-links');

    if (hamburgerBtn && navLinks) {
        hamburgerBtn.addEventListener('click', () => {
            navLinks.classList.toggle('show');
        });
    }
  });

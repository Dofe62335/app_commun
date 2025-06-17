 // --- Script for the form ---
 function selectRole(role) {
    document.getElementById("role").value = role;
    document.getElementById("user-btn").classList.toggle("active", role === "visiteur");
    document.getElementById("prof-btn").classList.toggle("active", role === "prof");
    document.getElementById("admin-btn").classList.toggle("active", role === "admin");
  }

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

  // 密码强度校验
  const passwordInput = document.getElementById('password');
  const strengthDiv = document.getElementById('password-strength');
  let passwordValid = false;
  passwordInput.addEventListener('input', function() {
    const pwd = passwordInput.value;
    let msg = '';
    passwordValid = false;
    if (pwd.length < 6) {
        msg = "Le mot de passe doit contenir au moins 6 caractères.";
    } else if (!/[A-Z]/.test(pwd)) {
        msg = "Le mot de passe doit contenir au moins une lettre majuscule.";
    } else if (!/[a-z]/.test(pwd)) {
        msg = "Le mot de passe doit contenir au moins une lettre minuscule.";
    } else if (!/[0-9]/.test(pwd)) {
        msg = "Le mot de passe doit contenir au moins un chiffre.";
    } else {
        msg = "<span style='color:#388e3c'>Mot de passe fort ✔</span>";
        passwordValid = true;
    }
    strengthDiv.innerHTML = msg;
  });

  // 确认密码校验
  const confirmInput = document.getElementById('confirm_password');
  const confirmTip = document.getElementById('confirm-tip');
  let confirmValid = false;
  function checkConfirmPwd() {
    if (confirmInput.value !== passwordInput.value) {
        confirmTip.textContent = "Les deux mots de passe ne correspondent pas.";
        confirmValid = false;
    } else if (confirmInput.value.length > 0) {
        confirmTip.innerHTML = "<span style='color:#388e3c'>Mot de passe confirmé ✔</span>";
        confirmValid = true;
    } else {
        confirmTip.textContent = '';
        confirmValid = false;
    }
  }
  confirmInput.addEventListener('input', checkConfirmPwd);
  passwordInput.addEventListener('input', checkConfirmPwd);

  // 条款校验
  const termsInput = document.getElementById('terms');

  // 表单提交校验
  document.getElementById('register-form').addEventListener('submit', function(e) {
    // 触发一次校验，确保最新状态
    emailInput.dispatchEvent(new Event('input'));
    passwordInput.dispatchEvent(new Event('input'));
    checkConfirmPwd();
    let termsValid = termsInput.checked;
    if (!termsValid) {
      alert("Veuillez accepter les conditions d'utilisation.");
    }
    if (!emailValid || !passwordValid || !confirmValid || !termsValid) {
      e.preventDefault();
      if (!emailValid) emailInput.focus();
      else if (!passwordValid) passwordInput.focus();
      else if (!confirmValid) confirmInput.focus();
      return false;
    }
    return true;
  });

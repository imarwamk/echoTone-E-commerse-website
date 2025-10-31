const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

if (registerBtn) {
  registerBtn.addEventListener('click', () => {
    container.classList.add("active");
  });
}
if (loginBtn) {
  loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
  });
}

const goToSignup = document.getElementById('goToSignup');
if (goToSignup) {
  goToSignup.addEventListener('click', (e) => {
    e.preventDefault();         
    container.classList.add("active"); 
    setTimeout(() => {
      const usernameSignup = document.getElementById('username_signup');
      if (usernameSignup) usernameSignup.focus();
    }, 300);
  });
}

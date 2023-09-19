const switchLoginRegister = () => {
    const toRegister = document.querySelector('#switch-to-register');
    const toLogin = document.querySelector('#switch-to-login');

    const loginBlock = document.querySelector('.login-block');
    const registerBlock = document.querySelector('.register-block');

    toRegister.addEventListener('click', () => {
        loginBlock.classList.add('hidden');
        registerBlock.classList.remove('hidden');
    })

    toLogin.addEventListener('click', () => {
        loginBlock.classList.remove('hidden');
        registerBlock.classList.add('hidden');
    })


}

export default switchLoginRegister;
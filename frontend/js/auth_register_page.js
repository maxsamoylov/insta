// переключает страницы логина и регистрации
function switchPage() {
    let authPage = document.getElementById('auth_page');
    let registerPage = document.getElementById('register_page');

    if (authPage.className === 'hidden') {
        authPage.className = '';
        registerPage.className = 'hidden';
    } else {
        authPage.className = 'hidden';
        registerPage.className = '';
    }
}

// показывает ошибки в форме
function showErrors(divId, errors) {
    const div = document.getElementById(divId);
    if (div) {
        div.innerHTML = '';
        div.className = '';
        errors.forEach((error) => {
            const errorElement = document.createElement('div');
            errorElement.className = 'error';
            errorElement.textContent = error;
            div.append(errorElement);
        });
    }
}

window.onload = () => {

    document.getElementById('register_link').addEventListener('click', (e) => {
        e.preventDefault();
        switchPage();
    });

    document.getElementById('login_link').addEventListener('click', (e) => {
        e.preventDefault();
        switchPage();
    });

    const registrationForm = document.getElementById('registration_form');

    registrationForm.onsubmit = (e) => {
        e.preventDefault();

        const registerBtn = document.getElementById('register_btn');
        registerBtn.disabled = true;

        fetch('backend/register.php', {
            method: 'POST',
            body: new FormData(registrationForm)
        })
            .then(response => response.json())
            .then(result => {
                if ('errors' in result) {
                    if (result.errors.length === 0) {
                        location.reload();
                    } else {
                        showErrors('register_errors', result.errors);
                    }
                }
                registerBtn.disabled = false;
            })
            .catch((e) => {
                showErrors('register_errors', [ e.message ]);
                registerBtn.disabled = false;
            });
    };

    const loginForm = document.getElementById('login_form');

    loginForm.onsubmit = (e) => {
        e.preventDefault();

        const loginBtn = document.getElementById('login_btn');
        loginBtn.disabled = true;

        fetch('backend/login.php', {
            method: 'POST',
            body: new FormData(loginForm)
        })
            .then(response => response.json())
            .then(result => {
                if ('errors' in result) {
                    if (result.errors.length === 0) {
                        location.reload();
                    } else {
                        showErrors('login_errors', result.errors);
                    }
                }
                loginBtn.disabled = false;
            })
            .catch((e) => {
                showErrors('login_errors', [ e.message ]);
                loginBtn.disabled = false;
            });
    }
};

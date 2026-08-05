document.addEventListener('DOMContentLoaded', function () {
    var tabs = document.querySelectorAll('.auth-tab');
    var panels = document.querySelectorAll('.auth-panel');
    var switchLinks = document.querySelectorAll('[data-switch]');

    function activate(name) {
        tabs.forEach(function (tab) {
            var isActive = tab.getAttribute('data-tab') === name;
            tab.classList.toggle('is-active', isActive);
            tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });
        panels.forEach(function (panel) {
            panel.classList.toggle('is-active', panel.getAttribute('data-panel') === name);
        });
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () { activate(tab.getAttribute('data-tab')); });
    });
    switchLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            activate(link.getAttribute('data-switch'));
        });
    });
});

function login() {
    document.getElementById("formLogin").addEventListener('submit', function (e) {
        e.preventDefault();

        const form = new FormData(e.target);

        const data = {
            email: form.get('email'),
            password: form.get('password')
        }

        let url = `${APP.BASE_URL}${APP.ENDPOINTS.user.login}`;

        fetch(url, {
            method: "POST",
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    window.flashy.success(result.message);
                } else {
                    window.flashy.error(result.message);
                }
            })
            .catch(error => {
                window.flashy.error(error);
            });
    });
}

function signUp() {
    document.getElementById("formRegister").addEventListener('submit', function (e) {
        e.preventDefault();

        const from = new FormData(e.target);

        const data = {
            name: from.get('txtName'),
            lastName: from.get('txtLastName'),
            phone: from.get('txtPhone'),
            email: from.get('txtEmail'),
            password: from.get('txtPassword'),
            passwordConfirm: from.get('txtPasswordConfirm')
        }

        let url = `${APP.BASE_URL}${APP.ENDPOINTS.user.signup}`;

        fetch(url, {
            method: "POST",
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    window.flashy.success(result.message);
                } else {
                    window.flashy.error(result.message);
                }
            })
            .catch(error => {
                window.flashy.error(error);
            });
    });
}


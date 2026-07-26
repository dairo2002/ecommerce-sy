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

function signUp() {
    document.getElementById("formRegister").addEventListener('submit', function (e) {
        e.preventDefault();

        const data = new FormData(e.target);
    
        let name = data.get('txtName')
        let lastName = data.get('txtLastName')
        let phone = data.get('txtPhone') 
        let email = data.get('txtEmail') 
        let password = data.get('txtPassword')
        let passwordConfirm = data.get('txtPasswordConfirm')

        console.log([
            name,
            lastName,
            phone,
            email,
            password,
            passwordConfirm,
        ]);
        

    });

}
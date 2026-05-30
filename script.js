// 1. Găsim elementele în pagină
const btnManager = document.getElementById('btn-manager');
const btnUser = document.getElementById('btn-user');
const btnCreateAcc = document.getElementById('btn-create-acc');

// 2. Logica pentru selecția butoanelor (doar dacă ele există pe pagină)
if (btnManager && btnUser) {
    btnManager.addEventListener('click', function() {
        btnManager.classList.add('active');
        btnUser.classList.remove('active');
    });

    btnUser.addEventListener('click', function() {
        btnUser.classList.add('active');
        btnManager.classList.remove('active');
    });
}

// 3. Logica pentru redirecționare (doar dacă butonul de creare cont există)
if (btnCreateAcc) {
    btnCreateAcc.addEventListener('click', function(event) {
        // Previne comportamentul standard (cum ar fi refresh-ul paginii)
        event.preventDefault(); 
        
        // Verificăm care buton e mov și trimitem pe pagina corectă
        if (btnManager.classList.contains('active')) {
            window.location.href = 'create-acc-manager.html';
        } else if (btnUser.classList.contains('active')) {
            window.location.href = 'create-acc-user.html';
        }
    });
}
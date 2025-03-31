// script.js

document.addEventListener('DOMContentLoaded', function() {
    const botaoModo = document.getElementById('modo-toggle');
    
    // Verifique se o botão existe antes de adicionar o evento
    if (botaoModo) {
        const corpo = document.body;

        // Verificar o modo atual (salvo no localStorage)
        if(localStorage.getItem('modo') === 'escuro') {
            corpo.classList.add('modo-escuro');
        }

        // Alternar modo claro/escuro
        botaoModo.addEventListener('click', function() {
            corpo.classList.toggle('modo-escuro');
            localStorage.setItem('modo', corpo.classList.contains('modo-escuro') ? 'escuro' : 'claro');
        });
    } else {
        console.error("Botão de alternância não encontrado!");
    }
});

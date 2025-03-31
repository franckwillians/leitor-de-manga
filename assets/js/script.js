// script.js

document.addEventListener('DOMContentLoaded', function() {
    const botaoModo = document.getElementById('modo-toggle');
    
    // Verifique se o botão de modo existe antes de adicionar o evento
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

    // Adicionar evento para alternância de modos de leitura
    const botaoLeitura = document.getElementById('leitura-toggle');
    if (botaoLeitura) {
        const conteudoManga = document.querySelector('.conteudo-manga');

        // Verificar o modo atual (salvo no localStorage)
        if(localStorage.getItem('modoLeitura') === 'pagina') {
            conteudoManga.style.display = 'none';
        } else {
            conteudoManga.style.display = 'block';
        }

        // Alternar modo de leitura
        botaoLeitura.addEventListener('click', function() {
            if (conteudoManga.style.display === 'block') {
                conteudoManga.style.display = 'none';
                localStorage.setItem('modoLeitura', 'pagina');
            } else {
                conteudoManga.style.display = 'block';
                localStorage.setItem('modoLeitura', 'continuo');
            }
        });
    } else {
        console.error("Botão de alternância de modo de leitura não encontrado!");
    }

    // Filtro de tipos e data na página Home
    const filtroTipo = document.getElementById('filtro-tipo');
    const filtroData = document.getElementById('filtro-data');
    
    filtroTipo.addEventListener('change', function() {
        // Implementar lógica de filtro por tipo
    });
    
    filtroData.addEventListener('change', function() {
        // Implementar lógica de filtro por data
    });
});
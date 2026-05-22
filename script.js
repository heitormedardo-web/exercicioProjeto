// script.js - Dark mode, menu hambúrguer e interatividade

// ===== MENU HAMBÚRGUER =====
function setupHamburgerMenu() {
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');
    const body = document.body;
    
    // Criar overlay
    const overlay = document.createElement('div');
    overlay.className = 'menu-overlay';
    document.body.appendChild(overlay);
    
    function toggleMenu() {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
        overlay.classList.toggle('active');
        
        // Impedir scroll quando o menu estiver aberto
        if (navMenu.classList.contains('active')) {
            body.style.overflow = 'hidden';
            body.classList.add('menu-open');
        } else {
            body.style.overflow = '';
            body.classList.remove('menu-open');
        }
    }
    
    // Abrir/fechar menu ao clicar no hambúrguer
    if (hamburger) {
        hamburger.addEventListener('click', toggleMenu);
    }
    
    // Fechar menu ao clicar no overlay
    overlay.addEventListener('click', toggleMenu);
    
    // Fechar menu ao clicar em um link
    const menuLinks = document.querySelectorAll('.nav-menu li a');
    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (navMenu.classList.contains('active')) {
                toggleMenu();
            }
        });
    });
    
    // Fechar menu ao redimensionar a tela para desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && navMenu.classList.contains('active')) {
            toggleMenu();
        }
    });
}

// ===== DARK MODE =====
function toggleDarkMode() {
    const body = document.body;
    
    if (body.classList.contains('dark-mode')) {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        localStorage.setItem('theme', 'light');
        updateButtonIcon('🌞');
    } else {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark');
        updateButtonIcon('🌙');
    }
}

function updateButtonIcon(icon) {
    const button = document.getElementById('toggle-dark-mode');
    if (button) {
        button.innerHTML = `${icon} Alternar Modo`;
    }
}

function loadSavedTheme() {
    const savedTheme = localStorage.getItem('theme');
    const body = document.body;
    
    if (savedTheme === 'dark') {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        updateButtonIcon('🌙');
    } else {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        updateButtonIcon('🌞');
    }
}

// ===== CONTADOR DE CONTATOS =====
function updateTotalContacts() {
    const table = document.querySelector('.contatos-table');
    if (table) {
        const rows = table.querySelectorAll('tbody tr');
        const total = rows.length;
        const totalElement = document.getElementById('total-contatos');
        if (totalElement) {
            totalElement.textContent = total;
        }
    }
}

// ===== ANIMAÇÃO DA TABELA =====
function addTableRowAnimation() {
    const rows = document.querySelectorAll('.contatos-table tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, index * 50);
    });
}

// ===== SISTEMA DE BUSCA =====
function setupSearch() {
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = ' Buscar contato...';
    searchInput.id = 'search-input';
    searchInput.style.cssText = `
        padding: 10px;
        margin: 20px 0;
        width: 100%;
        max-width: 300px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    `;
    
    const tableContainer = document.querySelector('.main-container');
    const table = document.querySelector('.contatos-table');
    
    if (tableContainer && table && !document.getElementById('search-input')) {
        tableContainer.insertBefore(searchInput, table);
        
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
}

// ===== NOTIFICAÇÃO DE MENU ABERTO (OPCIONAL) =====
function showMenuNotification() {
    const navMenu = document.getElementById('nav-menu');
    if (navMenu) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    if (navMenu.classList.contains('active')) {
                        console.log('Menu hambúrguer aberto');
                        // Você pode adicionar outras funcionalidades aqui
                    }
                }
            });
        });
        
        observer.observe(navMenu, { attributes: true });
    }
}

// ===== INICIALIZAÇÃO =====
document.addEventListener('DOMContentLoaded', () => {
    loadSavedTheme();
    updateTotalContacts();
    addTableRowAnimation();
    setupSearch();
    setupHamburgerMenu();  // Inicializar menu hambúrguer
    showMenuNotification();
    
    // Configurar botão de dark mode
    const toggleButton = document.getElementById('toggle-dark-mode');
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleDarkMode);
    }
});
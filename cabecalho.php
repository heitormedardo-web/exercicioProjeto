<!-- cabecalho.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Lista de Contatos</title>
    <style>
        /* RESET E ESTILOS BASE */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            transition: background-color 0.3s, color 0.3s;
        }

        /* MODO CLARO (padrão) */
        body.light-mode {
            background-color: #f5f5f5;
            color: #333;
        }

        /* MODO ESCURO */
        body.dark-mode {
            background-color: #1a1a1a;
            color: #f5f5f5;
        }

        /* NAVBAR */
        .navbar {
            background-color: #4CAF50;
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            position: relative;
            z-index: 1000;
        }

        .dark-mode .navbar {
            background-color: #2c5a2e;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .logo h2 {
            font-size: 1.5rem;
        }

        /* MENU DESKTOP */
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }

        .nav-menu li a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .nav-menu li a:hover {
            background-color: rgba(255,255,255,0.2);
        }

        /* MENU HAMBÚRGUER */
        .hamburger {
            display: none;
            cursor: pointer;
            flex-direction: column;
            gap: 5px;
            padding: 5px;
            z-index: 1000;
        }

        .bar {
            width: 30px;
            height: 3px;
            background-color: white;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .hamburger.active .bar:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }

        .hamburger.active .bar:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active .bar:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        /* BOTÃO DARK MODE */
        .btn-toggle {
            background-color: #333;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .btn-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        .dark-mode .btn-toggle {
            background-color: #f5f5f5;
            color: #333;
        }

        /* CONTAINER PRINCIPAL */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            min-height: calc(100vh - 250px);
        }

        /* TABELA ESTILIZADA */
        .contatos-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
        }

        .dark-mode .contatos-table {
            background-color: #2d2d2d;
            color: #f5f5f5;
        }

        .contatos-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .contatos-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 16px;
            border-bottom: 2px solid rgba(255,255,255,0.2);
        }

        .contatos-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        /* Efeito zebra - linhas alternadas */
        .contatos-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .dark-mode .contatos-table tbody tr:nth-child(even) {
            background-color: #363636;
        }

        /* Efeito hover nas linhas */
        .contatos-table tbody tr:hover {
            background-color: #f0f0f0;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .dark-mode .contatos-table tbody tr:hover {
            background-color: #404040;
        }

        /* Bordas laterais para destacar linhas */
        .contatos-table tbody tr {
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }

        .contatos-table tbody tr:hover {
            border-left-color: #667eea;
        }

        .dark-mode .contatos-table tbody tr:hover {
            border-left-color: #764ba2;
        }

        /* Estilo para a primeira coluna (número) */
        .contatos-table td:first-child {
            font-weight: bold;
            color: #667eea;
            width: 60px;
        }

        .dark-mode .contatos-table td:first-child {
            color: #9b8bea;
        }

        /* RODAPÉ */
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        .dark-mode .footer {
            background-color: #1a1a1a;
            border-top: 1px solid #333;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* TÍTULO DA PÁGINA */
        .page-title {
            margin: 20px 0;
            color: #4CAF50;
        }

        .dark-mode .page-title {
            color: #7bc47f;
        }

        /* MENSAGEM SEM CONTATOS */
        .no-contacts {
            text-align: center;
            padding: 40px;
            font-size: 18px;
            color: #999;
        }

        /* RESPONSIVIDADE */
        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }
            
            .nav-menu {
                position: fixed;
                left: -100%;
                top: 70px;
                flex-direction: column;
                background-color: #4CAF50;
                width: 100%;
                text-align: center;
                transition: 0.3s;
                box-shadow: 0 10px 27px rgba(0,0,0,0.05);
                padding: 20px 0;
                gap: 0;
                z-index: 999;
            }
            
            .dark-mode .nav-menu {
                background-color: #2c5a2e;
            }
            
            .nav-menu.active {
                left: 0;
            }
            
            .nav-menu li {
                margin: 15px 0;
            }
            
            .nav-menu li a {
                display: block;
                padding: 10px;
                font-size: 18px;
            }
            
            body.menu-open {
                overflow: hidden;
            }
            
            .menu-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 998;
            }
            
            .menu-overlay.active {
                display: block;
            }

            .btn-toggle {
                padding: 6px 12px;
                font-size: 12px;
            }
        }

        /* ANIMAÇÃO DO MENU */
        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .nav-menu.active {
            animation: slideIn 0.3s ease forwards;
        }
    </style>
</head>
<body class="light-mode">
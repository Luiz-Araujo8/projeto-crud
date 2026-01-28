# 📦 Sistema de Gestão de Estoque Dinâmico

Este projeto é um sistema de controlo de inventário desenvolvido para demonstrar competências em desenvolvimento Full Stack. A aplicação permite o gerenciamento completo de produtos (CRUD) com uma interface moderna e atualizações em tempo real via AJAX.

## 🔐 Credenciais de Acesso (Para Testes)

Para facilitar a avaliação, o sistema possui um usuário pré-configurado:
- **Usuário:** `admin`
- **Senha:** `123`

## 🚀 Tecnologias e Conceitos Aplicados

O projeto utiliza tecnologias fundamentais de mercado, focando em segurança e organização:

- **Back-end:** PHP 8.x estruturado com funções reutilizáveis em `functions.php`.
- **Banco de Dados:** MySQL com relacionamentos (Produtos e Categorias).
- **Front-end:** HTML5, CSS3 personalizado (`style.css`) e Bootstrap 5.
- **Interatividade:** JavaScript Vanilla (`script.js`) e **AJAX (Fetch API)** para comunicação assíncrona com a `api.php`.

## 🛠️ Diferenciais Técnicos

* **Consultas SQL:** Uso de `LEFT JOIN` para relacionar tabelas e `GROUP BY` para estatísticas de stock.
* **Segurança:** Uso de **PDO Prepared Statements** para prevenir *SQL Injection*.
* **Sanitização:** Implementação de `htmlspecialchars()` e `filter_var()` para evitar vulnerabilidades de *XSS*.
* **UX/UI:** Filtros por categoria e pesquisa por nome processados sem recarregar a página.

## 📂 Estrutura do Projeto

* `index.php`: Dashboard principal.
* `form_produto.php`: Formulário para Cadastro e Edição.
* `api.php`: Endpoint que processa pedidos AJAX e retorna JSON.
* `functions.php`: Lógica de negócio (CRUD e Estatísticas).
* `config.php`: Configuração da ligação PDO ao banco de dados `testesm`.

## 📖 Como Instalar

1. Clone este repositório para a sua pasta `htdocs`.
2. Importe o arquivo SQL da pasta `/sql` no seu **PHPMyAdmin**.
3. Verifique as credenciais no `config.php`.
4. Aceda a `localhost/nome-da-pasta` no navegador.
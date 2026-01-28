
window.onload = function() {
    buscarProdutos();
    buscarEstatisticas();
};


function buscarProdutos() {
    
    var nome = document.getElementById("buscaNome").value;
    var categoria = document.getElementById("filtroCategoria").value;

    
    var url = "api.php?acao=listar&busca=" + nome + "&categoria=" + categoria;

    
    fetch(url)
        .then(function(resposta) {
            return resposta.json(); 
        })
        .then(function(lista) {
            desenharTabela(lista); 
        })
        .catch(function(erro) {
            console.log("Erro ao carregar produtos: " + erro);
        });
}


function desenharTabela(produtos) {
    var corpoTabela = document.getElementById("tabelaProdutos");
    corpoTabela.innerHTML = ""; 

    if (produtos.length == 0) {
        corpoTabela.innerHTML = "<tr><td colspan='6'>Nenhum produto encontrado.</td></tr>";
        return;
    }

    
    for (var i = 0; i < produtos.length; i++) {

var p = produtos[i];


var linha = "<tr>" +
    "<td>" + p.id + "</td>" +
    "<td><strong>" + p.nome + "</strong></td>" + 
  
    "<td><span class='badge bg-success'>" + p.nome_categoria + "</span></td>" + 
    "<td>R$ " + p.preco + "</td>" +
    "<td>" + p.quantidade + " un</td>" +
    "<td>" +
        "<a href='form_produto.php?id=" + p.id + "' class='btn btn-sm btn-warning'>Editar</a> " +
        "<button onclick='deletarProduto(" + p.id + ")' class='btn btn-sm btn-danger'>Excluir</button>" +
    "</td>" +
"</tr>";

        corpoTabela.innerHTML += linha; 
    }
}


function deletarProduto(id) {
    if (confirm("Deseja realmente excluir este produto?")) {
       
        var dados = new FormData();
        dados.append('id', id);

        fetch('api.php?acao=excluir', {
            method: 'POST',
            body: dados
        })
        .then(function() {
            alert("Excluído com sucesso!");
            buscarProdutos(); 
            buscarEstatisticas(); 
        });
    }
}


function buscarEstatisticas() {
    fetch('api.php?acao=estatisticas')
        .then(function(res) { 
            return res.json(); 
        })
        .then(function(dados) {
            var divStats = document.getElementById("stats-container");
            divStats.innerHTML = ""; 

          
            for (var j = 0; j < dados.length; j++) {
                var s = dados[j];
                
                
                var cardHtml = "<div class='col-md-3'>" +
                    "<div class='card card-stats mb-3'>" +
                        "<small class='text-muted text-uppercase'>" + s.nome + "</small>" +
                        "<h4 class='mb-0'>" + s.total_produtos + " itens</h4>" +
                        "<small>Estoque total: " + (s.estoque_total || 0) + "</small>" +
                    "</div>" +
                "</div>";
                
                divStats.innerHTML += cardHtml;
            }
        })
        .catch(function(erro) {
            console.log("Erro nas estatísticas: " + erro);
        });
}
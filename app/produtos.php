<?php
include_once 'header.php';
?>

<section class="products">
    <h1 class="title">Todos os produtos</h1>
    <div class="box-container" id="products-container">
        <!-- Produtos serão carregados aqui via JavaScript -->
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Buscar produtos da API
    fetch('http://localhost/projeto/api/controllers/ProductController.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('products-container');
            
            if(data.records && data.records.length > 0) {
                data.records.forEach(product => {
                    const productBox = document.createElement('div');
                    productBox.className = 'box';
                    
                    productBox.innerHTML = `
                        <div class="image">
                            <img src="${product.imagem}" alt="${product.nome}">
                        </div>
                        <div class="content">
                            <h3>${product.nome}</h3>
                            <div class="author">${product.autor}</div>
                            <div class="genre">${product.genero}</div>
                            <div class="price">R$ ${product.preco.toFixed(2)}</div>
                            <div class="quantity">Quantidade: ${product.quantidade}</div>
                            <div class="actions">
                                <a href="editar.php?id=${product.id}" class="btn">Editar</a>
                                <button class="btn delete-btn" data-id="${product.id}">Excluir</button>
                            </div>
                        </div>
                    `;
                    
                    container.appendChild(productBox);
                });
                
                // Adicionar eventos de delete
                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const productId = this.getAttribute('data-id');
                        
                        swal({
                            title: "Tem certeza?",
                            text: "Você não poderá reverter isso!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if(willDelete) {
                                fetch('http://localhost/projeto/api/controllers/ProductController.php', {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({ id: productId })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if(data.message) {
                                        swal("Sucesso!", data.message, "success")
                                        .then(() => location.reload());
                                    }
                                })
                                .catch(error => {
                                    swal("Erro!", "Não foi possível excluir o produto.", "error");
                                });
                            }
                        });
                    });
                });
            } else {
                container.innerHTML = '<p class="empty">Nenhum produto encontrado</p>';
            }
        })
        .catch(error => {
            console.error('Erro ao buscar produtos:', error);
            document.getElementById('products-container').innerHTML = '<p class="empty">Erro ao carregar produtos</p>';
        });
});
</script>

<?php
include_once 'footer.php';
?>
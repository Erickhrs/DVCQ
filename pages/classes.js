export default () =>{
    const container = document.createElement('div');
    const template = `
    <div class="container">
        <h1>404</h1>
        <p>Página Não Encontrada</p>
        <a href="/">Voltar para a Página Inicial</a>
    </div>
    <style>
    .container {
        text-align: center;
    }
    h1 {
        font-size: 6rem;
        margin: 0;
    }
    p {
        font-size: 1.5rem;
        margin: 0.5rem 0 2rem;
    }
    .container a {
        display: inline-block;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        color: white;
        background-color: #4CAF50;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .container a:hover {
        background-color: #45a049;
    }
</style>
    `

    container.innerHTML = template;
    return container;
}
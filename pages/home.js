export default () =>{
    const container = document.createElement('div');
    const template = `
    <nav id="home-menu">
    <ul>
        <li><a href=""><ion-icon name="rocket-outline"></ion-icon> Ambiente de estudos</a></li>
        <li><a href=""><ion-icon name="document-text-outline"></ion-icon> Cadernos e Simulados</a></li>
        <li><a href=""><ion-icon name="stats-chart-outline"></ion-icon> Meu Desempenho</a></li>
    </ul>
    <main id="home-menu-root">

    </main>
</nav>
<style>
#home-menu ul{
    display: flex;
    flex-direction: row;
    justify-content:space-between;
    padding: 20px 35px 20px 35px;
    border-radius: px;
    background-color: var(--logo-blue);
  }
  #home-menu li{
      list-style: none;
      cursor: pointer;
    }
    #home-menu  li a{
      text-decoration: none;
      cursor: pointer;
      color: rgb(255, 255, 255);
      font-weight: bold;
    }
    #home-menu li a:hover{
      color: var(--green-todbg);
    }
</style>
    `
    container.innerHTML = template;
    return container;
}
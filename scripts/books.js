document.getElementById('searchInput').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    let notebookItems = document.querySelectorAll('.notebook-item');

    notebookItems.forEach(function(item) {
        let title = item.querySelector('p').textContent.toLowerCase();
        if (title.includes(filter)) {
            item.style.display = ''; // Mostrar o item
        } else {
            item.style.display = 'none'; // Ocultar o item
        }
    });
});
const urlPath = window.location.pathname;
const fileName = urlPath.substring(urlPath.lastIndexOf('/') + 1);

switch (fileName) {
    case 'index.php':
        document.getElementById("home").style.color = "#80ad64"; 
        break;
    case 'questions.php':
        document.getElementById("questions").style.color = "#80ad64"; 
        break;
    case 'classes.php':
        document.getElementById("classes").style.color = "#80ad64"; 
        break;
    case 'exams.php':
        document.getElementById("exams").style.color = "#80ad64"; 
        break;
    case 'disciplines.php':
        document.getElementById("disciplines").style.color = "#80ad64"; 
        break;
}
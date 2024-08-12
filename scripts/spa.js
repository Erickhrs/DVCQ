import home from "../pages/home.js"
import questions from "../pages/questions.js"
import subjects from "../pages/disciplines.js"
import classes from "../pages/classes.js"
import exams from "../pages/exams.js"

const init = () => {
    window.addEventListener("hashchange", () => {
        main.innerHTML = ""
        switch (window.location.hash) {
            case "":
               main.appendChild(home());
                break;
            case "#home":
                main.appendChild(home());
                break;
            case "#questions":
                main.appendChild(questions());
                break;
            case "#disciplines":
                main.appendChild(subjects());
                break;
            case "#classes":
                main.appendChild(classes());
                break;
            case "#exams":
                main.appendChild(exams());
                break;
        }
    })
}

const main = document.querySelector("#root");
window.addEventListener("load", function () {
  main.appendChild(home())
    init();
})
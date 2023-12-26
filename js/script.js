const Btn = document.querySelector("#show");
const comment = document.querySelector("#comment");
let click = 0;

Btn.addEventListener("click", () => {
    if (click == 0 ){
        comment.style.display = "block";
        Btn.firstChild.data = "Masquer les commentaires"
        click = 1;
    } else {
        comment.style.display = "none";
        Btn.firstChild.data = "Voir les commentaires"
        click = 0;
    }
})
window.addEventListener("load", function () {
    let sidebar = document.querySelector("#sidebar");
    sidebar.classList.toggle("close", screen.width < 960);
});

let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement;
        arrowParent.classList.toggle("showMenu");
    });
}
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu-alt-left");

sidebarBtn.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});

let btnClose = document.getElementById("btnClose");

btnClose.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});

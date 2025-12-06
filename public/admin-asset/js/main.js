// Click tog-show
if (document.querySelector(".tog-active")) {
    let togglesShow = document.querySelectorAll(".tog-active");
    togglesShow.forEach((e) => {
        e.addEventListener("click", (evt) => {
            let divActive = document.querySelector(
                e.getAttribute("data-active")
            );
            divActive.classList.toggle("active");
        });
    });
}

// print
if (
    document.getElementById("prt-content") &&
    document.getElementById("btn-prt-content")
) {
    let btnPrtContent = document.getElementById("btn-prt-content");
    btnPrtContent.addEventListener("click", printDiv);

    function printDiv() {
        let prtContent = document.getElementById("prt-content");
        newWin = window.open("");
        newWin.document.head.replaceWith(document.head.cloneNode(true));
        newWin.document.body.appendChild(prtContent.cloneNode(true));
        setTimeout(() => {
            newWin.print();
            newWin.close();
        }, 600);
    }
}

const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);
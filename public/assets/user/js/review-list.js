window.addEventListener("load", function () {
    const filterstar = this.document.querySelectorAll('.check-filterstar');

    [...filterstar].forEach((item) => item.addEventListener("click", function (i) {
        [...filterstar].forEach(itemlist => itemlist.classList.remove("active"));
        if (item.className != "check-filterstar active ") {
            item.className += " active";
        }
    })
    );
});

//Hiển thị phản hồi
function showRatingCmtChild(id) {
    var reply1 = document.getElementsByClassName(id + ' reply hide');
    reply1[0].className = reply1[0].className.replace(" hide", "");
    var reply2 = document.getElementsByClassName(id + ' childC-item hide');
    reply2[0].className = reply2[0].className.replace(" hide", "");
}

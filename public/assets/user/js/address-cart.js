const circlecheck = this.document.querySelectorAll('.choose-link');
const content = this.document.querySelectorAll('.choose-content');
const buttonselect = this.document.querySelectorAll('.cntry-district .btn-click button');
const buttonselectwards = this.document.querySelectorAll('.deli-address .wards button');
const select = this.document.querySelectorAll('.select');
const lilist = this.document.querySelectorAll('.choose-address ul li');


//Mã khuyến mãi
function maKhuyenMai() {
    var button = document.getElementById("myDIV");
    if (button.className == "usecode coupon-code singlebox") {
        var current1 = document.getElementsByClassName("coupon-code");
        var current2 = document.getElementsByClassName("applycode");
        current1[0].className += " active";
        current2[0].className += " active";
    } else {
        var current1 = document.getElementsByClassName("coupon-code");
        var current2 = document.getElementsByClassName("applycode");
        current1[0].className = current1[0].className.replace(" active", "");
        current2[0].className = current2[0].className.replace(" active", "");
    }
};


//Lựa chọn giao hàng hoặc nhận hàng tại cửa hàng
[...circlecheck].forEach((item) => item.addEventListener("click", function (i) {
    [...buttonselect].forEach(itemlist => itemlist.classList.remove("active"));
    [...buttonselectwards].forEach(itemlist => itemlist.classList.remove("active"));
    [...select].forEach(itemlist => itemlist.classList.remove("active"));
    [...select].forEach(itemlist => itemlist.style = "display: none;");
    [...circlecheck].forEach(itemlist => itemlist.classList.remove("current"));
    if (item.className != "choose-link current") {
        item.className += " current";
    }
    [...content].forEach(itemlist => itemlist.classList.remove("current"));
    var dataID = item.getAttribute('data-tab');
    var elements = document.getElementById(dataID);
    elements.className += " current";
})
);

[...lilist].forEach((item) => item.addEventListener("click", function (i) {
    [...lilist].forEach(itemlist => itemlist.classList.remove("active"));
    if (item.className != "active") {
        item.className += "active";
    }
})
);

[...buttonselect].forEach((item) => item.addEventListener("click", function (i) {
    if (item.className == "") {
        [...buttonselect].forEach(itemlist => itemlist.classList.remove("active"));
        [...buttonselectwards].forEach(itemlist => itemlist.classList.remove("active"));
        [...select].forEach(itemlist => itemlist.classList.remove("active"));
        [...select].forEach(itemlist => itemlist.style = "display: none;");
        item.className += "active";
        var dataID = item.getAttribute('data-button-id');
        var elements = document.getElementById(dataID);
        elements.className += " active";
        elements.style = "";
    }
    else {
        item.className = item.className.replace("active", "");
        var dataID = item.getAttribute('data-button-id');
        var elements = document.getElementById(dataID);
        elements.className = elements.className.replace(" active", "");
        elements.style = "display: none;";
    }
})
);


[...buttonselectwards].forEach((item) => item.addEventListener("click", function (i) {
    if (item.className == "") {
        [...buttonselectwards].forEach(itemlist => itemlist.classList.remove("active"));
        [...buttonselect].forEach(itemlist => itemlist.classList.remove("active"));
        [...select].forEach(itemlist => itemlist.classList.remove("active"));
        [...select].forEach(itemlist => itemlist.style = "display: none;");
        item.className += "active";
        var dataID = item.getAttribute('data-button-id');
        var elements = document.getElementById(dataID);
        elements.className += " active";
        elements.style = "";
    }
    else {
        item.className = item.className.replace("active", "");
        var dataID = item.getAttribute('data-button-id');
        var elements = document.getElementById(dataID);
        elements.className = elements.className.replace(" active", "");
        elements.style = "display: none;";
    }
})
);

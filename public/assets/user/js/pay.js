const li = this.document.querySelectorAll('.formality-pay-new>li');
const a = this.document.querySelector('.payment-method-new .refund-policy');
const popup = this.document.querySelector('.popup-hoantien');
const html = this.document.querySelector('html');
const btnclose = this.document.querySelector('.hoantienonline .row-ht a');
//Lựa chọn phương thức thanh toán
[...li].forEach((item) => item.addEventListener("click", function (i) {
    [...li].forEach(itemlist => itemlist.classList.remove("active"));
    if (item.className.endsWith('active') == false) {
        item.className += " active";
    }
})
);

//Xem chính sách hoàn tiền
a.onclick = function () {
    popup.className +=" active";
    html.style = "overflow: hidden;";
};

//Đóng xem chính sách
btnclose.onclick = function () {
    popup.className = popup.className.replace(" active", "");
    html.style = "overflow: auto;";
};


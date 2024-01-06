window.addEventListener("load", function () {
    //Slide chi tiết hình ảnh
    const tab = document.querySelectorAll(".item");
    const tabPic = document.querySelectorAll(".show-tab");
    var showTabActive = document.querySelector(".show-tab.active");
    var sliderStage = showTabActive.querySelector(".owl-stage");
    var sliderItems = showTabActive.querySelectorAll(".owl-item");
    const nextBtn = document.querySelectorAll("[data-next-id='showtab']");
    const prevBtn = document.querySelectorAll("[data-prev-id='showtab']");
    var sliderItemWidth = sliderItems[0].offsetWidth;
    var slidersLength = sliderItems.length;
    var positionX = 0;
    var index = 0;
    var counter = 0;
    showTabActive.querySelector(".counter").innerHTML = '(1/' + slidersLength + ')';

    [...nextBtn].forEach((item) => item.addEventListener("click", function (i) {
        changeSlide(1);
    })
    );

    [...prevBtn].forEach((item) => item.addEventListener("click", function (i) {
        changeSlide(-1);
    })
    );

    [...tab].forEach((item) => item.addEventListener("click", function (i) {
        var showTab = document.getElementById(item.id);
        if (showTab.className != 'item itemTab is-show-popup') {
            [...tab].forEach(itemlist => itemlist.classList.remove("active"));
            if (item.className != "item itemTab active ") {
                item.className += " active";
            }
            [...tabPic].forEach(itemlist => itemlist.classList.remove("active"));
            var dataID = showTab.getAttribute('data-gallery-id');
            var elements = document.querySelector("[data-gallery-id='" + dataID + "']");
            elements.className += " active";
            showTabActive = document.querySelector(".show-tab.active");;
            sliderStage = showTabActive.querySelector(".owl-stage");
            sliderItems = showTabActive.querySelectorAll(".owl-item");
            sliderItemWidth = sliderItems[0].offsetWidth;
            slidersLength = sliderItems.length;
            positionX = 0;
            index = 0;
            counter = 0;
            sliderStage.style = 'transform: translate3d(' + positionX + 'px, 0px, 0px); transition: all 0.25s ease 0s; width: ' + sliderItemWidth * slidersLength + 'px;';
            counter = index + 1;
            showTabActive.querySelector(".counter").innerHTML = '(' + counter + '/' + slidersLength + ')';
            var btnPrev = showTabActive.getElementsByClassName("owl-prev");
            btnPrev[0].className = btnPrev[0].className.replace(" disabled", "");
            btnPrev[0].className += " disabled";
            var btnNext = showTabActive.getElementsByClassName("owl-next");
            btnNext[0].className = btnNext[0].className.replace(" disabled", "");
        }
        else {
            var blockTab = document.querySelector('.block-tab');
            blockTab.className += " show";
            var root = document.getElementsByTagName('html')[0];
            root.className += 'overflow-hidden';

            var dataID = showTab.getAttribute('data-gallery-id');
            var elements = document.querySelectorAll("[data-gallery-id='" + dataID + "']");
            elements[1].className += " active";
            elements[2].className += " active";
        }
    })
    );

    function changeSlide(direction) {
        if (direction === 1) {
            positionX = positionX - sliderItemWidth;
            sliderStage.style = 'transform: translate3d(' + positionX + 'px, 0px, 0px); transition: all 0.25s ease 0s; width: ' + sliderItemWidth * slidersLength + 'px;';
            index++;
            counter = index + 1;
            showTabActive.querySelector(".counter").innerHTML = '(' + counter + '/' + slidersLength + ')';
            if (index >= slidersLength - 1) {
                var btn = showTabActive.getElementsByClassName("owl-next");
                btn[0].className += " disabled";
            }
            else {
                var btn = showTabActive.getElementsByClassName("owl-prev");
                btn[0].className = btn[0].className.replace(" disabled", "");
            }
        } else if (direction === -1) {
            positionX = positionX + sliderItemWidth;
            sliderStage.style = 'transform: translate3d(' + positionX + 'px, 0px, 0px); transition: all 0.25s ease 0s; width: ' + sliderItemWidth * slidersLength + 'px;';
            index--;
            counter = counter - 1;
            showTabActive.querySelector(".counter").innerHTML = '(' + counter + '/' + slidersLength + ')';
            if (index <= 0) {
                var btn = showTabActive.getElementsByClassName("owl-prev");
                btn[0].className += " disabled";
            }
            else {
                var btn = showTabActive.getElementsByClassName("owl-next");
                btn[0].className = btn[0].className.replace(" disabled", "");
            }
        }
    }


    //tab khối
    const btnClose = this.document.querySelector('.btn-closemenu');
    const tabitem = this.document.querySelectorAll('.tab-item');
    const content = this.document.querySelectorAll('.content-t');
    btnClose.addEventListener("click", function (i) {
        var blockTab = document.querySelector('.block-tab');
        blockTab.className = blockTab.className.replace(" show", "");
        var root = document.getElementsByTagName('html')[0];
        root.className = root.className.replace("overflow-hidden", "");
        [...tabitem].forEach(itemlist => itemlist.classList.remove("active"));
        [...content].forEach(itemlist => itemlist.classList.remove("active"));
    });

    [...tabitem].forEach((item) => item.addEventListener("click", function (i) {
        [...tabitem].forEach(itemlist => itemlist.classList.remove("active"));
        if (item.className != "tab-item active ") {
            item.className += " active";
        }
        [...content].forEach(itemlist => itemlist.classList.remove("active"));
        var dataID = item.getAttribute('data-tab-id');
        console.log(dataID);
        var elements = document.querySelectorAll("[data-tab-id='" + dataID + "']");
        elements[1].className += " active";
        console.log(elements);
    })
    );


    //box scroll
    var sliderStageBox = document.querySelector("[data-box-id='boxscroll']");
    var sliderItemsBox = sliderStageBox.querySelectorAll(".owl-item");
    const next = document.querySelector("[data-next-id='btnboxscroll']");
    const prev = document.querySelector("[data-prev-id='btnboxscroll']");
    var sliderItemBoxWidth = sliderItemsBox[0].offsetWidth;
    var slidersBoxLength = sliderItemsBox.length / 5;
    var X = 0;
    var i = 0;
    if (sliderItemsBox.length > 5) {
        next.addEventListener("click", function () {
            changeSlideBox(1);
        });
        prev.addEventListener("click", function () {
            changeSlideBox(-1);
        });
    }



    function changeSlideBox(direction) {
        if (direction === 1) {
            console.log(i >= slidersBoxLength - 1);
            if (i >= slidersBoxLength - 1) {
                i = 0;
                X = 0;
                sliderStageBox.style = 'width: 2640px; left: 0px; display: block; transition: all 1000ms  ease 0s; transform: translate3d(' + X + 'px, 0px, 0px);'
            }
            else {
                X = X - sliderItemBoxWidth * 5;
                sliderStageBox.style = 'width: 2640px; left: 0px; display: block; transition: all 200ms ease 0s; transform: translate3d(' + X + 'px, 0px, 0px);'
                i++;
            }
            // X = X - sliderItemBoxWidth;
            // sliderStageBox.style = 'transform: translate3d(' + X * 5 + 'px, 0px, 0px); transition: all 1.25s ease 0s; width: ' + sliderItemBoxWidth * slidersBoxLength + 'px;';
            // i++;
            // if (i == 1) {
            //     next.className += " disabled";
            //     prev.className = prev.className.replace(" disabled", "");
            // }
        } else if (direction === -1) {
            if (i <= 0) {
                i = slidersBoxLength - 1;
                X = X - sliderItemBoxWidth * 5;
                sliderStageBox.style = 'width: 2640px; left: 0px; display: block; transition: all 1000ms ease 0s; transform: translate3d(' + X + 'px, 0px, 0px);'
            }
            else {
                X = X + sliderItemBoxWidth * 5;
                sliderStageBox.style = 'width: 2640px; left: 0px; display: block; transition: all 200ms ease 0s; transform: translate3d(' + X + 'px, 0px, 0px);'
                i--;
            }
            // X = X + sliderItemBoxWidth;
            // sliderStageBox.style = 'transform: translate3d(' + X * 5 + 'px, 0px, 0px); transition: all 1.25s ease 0s; width: ' + sliderItemBoxWidth * slidersBoxLength + 'px;';
            // i--;
            // if (i == 0) {
            //     prev.className += " disabled";
            //     next.className = next.className.replace(" disabled", "");
            // }
        }
    }
});


//Hiển thị theo block
function showBlockTabUnBox() {
    var blockTab = document.querySelector('.block-tab');
    blockTab.className += " show";
    var root = document.getElementsByTagName('html')[0];
    root.className += 'overflow-hidden';
    var elements = document.querySelectorAll("[data-gallery-id='unbox-gallery']");
    elements[1].className += " active";
    elements[2].className += " active";
}

function showBlockTabSpecification() {
    var blockTab = document.querySelector('.block-tab');
    blockTab.className += " show";
    var root = document.getElementsByTagName('html')[0];
    root.className += 'overflow-hidden';
    var elements = document.querySelectorAll("[data-gallery-id='specification-gallery']");
    elements[1].className += " active";
    elements[2].className += " active";
}

function showBlockTabArticle() {
    var blockTab = document.querySelector('.block-tab');
    blockTab.className += " show";
    var root = document.getElementsByTagName('html')[0];
    root.className += 'overflow-hidden';
    var elements = document.querySelectorAll("[data-gallery-id='article-gallery']");
    elements[1].className += " active";
    elements[2].className += " active";
}



//Hiển thị phản hồi
function showRatingCmtChild(id) {
    var reply1 = document.getElementsByClassName(id + ' reply hide');
    reply1[0].className = reply1[0].className.replace(" hide", "");
    var reply2 = document.querySelectorAll('.' + id + '.childC-item.hide');
    console.log(reply2);
    if (reply2.length > 0) {
        [...reply2].forEach(itemlist => itemlist.classList.remove("hide"));
    }
}

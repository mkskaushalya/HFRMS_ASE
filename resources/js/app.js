import.meta.glob(['../img/*.*']);

import './bootstrap';
import Alpine from 'alpinejs';
import jQuery from 'jquery';
import 'daterangepicker';
import 'daterangepicker/daterangepicker.css';


// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle';

// import styles bundle
import 'swiper/css/bundle';


window.$ = jQuery;

window.Alpine = Alpine;

Alpine.start();

var reviewSwiper = new Swiper(".reviewSwiper", {
    direction: "vertical",
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

var hallSwiper = new Swiper(".hallSwiper", {
    slidesPerView: 4,
    spaceBetween: 20, autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

var swiper = new Swiper(".mySwiper", {
    loop: true,
    spaceBetween: 8,
    slidesPerView: 5,
    freeMode: true,
    watchSlidesProgress: true,
});
var swiper2 = new Swiper(".mySwiper2", {
    loop: true,
    spaceBetween: 10,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    thumbs: {
        swiper: swiper,
    },
});


/////////////////////////////////////////////////////////////////////////////////////

var booking_date = document.getElementById('booking_date');
var hallAvailabilityForm = document.getElementById('hall-availability-form');
var start_time = document.getElementById('start_time');
var end_time = document.getElementById('end_time');
var checkAvailabilitySubmitBtn = document.getElementById('checkAvailabilitySubmitBtn');
var hallAvailability = document.getElementById('hall-availability-span');
var actionURL = document.getElementById('hallBookingActionURL').value;
var hallShowActionURL = document.getElementById('hallShowActionURL').value + '#hall-availability';

if (hallAvailabilityForm.method.toUpperCase() === 'GET') {
    hallAvailabilityForm.action = hallShowActionURL;
} else {
    hallAvailabilityForm.action = actionURL;
}

function changeAvailability() {
    checkAvailabilitySubmitBtn.innerHTML = "Check";
    hallAvailability.style.display = "none";
    hallAvailabilityForm.method = "GET";
    hallAvailabilityForm.action = hallShowActionURL;
}

booking_date.addEventListener('change', function () {
    changeAvailability();
});

start_time.addEventListener('change', function () {
    changeAvailability();
});

end_time.addEventListener('change', function () {
    changeAvailability();
});


////////////////////////////////////////////////////////////////////////////////


var reviewActionEdit = document.querySelectorAll('.review_action_edit');

var reviewEditFormBox = document.querySelector('#review-edit-form');
var reviewEditFormCloseButton = document.querySelector('#review-edit-form-close-btn');

var reviewSubmitForm = document.querySelector('#review-submit-form');
var reviewEditFormHall = document.querySelector("form[name='reviewEditForm'] input[name='hall_id']");
var reviewEditForm = document.querySelector("form[name='reviewEditForm']");
var reviewEditFormTitle = document.querySelector("form[name='reviewEditForm'] input[name='title']");
var reviewEditFormMessage = document.querySelector("form[name='reviewEditForm'] textarea[name='message']");
var reviewEditFormId = document.querySelector("form[name='reviewEditForm'] input[name='review_id']");

var reviewActionDots = document.querySelectorAll('.action-btn-sec');


reviewActionDots.forEach((element) => {
    element.addEventListener('click', (e) => {
        element.querySelector('.action-dropdown').classList.add('active');

        setTimeout(() => {
            element.querySelector('.action-dropdown').classList.remove('active');
        }, 5000);

    });
});
reviewActionEdit.forEach((element) => {
    element.addEventListener('click', (e) => {
        e.preventDefault();
        let reviewId = e.target.getAttribute('data_review_id');
        let reviewTitle = e.target.getAttribute('data_review_title');
        let reviewMessage = e.target.getAttribute('data_review_message');
        let reviewRating = e.target.getAttribute('data_review_rating');
        let reviewFormActionURL = e.target.getAttribute('data_review_form_action');
        console.log(reviewId, reviewTitle, reviewMessage, reviewRating, reviewEditFormHall.value);
        reviewEditFormId.value = reviewId;
        reviewEditFormTitle.value = reviewTitle;
        reviewEditFormMessage.value = reviewMessage;
        var reviewEditFormRating1 = document.querySelector("#rating1edit");
        var reviewEditFormRating2 = document.querySelector("#rating2edit");
        var reviewEditFormRating3 = document.querySelector("#rating3edit");
        var reviewEditFormRating4 = document.querySelector("#rating4edit");
        var reviewEditFormRating5 = document.querySelector("#rating5edit");
        reviewEditFormRating1.checked = false;
        reviewEditFormRating2.checked = false;
        reviewEditFormRating3.checked = false;
        reviewEditFormRating4.checked = false;
        reviewEditFormRating5.checked = false;

        if (reviewRating === "1") {
            reviewEditFormRating1.checked = true;
        } else if (reviewRating === "2") {
            reviewEditFormRating2.checked = true;
        } else if (reviewRating === "3") {
            reviewEditFormRating3.checked = true;
        } else if (reviewRating === "4") {
            reviewEditFormRating4.checked = true;
        } else if (reviewRating === "5") {
            reviewEditFormRating5.checked = true;
        }

        reviewEditForm.action = reviewFormActionURL;


        reviewEditFormBox.classList.remove('hidden');
        reviewEditFormBox.scrollIntoView();
        location.href = "#review-edit-form";
        reviewSubmitForm.classList.add('hidden');

    });
});

reviewEditFormCloseButton.addEventListener('click', (e) => {
    e.preventDefault();
    reviewEditFormBox.classList.add('hidden');
    reviewSubmitForm.classList.remove('hidden');
});

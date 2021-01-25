/* 
======================
    jQuery  
======================
*/
$(function () {

    'user strict';
    
    $('[placeholder]').on("focus", function () {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    $('.confirm').on("click", function () {
       return confirm("Are You Sure You Want To Delete?");
    });

});



//Active Navbar on scroll
const nav = document.getElementById('navscroll');
const upperBar = document.getElementById('UpperBar');
const intersecting = document.getElementById('navIntersecting');
const intersectInIndex = document.getElementById("indexIntersect");
const intersectingCat = document.getElementById('navIntersect');
const intersectInCat = document.getElementById("catIntersect");
const intersectInItems = document.getElementById("itemsIntersect");

//=========================================
    /*
    Function Explanation:
    this is for the displaying navbar on scroll for each page on the website
    STEPS:
        - get empty div for each page and position it on the middle of the page this if for each page
        - if statement for defining this div for each page so the below function can intersect it on each page 
    */
//=========================================
function getObserver() {
    if (intersectInIndex !== null) {

        let observer = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    nav.classList.add('scrolling');
                    upperBar.classList.add('upperBarHid')
                } else {
                    nav.classList.remove('scrolling');
                    upperBar.classList.remove('upperBarHid');
                }
            });
        });

        return observer.observe(intersecting);
        
    } else if (intersectInCat !== null) {
        let observerCat = new IntersectionObserver((entries, observerCat) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    nav.classList.add('scrolling');
                    upperBar.classList.add('upperBarHid')
                } else {
                    nav.classList.remove('scrolling');
                    upperBar.classList.remove('upperBarHid');
                }
            });
        });
        return observerCat.observe(intersectingCat);

    } else if (intersectInItems !== null) {
        let observerCat = new IntersectionObserver((entries, observerCat) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    nav.classList.add('scrolling');
                    upperBar.classList.add('upperBarHid')
                } else {
                    nav.classList.remove('scrolling');
                    upperBar.classList.remove('upperBarHid');
                }
            });
        });
        return observerCat.observe(intersectInItems);
    }
}
getObserver();
/*
-------------------------------------------------
=> active login page in click
=> Ajax login
-------------------------------------------------
*/
$(function () {
    let rem = null;
    rem = $('#login').remove();

    $('.logClick').on('click', function (e) {

        e.preventDefault();

        rem.prependTo('body');
        $('body').css('overflow', 'hidden');

        $('.closeLogin, .screen-overlay').on('click', function () {
            rem.remove();
            $('body').css('overflow', 'visible');
        });
        $(document).on('keydown', function(key) {

            if (key.which == 27) {
                rem.remove();
                $('body').css('overflow', 'visible');
            }
        });

        /*
        -------------------------------------------------
            Login Ajax requests
        -------------------------------------------------
        */
        $('#login-req').on('submit', function (e) {

            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: $(this).serialize() + "&action=login",
                success: function(result) {
                    
                    //this is to handel coming request of the user exists the coming data will echo that userExists 
                    if (result == "userExists") {
                        
                        //when user exists will be directed to the homepage
                        window.location.replace("index.php");
                    } else {
                        //this is to handel errors of the user didn't exists in the DB
                        $('.errorLogin').fadeIn().html(result);
                        setTimeout(function () {
                            $('.errorLogin').fadeOut('slow');
                        }, 5000);
                    }
                },
                complete: function(status) {
                    $('#login-req').trigger('reset');
                }
            });
        });

        /*
        -------------------------------------------------
            signUp Ajax requests
        -------------------------------------------------
        */
       $("#signUpForm").on('submit', function (e) {
        
        //prevent the submit bottom from sending the data as it will be validate it first
        e.preventDefault();

        let formDataRegister = $('#signUpForm').serialize(); //this it to put incoming data values in URL encoded text string

        $.ajax({

            url: $(this).attr('action'),
            method: 'POST',
            data: formDataRegister + "&action=register", //this is the data that I will send to in server request
            
            //this result represent the data I will receive from the request sent, and this data coming from the login.php
            success: function (result) { 
                $('form').trigger("reset"); //this is to reset the form after success
                $('#resError').html(result);//here I put all coming data in the div that has id result
                $('.error-wrapper').fadeIn();
                setTimeout(function () {
                    $('.error-wrapper').fadeOut('slow');
                }, 4000);
            }
        })
    });

    });
});




//login and sign up Form 
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const loginContainer = document.getElementById('logContainer');

function getSignIn() {

    if (signInButton !== null && signUpButton !== null) {

        signUpButton.addEventListener('click', () => {
            loginContainer.classList.add("right-panel-active");
        });
        
        signInButton.addEventListener('click', () => {
            loginContainer.classList.remove("right-panel-active");
        });
        
    }

}
getSignIn();


const card = document.querySelectorAll(".card-item-ad");


card.forEach(each => {
    each.addEventListener('mouseenter', () => {
       
        let icons = each.childNodes[3].lastElementChild.lastElementChild;
        let cardBtn = each.childNodes[3].lastElementChild.firstElementChild.lastElementChild;
        
        let arrIcons = [];

        arrIcons.push(icons.children[0], icons.children[1]);
        // console.log(arrIcons[0]);
        
        arrIcons.forEach(i => {

            i.classList.add("activeIcons");
        });
        if (icons.children[0].classList.contains("activeIcons")) {
            cardBtn.classList.add("changBtnClr");
        }
    });
    each.addEventListener('mouseleave', () => {
       
        let icons = each.childNodes[3].lastElementChild.lastElementChild;
        let cardBtn = each.childNodes[3].lastElementChild.firstElementChild.lastElementChild;
        
        let arrIcons = [];

        arrIcons.push(icons.children[0], icons.children[1]);
        // console.log(arrIcons[0]);
        
        arrIcons.forEach(i => {

            i.classList.remove("activeIcons");
        });
        if (!icons.children[0].classList.contains("activeIcons")) {
            cardBtn.classList.remove("changBtnClr");
        }
    });
});


//create alive preview for new ad page

$(function () {

    function livePreview(live, preview) {

        $(live).on('keyup', function () {

            $(preview).text($(this).val());
        })
    }

    livePreview('#live-title', '#pre-title');
    livePreview('#live-price', '#pre-price');
})


// ajax calls for add new item form
$(function () {

    //validate Item name
    $('.Item_newName').on('blur', function () {

        $.ajax({
            url: 'validations/item_name.php',
            type: 'POST',
            data: 'itemName=' + $(this).val(),
            success: function(data) {
                $('.validate_newItem').fadeIn().html(data);
            }
        })
    })

    $('#createItem').on('submit', function (e) {

        e.preventDefault();

        let formVals = $(this).serialize();

        $.ajax({

            url: 'validations/newItem_validation.php',
            type: 'POST',
            data: formVals + '&action=createItem',
            success: function (data) {
                $('#createAddError').html(data);
                $('#createAddError div').fadeIn('slow');
                setTimeout(function () {
                    $('#createAddError div').fadeOut('slow');
                }, 5000);
            },

            //this after the request is complete
            complete: function (status) {

                //this to identify the responseText weather is success or not if the response has a success the form will be reset
                $.map(status, function (key, val) {
                   
                    let response = status.responseText;
                    
                    if (response.includes('error-wrapper-success')) {
                        
                        $('#createItem').trigger('reset');
                        $('.validate_newItem').fadeOut();
                    }
                });
            }
        });
    });
});


const detectPageItem = document.querySelector('title');


function productImg() {
    if (detectPageItem.textContent == "Items") {
        document.getElementById('galleryImgs').ondblclick = function (event) {
            event = event || window.event
            var target = event.target || event.srcElement
            var link = target.src ? target.parentNode : target
            var options = { index: link, event: event }
            var links = this.getElementsByTagName('a')
            blueimp.Gallery(links, options)
          }
    }
    
}
productImg();

function productMainImg() {
    if (detectPageItem.textContent == "Items") {
        document.getElementById('mainImg').onclick = function (event) {
            event = event || window.event
            var target = event.target || event.srcElement
            var link = target.src ? target.parentNode : target
            var options = { index: link, event: event }
            var links = this.getElementsByTagName('a')
            blueimp.Gallery(links, options)
          }
    }
}
productMainImg();

$(function () {
    
    $('#galleryImgs a').on('click', function (e) {

        e.preventDefault();

        let mainImg = $('#mainImg a img');
        let mainImgHref = $('#mainImg a');

        mainImg.removeAttr('src');
        mainImgHref.removeAttr('href');

        let replaceImg = $(this).find('img').attr('src');

        mainImg.attr('src', replaceImg);
        mainImgHref.attr('href', replaceImg);

        //active class
        $(this).siblings().removeClass('active');

        $(this).addClass('active');
        
    })
})

$(function () {
    $(".cart-qty-btn").on("click", function() {

        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
      
        if ($button.hasClass('plus')) {
            var newVal = parseFloat(oldValue) + 1;
          } else {
         // Don't allow decrementing below zero
          if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
          } else {
            newVal = 0;
          }
        }
      
        $button.parent().find("input").val(newVal);
      });
})


$(function() {
    $('#per-rate').barrating({
      theme: 'fontawesome-stars',
    });
 });

 //activate products slider for items
 const myProductsGlid = document.querySelector('.myProducts');
 const glideAsideGlid = document.querySelector('.glide-aside-fe');
 const glideConfig = {
    type: 'slider',
    perView: 5,
    gap: 0,
    // autoplay: 6000,
    breakpoints: ({
        600: { perView: 1 },
        1200: { perView: 3 }
      })
 };
 
 if (myProductsGlid) {
     
    let glid = new Glide('.myProducts', glideConfig);
    glid.mount();
 }

 if (glideAsideGlid) {
    const glideConfigAside = {
        type: 'slider',
        perView: 1,
        gap: 0,
     };
     let glid2 = new Glide('.glide-aside-fe', glideConfigAside);
     glid2.mount();
 }
 

 
 $(function () {
    $('#Add-New-Rev').on('submit', function (e) {

        e.preventDefault();

        let formVals = $(this).serialize();

        $.ajax({

            url: $(this).attr('action'),
            type: 'POST',
            data: formVals + "&comment=newReview",
            success: function (data) {
                
                $('#successOrFail-MSG').fadeIn('slow').html(data);
                
                setTimeout(function () {
                    $('#successOrFail-MSG').fadeOut('slow');
                }, 10000);
            },

            //this after the request is complete
            complete: function (status) {

                $('#Add-New-Rev').trigger('reset');

                //this to identify the responseText weather is success or not if the response has a success the form will be reset
                // $.map(status, function (key, val) {
                   
                //     // let response = status.responseText;
                    
                //     // if (response.includes('error-wrapper-success')) {
                        
                //     //     $('#createItem').trigger('reset');
                //     //     $('.validate_newItem').fadeOut();
                //     // }
                // });
            }
        });
    });
 })


 /*------------------------------------------------------------------
this is to put starts rating depend on the number coming from the DB
-------------------------------------------------------------------*/
function theItemTotalRate() {

    let totalRate = document.querySelectorAll('.itemRate');

    totalRate.forEach(elr => {

        if (elr.dataset.itemrate > 0) {
            for (let i = 1; i <= elr.dataset.itemrate; i++) {

                stars = document.createElement('i');
                 
                stars.setAttribute('class', 'fas fa-star');
         
                elr.appendChild(stars);
             }
    
             let rateRemain = 5 - elr.dataset.itemrate;
    
            //this is to display rest of stars ratings
            for (let i = 1; i <= rateRemain; i++) {
    
                reStars = document.createElement('i');
                
                reStars.setAttribute('class', 'far fa-star');
        
                elr.appendChild(reStars);
            }
        }
        
    });
}

theItemTotalRate();

function userRate() {
    let rateNum = document.querySelectorAll('.itemRating');

    
    rateNum.forEach(el => {

        let remainEl = 5 - el.dataset.rate;

        for (let i = 1; i <= el.dataset.rate; i++) {

            stars = document.createElement('i');
    
            stars.setAttribute('class', 'fas fa-star fa-sm');
    
            el.appendChild(stars);
        }

        //this is to display rest of stars ratings
        for (let i = 1; i <= remainEl; i++) {

            reStars = document.createElement('i');
    
            reStars.setAttribute('class', 'far fa-star fa-sm');
    
            el.appendChild(reStars);
        }
    });
}
userRate();

//this is to display only 3 comments
$(function () {

    //show all review will work only if there are more than 3 reviews
    function showAllRevBtn () {
        if ($('.comment').length < 3) {

            $('.all-cm').hide();
        } else {
            $('.all-cm').show();
        }
    }

    showAllRevBtn();

    function displayAllRev() {

        $('.comment').slice(0, 3).addClass('active-cm');//this is will activate first three comments only

        $('.see-all-cm').on('click', function (e) {//this is on click will display rest of the comments

            e.preventDefault();

            $('.comment:gt(2)').fadeToggle('slow').toggleClass('active-cm');

            $(this).toggleClass('active-All-cm');
        });
    }
    displayAllRev();


    //this is only if there is now reviews to be displayed
    function ifNoReviews() {

        if ($('.comment').length == 0) {

           $('.ifNoRev').show();
        } else {
            $('.ifNoRev').hide();
        }
    }

    ifNoReviews();
})


//this is display sidebar on click "items page"
$(function () {

    let rightSidebr = $('.aside-info');

    function activateSidebar() {

        $('.side-ctrl-open').on('click', function () {
        
            //1-add class of show sidebar
            rightSidebr.addClass('showSideBar');

                if (rightSidebr.hasClass('showSideBar')) {

                //add the body overlay
                $('.item-overlay').removeClass('dis-none');

                //4- display the close icon
                $('.side-ctrl-close').removeClass('dis-none');

                //2- disable the open icon
                $(this).fadeOut('fast');
            }
        });
    }
    activateSidebar();

    function deactivateSidebar() {
     
        $('.side-ctrl-close, .item-overlay').on('click', function () {

            $('.side-ctrl-open').fadeIn();

            //add the body overlay
            $('.item-overlay').addClass('dis-none');
    
            //this on click will remove the sidebar class
            rightSidebr.removeClass('showSideBar');

            $('.side-ctrl-close').addClass('dis-none');
        });
    }

    deactivateSidebar();
});
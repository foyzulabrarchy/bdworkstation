

function openNav() {
  document.getElementById("mySidenav").style.width = "100%";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}





/////////////////////////////////////////////////////////////////////
// jQuery for page scrolling feature - requires jQuery Easing plugin
/////////////////////////////////////////////////////////////////////

$('.page-scroll').bind('click', function (event) {
    document.getElementById("mySidenav").style.width = "0";
    var $anchor = $(this);
    $('html, body').stop().animate({
        scrollTop: $($anchor.attr('href')).offset().top - 64
    }, 1500, 'easeInOutExpo');
    // event.preventDefault();
});

function showLogin() {
    //document.getElementById('signUp').style.display='none';
    document.getElementById('logIn').style.display = 'block';
}
function hideLogin() {
    document.getElementById('logIn').style.display = 'none';
}

function showSignup() {
    document.getElementById('logIn').style.display = 'none';
    document.getElementById('signUp').style.display = 'block';
}
function hideSignup() {
    document.getElementById('signUp').style.display = 'none';
}

function subcategory() {
    document.getElementById("zero").style.display = "none";
    var x = document.getElementById("category").value;
    if (x == "other") {
        var i = 0;
        for (i = 1; i <= 31; i++) {
            var j = document.getElementById(i);
            if (j) {
                document.getElementById(i).style.display = "none";
            }
        }
        document.getElementById('zero2').style.display = "none";
        for (k = 236; k < 500; k++) {
            var m = document.getElementById(k);
            if (m) {
                document.getElementById(k).style.display = "none";
            }
        }
        document.getElementById(x).style.display = "none";
    }
    else {
        document.getElementById("other").style.display = "none";
        x = parseInt(x);
        console.log("Find Sub Category" + x);
        var i = 0;
        for (i = 1; i <= 31; i++) {
            var j = document.getElementById(i);
            if (j) {
                if (x != i) {
                    document.getElementById(i).style.display = "none";
                }
                else {
                    document.getElementById(i).style.display = "block";
                    document.getElementById("zero2").style.display = "none";
                    var l = document.getElementById(i).value;
                    l = parseInt(l);
                    var k;
                    for (k = 236; k < 500; k++) {
                        console.log("Find Services" + l);
                        var m = document.getElementById(k);
                        if (m) {
                            console.log("Existing " + l);
                            if (l != k) {
                                document.getElementById(k).style.display = "none";
                            }
                            else {
                                document.getElementById(k).style.display = "block";
                            }
                        }
                    }

                }
            }

        }
    }

}

function formSubCategoryShow() {
    var x = document.getElementById("formCategory").value;
    console.log("Find Sub Category" + x);
    var i = 0;
    for (i = 1; i <= 31; i++) {
        var j = document.getElementById(i);
        if (j) {
            if (x != i) {
                document.getElementById(i).style.display = "none";
            }
            else {
                document.getElementById(i).style.display = "block";
            }
        }

    }
}

function propLiHand(k) {  //Proposal List Handle
    if (k == 1) {
        document.getElementById("proposalLists").style.display = "block";
    } else {
        document.getElementById("proposalLists").style.display = "none";
    }
}

// Job Image Handle
function jobImgHand(k) {  //Proposal List Handle
    if (k == 1) {
        document.getElementById("jobImage").style.display = "block";
    } else {
        document.getElementById("jobImage").style.display = "none";
    }
}

// Ask Question Handle For Worker
function askQuesHand(k) {
    if (k == 1) {
        document.getElementById("askQues").style.display = "block";
    } else {
        document.getElementById("askQues").style.display = "none";
    }
}

// View Question Handle For Both
function viewQuesHand(k) {
    if (k == 1) {
        document.getElementById("viewQues").style.display = "block";
    } else {
        document.getElementById("viewQues").style.display = "none";
    }
}

// Modal view for answer textbox
function viewAnsBox(k) {
    if (k != 0) {
        var m = document.getElementById(k)
        if (m) {
            document.getElementById(k).style.display = "block";
        }
    }
}

// Show Answer
function viewAns(k) {
    if (k != 0) {
        var m = document.getElementById(k)
        if (m) {
            document.getElementById(k).style.display = "block";
        }
    }
}

// Show Report Modal. From user to worker
function viewUserReport(k) {
    if (k == 1) {
        document.getElementById("viewUserReport").style.display = "block";
    } else {
        document.getElementById("viewUserReport").style.display = "none";
    }
}

// View Job List To Invite
function viewInviteJobList(k) {
    if (k == 1) {
        document.getElementById("viewInviteJobList").style.display = "block";
    } else {
        document.getElementById("viewInviteJobList").style.display = "none";
    }
}

// All of Setting Page
//Select Setting
function SetSelect(k) {
    switch (k) {
        case "gen":
            document.getElementById("notificationSettingId").style.display = "none";
            document.getElementById("privacySettingId").style.display = "none";
            document.getElementById("generalSettingId").style.display = "block";
            break;
        case "not":
            document.getElementById("generalSettingId").style.display = "none";
            document.getElementById("privacySettingId").style.display = "none";
            document.getElementById("notificationSettingId").style.display = "block";
            break;
        case "pri":
            document.getElementById("generalSettingId").style.display = "none";
            document.getElementById("notificationSettingId").style.display = "none";
            document.getElementById("privacySettingId").style.display = "block";
            break;
        default:
            break;
    }
}

//General Setting
function SetGenFoSh(k) {
    switch (k) {
        // case "url":
        //     document.getElementById("urlForm").style.display = "block";
        //     break;
        case "perInfo":
            document.getElementById("perInfoForm").style.display = "block";
            break;
        case "pwd":
            document.getElementById("pwdForm").style.display = "block";
            break;
        case "acc":
            document.getElementById("accForm").style.display = "block";
            break;
        case "prCat":
            document.getElementById("prCatForm").style.display = "block";
            break;
        case "subCat":
            document.getElementById("subCatForm").style.display = "block";
            break;
        case "verFile":
            document.getElementById("verFileForm").style.display = "block";
            break;
        default:
            break;
    }
}

function SetGenFoCl(k) {
    switch (k) {
        // case "url":
        //     document.getElementById("urlForm").style.display = "none";
        //     break;
        case "perInfo":
            document.getElementById("perInfoForm").style.display = "none";
            break;
        case "pwd":
            document.getElementById("pwdForm").style.display = "none";
            break;
        case "acc":
            document.getElementById("accForm").style.display = "none";
            break;
        case "prCat":
            document.getElementById("prCatForm").style.display = "none";
            break;
        case "subCat":
            document.getElementById("subCatForm").style.display = "none";
            break;
        case "verFile":
            document.getElementById("verFileForm").style.display = "none";
            break;
        default:
            break;
    }
}

//Notification Setting
function SetNotFoSh(k) {
    switch (k) {
        case "email":
            document.getElementById("NotEmailForm").style.display = "block";
            break;
        case "sms":
            document.getElementById("notSmsForm").style.display = "block";
            break;
        case "alert":
            document.getElementById("notAlertForm").style.display = "block";
            break;
        default:
            break;
    }
}

function SetNotFoCl(k) {
    switch (k) {
        case "email":
            document.getElementById("NotEmailForm").style.display = "none";
            break;
        case "sms":
            document.getElementById("notSmsForm").style.display = "none";
            break;
        case "alert":
            document.getElementById("notAlertForm").style.display = "none";
            break;
        default:
            break;
    }
}


// Privacy Setting
function SetPriFoSh(k) {
    switch (k) {
        case "visi":
            document.getElementById("priVisibilityForm").style.display = "block";
            break;
    }
}

function SetPriFoCl(k) {
    switch (k) {
        case "visi":
            document.getElementById("priVisibilityForm").style.display = "none";
            break;
    }
}




////////////////////////////////////////////////////
// OWL Carousel: http://owlgraphic.com/owlcarousel
////////////////////////////////////////////////////

// Intro text carousel

$("#owl-intro-text").owlCarousel({
    singleItem: true,
    autoPlay: 6000,
    stopOnHover: true,
    navigation: false,
    navigationText: false,
    pagination: true
});


// Testimonials carousel
$("#owl-testimonial").owlCarousel({
    singleItem: true,
    pagination: true,
    autoHeight: true,
    autoPlay: 6000,
    stopOnHover: true
});

////////////////////////////////////////////////////////////////////
// Stellar (parallax): https://github.com/markdalgleish/stellar.js
////////////////////////////////////////////////////////////////////

// $.stellar({
//     // Set scrolling to be in either one or both directions
//     horizontalScrolling: false,
//     verticalScrolling: true,
// });



///////////////////////////////////////////////////////////
// WOW animation scroll: https://github.com/matthieua/WOW
///////////////////////////////////////////////////////////

new WOW().init();



////////////////////////////////////////////////////////////////////////////////////////////
// Counter-Up (requires jQuery waypoints.js plugin): https://github.com/bfintal/Counter-Up
////////////////////////////////////////////////////////////////////////////////////////////

// $('.counter').counterUp({
//     delay: 10,
//     time: 2000
// });



/////////////////////////
// Scroll to top button
/////////////////////////

// Check to see if the window is top if not then display button
$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('.scrolltotop').fadeIn();
    } else {
        $('.scrolltotop').fadeOut();
    }
});

// Click event to scroll to top
$('.scrolltotop').click(function () {
    $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
    return false;
});



////////////////////////////////////////////////////////////////////
// Close mobile menu when click menu link (Bootstrap default menu)
////////////////////////////////////////////////////////////////////

// $(document).on('click', '.navbar-collapse.in', function (e) {
//     if ($(e.target).is('a') && $(e.target).attr('class') != 'dropdown-toggle') {
//         $(this).collapse('hide');
//     }
// });


//////////////////////////////////////
// Buy SMS PAGE
//////////////////////////////////////
function showSelectPack() {
    var select_pack = document.getElementById("smsPackageSelect").value;
    document.getElementsByName('selectedPack')[0].value = select_pack;
    document.getElementsByName('selectedPack')[1].value = select_pack;
}

function showMethodForm(k) {
    var select_pack = document.getElementById("smsPackageSelect").value;

    if (select_pack == "") {
        swal({
            title: "Error!",
            text: "Please Select a package first!",
            icon: "error",
            button: "OK",
        }).then(function () {
            window.location = "buyCredits.php";
        });
    } else {
        document.getElementsByName('selectedPack')[0].value = select_pack;
        document.getElementsByName('selectedPack')[1].value = select_pack;
        switch (k) {
            case "optradioRocket":
                document.getElementById("optradioBkash").style.display = "none";
                document.getElementById("opt2").checked = false;
                document.getElementById("optradioRocket").style.display = "block";
                break;
            case "optradioBkash":
                document.getElementById("optradioRocket").style.display = "none";
                document.getElementById("opt1").checked = false;
                document.getElementById("optradioBkash").style.display = "block";
                break;
            default:
                break;
        }
    }
}

////////////////////////////////////////////////////////////////////
// Date Time Picker
////////////////////////////////////////////////////////////////////
function picking() {
    $('.form_datetime').datetimepicker({
        language: 'en',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });

    // $('.form_date').datetimepicker({
    //     language:  'fr',
    //     weekStart: 1,
    //     todayBtn:  1,
    //     autoclose: 1,
    //     todayHighlight: 1,
    //     startView: 2,
    //     minView: 2,
    //     forceParse: 0
    // });


    // $('.form_time').datetimepicker({
    //     language:  'fr',
    //     weekStart: 1,
    //     todayBtn:  1,
    //     autoclose: 1,
    //     todayHighlight: 1,
    //     startView: 1,
    //     minView: 0,
    //     maxView: 1,
    //     forceParse: 0
    // });

}




function displayUser() {
    document.getElementById("workerForm").style.display = "none";
    document.getElementById("workerOption").classList.remove("optionActive");

    // document.getElementById("bothForm").style.display = "none";
    // document.getElementById("bothOption").classList.remove("optionActive");

    document.getElementById("userForm").style.display = "block";
    document.getElementById("userOption").classList.add("optionActive");
}

function displayWorker() {
    document.getElementById("userForm").style.display = "none";
    document.getElementById("userOption").classList.remove("optionActive");

    // document.getElementById("bothForm").style.display = "none";
    // document.getElementById("bothOption").classList.remove("optionActive");

    document.getElementById("workerForm").style.display = "block";
    document.getElementById("workerOption").classList.add("optionActive");
}

function displayBoth() {
    document.getElementById("workerForm").style.display = "none";
    document.getElementById("workerOption").classList.remove("optionActive");

    document.getElementById("userForm").style.display = "none";
    document.getElementById("userOption").classList.remove("optionActive");

    // document.getElementById("bothForm").style.display = "block";
    // document.getElementById("bothOption").classList.add("optionActive");
}
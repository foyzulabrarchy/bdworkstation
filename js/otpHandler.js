//https://developers.facebook.com/docs/accountkit/webjs
$(".message").append("<p>initialized Account Kit.</p>");

// initialize Account Kit with CSRF protection
AccountKit_OnInteractive = function () {
  AccountKit.init(
    {
      appId: "282804475720913",
      state: "SIFAT",
      version: "v1.0",
      fbAppEventsEnabled: true,
    }
  );
};


// login callback
function loginCallback(response) {
  var New;
  if (response.status === "PARTIALLY_AUTHENTICATED") {
    var code = response.code;
    var csrf = response.state;
    $(".message").append("<p>Received auth token from facebook -  " + code + ".</p>");
    $(".message").append("<p>Triggering AJAX for server-side validation.</p>");

    $.post("backEnds/otpVerify.php", { code: code, csrf: csrf }, function (result) {
      $(".message").append("<p>Server response : " + result + "</p>");

      if (result > 0) {
        setTimeout(function () {
          window.location.href = "profile.php";
        }, 1);
      } else if (result == 0) {
        setTimeout(function () {
          window.location.href = "completeProfile.php";
        }, 1);
      } else {
        setTimeout(function () {
          window.location.href = "accountSuspend.php";
        }, 1);
      }
    });

  }
  else if (response.status === "NOT_AUTHENTICATED") {
    // handle authentication failure
    $(".message").append("<p>( Error ) NOT_AUTHENTICATED status received from facebook, something went wrong.</p>");
  }
  else if (response.status === "BAD_PARAMS") {
    // handle bad parameters
    $(".message").append("<p>( Error ) BAD_PARAMS status received from facebook, something went wrong.</p>");
  }
}


// phone form submission handler
function smsLogin() {
  document.getElementById('logIn').style.display = 'none';

  var countryCode = "+88";
  var phoneNumber = "";


  AccountKit.login(
    'PHONE',
    { countryCode: countryCode, phoneNumber: phoneNumber }, // will use default values if not specified
    loginCallback
  );
}



// Reset CallBack
function resetCallback(response) {
  var New;
  if (response.status === "PARTIALLY_AUTHENTICATED") {
    var code = response.code;
    var csrf = response.state;
    $(".message").append("<p>Received auth token from facebook -  " + code + ".</p>");
    $(".message").append("<p>Triggering AJAX for server-side validation.</p>");

    $.post("backEnds/OTPforgetPassword.php", { code: code, csrf: csrf }, function (result) {
      $(".message").append("<p>Server response : " + result + "</p>");

      if (result > 0) {
        setTimeout(function () {
          window.location.href = "setPassword.php";
        }, 1);
      }
    });

  }
  else if (response.status === "NOT_AUTHENTICATED") {
    // handle authentication failure
    $(".message").append("<p>( Error ) NOT_AUTHENTICATED status received from facebook, something went wrong.</p>");
  }
  else if (response.status === "BAD_PARAMS") {
    // handle bad parameters
    $(".message").append("<p>( Error ) BAD_PARAMS status received from facebook, something went wrong.</p>");
  }
}




function forgetReset(){
  document.getElementById('logIn').style.display = 'none';

  var countryCode = "+88";
  var phoneNumber = "";

  AccountKit.login(
    'PHONE',
    { countryCode: countryCode, phoneNumber: phoneNumber }, // will use default values if not specified
    resetCallback
  );
}
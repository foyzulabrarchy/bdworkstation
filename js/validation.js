function nameValidation(k) {
  var nameExp = /^([A-Za-z]+)([.]*)(\s*)([A-Za-z\s]*)$/;

  if (k == 1) {
    //For USER
    var firstName = document.getElementById("userfirstName").value;
    var lastName = document.getElementById("userlastName").value;
    var firstNameMsg = document.getElementById("userfirstNameMsg");
    var lastNameMsg = document.getElementById("userlastNameMsg");

    if (nameExp.test(firstName)) {
      firstNameMsg.style.color = "#66cc66";
      firstNameMsg.style.fontSize = "12px";
      firstNameMsg.innerHTML = "First Name is Ok!";
    } else {
      firstNameMsg.style.color = "#ff6666";
      firstNameMsg.style.fontSize = "12px";
      firstNameMsg.innerHTML = "Please use A-Z or a-z only!";
    }

    if (nameExp.test(lastName)) {
      lastNameMsg.style.color = "#66cc66";
      lastNameMsg.style.fontSize = "12px";
      lastNameMsg.innerHTML = "Last Name is Ok!";
    } else {
      lastNameMsg.style.color = "#ff6666";
      lastNameMsg.style.fontSize = "12px";
      lastNameMsg.innerHTML = "Please use A-Z or a-z only!";
    }
  }
  if (k == 2) {
    //For WORKER
    var firstName = document.getElementById("workerfirstName").value;
    var lastName = document.getElementById("workerlastName").value;
    var firstNameMsg = document.getElementById("workerfirstNameMsg");
    var lastNameMsg = document.getElementById("workerlastNameMsg");

    if (nameExp.test(firstName)) {
      firstNameMsg.style.color = "#66cc66";
      firstNameMsg.style.fontSize = "12px";
      firstNameMsg.innerHTML = "First Name is Ok!";
    } else {
      firstNameMsg.style.color = "#ff6666";
      firstNameMsg.style.fontSize = "12px";
      firstNameMsg.innerHTML = "Please use A-Z or a-z only!";
    }

    if (nameExp.test(lastName)) {
      lastNameMsg.style.color = "#66cc66";
      lastNameMsg.style.fontSize = "12px";
      lastNameMsg.innerHTML = "Last Name is Ok!";
    } else {
      lastNameMsg.style.color = "#ff6666";
      lastNameMsg.style.fontSize = "12px";
      lastNameMsg.innerHTML = "Please use A-Z or a-z only!";
    }
  }
}



function passValidation(k) {

  if (k == 1) {
    //For USER
    var userpass1 = document.getElementById("userpass1").value;
    var userpass2 = document.getElementById("userpass2").value;
    var userlengthMsg = document.getElementById("userpassLengthErrorMsg");
    var usermatchMsg = document.getElementById("userpassMatchErrorMsg");

    if (userpass1.length > 5) {
      userlengthMsg.style.color = "#66cc66";
      userlengthMsg.style.fontSize = "12px";
      userlengthMsg.innerHTML = "OK!";
    } else {
      userlengthMsg.style.color = "#ff6666";
      userlengthMsg.style.fontSize = "12px";
      userlengthMsg.innerHTML = "must be 6 character!";
    }

    if (userpass1 == userpass2) {
      usermatchMsg.style.color = "#66cc66";
      usermatchMsg.style.fontSize = "12px";
      usermatchMsg.innerHTML = "Matched!";
    } else {
      usermatchMsg.style.color = "#ff6666";
      usermatchMsg.style.fontSize = "12px";
      usermatchMsg.innerHTML = "Doesn't Matched!";
    }
  }
  if (k == 2) {
    //For WORKER
    var workerpass1 = document.getElementById("workerpass1").value;
    var workerpass2 = document.getElementById("workerpass2").value;
    var workerlengthMsg = document.getElementById("workerpassLengthErrorMsg");
    var workermatchMsg = document.getElementById("workerpassMatchErrorMsg");

    if (workerpass1.length > 5) {
      workerlengthMsg.style.color = "#66cc66";
      workerlengthMsg.style.fontSize = "12px";
      workerlengthMsg.innerHTML = "OK!";
    } else {
      workerlengthMsg.style.color = "#ff6666";
      workerlengthMsg.style.fontSize = "12px";
      workerlengthMsg.innerHTML = "must be 6 character!";
    }

    if (workerpass1 == workerpass2) {
      workermatchMsg.style.color = "#66cc66";
      workermatchMsg.style.fontSize = "12px";
      workermatchMsg.innerHTML = "Matched!";
    } else {
      workermatchMsg.style.color = "#ff6666";
      workermatchMsg.style.fontSize = "12px";
      workermatchMsg.innerHTML = "Doesn't Matched!";
    }
  }
}

function phoneNumberValidation(k) {
  var phoneNumberExp = /^([0]{1})([1]{1})([3456789]{1})([0-9]{8})$/g;

  if(k == 'r'){
    var phone1 = document.getElementById("buySmsphoneNumber1").value;
    var msg1 = document.getElementById("phoneErrorMsg1");

    if (phoneNumberExp.test(phone1)) {
      msg1.style.color = "#66cc66";
      msg1.style.fontSize = "12px";
      msg1.innerHTML = "Phone Number is Ok!";
    } else {
      msg1.style.color = "#ff6666";
      msg1.style.fontSize = "12px";
      msg1.innerHTML = "Please enter a correct phone number!";
    }
  
  }
  
  if(k == 'b'){

    var phone2 = document.getElementById("buySmsphoneNumber2").value;
    var msg2 = document.getElementById("phoneErrorMsg2");
  
   
  
    if (phoneNumberExp.test(phone2)) {
      msg2.style.color = "#66cc66";
      msg2.style.fontSize = "12px";
      msg2.innerHTML = "Phone Number is Ok!";
    } else {
      msg2.style.color = "#ff6666";
      msg2.style.fontSize = "12px";
      msg2.innerHTML = "Please enter a correct phone number!";
    }
  }

}
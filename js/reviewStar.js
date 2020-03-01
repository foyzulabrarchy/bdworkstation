
function reviewModelHandle(k){
    if(k == 1){
        document.getElementById('userReview').style.display='block';
    }else{
        document.getElementById('userReview').style.display='none';
    }
}


function clicked(k){
    var i;
    for (i = 1; i <= 5; i++) {
        document.getElementById(i).style.color = "#333333";
    }
    for (i = 1; i <= k; i++) {
        document.getElementById(i).style.color = "yellow";
    }

    document.getElementById("giveRating").value = k + '0';
}   
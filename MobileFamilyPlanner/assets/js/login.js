$(function(){
    $('#lgnAgree').click(function(){
       if($('#lgnAgree').prop('checked') === true){
           $('#lgnRemember').attr('disabled', false);
       } else{
           $('#lgnRemember').attr('disabled', true);
           $('#lgnRemember').prop('checked', false);
       }
    });

   $('#btnLogin').click(async function(){
       let emailErr = false;
       let passwordErr = false;

       let email = $('#inpLgnEmail').val();
       let password = CryptoJS.AES.encrypt($('#inpLgnPassword').val(), "CHEESEBURGER");

       if(email === ""){
           //Email is Blank
           emailErr = true;
           $('#inpLgnEmail').addClass('is-invalid');
           $('#invLgnEmail').attr('hidden', false);
       }else{
           //Email is NOT blank
           if(validateEmail(email) === false){
               //Email does NOT contain '@'
               $('#inpLgnEmail').addClass('is-invalid');
               $('#invLgnEmail').attr('hidden', false);
               emailErr = true;
           }else{
               //Email contains an '@'
               $('#inpLgnEmail').removeClass('is-invalid');
               $('#invLgnEmail').attr('hidden', true);

               emailErr = false;
           }
       }

       if(CryptoJS.AES.decrypt(password, "CHEESEBURGER").toString(CryptoJS.enc.Utf8) === ""){
           //Email is blank
           passwordErr = true;
           $('#inpLgnPassword').addClass('is-invalid');
           $('#invLgnPassword').attr("hidden", false);
       }else{
           //Email is NOT blank
           if(emailErr !== true) {
               //Check Password's Match
               await $.post("/MobileFamilyPlanner/src/controller/loginUser.php", {
                   inpLgnEmail: email
               }, function (data) {
                   data = JSON.parse(data)[0];
                   try {
                       if (CryptoJS.AES.decrypt(data.password, "CHEESEBURGER").toString(CryptoJS.enc.Utf8).localeCompare(CryptoJS.AES.decrypt(password, "CHEESEBURGER").toString(CryptoJS.enc.Utf8)) !== 0) {
                           //Passwords do NOT match
                           $('#invLogin').attr('hidden', false);
                           $('#inpLgnEmail').addClass('is-invalid');
                           $('#inpLgnPassword').addClass('is-invalid');

                           passwordErr = true;
                       } else {
                           //Passwords match
                           $('#invLogin').attr('hidden', true);
                           $('#inpLgnEmail').removeClass('is-invalid');
                           $('#inpLgnPassword').removeClass('is-invalid');

                           passwordErr = false;
                       }
                   }catch(err){
                       $('#invLogin').attr('hidden', false);
                       $('#inpLgnEmail').addClass('is-invalid');
                       $('#inpLgnPassword').addClass('is-invalid');

                       passwordErr = true;
                   }
               });
           }
       }

       if(emailErr !== true && passwordErr !== true){
           //Correct Details - Get UserID
           $.post("/MobileFamilyPlanner/src/controller/loginUser.php",{
               inpLgnEmail: email
           }, function(data){
               if($('#lgnAgree').prop('checked') === true){
                   //User Agrees
                   $('#invAgree').attr('hidden', true);

                   data = JSON.parse(data)[0];
                   //If remember me checked, save cookie for longer period
                   if($('#lgnRemember').prop('checked') === true){
                       //User checked remember me - save extended period cookie
                       let today = new Date();
                       let expire = new Date();
                       expire.setTime(today.getTime() + 3600000*24*14);
                       document.cookie = "userID=" + data.userID + ";expires=" + expire.toUTCString();
                       document.cookie = "familyID=" + data.familyID + ";expires=" + expire.toUTCString();
                       document.cookie = "accountType=" + data.type + ";expires=" + expire.toUTCString();

                       location.replace('/MobileFamilyPlanner/public/myFamily.php');
                   }else{
                       //User has NOT checked remember me - save short period cookie
                       document.cookie = "userID=" + data.userID;
                       document.cookie = "familyID=" + data.familyID;
                       document.cookie = "accountType=" + data.type;

                       location.replace('/MobileFamilyPlanner/public/myFamily.php');
                   }
               }else{
                   //User does NOT agree
                   $('#invAgree').attr('hidden', false);
               }


           });
       }
   }) ;
});

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
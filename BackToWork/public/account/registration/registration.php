<?php include_once "../../header.php" ?>
<html lang="en">
    <script src="../../../assets/js/account/registration/registration.js"></script>
    <body>
        <div class="container-fluid main">
            <h1>Registration</h1>
            <div class="container">
                <div class="container containerBackground text-center" id="registrationForm">
                    <!-- Form For User Registration -->
                    <form class="form-signin">
                        <div class="form-group">
                            <label for="inpFirstName" id="invFirstName" class="text-danger" hidden>First Name Cannot Be Empty And Longer Than 45 Characters!</label>
                            <input class="form-control inpPadding" type="text" placeholder="First Name" id="inpFirstName">
                        </div>
                        <div class="form-group">
                            <label for="inpLastName" id="invLastName" class="text-danger" hidden>Last Name Cannot Be Empty And Longer Than 45 Characters!</label>
                            <input class="form-control inpPadding" type="text" placeholder="Last Name" id="inpLastName">
                        </div>
                        <div class="form-group">
                            <label for="inpGroupName" id="invGroupName" class="text-danger" hidden>Group Name Cannot Be Empty And Longer Than 45 Characters!</label>
                            <input class="form-control inpPadding" type="text" placeholder="Group Name" id="inpGroupName">
                        </div>
                        <div class="form-group">
                            <label for="inpDOB" id="invDOB" class="text-danger" hidden>Date of Birth is Invalid!</label>
                            <label for="inpDOB" id="youngDOB" class="text-danger" hidden>You MUST be 14 Years or Older to Register!</label>
                            <input class="form-control inpPadding" type="date" placeholder="Date of Birth" id="inpDOB">
                        </div>
                        <div class="form-group">
                            <label for="inpEmail" id="invEmail" class="text-danger" hidden>Email Cannot Be Empty, Container More Than 45 Characters And Must Contain '@'</label>
                            <label for="inpEmail" id="invEmailExists" class="text-danger" hidden>Email Already Exists! Please Login Or Use An Alternative Email.</label>
                            <input class="form-control inpPadding" type="text" placeholder="Email" id="inpEmail">
                        </div>
                        <div class="form-group">
                            <label for="inpPassword" id="invPassword" class="text-danger" hidden>Passwords Cannot Be Empty, Must Container More Than 5 Characters And Must Match!</label>
                            <input class="form-control inpPadding" type="password" placeholder="Password" id="inpPassword">
                        </div>
                        <div class="form-group">
                            <input class="form-control inPadding" type="password" placeholder="Confirm Password" id="inpConfirmPassword">
                        </div>
                        <div class="form-group" hidden>
                            <label id="invType" class="text-danger" hidden>Please Select An Account Type!</label>
                            <select class="form-select" aria-label="Default select example" style="width: 100%" id="inpType">
                                <option selected value="0">Adult</option>
                            </select>
                        </div>
                        <label id="familyID" hidden>0</label>
                    </form>
                    <!-- Register Button -->
                    <div class="text-center">
                        <button id="btnRegister" class="btn btn-lrg btn-primary" style="width: 80%" type="submit">Register</button><br>
                        <a href="../login/login.php">Back To Login</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
include_once "../../footer.php";

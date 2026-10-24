
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Greener Society job application page where applicants can apply for environmental conservation positions.">
    <meta name="keywords" content="Greener Society, job application, environmental jobs, conservation jobs, recruitment">
    <meta name="author" content="TechTide Group">

    <title>Greener Society - Job Application</title>

    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Embedded CSS example required for the assignment */
        .application-banner {
            background-color: lightgoldenrodyellow;
            border: 1px solid #444;
            padding: 0.5rem;
            text-align: center;
            font-size: 20px;
        }
    </style>
</head>

<body class="apply-page">

<?php include 'header.inc'; ?>


    <main>

        <!-- Application heading -->

        <div class="application-banner">

            <h1>Join Greener Society</h1>

            <p>
                Thank you for considering a career with Greener Society.
                We look forward to receiving your application.
            </p>

        </div>


        <form id="form"
            action="process_eoi.php"
            method="post">

           
            <!-- Job Reference -->

            <div class="job-reference-form">

                <label for="job-reference">
                    <strong>Job Reference Number</strong>
                </label>

                <input
                    type="text"
                    id="job-reference"
                    name="Job_Reference_Number"
                    pattern="GS102A|GS204B|GS305C"
                    placeholder="e.g. GS102A"
                    title="Enter GS102A, GS204B or GS305C."
                    required>

            </div>


            <!-- Two-column form layout -->

            <div class="application-grid">


                <!-- YOUR DETAILS -->

                <fieldset class="form-item details-fieldset">

                    <legend>
                        <strong>Your Details</strong>
                    </legend>

                  <div class="details-first-name">
                    <label for="first-name">
                        First Name
                    </label>

                    <input
                        type="text"
                        id="first-name"
                        name="First_Name"
                        maxlength="20"
                        pattern="[A-Za-z '\-]+"
                        placeholder="Enter your first name"
                        title="Use letters, spaces, apostrophes and hyphens only."
                        required>
                  </div>

                  <div class="details-last-name">
                    <label for="last-name">
                        Last Name
                    </label>

                    <input
                        type="text"
                        id="last-name"
                        name="Last_Name"
                        maxlength="20"
                        pattern="[A-Za-z '\-]+"
                        placeholder="Enter your last name"
                        title="Use letters, spaces, apostrophes and hyphens only."
                        required>
                  </div>

                  <div class="details-birth">
                    <label for="date-of-birth">
                        Date of Birth
                    </label>

                    <input
                        type="date"
                        id="date-of-birth"
                        name="Date_of_Birth"
                        required>
                  </div>

                </fieldset>


                <!-- GENDER -->

                <fieldset class="form-item gender-fieldset">

                    <legend>
                        <strong>Gender</strong>
                    </legend>

                  <div class="male">
                    <label for="male"> 
                        Male 
                    </label>

                    <input
                        type="radio"
                        id="male"
                        name="Gender"
                        value="Male"
                        required>
                  </div>

                  <div class="female">
                    <label for="female"> 
                        Female 
                    </label>
                        
                    <input
                        type="radio"
                        id="female"
                        name="Gender"
                        value="Female">
                  </div>

                  <div class="rather-not-say">
                    <label for="rather-not-say"> 
                        Rather Not Say 
                    </label>

                    <input
                        type="radio"
                        id="rather-not-say"
                        name="Gender"
                        value="Rather Not Say">
                  </div>

                </fieldset>


                <!-- ADDRESS -->

                <fieldset class="form-item address-fieldset">

                    <legend>
                        <strong>Your Address</strong>
                    </legend>

                  <div class="street">
                    <label for="street-address">
                        Street Address
                    </label>

                    <input
                        type="text"
                        id="street-address"
                        name="Street_Address"
                        maxlength="40"
                        placeholder="Enter your street address"
                        required>
                  </div> 

                  <div class="suburb">
                    <label for="suburb-town">
                        Suburb/Town
                    </label>

                    <input
                        type="text"
                        id="suburb-town"
                        name="Suburb"
                        maxlength="40"
                        placeholder="Enter your suburb or town"
                        required>
                  </div> 

                  <div class="state">
                    <label for="state">
                        State
                    </label>

                    <select
                        id="state"
                        name="State"
                        required>

                        <option value="">Please Select</option>
                        <option value="VIC">VIC</option>
                        <option value="NSW">NSW</option>
                        <option value="QLD">QLD</option>
                        <option value="NT">NT</option>
                        <option value="WA">WA</option>
                        <option value="SA">SA</option>
                        <option value="TAS">TAS</option>
                        <option value="ACT">ACT</option>

                    </select>
                  </div> 

                  <div class="postcode">
                    <label for="postcode">
                        Postcode
                    </label>

                    <input
                        type="text"
                        id="postcode"
                        name="Postcode"
                        pattern="[0-9]{4}"
                        placeholder="e.g. 3000"
                        title="Enter exactly 4 digits."
                        required>
                  </div> 

                </fieldset>


                <!-- CONTACTS -->

                <fieldset class="form-item contacts-fieldset">

                    <legend>
                        <strong>Contacts</strong>
                    </legend>

                  <div class="email">
                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="Email"
                        placeholder="e.g. example@email.com"
                        title="Enter a valid email address."
                        required>
                  </div>

                  <div class="phone-number">
                    <label for="phone-number">
                        Phone Number
                    </label>

                    <input
                        type="tel"
                        id="phone-number"
                        name="Phone_Number"
                        pattern="[0-9]{8,12}"
                        placeholder="e.g. 0412345678"
                        title="Enter a phone number containing 8 to 12 digits."
                        required>
                  </div>

                </fieldset>
            </div>
            
                <!-- SKILLS -->

                <fieldset class="form-item-skills-fieldset">

                    <legend>
                        <strong>Your Skills</strong>
                    </legend>


                    <p>
                        <strong>Skill List</strong>
                    </p>


                    <div class="skills-grid">

                        <label>
                            <input
                                type="checkbox"
                                id="loves-environment"
                                name="Skills[]"
                                value="Loves The Environment"
                                required>
                            Loves The Environment
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="organization"
                                name="Skills[]"
                                value="Organization">
                            Organization
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="punctuality"
                                name="Skills[]"
                                value="Punctuality">
                            Punctuality
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="hard-working"
                                name="Skills[]"
                                value="Hard Working">
                            Hard Working
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="resilience"
                                name="Skills[]"
                                value="Resilience">
                            Resilience
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="team-player"
                                name="Skills[]"
                                value="Team Player">
                            Team Player
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="passionate"
                                name="Skills[]"
                                value="Passionate">
                            Passionate
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="leadership"
                                name="Skills[]"
                                value="Leadership">
                            Leadership
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="communication"
                                name="Skills[]"
                                value="Communication">
                            Communication
                        </label>

                    </div>

                  <div class="other-skills">
                    <label for="other-skills">
                        <strong>Other Skills</strong>
                    </label>

                    <textarea
                        id="other-skills"
                        name="Other_Skills"
                        rows="6"
                        placeholder="Tell us about any other skills you have."></textarea>
                  </div>

                </fieldset>


            <!-- FORM BUTTONS -->

            <div class="form-buttons">

                <button type='submit' class="submit"> 
                    <i class='fa-solid fa-check' aria-hidden='true'> 
                    </i> 
                    Submit Application
                </button>

                <button type='reset' class="reset"> 
                    <i class='fa-solid fa-rotate-left' aria-hidden='true'> 
                    </i> 
                    Reset Application
                </button>

            </div>


        </form>

    </main>

    <?php include 'footer.inc'; ?>

</body>
</html>
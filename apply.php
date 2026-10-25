<?php
    require_once 'settings.php';
    session_start();

    $form_data = [];

    if (isset($_SESSION['form_data'])) {
        $form_data = $_SESSION['form_data'];
    }

    $job_reference_result = mysqli_query($conn, "SELECT job_reference FROM jobs");
?>

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

            <h1> <span aria-hidden="true"> 🌱 </span> Join Greener Society</h1>

            <p class="apply-introduction">
                Thank you for considering a career with Greener Society.
                We look forward to receiving your application.
            </p>

        </div>


        <form id="form"
            action="process_eoi.php"
            method="post" 
            novalidate >
           
            <!-- Job Reference, using PHP to take Job Reference numbers from jobs table for maintainability -->

            <div class="job-reference-form">

                <label for="job-reference">
                    <strong> Job Reference Number </strong>
                </label>

                <select
                    id="job-reference"
                    name="Job_Reference_Number"
                    required>

                    <option value=""> Please Select a Job </option>

                    <?php
                    if ($job_reference_result) {
                      while ($job_row = mysqli_fetch_assoc($job_reference_result)) {
                        echo "<option value='" . htmlspecialchars($job_row['job_reference'], ENT_QUOTES, 'UTF-8') . "'";

                        if (isset($form_data['Job_Reference_Number']) && $form_data['Job_Reference_Number'] === $job_row['job_reference']) {
                          echo " selected";
                        }

                        echo ">" . htmlspecialchars($job_row['job_reference'], ENT_QUOTES, 'UTF-8') . "</option>";
                      }
                    }
                    ?>
                </select>
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
                        value="<?php
                          if (isset($form_data['First_Name'])) {
                            echo htmlspecialchars($form_data['First_Name'], ENT_QUOTES, 'UTF-8');
                          }
                        ?>"
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
                        value="<?php
                          if (isset($form_data['Last_Name'])) {
                            echo htmlspecialchars($form_data['Last_Name'], ENT_QUOTES, 'UTF-8');
                          }
                        ?>"
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
                        value="<?php
                          if (isset($form_data['Date_of_Birth'])) {
                            echo htmlspecialchars($form_data['Date_of_Birth'], ENT_QUOTES, 'UTF-8');
                          }
                        ?>"
                        required>
                  </div>

                </fieldset>


                <!-- GENDER -->

                <fieldset class="form-item gender-fieldset">

                    <legend>
                        <strong>Gender</strong>
                    </legend>

                  <div class="male gender-flex">
                    <label for="male" class="gender-option"> 
                        Male 
                    </label>

                    <input
                        type="radio"
                        id="male"
                        name="Gender"
                        value="Male"<?php
                          if (isset($form_data['Gender']) && $form_data['Gender'] === 'Male') {
                            echo "checked";
                          }
                        ?>
                        >
                  </div>

                  <div class="female gender-flex">
                    <label for="female" class="gender-option"> 
                        Female 
                    </label>
                        
                    <input
                        type="radio"
                        id="female"
                        name="Gender"
                        value="Female"<?php
                          if (isset($form_data['Gender']) && $form_data['Gender'] === 'Female') {
                            echo "checked";
                          }
                        ?>
                        >
                  </div>

                  <div class="rather-not-say gender-flex">
                    <label for="rather-not-say" class="gender-option"> 
                        Rather Not Say 
                    </label>

                    <input
                        type="radio"
                        id="rather-not-say"
                        name="Gender"
                        value="Rather Not Say"<?php
                          if (isset($form_data['Gender']) && $form_data['Gender'] === 'Rather Not Say') {
                            echo "checked";
                          }
                        ?>
                        >
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
                        value="<?php
                          if (isset($form_data['Street_Address'])) {
                            echo htmlspecialchars($form_data['Street_Address'], ENT_QUOTES, 'UTF-8');
                          }
                        ?>"
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
                        value="<?php
                          if (isset($form_data['Suburb'])) {
                            echo htmlspecialchars($form_data['Suburb'], ENT_QUOTES, 'UTF-8');
                          }
                        ?>"
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
                        <option value="VIC"
                        <?php
                          if (isset($form_data['State']) && $form_data['State'] === 'VIC') {
                            echo "selected";
                          }
                        ?>> VIC
                        </option>
                        <option value="NSW"
                        <?php
                          if (isset($form_data['State']) && $form_data['State'] === 'NSW') {
                            echo "selected";
                          }
                        ?>> NSW
                        </option>
                        <option value="QLD"
                        <?php
                          if (isset($form_data['State']) && $form_data['State'] === 'QLD') {
                            echo "selected";
                          }
                        ?>> QLD
                        </option>
                        <option value="NT"
                        <?php
                          if (isset($form_data['State']) && $form_data['State'] === 'NT') {
                            echo "selected";
                          }
                        ?>> NT
                        </option>
                        <option value="WA"
                        <?php
                          if (isset($form_data['State']) && $form_data['State'] === 'WA') {
                            echo "selected";
                          }
                        ?>> WA
                        </option>
                        <option value="SA"
                        <?php
                          if (isset($form_data['State']) && $form_data['State'] === 'SA') {
                            echo "selected";
                          }
                        ?>> SA
                        </option>
                        <option value="TAS"
                        <?php
                          if (isset($form_data['State']) && $form_data['State'] === 'TAS') {
                            echo "selected";
                          }
                        ?>> TAS
                        </option>
                        <option value="ACT"
                        <?php
                          if (isset($form_data['State']) && $form_data['State'] === 'ACT') {
                            echo "selected";
                          }
                        ?>> ACT
                        </option>

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
                        value="<?php
                          if (isset($form_data['Postcode'])) {
                            echo htmlspecialchars($form_data['Postcode'], ENT_QUOTES, 'UTF-8');
                          }
                        ?>"
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
                        value="<?php
                          if (isset($form_data['Email'])) {
                            echo htmlspecialchars($form_data['Email'], ENT_QUOTES, 'UTF-8');
                          }
                        ?>"
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
                        value="<?php
                          if (isset($form_data['Phone_Number'])) {
                            echo htmlspecialchars($form_data['Phone_Number'], ENT_QUOTES, 'UTF-8');
                          }
                        ?>"
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
                                <?php
                                  if (isset($form_data['Skills']) && is_array($form_data['Skills']) && 
                                  in_array('Loves The Environment', $form_data['Skills'], true)) {
                                    echo "checked";
                                  }
                                ?>>
                            Loves The Environment
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="organization"
                                name="Skills[]"
                                value="Organization"
                                <?php
                                  if (isset($form_data['Skills']) && is_array($form_data['Skills']) && 
                                  in_array('Organization', $form_data['Skills'], true)) {
                                    echo "checked";
                                  }
                                ?>>
                            Organization
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="punctuality"
                                name="Skills[]"
                                value="Punctuality"
                                <?php
                                  if (isset($form_data['Skills']) && is_array($form_data['Skills']) && 
                                  in_array('Punctuality', $form_data['Skills'], true)) {
                                    echo "checked";
                                  }
                                ?>>
                            Punctuality
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="hard-working"
                                name="Skills[]"
                                value="Hard Working"
                                <?php
                                  if (isset($form_data['Skills']) && is_array($form_data['Skills']) && 
                                  in_array('Hard Working', $form_data['Skills'], true)) {
                                    echo "checked";
                                  }
                                ?>>
                            Hard Working
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="resilience"
                                name="Skills[]"
                                value="Resilience"
                                <?php
                                  if (isset($form_data['Skills']) && is_array($form_data['Skills']) && 
                                  in_array('Resilience', $form_data['Skills'], true)) {
                                    echo "checked";
                                  }
                                ?>>
                            Resilience
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="team-player"
                                name="Skills[]"
                                value="Team Player"
                                <?php
                                  if (isset($form_data['Skills']) && is_array($form_data['Skills']) && 
                                  in_array('Team Player', $form_data['Skills'], true)) {
                                    echo "checked";
                                  }
                                ?>>
                            Team Player
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="passionate"
                                name="Skills[]"
                                value="Passionate"
                                <?php
                                  if (isset($form_data['Skills']) && is_array($form_data['Skills']) && 
                                  in_array('Passionate', $form_data['Skills'], true)) {
                                    echo "checked";
                                  }
                                ?>>
                            Passionate
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="leadership"
                                name="Skills[]"
                                value="Leadership"
                                <?php
                                  if (isset($form_data['Skills']) && is_array($form_data['Skills']) && 
                                  in_array('Leadership', $form_data['Skills'], true)) {
                                    echo "checked";
                                  }
                                ?>>
                            Leadership
                        </label>


                        <label>
                            <input
                                type="checkbox"
                                id="communication"
                                name="Skills[]"
                                value="Communication"
                                <?php
                                  if (isset($form_data['Skills']) && is_array($form_data['Skills']) && 
                                  in_array('Communication', $form_data['Skills'], true)) {
                                    echo "checked";
                                  }
                                ?>>
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
                        placeholder="Tell us about any other skills you have."><?php
                      if (isset($form_data['Other_Skills'])) {
                        echo htmlspecialchars($form_data['Other_Skills'], ENT_QUOTES, 'UTF-8');
                      }
                    ?></textarea>
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
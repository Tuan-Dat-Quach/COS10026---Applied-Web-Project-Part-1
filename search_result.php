<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Recruitment Website for Greener Society! Here you can find out about the company's details, and of course, the opportunity to participate with us in conserving the environment!">

    <meta name="keywords" content="Environmental Conservation, GS, Greener Society, Protect Environment, Recruitment">

    <meta name="author" content="TechTide Group">

    <title>Greener Society - Recruitment Website</title>

    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .job-image {
            display: block;
            width: 100%;
            max-width: 700px;
            height: auto;
            margin: 0 auto;
            border-radius: 12px;
        }
    </style>
</head>

<body class="search-page jobs-page">
    <?php include 'header.inc'; ?>

    <main>
    <div class="display-result">
        <!-- This is the search bar -->
        <div class="search_bar">
            <h1> Find your next opportunity </h1>
            <form action="search_result.php" method="GET">
                <label for="search">
                    <span aria-hidden="true"> 🔍 </span>
                </label>
                <input type="text" name="search" id="search" placeholder="Search jobs by title, reference number or keywords...">
                <input type="submit" value="Search">
            </form>
        </div>

        <?php
          // This is the function to highlight searched keywords
          function highlight($text, $search) {
            // Sanitise the searched keywords
            $safe_text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
            // If the user enters nothing, simply return the words with no highlight
            if ($search === '') {
              return $safe_text ;
            }
            // Replace the matched words with their marked version
            return preg_replace("/($search)/iu", "<mark>$1</mark>", $safe_text);
          }

          // Connect to the database
          require_once "settings.php";
            // Start displaying in search_result.php when the user enters search button
            if (isset($_GET['search'])) {
              $search = trim($_GET['search']);
              // Check if user enters nothing
              if ($search === '') {
                echo "<p class='no-keyword'> Please enter some keywords to find your jobs ! </p>";
              // Using prepared statement when searching for keywords in job title, reference number and description
              } else {
                
                $sql = "SELECT * FROM jobs
                        WHERE job_title LIKE ?
                        OR job_reference LIKE ?
                        OR short_description LIKE ?";
                // Prepare SQL query with placeholder (?)
                if ($stmt = $conn->prepare($sql)) {
                  // Format the ? in sql, using % wildcard to represent any number of characters
                  $keyword = "%" . $search . "%";
                  // Bind values into the placeholders, here with 3 strings
                  $stmt->bind_param("sss", $keyword, $keyword, $keyword);
                  // Send safe SQL query to the database to run
                  $stmt->execute();
                  // Retrieve the result set from the executed query
                  $result = $stmt->get_result();
              
                  if($result) {
                    // Count the number of jobs found
                    $job_count = mysqli_num_rows($result);
                    // Start displaying if there is at least 1 job found
                    if ($job_count > 0) {
                      echo "<p class='jobs-found'> There are " . $job_count . " results for '" . htmlspecialchars($search, ENT_QUOTES, 'UTF-8') . "' ! </p>";
                      while ($row = mysqli_fetch_assoc($result)) {
                        echo "<section class='job-section' aria-labelledby='" . htmlspecialchars($row['job_reference'], ENT_QUOTES, 'UTF-8') . "'>";
                        echo "<img class='job-image' src='" . htmlspecialchars($row['image_src'], ENT_QUOTES, 'UTF-8') . "'" . " alt='" . htmlspecialchars($row['image_alt'], ENT_QUOTES, 'UTF-8') . "'>";
                        echo "<h2 id='" . htmlspecialchars($row['job_reference'], ENT_QUOTES, 'UTF-8') . "'>" . highlight($row['job_title'], $search) . "</h2>";
                        echo "<p class='job-reference'> Reference Number: " . highlight($row['job_reference'], $search) . "</p>";
                        echo "<p>" . highlight($row['short_description'], $search) . "</p>";
                        echo "<table class='job-details'>";
                        echo "<tr>";
                        echo "<th> Salary </th>";
                        echo "<td>" . htmlspecialchars($row['salary'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th> Employment Type </th>";
                        echo "<td>" . htmlspecialchars($row['employment_type'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th> Reporting Line </th>";
                        echo "<td>" . htmlspecialchars($row['reporting_line'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "</tr>";
                        echo "</table>";
                        echo "<h3> Key Responsibilities </h3>";
                        echo "<ol>";
                        // Use explode to break the array at newline point
                        $responsibilities = explode("\n", $row['responsibilities']);
                        foreach ($responsibilities as $single_res) {
                        $single_res = trim($single_res);
                        if ($single_res !== "") {
                          echo "<li>" . htmlspecialchars($single_res, ENT_QUOTES, 'UTF-8') . "</li>";
                        }
                        }
                        echo "</ol>";
                        echo "<h3> Essential Requirements </h3>";
                        echo "<ul>";
                        $ess_requirements = explode("\n", $row['essential_requirements']);
                        foreach ($ess_requirements as $single_ess_req) {
                        $single_ess_req = trim($single_ess_req);
                        if ($single_ess_req !== "") {
                          echo "<li>" . htmlspecialchars($single_ess_req, ENT_QUOTES, 'UTF-8') . "</li>";
                        }
                        }
                        echo "</ul>";
                        echo "<h3> Preferable Requirements </h3>";
                        echo "<ul>";
                        $pref_requirements = explode("\n", $row['preferable_requirements']);
                        foreach ($pref_requirements as $single_pref_req) {
                        $single_pref_req = trim($single_pref_req);
                        if ($single_pref_req !== "") {
                          echo "<li>" . htmlspecialchars($single_pref_req, ENT_QUOTES, 'UTF-8') . "</li>";
                        }
                        }
                        echo "</ul>";
                        echo "<a class='apply-link' href='apply.php'> Apply for this position </a>";
                        echo "</section>";
                      }
                    } else {
                      echo "<p class='jobs-unfound'> We cannot find any job like that. Try searching other words ... </p>";
                    }
                  }
                // Close the prepared statement
                mysqli_stmt_close($stmt);
                // Print out error if failed to prepare SQL statement
                } else {
                  echo "<p class='failed-stmt'> Sorry, something went wrong. Please try again later. <p>";
                }
              }
            }
          mysqli_close($conn);
        ?>
    </div>
    </main>

<?php include 'footer.inc'; ?>

</body>
</html>
        
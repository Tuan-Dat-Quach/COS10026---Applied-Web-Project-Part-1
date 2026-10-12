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

<body class="search-page">
    <?php include 'header.inc'; ?>

    <main>
    <div class="display-result">
        <div class="search_bar">
            <h2> Find your next opportunity </h2>
            <form action="search_result.php" method="GET">
                <label for="search">
                    <span aria-hidden="true"> 🔍 </span>
                </label>
                <input type="text" name="search" id="search" placeholder="Search jobs by title, reference number or keywords...">
                <input type="submit" value="Search">
            </form>
        </div>

        <?php
          require_once "settings.php";
          $connect = mysqli_connect($host, $user, $pwd, $sql_db);
          if (!$connect) {
           die("Connection failed: " . mysqli_connect_error());
          }

          if (isset($_GET['search'])) {
            $search = mysqli_real_escape_string($connect, trim($_GET['search']));
            $sql = "SELECT * FROM jobs
                    WHERE job_title LIKE '%$search%'
                    OR job_reference LIKE '%$search%'
                    OR short_description LIKE '%$search%'";
            $result = mysqli_query($connect, $sql);
            
            if($result && mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<section class='job-section' aria-labelledby='" . htmlspecialchars($row['job_reference']) . "'>";
                echo "<img class='job-image' src='" . htmlspecialchars($row['image_src']) . "'" . " alt='" . htmlspecialchars($row['image_alt']) . "'>";
                echo "<h2 id='" . htmlspecialchars($row['job_reference']) . "'>" . htmlspecialchars($row['job_title']) . "</h2>";
                echo "<p class='job-reference'> Reference Number: " . htmlspecialchars($row['job_reference']) . "</p>";
                echo "<p>" . htmlspecialchars($row['short_description']) . "</p>";
                echo "<table class='job-details'>";
                echo "<tr>";
                echo "<th> Salary </th>";
                echo "<td>" . htmlspecialchars($row['salary']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th> Employment Type </th>";
                echo "<td>" . htmlspecialchars($row['employment_type']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th> Reporting Line </th>";
                echo "<td>" . htmlspecialchars($row['reporting_line']) . "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<h3> Key Responsibilities </h3>";
                echo "<ol>";
                $responsibilities = explode("\n", $row['responsibilities']);
                foreach ($responsibilities as $single_res) {
                $single_res = trim($single_res);
                  if ($single_res !== "") {
                    echo "<li>" . htmlspecialchars($single_res) . "</li>";
                  }
                }
                echo "</ol>";
                echo "<h3> Essential Requirements </h3>";
                echo "<ul>";
                $ess_requirements = explode("\n", $row['essential_requirements']);
                foreach ($ess_requirements as $single_ess_req) {
                $single_ess_req = trim($single_ess_req);
                  if ($single_ess_req !== "") {
                    echo "<li>" . htmlspecialchars($single_ess_req) . "</li>";
                  }
                }
                echo "</ul>";
                echo "<h3> Preferable Requirements </h3>";
                echo "<ul>";
                $pref_requirements = explode("\n", $row['preferable_requirements']);
                foreach ($pref_requirements as $single_pref_req) {
                $single_pref_req = trim($single_pref_req);
                  if ($single_pref_req !== "") {
                    echo "<li>" . htmlspecialchars($single_pref_req) . "</li>";
                  }
                }
                echo "</ul>";
                echo "<a class='apply-link' href='apply.php'> Apply for this position </a>";
                echo "</section>";
              }
            } else {
              echo "<p class='jobs-unfound'> We cannot find any job like that. Try searching other words ... </p>";
            }

            mysqli_close($connect);
          }
        ?>
    </div>
    </main>

<?php include 'footer.inc'; ?>

</body>
</html>
        

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Greener Society position description page featuring current environmental conservation employment opportunities.">
    <meta name="keywords" content="Greener Society, environmental jobs, conservation jobs, recruitment, sustainability">
    <meta name="author" content="TechTide Group">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Greener Society - Position Descriptions</title>

    <link rel="stylesheet" href="styles/styles.css">

    <style>
        .job-image {
            display: block;
            width: 100%;
            max-width: 700px;
            height: auto;
            margin: 20px auto;
            border-radius: 12px;
        }
    </style>
</head>

<body class="jobs-page">

<?php include 'header.inc'; ?>

<?php
  $connect = mysqli_connect("localhost", "root", "", "greener_society");
  if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
  }
  $sql = "SELECT * FROM jobs";
  $result = mysqli_query($connect, $sql);
?>

    <main>

        <div class="jobs-container">

            <header>
                <h1 class="jobs-heading">
                    <span aria-hidden="true"> 🌱 </span> Position Descriptions
                </h1>

                <p class="jobs-introduction">
                    Explore our current employment opportunities and discover
                    how you can contribute to a greener and more sustainable future.
                </p>
            </header>


            <div class="jobs-layout">

                <div class="jobs-list">
                
                <!-- 3 MAIN JOB POSITIONS -->
                <?php
                  if($result) {
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
                        echo "<li>" . htmlspecialchars($single_res) . "</li>";
                      }
                      echo "</ol>";
                      echo "<h3> Essential Requirements </h3>";
                      echo "<ul>";
                      $ess_requirements = explode("\n", $row['essential_requirements']);
                      foreach ($ess_requirements as $single_ess_req) {
                        echo "<li>" . htmlspecialchars($single_ess_req) . "</li>";
                      }
                      echo "</ul>";
                      echo "<h3> Preferable Requirements </h3>";
                      echo "<ul>";
                      $pref_requirements = explode("\n", $row['preferable_requirements']);
                      foreach ($pref_requirements as $single_pref_req) {
                        echo "<li>" . htmlspecialchars($single_pref_req) . "</li>";
                      }
                      echo "</ul>";
                      echo "<a class='apply-link' href='apply.php'> Apply for this position </a>";
                      echo "</section>";
                    }
                  } else {
                    echo "<p> There is currently no job position to show. Stay tune for Updates! </p>";
                  }

                ?>
                <!-- ASIDE -->

                <aside class="job-aside">

                    <h2>
                        <span aria-hidden="true"> 🌿 </span> Why Work With Greener Society?
                        
                    </h2>

                    <p>
                        Our team works with communities across Victoria to protect
                        natural environments and create sustainable green spaces.
                        Employees have the opportunity to participate in meaningful
                        environmental projects while working with volunteers and
                        community partners.
                    </p>

                    <p>
                        We encourage applications from people who are passionate
                        about environmental conservation and community development.
                    </p>

                </aside>

            </div>


            <!-- BOTTOM NAVIGATION -->

            <div class="job-navigation">

                <p>
                    Ready to make a difference?
                </p>

            </div>

        </div>

    </main>


<?php include 'footer.inc'; ?>

</body>
</html>
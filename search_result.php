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
</head>

<body>
    <?php include 'header.inc'; ?>

    <main>
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
    </main>
</body>
</html>
        
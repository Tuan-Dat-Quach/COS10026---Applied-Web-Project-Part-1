<?php
require_once 'settings.php'; // your database connection file

// Fetch group details as key => value
$group = [];
$result = mysqli_query($conn, "SELECT detail_key, detail_value FROM group_details");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $group[$row['detail_key']] = $row['detail_value'];
    }
}

// Fetch team members
$members = [];
$result = mysqli_query($conn, "SELECT * FROM team_members ORDER BY id ASC");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $members[] = $row;
    }
}

// Quote section classes and flags (by member order)
$quote_classes = ['TDQ-Quote', 'RN-Quote', 'JM-Quote'];
$flags = ['🇻🇳', '🇱🇰', '🇯🇵'];

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Recruitment Website for Greener Society! Here you can find out about the company's details, and the opportunity to participate in conserving the environment.">
    <meta name="keywords" content="Environmental Conservation, GS, Greener Society, Protect Environment, Recruitment">
    <meta name="author" content="TechTide Group">

    <title>Greener Society - Recruitment Website</title>

    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* This is the CSS applied to the 4 headings in about.php */
        .about-titles {
            color: #065747;
            font-size: 3rem;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body class="about-page">

<?php include 'header.inc'; ?>

        <main>
            <!-- This is the first section of about.php, including group name, tutorial class day and time and the group photo -->
            <section class="about-us" aria-labelledby="section-title1">
                <div class="about-group">
                <h1 class="about-titles" id="section-title1"> <strong> About Us </strong> </h1>
                <!-- This is the nested list of <ul> and <ol> -->
                <ul>
                    <li> Our group's super-duper cool name: <strong id="epic-name"> <?= e($group['group_name'] ?? '') ?> </strong> </li>
                    <li> Our group's members and Student IDs:
                        <ol class="student-id">
                            <?php foreach ($members as $m): ?>
                            <li> <span aria-hidden="true"> 👤 </span> <?= e($m['name']) ?> - <strong> <?= e($m['student_id']) ?> </strong> </li>
                            <?php endforeach; ?>
                        </ol>
                    </li>
                    <li> Our tutorial class day, time and location:
                        <ol>
                            <li> Day: <?= e($group['tutorial_day'] ?? '') ?> <span aria-hidden="true"> 📆 </span> </li>
                            <li> Time: <?= e($group['tutorial_time'] ?? '') ?> <span aria-hidden="true"> ⏰ </span> </li>
                            <li> Location: <?= e($group['tutorial_location'] ?? '') ?> <span aria-hidden="true"> 📍 </span> </li>
                        </ol>
                    </li>
                    <li> Our group number: <?= e($group['group_number'] ?? '') ?> </li>
                    <li> Our scenario: <?= e($group['scenario'] ?? '') ?> </li>
                </ul>
                </div>

                <!-- This is the group photo, along with a caption -->
                <div class="group-photo">
                <figure>
                    <img src="Images/official-group-photo.jpg" alt="Group photo of G05 - TideTech">
                    <figcaption id="about-caption1"> <strong> <em> <span aria-hidden="true"> 😎 </span> Our epic group: Ravindu Nethsara, Johnathan Mey and Tuan Dat Quach </em> </strong> </figcaption>
                </figure>
                </div>
            </section>

            <!-- This is the second section, displaying member contributions of our group-->
            <section class="member-contributions" aria-labelledby="section-title2">
                <div class="contribution-image">
                <!-- Source of the image used: https://sparkstrategy.com.au/contribution-vs-attribution-intermediaries/ -->
                <figure>
                    <img src="Images/description_image3.png" alt="description image for contribution">
                </figure>
                </div>

                <div class="individual-tasks">
                <h2 class="about-titles" id="section-title2"> <strong> Member Contributions </strong> </h2>
                <h3 style="font-size: 2rem; color:blue; margin-left: 0.5rem;"> <strong> <span aria-hidden="true"> 🖌️ </span> Individual Responsibilities: </strong> </h3>
                <!-- This is a description list used to present member contributions -->
                <dl>
                    <?php foreach ($members as $m): ?>
                    <dt class="member-name1"> <span aria-hidden="true"> 📌 </span> <?= e($m['name']) ?> </dt>
                        <?php foreach (explode(';', $m['responsibilities']) as $task): ?>
                            <?php if (trim($task) !== ''): ?>
                        <dd> - <?= e(trim($task)) ?> </dd>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    <dt style="font-size: 2rem; color: blue; margin: 1rem 0.5rem 1rem 0.5rem;"> <strong> <span aria-hidden="true"> 🤝 </span> All members: </strong> </dt>
                        <dd> - CSS Style for each individual page </dd>
                        <dd> - Suggesting ideas </dd>
                        <dd> - Re-evaluation and finalisation </dd>
                </dl>
                </div>
            </section>
            <br>

            <!-- This is the third section, stating individual quotes that inspire each of us -->
            <section class="individual-quotes" aria-labelledby="section-title3">
                <div class="inspiration">
                <h2 class="about-titles" id="section-title3"> <strong> What Inspires Us </strong> </h2>
                <br>
                    <?php foreach ($members as $i => $m): ?>
                    <div class="<?= e($quote_classes[$i] ?? '') ?>">
                    <h3 class="member-name2"> <span aria-hidden="true"> 👤 </span> <?= e($m['name']) ?>: </h3>
                    <p> <span aria-hidden="true"> <?= $flags[$i] ?? '' ?> </span> "<?= e($m['quote_original']) ?>" </p>
                    <p> => English Translation: "<?= e($m['quote_translation']) ?>" </p>
                    </div>
                    <br>
                    <?php endforeach; ?>
                    <br>
                </div>

                <div class="inspirative-image">
                <!-- Source of the image used: https://www.socialmediabutterflyblog.com/2019/11/17-ways-to-find-more-inspiration-and-meaning-in-your-daily-life/ -->
                <figure>
                    <img src="Images/description_image4.png" alt="description image for inspiration">
                </figure>
                </div>
            </section>

            <!-- This is the final section, revealing some fun facts about the group members -->
            <section class="funfact" aria-labelledby="section-title4">
                <div class="funfact-image">
                <!-- Source of the image used: https://stock.adobe.com/search?k=fun+fact&asset_id=194933763 -->
                <figure>
                    <img src="Images/description_image5.png" alt="description image for fun facts">
                </figure>
                </div>

                <!-- This is a table used to present fun facts about the team members -->
                <div class="member-secret">
                <h2 class="about-titles" id="section-title4"> <strong> Finally... Our thrilling secrets! </strong> </h2> <br>
                <table>
                    <caption> <span aria-hidden="true"> 🧐 </span> These are things that help you to know more about us </caption>
                    <thead>
                        <tr>
                            <th colspan="3" class="table-header"> <span aria-hidden="true"> 🔍 </span> FUN FACTS ABOUT EACH MEMBER </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach ($members as $m): ?>
                            <td> <strong> <?= e($m['name']) ?> </strong> </td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="first-row"> <span aria-hidden="true"> 📚 </span> His favourite subject is Maths, especially when it comes to Probability and Statistics </td>
                            <td class="first-row"> <span aria-hidden="true"> 🎧 </span> He is a big fan of listening to music </td>
                            <td class="first-row"> <span aria-hidden="true"> ☕️ </span> He works as a barista, but he doesn't like coffee </td>
                        </tr>
                        <tr>
                            <td class="second-row"> <span aria-hidden="true"> 🧩 </span> He likes solving puzzles or IQ games, including Minesweeper, Sudoku and match-3 games </td>
                            <td class="second-row"> <span aria-hidden="true"> 🤖 </span> He is interested in Artificial Intelligence (AI) </td>
                            <td class="second-row"> <span aria-hidden="true"> ✈️ </span> He has never gone overseas or interstate </td>
                        </tr>
                        <tr>
                            <td class="third-row"> <span aria-hidden="true"> 🎼 </span> He loves playing kalimba, as the only instrument that he's keen on </td>
                            <td class="third-row"> <span aria-hidden="true"> ⏰ </span> He can spend a surprisingly long time trying to fix one small coding error </td>
                            <td class="third-row"> <span aria-hidden="true"> 🕹️ </span> He loves games, whether it's video, board or card games </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </section>
        </main>

        <?php include 'footer.inc'; ?>

</body>
</html>
<?php mysqli_close($conn); ?>
<?php
require_once 'settings.php';

function e($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }

// Group details (single row)
$group = [];
$res = mysqli_query($conn, "SELECT * FROM group_details LIMIT 1");
if ($res) {
    $group = mysqli_fetch_assoc($res) ?: [];
}

// Members
$members = [];
$res = mysqli_query($conn, "SELECT id, name, student_id, quote_original, quote_translation FROM team_members ORDER BY id ASC");
while ($res && $row = mysqli_fetch_assoc($res)) {
    $members[] = $row;
}

// Individual contributions: $contrib[member_id][project][] = task
$contrib = [];
$res = mysqli_query($conn, "SELECT member_id, project, task FROM member_contributions ORDER BY project, id");
while ($res && $row = mysqli_fetch_assoc($res)) {
    $contrib[$row['member_id']][$row['project']][] = $row['task'];
}

// Shared tasks: $shared[project][] = task
$shared = [];
$res = mysqli_query($conn, "SELECT project, task FROM shared_tasks ORDER BY project, id");
while ($res && $row = mysqli_fetch_assoc($res)) {
    $shared[$row['project']][] = $row['task'];
}

// Fun facts: $facts[row_num][member_id] = row
$facts = [];
$res = mysqli_query($conn, "SELECT member_id, row_num, emoji, fact FROM fun_facts ORDER BY row_num, member_id");
while ($res && $row = mysqli_fetch_assoc($res)) {
    $facts[$row['row_num']][$row['member_id']] = $row;
}
$row_classes = [1 => 'first-row', 2 => 'second-row', 3 => 'third-row'];

// Builds a bullet list of tasks for one project
function task_cell($tasks, $p) {
    if (empty($tasks[$p])) return '—';
    $out = '<ul>';
    foreach ($tasks[$p] as $t) $out .= '<li>' . e($t) . '</li>';
    return $out . '</ul>';
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
            <!-- Section 1: group details from database -->
            <section class="about-us" aria-labelledby="section-title1">
                <div class="about-group">
                <h1 class="about-titles" id="section-title1"> <strong> About Us </strong> </h1>
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

                <div class="group-photo">
                <figure>
                    <img src="Images/official-group-photo.jpg" alt="Group photo of G05 - TideTech">
                    <figcaption id="about-caption1"> <strong> <em> <span aria-hidden="true"> 😎 </span> Our epic group: Ravindu Nethsara, Johnathan Mey and Tuan Dat Quach </em> </strong> </figcaption>
                </figure>
                </div>
            </section>

            <!-- Section 2: member contributions table (Project 1 and 2) from database -->
            <section class="member-contributions" aria-labelledby="section-title2">
                <div class="contribution-image">
                <!-- Source of the image used: https://sparkstrategy.com.au/contribution-vs-attribution-intermediaries/ -->
                <figure>
                    <img src="Images/description_image3.png" alt="description image for contribution">
                </figure>
                </div>

                <div class="individual-tasks">
                <h2 class="about-titles" id="section-title2"> <strong> Member Contributions </strong> </h2>
                <table class="contribution-table">
                    <caption> <span aria-hidden="true"> 🖌️ </span> Individual Responsibilities </caption>
                    <thead>
                        <tr>
                            <th scope="col"> Member </th>
                            <th scope="col"> Project Part 1 </th>
                            <th scope="col"> Project Part 2 </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $m): ?>
                        <tr>
                            <th scope="row"> <span aria-hidden="true"> 📌 </span> <?= e($m['name']) ?> </th>
                            <td> <?= task_cell($contrib[$m['id']] ?? [], 1) ?> </td>
                            <td> <?= task_cell($contrib[$m['id']] ?? [], 2) ?> </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th scope="row"> <span aria-hidden="true"> 🤝 </span> All members </th>
                            <td> <?= task_cell($shared, 1) ?> </td>
                            <td> <?= task_cell($shared, 2) ?> </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </section>
            <br>

            <!-- Section 3: quotes from database -->
            <section class="individual-quotes" aria-labelledby="section-title3">
                <div class="inspiration">
                <h2 class="about-titles" id="section-title3"> <strong> What Inspires Us </strong> </h2>
                <br>
                    <?php foreach ($members as $m): ?>
                    <div class="quote">
                    <h3 class="member-name2"> <span aria-hidden="true"> 👤 </span> <?= e($m['name']) ?>: </h3>
                    <p> "<?= e($m['quote_original']) ?>" </p>
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

            <!-- Section 4: fun facts table from database -->
            <section class="funfact" aria-labelledby="section-title4">
                <div class="funfact-image">
                <!-- Source of the image used: https://stock.adobe.com/search?k=fun+fact&asset_id=194933763 -->
                <figure>
                    <img src="Images/description_image5.png" alt="description image for fun facts">
                </figure>
                </div>

                <div class="member-secret">
                <h2 class="about-titles" id="section-title4"> <strong> Finally... Our thrilling secrets! </strong> </h2> <br>
                <table>
                    <caption> <span aria-hidden="true"> 🧐 </span> These are things that help you to know more about us </caption>
                    <thead>
                        <tr>
                            <th colspan="<?= count($members) ?>" class="table-header"> <span aria-hidden="true"> 🔍 </span> FUN FACTS ABOUT EACH MEMBER </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach ($members as $m): ?>
                            <td> <strong> <?= e($m['name']) ?> </strong> </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php foreach ($facts as $rn => $rowFacts): ?>
                        <tr>
                            <?php foreach ($members as $m): $f = $rowFacts[$m['id']] ?? null; ?>
                            <td class="<?= e($row_classes[$rn] ?? '') ?>">
                                <?php if ($f): ?><span aria-hidden="true"> <?= e($f['emoji']) ?> </span> <?= e($f['fact']) ?><?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </section>
        </main>

        <?php include 'footer.inc'; ?>

</body>
</html>
<?php mysqli_close($conn); ?>

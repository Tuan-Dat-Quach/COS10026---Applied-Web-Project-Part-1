<?php
require_once 'settings.php';

// Escapes text so it is safe to print inside HTML
function escape_html($text) {
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
}

// Builds a bullet list of the tasks for one project, or a dash if there are none
function build_task_list_html($tasks_by_project, $project_number) {
    if (empty($tasks_by_project[$project_number])) {
        return '—';
    }
    $list_html = '<ul>';
    foreach ($tasks_by_project[$project_number] as $task_description) {
        $list_html .= '<li>' . escape_html($task_description) . '</li>';
    }
    return $list_html . '</ul>';
}

// Joins names into a readable sentence: "A", "A and B" or "A, B and C"
function build_member_names_sentence($member_names) {
    $name_count = count($member_names);

    if ($name_count === 0) {
        return '';
    }
    if ($name_count === 1) {
        return $member_names[0];
    }

    $last_member_name = array_pop($member_names);
    return implode(', ', $member_names) . ' and ' . $last_member_name;
}

// Group details (single row)
$group_details = [];
$group_query_result = mysqli_query($conn, "SELECT * FROM group_details LIMIT 1");
if ($group_query_result) {
    $group_details = mysqli_fetch_assoc($group_query_result) ?: [];
}

// Team members
$team_members = [];
$members_query_result = mysqli_query($conn, "SELECT id, name, student_id, quote_original, quote_translation FROM team_members ORDER BY id ASC");
while ($members_query_result && $member_row = mysqli_fetch_assoc($members_query_result)) {
    $team_members[] = $member_row;
}

// Group photo caption, built from the member names in the database
$member_names = array_column($team_members, 'name');
$member_names_sentence = build_member_names_sentence($member_names);
$group_photo_caption = 'Our epic group';
if ($member_names_sentence !== '') {
    $group_photo_caption .= ': ' . $member_names_sentence;
}

// Group photo alt text, built from the group number and name
$group_photo_alt_text = 'Group photo of ' . ($group_details['group_number'] ?? '') . ' - ' . ($group_details['group_name'] ?? '');

// Individual contributions: $contributions_by_member[member_id][project_number][] = task
$contributions_by_member = [];
$contributions_query_result = mysqli_query($conn, "SELECT member_id, project, task FROM member_contributions ORDER BY project, id");
while ($contributions_query_result && $contribution_row = mysqli_fetch_assoc($contributions_query_result)) {
    $contributions_by_member[$contribution_row['member_id']][$contribution_row['project']][] = $contribution_row['task'];
}

// Shared tasks: $shared_tasks_by_project[project_number][] = task
$shared_tasks_by_project = [];
$shared_query_result = mysqli_query($conn, "SELECT project, task FROM shared_tasks ORDER BY project, id");
while ($shared_query_result && $shared_task_row = mysqli_fetch_assoc($shared_query_result)) {
    $shared_tasks_by_project[$shared_task_row['project']][] = $shared_task_row['task'];
}

// Fun facts: $fun_facts_by_row[row_number][member_id] = fun fact row
$fun_facts_by_row = [];
$fun_facts_query_result = mysqli_query($conn, "SELECT member_id, row_num, emoji, fact FROM fun_facts ORDER BY row_num, member_id");
while ($fun_facts_query_result && $fun_fact_row = mysqli_fetch_assoc($fun_facts_query_result)) {
    $fun_facts_by_row[$fun_fact_row['row_num']][$fun_fact_row['member_id']] = $fun_fact_row;
}
$fun_fact_row_classes = [1 => 'first-row', 2 => 'second-row', 3 => 'third-row'];
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
            <!-- Section 1: group details and group photo from database -->
            <section class="about-us" aria-labelledby="section-title1">
                <div class="about-group">
                <h1 class="about-titles" id="section-title1">  About Us </h1>
                <ul>
                    <li> Our group's super-duper cool name: <strong id="epic-name"> <?= escape_html($group_details['group_name'] ?? '') ?> </strong> </li>
                    <li> Our group's members and Student IDs:
                        <ol class="student-id">
                            <?php foreach ($team_members as $member): ?>
                            <li> <span aria-hidden="true"> 👤 </span> <?= escape_html($member['name']) ?> - <strong> <?= escape_html($member['student_id']) ?> </strong> </li>
                            <?php endforeach; ?>
                        </ol>
                    </li>
                    <li> Our tutorial class day, time and location:
                        <ol>
                            <li> Day: <?= escape_html($group_details['tutorial_day'] ?? '') ?> <span aria-hidden="true"> 📆 </span> </li>
                            <li> Time: <?= escape_html($group_details['tutorial_time'] ?? '') ?> <span aria-hidden="true"> ⏰ </span> </li>
                            <li> Location: <?= escape_html($group_details['tutorial_location'] ?? '') ?> <span aria-hidden="true"> 📍 </span> </li>
                        </ol>
                    </li>
                    <li> Our group number: <?= escape_html($group_details['group_number'] ?? '') ?> </li>
                    <li> Our scenario: <?= escape_html($group_details['scenario'] ?? '') ?> </li>
                </ul>
                </div>

                <div class="group-photo">
                <?php if (!empty($group_details['group_photo'])): ?>
                <figure>
                    <img src="<?= escape_html($group_details['group_photo']) ?>" alt="<?= escape_html($group_photo_alt_text) ?>">
                    <figcaption id="about-caption1"> <strong> <span aria-hidden="true"> 😎 </span> <?= escape_html($group_photo_caption) ?> </strong> </figcaption>
                </figure>
                <?php endif; ?>
                </div>
            </section>

            <!-- Section 2: member contributions table (Project 1 and 2) from database -->
            <section class="member-contributions" aria-labelledby="section-title2">
                <h2 class="about-titles" id="section-title2"> Member Contributions </h2>
                <table class="contribution-table">
                    <thead>
                        <tr>
                            <th scope="col" class="table-header"> Member </th>
                            <th scope="col" class="table-header"> Project Part 1 </th>
                            <th scope="col" class="table-header"> Project Part 2 </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($team_members as $member): ?>
                        <tr>
                            <th scope="row"> <span aria-hidden="true"> 📌 </span> <?= escape_html($member['name']) ?> </th>
                            <td> <?= build_task_list_html($contributions_by_member[$member['id']] ?? [], 1) ?> </td>
                            <td> <?= build_task_list_html($contributions_by_member[$member['id']] ?? [], 2) ?> </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th scope="row"> <span aria-hidden="true"> 🤝 </span> All members </th>
                            <td> <?= build_task_list_html($shared_tasks_by_project, 1) ?> </td>
                            <td> <?= build_task_list_html($shared_tasks_by_project, 2) ?> </td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <br>

            <!-- Section 3: quotes from database -->
            <section class="individual-quotes" aria-labelledby="section-title3">
                <div class="inspiration">
                <h2 class="about-titles" id="section-title3"> What Inspires Us </h2>
                <br>
                    <?php foreach ($team_members as $member): ?>
                    <div class="quote">
                    <h3 class="member-name2"> <span aria-hidden="true"> 👤 </span> <?= escape_html($member['name']) ?>: </h3>
                    <p> "<?= escape_html($member['quote_original']) ?>" </p>
                    <p> => English Translation: "<?= escape_html($member['quote_translation']) ?>" </p>
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
                <h2 class="about-titles" id="section-title4"> Finally... Our thrilling secrets! </h2> <br>
                <table>
                    <caption> <span aria-hidden="true"> 🧐 </span> These are things that help you to know more about us </caption>
                    <thead>
                        <tr>
                            <th colspan="<?= count($team_members) ?>" class="table-header"> <span aria-hidden="true"> 🔍 </span> FUN FACTS ABOUT EACH MEMBER </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach ($team_members as $member): ?>
                            <td> <strong> <?= escape_html($member['name']) ?> </strong> </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php foreach ($fun_facts_by_row as $row_number => $facts_in_row): ?>
                        <tr>
                            <?php foreach ($team_members as $member): $fun_fact = $facts_in_row[$member['id']] ?? null; ?>
                            <td class="<?= escape_html($fun_fact_row_classes[$row_number] ?? '') ?>">
                                <?php if ($fun_fact): ?><span aria-hidden="true"> <?= escape_html($fun_fact['emoji']) ?> </span> <?= escape_html($fun_fact['fact']) ?><?php endif; ?>
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
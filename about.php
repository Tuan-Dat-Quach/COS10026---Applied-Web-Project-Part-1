<?php
require_once 'settings.php';

/* Retrieve group details from greener_society.group_details */
$groupDetails = [];

$groupSql = "SELECT detail_key, detail_value FROM group_details";
$groupResult = mysqli_query($conn, $groupSql);

if (!$groupResult) {
    die("Error retrieving group details: " . mysqli_error($conn));
}

while ($detail = mysqli_fetch_assoc($groupResult)) {
    $groupDetails[$detail['detail_key']] = $detail['detail_value'];
}

/* Retrieve team members from greener_society.team_members */
$members = [];

$memberSql = "SELECT * FROM team_members ORDER BY id";
$memberResult = mysqli_query($conn, $memberSql);

if (!$memberResult) {
    die("Error retrieving team members: " . mysqli_error($conn));
}

while ($member = mysqli_fetch_assoc($memberResult)) {
    $members[] = $member;
}

/* Escape database values before displaying them */
function aboutEscape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/* Retrieve a group detail, with a fallback value */
function getGroupDetail($key, $fallback = '')
{
    global $groupDetails;

    return aboutEscape($groupDetails[$key] ?? $fallback);
}

/* Split responsibilities into separate list items */
function getResponsibilities($responsibilities)
{
    return preg_split(
        '/[\r\n|;]+/',
        (string) $responsibilities,
        -1,
        PREG_SPLIT_NO_EMPTY
    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Recruitment Website for Greener Society! Here you can find out about the company's details and opportunities to participate in conserving the environment.">
    <meta name="keywords" content="Environmental Conservation, GS, Greener Society, Protect Environment, Recruitment">
    <meta name="author" content="TechTide Group">

    <title>Greener Society - Recruitment Website</title>

    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
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

    <!-- About Us -->
    <section class="about-us" aria-labelledby="section-title1">

        <div class="about-group">
            <h1 class="about-titles" id="section-title1">
                <strong>About Us</strong>
            </h1>

            <ul>
                <li>
                    Our group's super-duper cool name:
                    <strong id="epic-name">
                        <?= getGroupDetail('group_name', 'TechTide'); ?>
                    </strong>
                </li>

                <li>
                    Our group's members and Student IDs:
                    <ol class="student-id">
                        <?php if (!empty($members)): ?>
                            <?php foreach ($members as $member): ?>
                                <li>
                                    <span aria-hidden="true">👤</span>
                                    <?= aboutEscape($member['name'] ?? ''); ?> -
                                    <strong>
                                        <?= aboutEscape($member['student_id'] ?? ''); ?>
                                    </strong>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No team members found.</li>
                        <?php endif; ?>
                    </ol>
                </li>

                <li>
                    Our tutorial class day, time and location:
                    <ol>
                        <li>
                            Day:
                            <?= getGroupDetail(
                                'tutorial_day',
                                'Every Thursday (Except for Mid-term Break)'
                            ); ?>
                            <span aria-hidden="true">📆</span>
                        </li>

                        <li>
                            Time:
                            <?= getGroupDetail(
                                'tutorial_time',
                                '12:30 p.m. to 14:30 p.m.'
                            ); ?>
                            <span aria-hidden="true">⏰</span>
                        </li>

                        <li>
                            Location:
                            <?= getGroupDetail(
                                'tutorial_location',
                                'Room BA513, Floor 5 at BA Building'
                            ); ?>
                            <span aria-hidden="true">📍</span>
                        </li>
                    </ol>
                </li>

                <li>
                    Our group number:
                    <?= getGroupDetail('group_number', 'G05'); ?>
                </li>

                <li>
                    Our scenario:
                    <?= getGroupDetail(
                        'scenario',
                        'An environmental organisation strengthening its online presence to promote conservation projects, community campaigns, educational resources, volunteer opportunities and public donations.'
                    ); ?>
                </li>
            </ul>
        </div>

        <div class="group-photo">
            <figure>
                <img src="Images/official-group-photo.jpg"
                     alt="Group photo of G05 - TechTide">

                <figcaption id="about-caption1">
                    <strong>
                        <em>
                            <span aria-hidden="true">😎</span>
                            Our epic group:
                            <?php
                            $memberNames = [];

                            foreach ($members as $member) {
                                $memberNames[] = $member['name'] ?? '';
                            }

                            echo aboutEscape(implode(', ', $memberNames));
                            ?>
                        </em>
                    </strong>
                </figcaption>
            </figure>
        </div>

    </section>

    <!-- Member Contributions -->
    <section class="member-contributions" aria-labelledby="section-title2">

        <div class="contribution-image">
            <figure>
                <img src="Images/description_image3.png"
                     alt="Description image for contributions">
            </figure>
        </div>

        <div class="individual-tasks">

            <h2 class="about-titles" id="section-title2">
                <strong>Member Contributions</strong>
            </h2>

            <h3 style="font-size: 2rem; color: blue; margin-left: 0.5rem;">
                <strong>
                    <span aria-hidden="true">🖌️</span>
                    Individual Responsibilities:
                </strong>
            </h3>

            <dl>
                <?php if (!empty($members)): ?>

                    <?php foreach ($members as $member): ?>

                        <dt class="member-name1">
                            <span aria-hidden="true">📌</span>
                            <?= aboutEscape($member['name'] ?? ''); ?>
                        </dt>

                        <?php
                        $responsibilities = getResponsibilities(
                            $member['responsibilities'] ?? ''
                        );
                        ?>

                        <?php foreach ($responsibilities as $responsibility): ?>
                            <dd>
                                - <?= aboutEscape(trim($responsibility)); ?>
                            </dd>
                        <?php endforeach; ?>

                    <?php endforeach; ?>

                <?php else: ?>
                    <dd>No member contributions found.</dd>
                <?php endif; ?>

                <dt style="font-size: 2rem; color: blue; margin: 1rem 0.5rem;">
                    <strong>
                        <span aria-hidden="true">🤝</span>
                        All members:
                    </strong>
                </dt>

                <dd>- CSS style for each individual page</dd>
                <dd>- Suggesting ideas</dd>
                <dd>- Re-evaluation and finalisation</dd>
            </dl>

        </div>
    </section>

    <br>

    <!-- Individual Quotes -->
    <section class="individual-quotes" aria-labelledby="section-title3">

        <div class="inspiration">

            <h2 class="about-titles" id="section-title3">
                <strong>What Inspires Us</strong>
            </h2>

            <br>

            <?php
            $quoteClasses = ['TDQ-Quote', 'RN-Quote', 'JM-Quote'];
            $quoteFlags = ['🇻🇳', '🇱🇰', '🇯🇵'];
            ?>

            <?php if (!empty($members)): ?>

                <?php foreach ($members as $index => $member): ?>

                    <div class="<?= aboutEscape($quoteClasses[$index] ?? 'member-quote'); ?>">

                        <h3 class="member-name2">
                            <span aria-hidden="true">👤</span>
                            <?= aboutEscape($member['name'] ?? ''); ?>:
                        </h3>

                        <p>
                            <span aria-hidden="true">
                                <?= $quoteFlags[$index] ?? '💬'; ?>
                            </span>
                            <?= aboutEscape($member['quote_original'] ?? ''); ?>
                        </p>

                        <p>
                            =&gt; English Translation:
                            <?= aboutEscape($member['quote_translation'] ?? ''); ?>
                        </p>

                    </div>

                    <br>

                <?php endforeach; ?>

            <?php else: ?>
                <p>No member quotes found.</p>
            <?php endif; ?>

            <br><br>
        </div>

        <div class="inspirative-image">
            <figure>
                <img src="Images/description_image4.png"
                     alt="Description image for inspiration">
            </figure>
        </div>

    </section>

    <!-- Fun Facts -->
    <section class="funfact" aria-labelledby="section-title4">

        <div class="funfact-image">
            <figure>
                <img src="Images/description_image5.png"
                     alt="Description image for fun facts">
            </figure>
        </div>

        <div class="member-secret">

            <h2 class="about-titles" id="section-title4">
                <strong>Finally... Our thrilling secrets!</strong>
            </h2>

            <br>

            <table>
                <caption>
                    <span aria-hidden="true">🧐</span>
                    These are things that help you to know more about us
                </caption>

                <thead>
                    <tr>
                        <th colspan="<?= max(count($members), 1); ?>"
                            class="table-header">
                            <span aria-hidden="true">🔍</span>
                            FUN FACTS ABOUT EACH MEMBER
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php foreach ($members as $member): ?>
                            <td>
                                <strong>
                                    <?= aboutEscape($member['name'] ?? ''); ?>
                                </strong>
                            </td>
                        <?php endforeach; ?>
                    </tr>

                    <tr>
                        <?php foreach ($members as $member): ?>
                            <td class="first-row">
                                <?= aboutEscape($member['fun_fact_1'] ?? ''); ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>

                    <tr>
                        <?php foreach ($members as $member): ?>
                            <td class="second-row">
                                <?= aboutEscape($member['fun_fact_2'] ?? ''); ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>

                    <tr>
                        <?php foreach ($members as $member): ?>
                            <td class="third-row">
                                <?= aboutEscape($member['fun_fact_3'] ?? ''); ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>

        </div>
    </section>

</main>

<?php include 'footer.inc'; ?>

</body>
</html>
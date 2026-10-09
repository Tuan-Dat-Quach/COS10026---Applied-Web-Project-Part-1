<?php include 'header.inc'; ?>

        <main>
            <!-- This is the first section of about.html, including group name, tutorial class day and time and the group photo -->
            <section class="about-us" aria-labelledby="section-title1">
                <div class="about-group">
                <h1 class="about-titles" id="section-title1"> <strong> About Us </strong> </h1>
                <!-- This is the nested list of <ul> and <ol> -->
                <ul>
                    <li> Our group's super-duper cool name: <strong id="epic-name"> TechTide </strong> </li>
                    <li> Our group's members and Student IDs:
                        <ol class="student-id">
                            <li> <span aria-hidden="true"> 👤 </span> Tuan Dat Quach - <strong> 106424486 </strong> </li>
                            <li> <span aria-hidden="true"> 👤 </span> Ravindu Nethsara - <strong> 105998951 </strong> </li>
                            <li> <span aria-hidden="true"> 👤 </span> Johnathan Mey - <strong> 105341872 </strong> </li>
                        </ol>
                    </li>
                    <li> Our tutorial class day, time and location:
                        <ol>
                            <li> Day: Every Thursday (Except for Mid-term Break) <span aria-hidden="true"> 📆 </span> </li>
                            <li> Time: 12:30 p.m to 14:30 p.m <span aria-hidden="true"> ⏰ </span> </li>
                            <li> Location: Room BA513, Floor 5 at BA Building <span aria-hidden="true"> 📍 </span> </li>
                        </ol>
                    </li>
                    <li> Our group number: G05 </li>
                    <li> Our scenario: An environmental organisation strengthening its online presence to promote conservation projects, community campaigns, 
                         educational resources, volunteer opportunities and public donations. </li>
                </ul>
                </div>

                <!-- This is the group photo, along with a caption -->
                <div class="group-photo">
                <figure>
                    <img src=Images/official-group-photo.jpg alt="Group photo of G05 - TideTech">
                    <figcaption id="about-caption1"> <strong> <em> <span aria-hidden="true"> 😎 </span> Our epic group: Ravindu Nethsara, Johnathan Mey and Tuan Dat Quach </em> </strong> </figcaption>
                </figure>
                </div>
            </section>

            <!-- This is the second section, displaying member contributions of our group-->
            <section class="member-contributions" aria-labelledby="section-title2">
                <div class="contribution-image">
                <!-- Source of the image used: https://sparkstrategy.com.au/contribution-vs-attribution-intermediaries/ -->
                <figure>
                    <img src="Images/description_image3.png" alt="description image for coontribution">
                </figure>
                </div>
                
                <div class="individual-tasks">
                <h2 class="about-titles" id="section-title2"> <strong> Member Contributions </strong> </h2>
                <h3 style="font-size: 2rem; color:blue; margin-left: 0.5rem;"> <strong> <span aria-hidden="true"> 🖌️ </span> Individual Responsibilities: </strong> </h3>
                <!-- This is a description list used to present member contributions -->
                <dl>
                    <dt class="member-name1"> <span aria-hidden="true"> 📌 </span> Tuan Dat Quach </dt>
                        <dd> - Main content for index.html and about.html </dd>
                        <dd> - General CSS for pages </dd>
                    <dt class="member-name1"> <span aria-hidden="true"> 📌 </span> Ravindu Nethsara </dt>
                        <dd> - Main content for jobs.html </dd>
                    <dt class="member-name1"> <span aria-hidden="true"> 📌 </span> Johnathan Mey </dt>
                        <dd> - Main content for apply.html </dd>
                        <dd> - Assignment Submission </dd>
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
                    <div class="TDQ-Quote">
                    <h3 class="member-name2"> <span aria-hidden="true"> 👤 </span> Tuan Dat Quach: </h3>
                    <p> <span aria-hidden="true"> 🇻🇳 </span> "Sâu thẳm trong tim tôi là một niềm đam mê mãnh liệt với những con số, những quy luật và tính logic chặt chẽ."
                    <p> => English Translation: "Deep from my heart lies a profound passion for numbers, principles and coherent logics." </p>
                    </div>
                    <br>
                    <div class="RN-Quote">
                    <h3 class="member-name2"> <span aria-hidden="true"> 👤 </span> Ravindu Nethsara: </h3>
                    <p> <span aria-hidden="true"> 🇱🇰 </span> "අද දවස හොඳම දවස කරගන්න." </p>
                    <p> => English Translation: "Make today your best day." </p>
                    </div>
                    <br>
                    <div class="JM-Quote">
                    <h3 class="member-name2"> <span aria-hidden="true"> 👤 </span> Johnathan Mey:  </h3>
                    <p> <span aria-hidden="true"> 🇯🇵 </span> "塵も積もれば山となる." (Chiri mo tsumoreba yama to naru) </p>
                    <p> => English Translation: "Even dust, when piled up, becomes a mountain." </p>
                    </div>
                    <br><br>
                </div>

                <div class="inspirative-image">
                <!-- Source of the image used: https://www.socialmediabutterflyblog.com/2019/11/17-ways-to-find-more-inspiration-and-meaning-in-your-daily-life/ -->
                <figure>
                    <img src=Images/description_image4.png alt="description image for inspiration"> 
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
                            <td> <strong> Tuan Dat Quach </strong> </td>
                            <td> <strong> Ravindu Nethsara </strong> </td>
                            <td> <strong> Johnathan Mey </strong> </td>
                        </tr>
                        <tr >
                            <td class="first-row"> <span aria-hidden="true"> 📚 </span> His favourite subject is Maths, especially when it comes to Probability and Statistics </td> 
                            <td class="first-row"> <span aria-hidden="true"> 🎧 </span> He is a big fan of listening to music </td> 
                            <td class="first-row"> <span aria-hidden="true"> ☕️ </span> He works as a barista, but he doesn't like coffee </td> 
                        </tr>
                        <tr>
                            <td class="second-row"> <span aria-hidden="true"> 🧩 </span> He likes solving puzzles or IQ games, including Minesweeper, Sudoku and match-3 games </td> 
                            <td class="second-row"> <span aria-hidden="true"> 🤖 </span> He is interested in Artificial Intelligence (AI) </td> 
                            <td class="second-row"> <span aria-hidden="true"> ✈️ </span> He has never gone overseas or interstate  </td> 
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
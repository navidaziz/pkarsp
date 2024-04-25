<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
    .block_div {
        border: 1px solid #9FC8E8;
        border-radius: 10px;
        min-height: 3px;
        margin: 3px;
        padding: 10px;
        background-color: white;
        color: white;
    }

    .block_div {
        border: 1px solid #9FC8E8;
        border-radius: 10px;
        min-height: 3px;
        margin: 3px;
        padding: 10px;
        background-color: #38404B;
    }

    /* Variables */
    /* Replace variables with their actual values */
    :root {
        --font: 'Roboto', sans-serif;
        --bg: #37404a;
        --white: #FFF;
        --grey: #333;
        --rose: #E87E91;
        --blue-light: #73bec8;
        --blue-lighter: #ABDAD3;
        --green: #85FFC7;
        --red: #EF5350;
    }

    /* Margin & Padding */
    .m-b-xs {
        margin-bottom: 2%;
    }

    .m-b-md {
        margin-bottom: 10%;
    }

    .m-t-xs {
        margin-top: 2%;
    }

    .m-t-sm {
        margin-top: 5%;
    }

    /* General */
    * {
        outline: 0 !important;
    }

    body {
        padding: 2% 0;
        background-color: var(--bg);
    }

    h1 {
        font-family: var(--font);
        font-size: 2.2em;
        font-weight: 300;
        color: var(--green);
        text-transform: uppercase;
    }

    p {
        font-family: var(--font);
        font-size: 1.1em;
        font-weight: 300;
        color: var(--white);
    }

    a {
        color: var(--white);
    }

    a:hover {
        text-decoration: none;
        color: var(--white);
    }

    #visits label,
    #visits .labels {
        display: block;
        margin-bottom: 2%;
        font-family: var(--font);
        font-size: 1.1em;
        font-weight: 300;
        color: var(--white);
        letter-spacing: 0.5px;
    }

    /* ... */
    /* ... */

    #visits input::-webkit-input-placeholder {
        color: transparent !important;
    }

    #visits input::-moz-placeholder {
        color: transparent !important;
    }

    #visits input:-ms-input-placeholder {
        color: transparent !important;
    }

    #visits input:-moz-placeholder {
        color: transparent !important;
    }

    #visits input,
    #visits select {
        display: block;
        width: 100%;
        overflow: hidden;
        outline: none;
        border: 2px solid var(--grey);
    }

    #visits input {
        margin-top: 1.5%;
        padding: 0 0 5px 0;
        background: transparent;
        border: none;
        outline: none;
        border-bottom: 2px solid var(--white);
        font-size: 1.1em;
        font-weight: 300;
        color: var(--green);
    }

    #visits input:focus {
        border-color: var(--green);
    }

    /* ... */

    #visits [type="checkbox"],
    #visits [type="radio"] {
        display: inline-block;
        margin: 0 10px 0 0 !important;
        position: relative;
        top: 5px;
        right: 0;
        bottom: 0;
        left: 0;
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        -o-appearance: none;
        appearance: none;
        height: 23px;
        width: 23px;
        transition: all 0.15s ease-out 0s;
        background: var(--bg);
        color: var(--white);
        cursor: pointer;
        outline: none;
        z-index: 1000;
        border: 1px solid var(--white);
    }

    #visits [type="checkbox"]:hover,
    #visits [type="radio"]:hover {
        border-color: var(--green);
    }

    #visits [type="checkbox"]:checked:before {
        display: inline-block;
        height: 21px;
        width: 21px;
        position: relative;
        left: 0;
        bottom: 0;
        content: "\e014";
        text-align: center;
        font-family: 'Glyphicons Halflings';
        line-height: 20px;
        font-size: 15px;
        color: var(--green);
    }

    #visits [type="checkbox"]:focus {
        outline: none;
        border-color: var(--white);
    }

    /* ... */

    #visits select {
        height: 40px;
        padding-left: 5px;
        background-color: var(--bg);
        border: 2px solid var(--white);
        color: var(--green);
    }

    #visits select option {
        padding: 5px 10px;
        font-weight: 300;
        cursor: pointer;
    }

    #visits select option:hover {
        background-color: var(--green);
    }

    /* ... */

    #visits textarea {
        resize: none;
        margin-top: 2%;
        padding: 10px 10px 0px 20px;
        width: 100%;
        height: 90px;
        color: var(--green);
        background-color: var(--bg);
        border: 2px solid var(--white);
    }

    /* ... */

    #visits .btn {
        display: inline-block;
        position: relative;
        width: 100%;
        margin: 3% 0 0 0;
        height: 45px;
        text-transform: uppercase;
        text-decoration: none;
        cursor: pointer;
        border: 3px solid var(--green);
        border-radius: 0;
        font-weight: 500;
        font-size: 1.2em;
        color: var(--green);
        text-align: center;
        background: none;
        transition: color 0.25s ease;
    }

    #visits .btn:after {
        position: absolute;
        content: '';
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background-color: var(--green);
        transform-origin: left;
        transition: width 0.5s ease;
    }

    /* Targeting radio buttons */
    #visits [type="radio"] {
        display: inline-block;
        margin: 0 10px 0 0 !important;
        position: relative;
        top: 5px;
        right: 0;
        bottom: 0;
        left: 0;
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        -o-appearance: none;
        appearance: none;
        height: 23px;
        width: 23px;
        transition: all 0.15s ease-out 0s;
        background: var(--bg);
        color: var(--white);
        cursor: pointer;
        outline: none;
        z-index: 1000;
        border: 1px solid var(--white);
    }

    /* Styling checked radio buttons */
    #visits [type="radio"]:checked:before {
        display: inline-block;
        content: "\2713";
        /* Checkmark symbol */
        font-size: 20px;
        /* Adjust size as needed */
        color: var(--green);
        /* Color of the checkmark */
        position: absolute;
        top: 0;
        left: 0;
        line-height: 23px;
    }
</style>

<body>



    <div class="container">
        <div class="row">

            <div class="col-sm-12">

                <main id="main" class="container">
                    <div class="row">
                        <div class="col-xs-12 col-lg-offset-3 col-lg-6">
                            <div class="m-b-md text-center">
                                <h1 id="title">Survey Form</h1>
                                <p id="description" class="description" class="text-center">Let us know how we can improve freeCodeCamp</p>
                            </div>



                            <table class="table table-bordered" id="visits">
                                <thead>
                                    <tr>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    $query = "SELECT v.*,  
                    s.schoolName as school_name,
                    s.registrationNumber as registration_no,
                    session_year.sessionYearTitle as session
                    FROM visits as v
                    INNER JOIN schools as s ON(s.schoolId = v.schools_id)
                    INNER JOIN school as s_session ON(s_session.schoolId = v.school_id)
                    INNER JOIN session_year ON(session_year.sessionYearId = s_session.session_year_id)
                    WHERE v.is_deleted = 0
                    ";
                                    $rows = $this->db->query($query)->result();
                                    foreach ($rows as $row) { ?>
                                        <tr>
                                            <td><a href="<?php echo site_url('visits/delete_visit/' . $row->visit_id); ?>" onclick="return confirm('Are you sure? you want to delete the record.')">Delete</a>
                                                <?php echo $count++ ?>
                                                <?php echo $row->schools_id; ?>
                                                <?php echo $row->registration_no; ?>
                                                <?php echo $row->visit_reason; ?>
                                                <?php if ($row->primary_l == 1) { ?> Primary <?php }  ?>
                                                <?php if ($row->middle_l) { ?> Middle <?php }  ?>
                                                <?php if ($row->high_l) { ?> High <?php }  ?>
                                                <?php if ($row->high_sec_l) { ?> Higer Sec. <?php }  ?>
                                                <?php if ($row->academy_l) { ?> Acadmey <?php }  ?>
                                                <?php echo $row->school_name; ?>
                                                <?php echo $row->session; ?>
                                                <?php echo $row->visited; ?>

                                                <button onclick="add_to_visit_list('<?php echo $row->visit_id; ?>')">Edit Visit</button>

                                                <?php if ($row->visited == 'No') { ?>
                                                    <button onclick="get_visit_form('<?php echo $row->visit_id; ?>')">Add Visit Report</button>
                                                <?php } else { ?>
                                                    <button onclick="get_visit_form('<?php echo $row->visit_id; ?>')">Update Visit Report</button>

                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <form method="GET" action="" id="visits" name="survey-form">
                                <fieldset>
                                    <label for="name" id="name-label">
                                        Name *
                                        <input class="" type="text" id="name" name="name" placeholder="Enter your name (required)" required />
                                    </label>
                                </fieldset>
                                <fieldset>
                                    <label for="email" id="email-label">
                                        Email *
                                        <input class="" type="email" id="email" name="email" placeholder="Enter your email (required)" required />
                                    </label>
                                </fieldset>
                                <fieldset>
                                    <label for="number" id="number-label">
                                        Age *
                                        <input class="" type="number" id="number" name="number" min="8" max="112" placeholder="Enter you age (required)" required />
                                    </label>
                                </fieldset>
                                <fieldset>
                                    <label for="dropdown">
                                        Which option best describes your current role? *
                                        <select id="dropdown" name="dropdown" class="m-t-xs">
                                            <option value="student" selected>Student</option>
                                            <option value="ftLob">Full Time Job</option>
                                            <option value="ftLearner">Full Time Learner</option>
                                            <option value="notSaying">Prefer not to say</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </label>
                                </fieldset>
                                <fieldset>
                                    <div class="labels">
                                        How likely is that you would recommend freeCodeCamp to a friend? *
                                    </div>
                                    <label class="m-b-xs">
                                        <input type="radio" name="survey-form-gender" value="definitely" checked /> Definitely
                                    </label>
                                    <label class="m-b-xs">
                                        <input type="radio" name="survey-form-gender" value="maybe" /> Maybe
                                    </label>
                                    <label class="m-b-xs">
                                        <input type="radio" name="survey-form-gender" value="notSure" /> Not sure
                                    </label>
                                </fieldset>
                                <fieldset>
                                    <label for="survey-form-like">
                                        What do you like most in FCC:
                                        <select id="survey-form-like" name="survey-form-like" class="m-t-xs">
                                            <option value="challenges" selected>Challenges</option>
                                            <option value="projects">Projects</option>
                                            <option value="community">Community</option>
                                            <option value="openSource">Open Source</option>
                                        </select>
                                    </label>
                                </fieldset>
                                <fieldset>
                                    <div class="labels">
                                        Things that should be improved in the future (Check all that apply):
                                    </div>
                                    <label for="survey-form-improve1" class="m-b-xs">
                                        <input type="checkbox" id="survey-form-improve1" value="feProjects">
                                        Front-end Projects
                                    </label>
                                    <label for="survey-form-improve2" class="m-b-xs">
                                        <input type="checkbox" id="survey-form-improve2" value="beProjects">
                                        Back-end Projects
                                    </label>
                                    <label for="survey-form-improve3" class="m-b-xs">
                                        <input type="checkbox" id="survey-form-improve3" value="dataVisualization">
                                        Data Visualization
                                    </label>
                                    <label for="survey-form-improve4" class="m-b-xs">
                                        <input type="checkbox" id="survey-form-improve4" value="challenges">
                                        Challenges
                                    </label>
                                    <label for="survey-form-improve5" class="m-b-xs">
                                        <input type="checkbox" id="survey-form-improve5" value="openSources">
                                        Open Source Community
                                    </label>
                                    <label for="survey-form-improve6" class="m-b-xs">
                                        <input type="checkbox" id="survey-form-improve6" value="gitter">
                                        Gitter help rooms
                                    </label>
                                    <label for="survey-form-improve7" class="m-b-xs">
                                        <input type="checkbox" id="survey-form-improve7" value="videos">
                                        Videos
                                    </label>
                                    <label for="survey-form-improve8" class="m-b-xs">
                                        <input type="checkbox" id="survey-form-improve8" value="meetup">
                                        City Meetups
                                    </label>
                                    <label for="survey-form-improve9" class="m-b-xs">
                                        <input type="checkbox" id="survey-form-improve9" value="wiki">
                                        Wiki
                                    </label>
                                    <label for="survey-form-improve10" class="m-b-xs">
                                        <input type="checkbox" id="survey-form-improve10" value="forum">
                                        Forum
                                    </label>
                                    <label for="survey-form-improve11" class="m-b-xs">
                                        <input type="checkbox" id="survey-form-improve11" value="additional">
                                        Additional Courses
                                    </label>
                                </fieldset>
                                <fieldset>
                                    <label for="survey-form-suggestions">
                                        Any Comments or Suggestions?
                                        <textarea id="survey-form-suggestions" maxlength="194"></textarea>
                                    </label>
                                </fieldset>
                                <button id="submit" type="submit" class="btn">Submit the form</button>
                            </form>
                            <div class="copyright m-t-sm">
                                <div>By Adèle Royer with <i class="glyphicon glyphicon-heart"></i></div>
                            </div>
                        </div>
                    </div>
                </main>

            </div>

        </div>
    </div>

</body>

</html>
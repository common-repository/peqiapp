<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="peqiapp-page">
    <?php require_once PEQIAPP_PATH . 'pages/header.php'; ?>

    <div id="survey-page">
        <div class="card-container">
            <div class="text">
                <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/survey.png'); ?>" alt="survey" class="image-title">
                <div class="heading-1-xl">
                    Survey</div>
                <div class="typography">
                    <p class="paragraph-2-m">Just a few questions before we start.</p>
                </div>
            </div>
            <form method="post" class="form-inputs">

                <p class="label-survey">Who’s site is this?</p>
                <div class="container-input">
                    <div class="subcontainer-input">
                        <select class="input-select" id="peqi_question_two" name="peqi_question_two" required>
                            <option value="option_1">It’s my site</option>
                            <option value="option_2">It’s from the company i work in</option>
                            <option value="option_3">It’s from a client</option>
                        </select>
                    </div>
                </div>

                <p class="label-survey">What is this site for?</p>
                <div class="container-input">
                    <div class="subcontainer-input">
                        <select class="input-select" id="peqi_question_two" name="peqi_question_two" required>
                            <option value="option_1">Online presence</option>
                            <option value="option_2">Lead generations</option>
                            <option value="option_3">Sales/e-commerce</option>
                            <option value="option_4">Content distribution (ex: Blogs)</option>
                        </select>
                    </div>
                </div>

                <p class="label-survey">What do you expect from Peqi?</p>
                <div class="container-input">
                    <div class="subcontainer-input">
                        <select class="input-select" id="peqi_question_two" name="peqi_question_two" required>
                            <option value="option_1">Decrease bounce rate</option>
                            <option value="option_2">Increase performance</option>
                            <option value="option_3">Improve Webcore Vitals</option>
                            <option value="option_4">Increase security</option>
                        </select>
                    </div>
                </div>

                <p class="label-survey">Do you use other performance plugins?</p>
                <div class="container-input">
                    <div class="subcontainer-input">
                        <select class="input-select" id="peqi_question_two" name="peqi_question_two" required>
                            <option value="option_1">Yes</option>
                            <option value="option_2">No</option>
                        </select>
                    </div>
                </div>

                <p class="label-survey">Do you use or know about CDN?</p>
                <div class="container-input">
                    <div class="subcontainer-input">
                        <select class="input-select" id="peqi_question_two" name="peqi_question_two" required>
                            <option value="option_1">Yes</option>
                            <option value="option_2">No</option>
                        </select>
                    </div>
                </div>

                <p class="label-survey">How has your experience with Peqi been so far?</p>
                <div class="container-input">
                    <div class="subcontainer-input">
                        <label for="peqi_question_three" class="label-input">Write a feedback</label>
                        <textarea class="input" id="peqi_question_three" name="peqi_question_three" rows="4" cols="20" required></textarea>
                    </div>
                </div>


                <div class="button-login-text">
                    <button class="primary-button" type="submit" name="peqi_send_survey">Continue the onboarding</button>
                </div>
            </form>
        </div>
    </div>
</div>
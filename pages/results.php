<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
if (!defined('ABSPATH')) {
    exit;
}

$peqified_url = 'https://' . PEQI_WEBSITE . '.peqified.net';

?>

<div class="peqiapp-page">
    <?php require_once PEQIAPP_PATH . 'pages/header.php'; ?>

    <div id="results-page">
        <div class="card-container">
            <div class="text">
                <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/magic.png'); ?>" alt="magic" class="image-title">
                <div class="heading-1-xl">
                    Results preview
                </div>
            </div>

            <div class="frame-2780">
                <div class="tag">
                    <svg class="seal-check" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.1163 6.42625C13.8806 6.18 13.6369 5.92625 13.545 5.70312C13.46 5.49875 13.455 5.16 13.45 4.83187C13.4406 4.22187 13.4306 3.53062 12.95 3.05C12.4694 2.56937 11.7781 2.55937 11.1681 2.55C10.84 2.545 10.5013 2.54 10.2969 2.455C10.0744 2.36312 9.82 2.11937 9.57375 1.88375C9.1425 1.46937 8.6525 1 8 1C7.3475 1 6.85812 1.46937 6.42625 1.88375C6.18 2.11937 5.92625 2.36312 5.70312 2.455C5.5 2.54 5.16 2.545 4.83187 2.55C4.22187 2.55937 3.53062 2.56937 3.05 3.05C2.56937 3.53062 2.5625 4.22187 2.55 4.83187C2.545 5.16 2.54 5.49875 2.455 5.70312C2.36312 5.92562 2.11937 6.18 1.88375 6.42625C1.46937 6.8575 1 7.3475 1 8C1 8.6525 1.46937 9.14187 1.88375 9.57375C2.11937 9.82 2.36312 10.0737 2.455 10.2969C2.54 10.5013 2.545 10.84 2.55 11.1681C2.55937 11.7781 2.56937 12.4694 3.05 12.95C3.53062 13.4306 4.22187 13.4406 4.83187 13.45C5.16 13.455 5.49875 13.46 5.70312 13.545C5.92562 13.6369 6.18 13.8806 6.42625 14.1163C6.8575 14.5306 7.3475 15 8 15C8.6525 15 9.14187 14.5306 9.57375 14.1163C9.82 13.8806 10.0737 13.6369 10.2969 13.545C10.5013 13.46 10.84 13.455 11.1681 13.45C11.7781 13.4406 12.4694 13.4306 12.95 12.95C13.4306 12.4694 13.4406 11.7781 13.45 11.1681C13.455 10.84 13.46 10.5013 13.545 10.2969C13.6369 10.0744 13.8806 9.82 14.1163 9.57375C14.5306 9.1425 15 8.6525 15 8C15 7.3475 14.5306 6.85812 14.1163 6.42625ZM10.8538 6.85375L7.35375 10.3538C7.30731 10.4002 7.25217 10.4371 7.19147 10.4623C7.13077 10.4874 7.06571 10.5004 7 10.5004C6.93429 10.5004 6.86923 10.4874 6.80853 10.4623C6.74783 10.4371 6.69269 10.4002 6.64625 10.3538L5.14625 8.85375C5.05243 8.75993 4.99972 8.63268 4.99972 8.5C4.99972 8.36732 5.05243 8.24007 5.14625 8.14625C5.24007 8.05243 5.36732 7.99972 5.5 7.99972C5.63268 7.99972 5.75993 8.05243 5.85375 8.14625L7 9.29313L10.1462 6.14625C10.1927 6.09979 10.2479 6.06294 10.3086 6.0378C10.3692 6.01266 10.4343 5.99972 10.5 5.99972C10.5657 5.99972 10.6308 6.01266 10.6914 6.0378C10.7521 6.06294 10.8073 6.09979 10.8538 6.14625C10.9002 6.1927 10.9371 6.24786 10.9622 6.30855C10.9873 6.36925 11.0003 6.4343 11.0003 6.5C11.0003 6.5657 10.9873 6.63075 10.9622 6.69145C10.9371 6.75214 10.9002 6.8073 10.8538 6.85375Z" fill="#000814" />
                    </svg>
                    <div class="recomended"> Website ready </div>
                </div>
                <p class="url-title"> The peqified version of your site is ready and available at: </p>
                <a class="pill" id="url-peqified" href="<?php echo $peqified_url; ?>" target="_blank">
                    <svg class="link-simple" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.3539 5.6465C10.4004 5.69294 10.4373 5.74808 10.4625 5.80878C10.4876 5.86948 10.5006 5.93455 10.5006 6.00025C10.5006 6.06596 10.4876 6.13102 10.4625 6.19172C10.4373 6.25242 10.4004 6.30757 10.3539 6.354L6.35393 10.354C6.30747 10.4005 6.25232 10.4373 6.19163 10.4624C6.13093 10.4876 6.06588 10.5005 6.00018 10.5005C5.93448 10.5005 5.86943 10.4876 5.80873 10.4624C5.74803 10.4373 5.69288 10.4005 5.64643 10.354C5.59997 10.3075 5.56312 10.2524 5.53798 10.1917C5.51284 10.131 5.4999 10.066 5.4999 10.0003C5.4999 9.93456 5.51284 9.8695 5.53798 9.8088C5.56312 9.74811 5.59997 9.69296 5.64643 9.6465L9.64643 5.6465C9.69286 5.60001 9.74801 5.56313 9.80871 5.53797C9.86941 5.51281 9.93447 5.49986 10.0002 5.49986C10.0659 5.49986 10.1309 5.51281 10.1916 5.53797C10.2523 5.56313 10.3075 5.60001 10.3539 5.6465ZM13.4752 2.52525C13.1502 2.20021 12.7643 1.94237 12.3397 1.76646C11.915 1.59054 11.4598 1.5 11.0002 1.5C10.5405 1.5 10.0854 1.59054 9.6607 1.76646C9.23604 1.94237 8.85019 2.20021 8.52518 2.52525L6.64643 4.40338C6.55261 4.4972 6.4999 4.62445 6.4999 4.75713C6.4999 4.88981 6.55261 5.01706 6.64643 5.11088C6.74025 5.2047 6.8675 5.25741 7.00018 5.25741C7.13286 5.25741 7.26011 5.2047 7.35393 5.11088L9.23268 3.23588C9.70323 2.77566 10.3363 2.51957 10.9945 2.5232C11.6527 2.52682 12.2829 2.78987 12.7483 3.25524C13.2138 3.72061 13.4769 4.35077 13.4807 5.00895C13.4844 5.66714 13.2284 6.30024 12.7683 6.77088L10.8889 8.64963C10.7951 8.74337 10.7424 8.87053 10.7423 9.00316C10.7423 9.13578 10.7949 9.26299 10.8886 9.35682C10.9824 9.45064 11.1095 9.50338 11.2421 9.50344C11.3748 9.50349 11.502 9.45087 11.5958 9.35713L13.4752 7.47525C13.8002 7.15024 14.0581 6.76439 14.234 6.33973C14.4099 5.91506 14.5004 5.45991 14.5004 5.00025C14.5004 4.5406 14.4099 4.08544 14.234 3.66078C14.0581 3.23612 13.8002 2.85026 13.4752 2.52525ZM8.64643 10.889L6.76768 12.7678C6.53648 13.0041 6.26068 13.1923 5.95625 13.3214C5.65182 13.4505 5.32482 13.5179 4.99416 13.5197C4.66351 13.5215 4.33578 13.4577 4.02995 13.332C3.72412 13.2063 3.44626 13.0212 3.21247 12.7873C2.97868 12.5535 2.7936 12.2756 2.66794 11.9698C2.54229 11.6639 2.47855 11.3362 2.48043 11.0055C2.48231 10.6749 2.54977 10.3479 2.67889 10.0435C2.80802 9.73905 2.99625 9.46329 3.23268 9.23213L5.1108 7.354C5.20462 7.26018 5.25733 7.13293 5.25733 7.00025C5.25733 6.86757 5.20462 6.74032 5.1108 6.6465C5.01698 6.55268 4.88974 6.49997 4.75705 6.49997C4.62437 6.49997 4.49712 6.55268 4.4033 6.6465L2.52518 8.52525C1.86877 9.18166 1.5 10.0719 1.5 11.0003C1.5 11.9286 1.86877 12.8188 2.52518 13.4753C3.18159 14.1317 4.07187 14.5004 5.00018 14.5004C5.92848 14.5004 6.81877 14.1317 7.47518 13.4753L9.35393 11.5959C9.44767 11.5021 9.50029 11.3748 9.50024 11.2422C9.50018 11.1096 9.44744 10.9824 9.35362 10.8887C9.2598 10.795 9.13258 10.7423 8.99996 10.7424C8.86733 10.7424 8.74017 10.7952 8.64643 10.889Z" fill="#000814" />
                    </svg>
                    <p class="url-peqified"><?php echo $peqified_url; ?></p>
                </a>
                <p class="url-subtitle">Be sure to access the link and check if the peqified version is working as intended</p>
            </div>

            <div class="frame-2799">
                <div class="frame-2802">
                    <div class="tag">
                        <svg class="chart-line" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.75 13C14.75 13.1989 14.671 13.3897 14.5303 13.5303C14.3897 13.671 14.1989 13.75 14 13.75H2C1.80109 13.75 1.61032 13.671 1.46967 13.5303C1.32902 13.3897 1.25 13.1989 1.25 13V3C1.25 2.80109 1.32902 2.61032 1.46967 2.46967C1.61032 2.32902 1.80109 2.25 2 2.25C2.19891 2.25 2.38968 2.32902 2.53033 2.46967C2.67098 2.61032 2.75 2.80109 2.75 3V8.34688L5.50625 5.9375C5.63564 5.82429 5.80001 5.75897 5.97181 5.75249C6.14362 5.746 6.31244 5.79874 6.45 5.90188L9.96375 8.53687L13.5063 5.4375C13.5788 5.36507 13.6655 5.30828 13.7609 5.27065C13.8562 5.23303 13.9583 5.21536 14.0608 5.21874C14.1633 5.22212 14.264 5.24648 14.3567 5.29031C14.4494 5.33414 14.5321 5.39651 14.5997 5.47357C14.6674 5.55063 14.7185 5.64074 14.7499 5.73833C14.7814 5.83593 14.7925 5.93893 14.7826 6.04098C14.7726 6.14304 14.7419 6.24197 14.6922 6.33167C14.6425 6.42137 14.575 6.49993 14.4937 6.5625L10.4937 10.0625C10.3644 10.1757 10.2 10.241 10.0282 10.2475C9.85638 10.254 9.68756 10.2013 9.55 10.0981L6.03625 7.465L2.75 10.3406V12.25H14C14.1989 12.25 14.3897 12.329 14.5303 12.4697C14.671 12.6103 14.75 12.8011 14.75 13Z" fill="#000814" />
                        </svg>
                        <div class="recomended"> Peqi results </div>
                    </div>
                    <p class="paragraph"> These are the average peqi results, but it can be ever better for your website! </p>
                    <p class="paragraph"> We are working hard on your site. The results will be available shotly after the onboarding is complete. </p>
                    <p class="paragraph"> The more you stay with Peqi, the better yours results become. </p>
                </div>
                <div class="frame-2801">
                    <div class="ellipse-274">
                    </div>
                    <div class="ellipse-275">
                    </div>
                    <p class="score"> Score </p>
                    <p class="score-value"> +60% </p>
                </div>
                <div class="frame-2805">
                    <div class="peqi-grade">
                        <p class="peqi-grade2"> Peqi Grade </p>
                        <div class="frame-2803">
                            <div class="frame-2800">
                                <p class="grade"> Grade </p>
                                <div class="after-peqi">
                                    <p class="grade-value"> A </p>
                                </div>
                            </div>
                            <div class="frame-2798">
                                <p class="performance"> Performance </p>
                                <p class="performance-value"> +40% </p>
                            </div>
                            <div class="frame-27992">
                                <p class="structure"> Structure </p>
                                <p class="structure-value"> +53% </p>
                            </div>
                        </div>
                    </div>
                    <div class="web-vital">
                        <p class="web-vital2"> Web vital </p>
                        <div class="frame-2804">
                            <div class="frame-2798">
                                <p class="largest-contentful-paint"> Largest Contentful Paint </p>
                                <p class="largest-contentful-paint-value"> +40% </p>
                            </div>
                            <div class="frame-27992">
                                <p class="total-blocking-time"> Total Blocking time </p>
                                <p class="total-blocking-time-value"> +53% </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="onboard-content2">
                <div class="frame-314">
                    <div class="lets-configure-your-dns">
                        <form method="post" class="form-inputs" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <input type="hidden" name="action" value="peqi_activate_plan_form">
                            <input type="hidden" name="peqi_website" value="<?php echo esc_attr(PEQI_WEBSITE); ?>" />
                            <div class="button-login-text" style="width: 760px;">
                                <button class="primary-button" type="submit" name="peqi_render_step3">ACTIVATE PEQIFIED VERSION!</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
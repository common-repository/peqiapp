<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
if (!defined('ABSPATH')) {
    exit;
}

$reports = PeqiApp_API::get_reports();
$reports = json_decode(wp_remote_retrieve_body($reports), true);
$reports = isset($reports['results']) ? $reports['results'] : [];

function peqi_getColorPercent($percentage)
{
    $percentage = rtrim($percentage, '%');

    if ($percentage >= 90) {
        return 'percent-A';
    } elseif ($percentage >= 80) {
        return 'percent-B';
    } elseif ($percentage >= 70) {
        return 'percent-C';
    } elseif ($percentage >= 60) {
        return 'percent-D';
    } elseif ($percentage >= 50) {
        return 'percent-E';
    } else {
        return 'percent-F';
    }
}

function peqi_getColorGrade($grade)
{
    if ($grade == 'A') {
        return 'grade-A';
    } elseif ($grade == 'B') {
        return 'grade-B';
    } elseif ($grade == 'C') {
        return 'grade-C';
    } elseif ($grade == 'D') {
        return 'grade-D';
    } elseif ($grade == 'E') {
        return 'grade-E';
    } else {
        return 'grade-F';
    }
}

?>

<div id="reports-page">
    <div class="card-container-xl">
        <div class="title-container">
            <h3>Reports</h3>
            <h4>View your application's performance report.</h4>
        </div>

        <div class="table-container">
            <table class="reports-table">
                <thead>
                    <tr class="table-row-title">
                        <th class="table-header">DOMAIN</th>
                        <th class="table-header">GRADE</th>
                        <th class="table-header">PERFORMANCE</th>
                        <th class="table-header">STRUCTURE</th>
                        <th class="table-header">CREATED AT</th>
                        <th class="table-header">RESULTS BASE</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php foreach ($reports as $report) : ?>
                        <?php
                        $grade = $report['gtmetrix_grade'];
                        $performance = $report['performance_score'];
                        $structure = $report['structure_score'];

                        $gradeColor = peqi_getColorGrade($grade);
                        $performanceColor = peqi_getColorPercent($performance);
                        $structureColor = peqi_getColorPercent($structure);

                        $created_at = new DateTime($report['created_at']);
                        $data_formatada = $created_at->format('Y-m-d H:i');
                        $origin = $report['origin'];

                        ?>

                        <tr class="table-row hover:table-row">
                            <td class="table-cell">
                                <div>
                                    <div></div>
                                    <span class="table-span-created"><?php echo esc_html(PEQI_WEBSITE); ?></span>
                                </div>
                            </td>
                            <td class="table-cell">
                                <?php if ($grade !== null) : ?>
                                    <span class="table-span-grade <?php echo esc_html($gradeColor); ?>"><?php echo esc_html($grade); ?></span>

                                <?php else : ?>
                                    <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/loading.gif'); ?>" alt="loading" class="image-loading" width="24" height="24">
                                <?php endif; ?>
                            </td>
                            <td class="table-cell">
                                <?php if ($performance !== null) : ?>
                                    <span class="table-span-percent <?php echo esc_html($performanceColor); ?>"><?php echo esc_html($performance); ?></span>


                                <?php else : ?>
                                    <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/loading.gif'); ?>" alt="loading" class="image-loading" width="24" height="24">
                                <?php endif; ?>
                            </td>
                            <td class="table-cell">
                                <?php if ($structure !== null) : ?>
                                    <span class="table-span-percent <?php echo esc_html($structureColor); ?>"><?php echo esc_html($structure); ?></span>

                                <?php else : ?>
                                    <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/loading.gif'); ?>" alt="loading" class="image-loading" width="24" height="24">
                                <?php endif; ?>
                            </td>
                            <td class="table-cell">
                                <div>
                                    <div></div>
                                    <span class="table-span-created"><?php echo esc_html($data_formatada); ?></span>
                                </div>
                            </td>
                            <td class="table-cell">
                                <div>
                                    <div></div>
                                    <span class="table-span-created">
                                        <?php
                                        if ($origin === true) {
                                            echo "ORIGINAL";
                                        } else {
                                            echo "PEQIFIED";
                                        }
                                        ?>
                                    </span>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
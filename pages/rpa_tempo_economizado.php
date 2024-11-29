<?php include_once '../public/partials/header.php'; ?>

<div class="wrapper">
    <h1>RPA Tempo Economizado</h1>

    <form method="POST">
        <button class="btn filter" name="month" value="Jan" type="submit">Jan</button>
        <button class="btn filter" name="month" value="Feb" type="submit">Fev</button>
        <button class="btn filter" name="month" value="Mar" type="submit">Mar</button>
        <button class="btn filter" name="month" value="Apr" type="submit">Abr</button>
        <button class="btn filter" name="month" value="May" type="submit">Mai</button>
        <button class="btn filter" name="month" value="Jun" type="submit">Jun</button><br>
        <button class="btn filter" name="month" value="Jul" type="submit">Jul</button>
        <button class="btn filter" name="month" value="Aug" type="submit">Ago</button>
        <button class="btn filter" name="month" value="Sep" type="submit">Set</button>
        <button class="btn filter" name="month" value="Oct" type="submit">Out</button>
        <button class="btn filter" name="month" value="Nov" type="submit">Nov</button>
        <button class="btn filter" name="month" value="Dec" type="submit">Dez</button>
    </form>

    <?php 
        require_once '../src/db_functions/select.php';

        $currentYear = date('Y');
        $filterMonth = date('M');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $filterMonth = $_POST['month'];
        }

        // Get saved time by date
        $query = "
        SELECT 
            data_execucao,
            SUM(TIME_TO_SEC(SUBSTRING_INDEX(REPLACE(duracao, '﻿', ''), ':', 1))) AS TotalHours,
            SUM(TIME_TO_SEC(SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(duracao, '﻿', ''), ':', -2), ':', 1))) AS TotalMinutes,
            SUM(TIME_TO_SEC(SUBSTRING_INDEX(REPLACE(duracao, '﻿', ''), ':', -1))) AS TotalSeconds
        FROM rpa_historico_execucoes
        WHERE ano LIKE '$currentYear' AND data_execucao LIKE '$filterMonth%'
        GROUP BY data_execucao
        ORDER BY id_execucao ASC;";

        $hoursByDate = selectData($query);

        foreach ($hoursByDate as $row) {
            $totalHours[] = $row['TotalHours'];
            $executionDate[] = $row['data_execucao'];
            $totalMinutes[] = $row['TotalMinutes'];
            $totalSeconds[] = $row['TotalSeconds'];
            $totalDecimalTime[] = $row['TotalHours'] + ($row['TotalMinutes'] / 60) + ($row['TotalSeconds'] / 3600);
        }

        // Get total of time saved based on filter
        $query = "
        SELECT 
            SUM(TIME_TO_SEC(SUBSTRING_INDEX(REPLACE(duracao, '﻿', ''), ':', 1))) AS TotalHours,
            SUM(TIME_TO_SEC(SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(duracao, '﻿', ''), ':', -2), ':', 1))) AS TotalMinutes,
            SUM(TIME_TO_SEC(SUBSTRING_INDEX(REPLACE(duracao, '﻿', ''), ':', -1))) AS TotalSeconds
        FROM rpa_historico_execucoes
        WHERE ano LIKE '$currentYear' AND data_execucao LIKE '$filterMonth%';";

        $totalSavedHours = selectData($query);

        foreach ($totalSavedHours as $row) {
            $totalHoursSum = $row['TotalHours'] + ($row['TotalMinutes'] / 60) + ($row['TotalSeconds'] / 3600);
        }


        // Get total of time
        $query = "
        SELECT 
            SUM(TIME_TO_SEC(SUBSTRING_INDEX(REPLACE(duracao, '﻿', ''), ':', 1))) AS TotalHours,
            SUM(TIME_TO_SEC(SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(duracao, '﻿', ''), ':', -2), ':', 1))) AS TotalMinutes,
            SUM(TIME_TO_SEC(SUBSTRING_INDEX(REPLACE(duracao, '﻿', ''), ':', -1))) AS TotalSeconds
        FROM rpa_historico_execucoes;";

        $timeSavedSinceStarted = selectData($query);

        foreach ($timeSavedSinceStarted as $row) {
            $hoursSinceStarted = $row['TotalHours'] + ($row['TotalMinutes'] / 60) + ($row['TotalSeconds'] / 3600);
        }

        // Get total of executions
        $query = "
        SELECT COUNT(processo) AS NumberOfTimes 
        FROM rpa_historico_execucoes
        WHERE ano LIKE '$currentYear' AND data_execucao LIKE '$filterMonth%';";
        $processCount = selectData($query);

        foreach ($processCount as $row) {
            $numberOfTimes = htmlspecialchars($row['NumberOfTimes']);
        }

        // Get total of executions per day
        $query = "
        SELECT COUNT(processo) AS NumberOfTimes 
        FROM rpa_historico_execucoes
        WHERE ano LIKE '$currentYear' AND data_execucao LIKE '$filterMonth%' 
        GROUP BY data_execucao;";
        $processCountPerDay = selectData($query);

        foreach ($processCountPerDay as $row) {
            $executionsPerDay[] = htmlspecialchars($row['NumberOfTimes']);
        }
    ?>
    <div class="containers">
        <div class="home-box">
            <h3>Horas Econdomizadas <?php echo $filterMonth . " " . $currentYear; ?></h3>
            <canvas id="hours-saved-by-day"></canvas>
        </div>

        <div class="home-box">
            <h3>Número de Execuções <?php echo $filterMonth . " " . $currentYear; ?></h3>
            <canvas id="usage"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('hours-saved-by-day');
        const labels = <?php echo json_encode($executionDate); ?>;
        const dataChart = <?php echo json_encode($totalDecimalTime); ?>;
        const dateTitle = <?php echo json_encode($filterMonth . " " . $currentYear); ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tempo Economizado',
                    data: dataChart,
                    borderWidth: 0,
                    borderRadius: 10,
                    borderSkipped: false,
                    barPercentage: 0.5,
                    backgroundColor: '#66cc85'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    title: {
                        display: false,
                        text: 'Hours Saved ' + dateTitle
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });

        const usage = document.getElementById('usage');
        const lineLabels = <?php echo json_encode($executionDate); ?>;
        const lineData = <?php echo json_encode($executionsPerDay); ?>;

        new Chart(usage, {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: [{
                    label: 'Uso',
                    data: lineData,
                    borderWidth: 2,
                    pointRadius: 2,
                    borderSkipped: false,
                    backgroundColor: '#ff9019',
                    borderColor: '#ff9019',
                    cubicInterpolationMode: 'monotone'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    title: {
                        display: false,
                        text: 'Usage ' + dateTitle
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

    <div class="containers">
        <div class="home-box">   
            <h3>Número de Execuções</h3>
            <?php echo htmlspecialchars($numberOfTimes); ?>
        </div>
        <div class="home-box">   
            <h3>Dias de Trabalho</h3>
            <?php echo number_format($totalHoursSum / 8, 0); ?>
        </div>
        <div class="home-box">   
            <h3>Horas Economizadas <?php echo $filterMonth?></h3>
            <?php echo number_format($totalHoursSum, 1); ?>
        </div>
        <div class="home-box">   
            <h3>Desde 2023</h3>
            <?php echo number_format($hoursSinceStarted, 0) . " horas<br>"; 
                  echo number_format($hoursSinceStarted / 8, 0) . " dias trabalho";?>
        </div>
    </div>

</div>

    <div class="buttons-container">
        <a href="rpa_relatorios"><button class="btn secondary" type="button">Voltar</button></a>
    </div>

</body>
</html>

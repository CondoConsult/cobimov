<?php 
include_once '../public/partials/header.php';
include_once '../src/db_functions/select.php';

$recordsPerPage = 8;
$totalRecordsQuery = "SELECT COUNT(*) as total FROM rpa_avisos_whatsapp;";
$totalRecordsResult = selectData($totalRecordsQuery);
$totalRecords = $totalRecordsResult[0]['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max(1, min($totalPages, $currentPage));

$startRecord = ($currentPage - 1) * $recordsPerPage;

$query = "SELECT * FROM rpa_avisos_whatsapp LIMIT $startRecord, $recordsPerPage;";
$result = selectData($query);
?>

<div class="wrapper">
    <h1>Bloquear Envio Avisos WhatsApp</h1>
    <p>Informe o numero ou cliente que deseja remover da lista de envio de mensagens.</p>

    <form action="../src/db_forms/avisos_whatsapp.php" method="POST">
        <label>Telefone</label><br>
        <input type="tel" name="numero-telefone" placeholder="41999999999" required><br>
        <label>Nome Contato</label><br>
        <input type="text" name="nome-contato" required><br>
        <button class="btn primary" name="button" value="insert">Adicionar</button>
    </form><br><br>

    <div class='table-container'>
      <table class='tables'>
            <tr>
                <th>Telefone</th>
                <th>Nome Contato</th>
                <th></th>
            </tr>

    <?php 
    foreach ($result as $row) {
        $telefone = htmlspecialchars($row['telefone']);
        $nomeContato = htmlspecialchars($row['nome_contato']);
        ?>
        
        <form action="../src/db_forms/avisos_whatsapp.php" method="POST">
            <tr>

            <td><?php echo $telefone;?></td>
            <td><?php echo $nomeContato;?></td>

            <td>
              <input value="<?php echo $telefone ?>" name="numero-telefone" hidden>
              <button class="btn" name="button" value="delete" onclick="return confirm('Tem certeza que deseja remover?');">
                  <img class="processes-status-icons" src="../public/images/icons/trash.svg" alt="Delete">
              </button>
          </td>
        </form>

    <?php } ?>
      </tr>
    </table>
    </div>

    <!-- Pages -->
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?php echo $currentPage - 1; ?>">« </a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="<?php echo $i === $currentPage ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?php echo $currentPage + 1; ?>">» </a>
        <?php endif; ?>
    </div>

    <div class="buttons-container">
        <a href="rpa_avisos_whatsapp.php">
            <button class="btn secondary" type="button">Voltar</button>
        </a>
    </div>
</div>
</body>
</html>

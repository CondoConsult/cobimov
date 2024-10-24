<?php 
include_once '../public/partials/header.php';
include_once '../src/db_functions/select.php';

$query = "SELECT rpa_avisos_whatsapp.*, CondName FROM rpa_avisos_whatsapp
          LEFT JOIN Condominios 
          ON Condominios.CondID = rpa_avisos_whatsapp.condominio_id
          ORDER BY CondName ASC;";
$result = selectData($query);
?>

<div class="wrapper">
    <h1>Bloquear Envio Avisos WhatsApp</h1>
    <p>Informe o numero ou cliente que deseja remover da lista de envio de mensagens.</p>

    <form action="../src/db_forms/avisos_whatsapp.php" method="POST">
        <label>Telefone</label><br>
        <input type="tel" name="numero-telefone" placeholder="41999999999" required><br>
        <?php require_once '../src/selects/condominios.php'; ?><br>
        <label>Nome Contato</label><br>
        <input type="text" name="nome-contato" required><br>
        <button class="btn primary" name="button" value="insert">Adicionar</button>
    </form><br><br>

    <div class='table-container'>
      <table class='tables'>
            <tr>
                <th>Telefone</th>
                <th>Nome Contato</th>
                <th>Condominio</th>
                <th></th>
            </tr>

    <?php 
    foreach ($result as $row) {
        $telefone = htmlspecialchars($row['telefone']);
        $condominio = htmlspecialchars($row['CondName']);
        $nomeContato = htmlspecialchars($row['nome_contato']);
        ?>
        
        <form action="../src/db_forms/avisos_whatsapp.php" method="POST">
            <tr>

            <td><?php echo $telefone;?></td>
            <td><?php echo $nomeContato;?></td>
            <td><?php echo $condominio;?></td>

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

    <div class="buttons-container">
        <a href="rpa_avisos_whatsapp.php">
            <button class="btn secondary" type="button">Voltar</button>
        </a>
    </div>
</div>
</body>
</html>

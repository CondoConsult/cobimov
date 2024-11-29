<?php 
include_once '../public/partials/header.php';
include_once '../src/db_functions/select.php';
?>

<div class="wrapper">

    <h1>Solicitações de Pagamento - Colaboradores</h1>

    <?php

    $query = "SELECT DISTINCT(solicitante) FROM colaborador_pagamentos
                ORDER BY data_solicitacao DESC;";
    $requestBy = selectData($query);

    echo "<form method='POST'>";

    if ($accountType === 'admin') {
      echo "<label>Solicitante</label><br>
            <select name='solicitante' required>";
      foreach ($requestBy as $row) {
        $solicitante = htmlspecialchars($row['solicitante']);
        echo "<option value='" . $solicitante . "'>" . $solicitante . "</option>";
      }
      echo "</select><br>";
    }


    ?>
      <label>Status</label><br>
      <select name="status">
        <option value="">Todos</option>
        <option value="Pendente">Pendente</option>
        <option value="Aprovado">Aprovado</option>
        <option value="Pago">Pago</option>
        <option value="Negado">Negado</option>
      </select>
      <button class='btn filter'>Filtrar</button>
    </form>

    <?php

    $solicitanteFiltro = isset($_POST['solicitante']) && $_POST['solicitante'] ? $_POST['solicitante'] : '';
    $statusFiltro = isset($_POST['status']) && $_POST['status'] ? $_POST['status'] : '';

    if ($accountType === 'admin') {
      $query = "SELECT * FROM colaborador_pagamentos
      WHERE (solicitante = '$solicitanteFiltro' OR '$solicitanteFiltro' = '')
      AND (status_pagamento = '$statusFiltro' OR '$statusFiltro' = '')
      ORDER BY data_solicitacao DESC;";
      $results = selectData($query);
    } else {
      $query = "SELECT * FROM colaborador_pagamentos
      WHERE solicitante = '$username'
      AND (status_pagamento = '$statusFiltro' OR '$statusFiltro' = '')
      ORDER BY data_solicitacao DESC;";
      $results = selectData($query);
    }

    echo "<h3>". $solicitanteFiltro ." " . $statusFiltro . "</h3>";
                  
    echo "<div class='table-container'>
            <table class='tables'>
              <tr>
                <th>Data</th> 
                <th>Descrição</th>
                <th>Metodo Pagamento</th>
                <th>Valor</th>
                <th>Solicitante</th>
                <th>Status</th>
                <th></th>
              </tr>";

              foreach ($results as $row) {
                  $dataSolicitacao = date('d/m/Y', strtotime(htmlspecialchars($row['data_solicitacao'])));
                  $classe = htmlspecialchars($row['classe']);
                  $descricao = htmlspecialchars($row['descricao']);
                  $metodoPagamento = htmlspecialchars($row['metodo_pagamento']);
                  $pixBoleto = htmlspecialchars($row['chave_pix_boleto']);
                  $valor = htmlspecialchars($row['valor']);
                  $statusPagamento = htmlspecialchars($row['status_pagamento']);
                  $solicitante = htmlspecialchars($row['solicitante']);
                  $pagamentoID = htmlspecialchars($row['pagamento_id']);
                  $anexo = htmlspecialchars($row['anexo']);
              
                  echo "<tr>";
                  echo "<td>" . $dataSolicitacao . "</td>";
                  echo "<td>" . $descricao . "</td>";
                  echo "<td>" . $metodoPagamento . "</td>";
                  echo "<td>R$ " . number_format($valor, 2, ',', '.') . "</td>";
                  echo "<td>" . $solicitante . "</td>";

                  switch ($statusPagamento) {
                    case 'pendente':
                      echo "<td><i class='fa-regular fa-clock'></i></td>";
                      break;
                    
                    case 'aprovado':
                      echo "<td><i class='fa-regular fa-clock'></i><i class='fa-solid fa-robot'></i></td>";
                      break;
          
                    case 'negado':
                      echo "<td><i class='fa-solid fa-ban'></i></td>";
                      break;
          
                    case 'pago':
                      echo "<td><i class='fa-solid fa-check'></i></td>";
                      break;
                  }

                  echo "<td><button class='modal' data-id='" . $pagamentoID . "'><i class='fa-solid fa-eye'></i> visualizar</button></td>";
                  echo "</tr>";
              
                  // Modal for each record
                  echo "<div class='modal-window' id='modal-" . $pagamentoID . "'>";
                  echo "<div class='modal-content'>";
                  echo "<span class='close' data-id='" . $pagamentoID . "'>&times;</span>";
                  echo "<h2>Detalhes do Pagamento</h2>";
                  echo "<p><strong>Classe:</strong> " . $classe . "</p>";
                  echo "<p><strong>Descrição:</strong> " . $descricao . "</p>";
                  echo "<p><strong>Valor:</strong> R$ " . number_format($valor, 2, ',', '.') . "</p>";
                  echo "<p><strong>Status:</strong> " . $statusPagamento . "</p>";
                  echo "<p><strong>Solicitante:</strong> " . $solicitante . "</p>";
                  echo "<p><strong>Metodo de Pagamento:</strong> " . $metodoPagamento . " - " .  $pixBoleto . "</p>";
                  if ($anexo) {
                      echo "<p><a target='_blank' href='../uploads/" . $anexo . "'>Visualizar Anexo</a></p>";
                  }

                  if ($statusPagamento === 'pendente') {
                    if ($accountType === 'admin') {
                      echo "<form action='../src/db_forms/colaborador_pagamentos' method='POST'>
                              <input value='" . $pagamentoID . "' name='pagamento-id' hidden>
                              <button name='button' class='btn primary' value='approve'>Aprovar</button>
                              <button name='button' class='btn primary' value='deny'>Rejeitar</button>
                            </form>";
                    } else {
                      echo "<form action='../src/db_forms/colaborador_pagamentos' method='POST'>
                             <input value='" . $pagamentoID . "' name='pagamento-id' hidden>
                             <button class='btn primary' name='button' value='delete'>Excluir</button>
                            </form>";
                    }
                  }

                  echo "</div>";
                  echo "</div>";
              }
              ?>
              

    </table></div>

</div>

  <div class="buttons-container">
    <a href="colaborador_area"><button class="btn secondary" type="button">Voltar</button></a>
  </div>


  <script>

document.addEventListener('DOMContentLoaded', function () {
    // Get all the buttons that trigger modals
    let modalButtons = document.querySelectorAll('.modal');
    
    // Get all the close buttons
    let closeButtons = document.querySelectorAll('.close');

    // Function to show a modal
    function showModal(modalId) {
        let modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
        }
    }

    // Function to close a modal
    function closeModal(modalId) {
        let modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Add event listeners to open modals
    modalButtons.forEach(button => {
        button.addEventListener('click', function() {
            let modalId = 'modal-' + this.getAttribute('data-id');
            showModal(modalId);
        });
    });

    // Add event listeners to close modals
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            let modalId = 'modal-' + this.getAttribute('data-id');
            closeModal(modalId);
        });
    });

});


  </script>

</body>
</html>
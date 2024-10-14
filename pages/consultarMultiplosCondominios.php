<?php include_once '../public/partials/header.php';?>

    <main>
        <div class="wrapper">
        <h1>Consultar Multiplos Condomínios</h1>
        <p>Selecione os condomínios clicando e segurando a tecla CTRL.</p>
        
    <?php

    require_once '../src/filters/condominios_multiplos.php';
    require_once '../src/db/dbh.php';

    if (empty($condFiltro)) {
        echo "<div class='select-filter'><p> 👆 Por favor, selecione os condomínios.</p></div>";
    } else {

        try {

            $columnHeaders = ['Condomínio', 'Endereço', 'Bairro', 'Cidade', 'Telefone', 'CNPJ', 'Unidades', 'Perfil', 
                             'Síndico', 'Telefone do Síndico', 'E-mail do Síndico', 'Síndico Morador?', 'Unidade do Síndico', 
                             'Dia de Vencimento', 'Taxa Garantidora', 'Gás', 'Água', 'Taxa do Boleto', 
                             'Dia de Recebimento do Rateio', 'Gráfica', 'Protocolo', 'Demonstrativo', 
                             'Forma de Entrega', 'Porteiro/Zelador', 'Telefone do Porteiro/Zelador', 
                             'Primeira Cobrança', 'Detalhes de Antecipação', 'Antiga Garantidora', 
                             'Telefone da Antiga Garantidora', 'E-mail da Antiga Garantidora', 
                             'Endereço da Antiga Garantidora', 'Observações Gerais', 'Fim do Contrato'];            

            $columns = ['CondName', 'StreetName', 'District', 'City', 'Phone', 'CGC', 'Unidades', 
                       'Perfil', 'Sindico', 'SindicoTelefone', 'SindicoEmail', 'SindicoMorador', 'SindicoMoradorUnidade',
                       'DiaVencimento', 'TaxaGarantidora', 'Gas', 'Agua', 'TaxaBoleto', 'DiaRecebimentoRateio',
                       'Grafica', 'Protocolo', 'Demonstrativo', 'FormaEntrega', 'PorteiroZeladorNome', 'PorteiroZeladorTelefone',
                       'DataPrimeiraCobranca', 'DetalhesAntecipacao', 'AntigaGarantidora', 'AntigaGarantidoraTelefone', 
                       'AntigaGarantidoraEmail', 'AntigaGarantidoraEndereco', 'ObservacoesGerais', 'FimContrato'];

            echo "<div class='table-container'>
                  <table class='tables'>
                  <tr>";

                  foreach ($columnHeaders as $cheader) {
                    echo "<th>" . $cheader . "</th>";
                  }
            echo "</tr>";


            foreach ($condFiltro as $condominio) {

                $query = "SELECT Condominios.*, Administradoras.Nome AS Administradora, CondominiosInfoAd.* FROM Condominios
                LEFT JOIN CondominiosInfoAd
                ON Condominios.CondID = CondominiosInfoAd.CondID
                LEFT JOIN Administradoras 
                ON CondominiosInfoAd.AdministradoraID = Administradoras.AdministradoraID
                WHERE Condominios.CondID = :condominio;";
    
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':condominio', $condominio);
                $stmt->execute();
    
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($results as $row) {
                    
                    echo "<tr>";
                    foreach ($columns as $column) {
                        echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
                    }
                    echo "<tr>";

                }      
            }

            echo "</table></div>";

            $pdo = null;
            $stmt = null;

        } catch (PDOException $error) {
            die("Query failed: " . $error->getMessage());
        }
    }

?>

    <div class="buttons-container">
        <a href="consultarCondominio.php"><button class="btn secondary" type="button">Voltar</button></a>
    </div>

  </div>
</main>

</body>
</html>
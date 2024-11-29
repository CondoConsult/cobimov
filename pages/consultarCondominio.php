<?php include_once '../public/partials/header.php';?>

    <main>
        <div class="wrapper">
            <h1>Consultar Condomínios</h1>
            <!-- <p><a href="consultarMultiplosCondominios.php"><i class="fa-regular fa-eye"></i> Consultar multiplos</a></p>-->

            <?php             
            require_once '../src/filters/condominios.php'; 
            require_once '../src/db_functions/select.php';

                $query = "SELECT Condominios.*, Administradoras.Nome AS Administradora, CondominiosInfoAd.* 
                          FROM Condominios
                          LEFT JOIN CondominiosInfoAd ON Condominios.CondID = CondominiosInfoAd.CondID
                          LEFT JOIN Administradoras ON CondominiosInfoAd.AdministradoraID = Administradoras.AdministradoraID
                          WHERE Condominios.CondID = '$condFiltro';";

                $results = selectData($query);

                foreach ($results as $row) {
                   echo "<h2>" . $row['CondName'] . "</h2>";
                }

                if (!empty($results)) { ?>
                    <form action="editarInformacoesAdicionais.php" method="POST">
                        <button class="button-edit" name="edit" value="<?php echo $condFiltro; ?>"><img class='processes-status-icons' src='../public/images/icons/edit.svg'></button><br><br>
                    </form>
                    <div class="tab">
                        <button class="tablinks first" onclick="openTab(event, 'Tab1')">Condomínio</button>
                        <button class="tablinks" onclick="openTab(event, 'Tab2')">Síndico e Porteiro</button>
                        <button class="tablinks" onclick="openTab(event, 'Tab3')">Vencimento e Taxas</button>
                        <button class="tablinks" onclick="openTab(event, 'Tab4')">Entrega e Cobrança</button>
                        <button class="tablinks" onclick="openTab(event, 'Tab5')">Garantidora Anterior</button>
                        <button class="tablinks" onclick="openTab(event, 'Tab6')">Informações Adicionais</button>
                        <button class="tablinks" onclick="openTab(event, 'Tab7')">Automação</button>
                    </div>
                    
                <?php }

                    foreach ($results as $row) {
                        echo "<div id='Tab1' class='tabcontent'>";
                        echo "<label>Banco de Emissão</label>";
                        echo "<p>" . $row['BancoEmissao'] . "</p>";
                        echo "<label>Administradora</label>";
                        echo "<p>" . $row['Administradora'] . "</p>";
                        echo "<label>Endereço</label>";
                        echo "<p>" . $row['StreetName'] . ", " . $row['District'] . ", " . $row['City'] . ", " . $row['StateProvince'] . ", " . $row['ZipCode'] . "</p>";
                        echo "<label>Telefone</label>";
                        echo "<p>" . $row['Phone'] . "</p>";
                        echo "<label>CGC</label>";
                        echo "<p>" . $row['CGC'] . "</p>";
                        echo "<label>Unidades</label>";
                        echo "<p>" . $row['Unidades'] . "</p>";
                        echo "<label>Perfil</label>";
                        echo "<p>" . $row['Perfil'] . "</p>";
                        echo "</div>";

                        echo "<div id='Tab2' class='tabcontent'>";
                        echo "<h2>Síndico</h2>";
                        echo "<label>Nome</label>";
                        echo "<p>" . $row['Sindico'] . "</p>";
                        echo "<label>E-mail</label>";
                        echo "<p>" . $row['SindicoEmail'] . "</p>";
                        echo "<label>Telefone</label>";
                        echo "<p>" . $row['SindicoTelefone'] . "</p>";
                        echo "<label>Morador?</label>";
                        echo "<p>" . $row['SindicoMorador'] . "</p>";
                        echo "<label>Unidade</label>";
                        echo "<p>" . $row['SindicoMoradorUnidade'] . "</p>";

                        echo "<h2>Porteiro</h2>";
                        echo "<label>Nome</label>";
                        echo "<p>" . $row['PorteiroZeladorNome'] . "</p>";
                        echo "<label>Telefone</label>";
                        echo "<p>" . $row['PorteiroZeladorTelefone'] . "</p>";
                        echo "</div>";

                        echo "<div id='Tab3' class='tabcontent'>";
                        echo "<h2>Taxas</h2>";
                        echo "<label>Dia do Vencimento</label>";
                        echo "<p>" . $row['DiaVencimento'] . "</p>";
                        echo "<label>Taxa Garantidora</label>";
                        echo "<p>" . $row['TaxaGarantidora'] . " %</p>";
                        echo "<label>Taxa Boleto</label>";
                        echo "<p>R$ " . $row['TaxaBoletoValor'] . "</p>";
                        echo "<label>Gás</label>";
                        echo "<p>" . $row['Gas'] . "</p>";
                        echo "<label>Água</label>";
                        echo "<p>" . $row['Agua'] . "</p>";
                        echo "</div>";


                        echo "<div id='Tab4' class='tabcontent'>";
                        echo "<h2>Cobrança</h2>";
                        echo "<label>Primeira Cobrança</label>";
                        echo "<p>" . $row['DataPrimeiraCobranca'] . "</p>";
                        echo "<label>Antecipação</label>";
                        echo "<p>" . $row['DetalhesAntecipacao'] . "</p>";
 
                        echo "<h2>Entrega</h2>";
                        echo "<label>Forma de entrega</label>";
                        echo "<p>" . $row['FormaEntrega'] . "</p>";
                        echo "<label>Observações</label>";
                        echo "<p>" . $row['ObservacoesEntrega'] . "</p>";
                        echo "</div>";

                        echo "<div id='Tab5' class='tabcontent'>";
                        echo "<h2>Garantidora Anterior</h2>";
                        echo "<label>Nome</label>";
                        echo "<p>" . $row['AntigaGarantidora'] . "</p>";
                        echo "<label>E-mail</label>";
                        echo "<p>" . $row['AntigaGarantidoraEmail'] . "</p>";
                        echo "<label>Telefone</label>";
                        echo "<p>" . $row['AntigaGarantidoraTelefone'] . "</p>";
                        echo "<label>Endereço</label>";
                        echo "<p>" . $row['AntigaGarantidoraEndereco'] . "</p>";
                        echo "</div>";

                        echo "<div id='Tab6' class='tabcontent'>";
                        echo "<h2>Informações Adicionais</h2>";
                        echo "<label>Dia do Recebimento Rateio</label>";
                        echo "<p>" . $row['DiaRecebimentoRateio'] . "</p>";
                        echo "<label>Enviar para Gráfica?</label>";
                        echo "<p>" . $row['Grafica'] . "</p>";
                        echo "<label>Protocolo</label>";
                        echo "<p>" . $row['Protocolo'] . "</p>";
                        echo "<label>Demonstrativo</label>";
                        echo "<p>" . $row['Demonstrativo'] . "</p>";
            
                        echo "<h2>Contrato</h2>";
                        echo "<label>Fim Contrato</label>";
                        echo "<p>" . $row['FimContrato'] . "</p>";
                        echo "<h2>Observações</h2>";
                        echo "<p>" . $row['ObservacoesGerais'] . "</p>";
                        echo "</div>";

                        echo "<div id='Tab7' class='tabcontent'>";
                        echo "<label>Enviar boletos e-mail</label>";
                        echo "<p>" . $row['EnviarBoletoEmail'] . "</p>";
                        echo "</div>";
                    }
            ?>
            </div>
            <div class="buttons-container">
                <a href="condominios.php"><button class="btn secondary" type="button">Voltar</button></a>
            </div>
        
    </main>
</body>
<script src="../js/main.js"></script>
<script src="../public/js/tabs.js"></script>
</html>

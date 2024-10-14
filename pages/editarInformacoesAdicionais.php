<?php 
include_once '../public/partials/header.php';?>

  <main>

    <div class="wrapper">
    <h1>Editar Informações Adicionais Condomínio</h1>

      <?php

        $condFiltro = $_POST['edit'];

        $query = "SELECT * FROM CondominiosInfoAd 
                  RIGHT JOIN Condominios
                  ON CondominiosInfoAd.CondID = Condominios.CondID
                  LEFT JOIN Administradoras
                  ON CondominiosInfoAd.AdministradoraID = Administradoras.AdministradoraID
                  WHERE Condominios.CondID = '$condFiltro';";
        $results = selectData($query);

        foreach ($results as $row) {
          $condID = $condFiltro;
          $administradora = $row['Nome'];
          $administradoraID = $row['AdministradoraID'];
          $condominio = $row['CondName'];
          $perfil = $row['Perfil'];
          $unidades = $row['Unidades'];
          $sindico = $row['Sindico'];
          $sindicoEmail = $row['SindicoEmail'];
          $sindicoTelefone = $row['SindicoTelefone'];
          $sindicoMorador = $row['SindicoMorador'];
          $sindicoUnidade = $row['SindicoMoradorUnidade'];
          $diaVencimento = $row['DiaVencimento'];
          $taxaGarantidora = $row['TaxaGarantidora'];
          $gas = $row['Gas'];
          $agua = $row['Agua'];
          $taxaBoletoValor = $row['TaxaBoletoValor'];
          $diaRecebimentoRateio = $row['DiaRecebimentoRateio'];
          $grafica = $row['Grafica'];
          $protocolo = $row['Protocolo'];
          $demonstrativo = $row['Demonstrativo'];
          $nomePorteiroZelador = $row['PorteiroZeladorNome'];
          $telefonePorteiroZelador = $row['PorteiroZeladorTelefone'];
          $primeiraCobranca = $row['DataPrimeiraCobranca'];
          $detalhesAntecipacao = $row['DetalhesAntecipacao'];
          $antigaGarantidora = $row['AntigaGarantidora'];
          $antigaGarantidoraTelefone = $row['AntigaGarantidoraTelefone'];
          $antigaGarantidoraEmail = $row['AntigaGarantidoraEmail'];
          $antigaGarantidoraEndereco = $row['AntigaGarantidoraEndereco'];
          $ObservacoesGerais = $row['ObservacoesGerais'];
          $fimContrato = $row['FimContrato'];
          $FormaEntrega = $row['FormaEntrega'];
          $observacoesEntrega = $row['ObservacoesEntrega'];
          $avisosEmail = $row['AvisosEmail'];
          $enviarBoletoEmail = $row['EnviarBoletoEmail'];
          $sindicoIsento = $row['SindicoIsento'];
          $sistema = $row['Sistema'];
          $bancoEmissao = $row['BancoEmissao'];
          $repasseTaxa = $row['DescRepasseTaxa'];
          $repasseBoleto = $row['DescRepasseBoleto'];
        }

      if (empty($condFiltro)) {
        echo "<div class='select-filter'><p> 👆 Por favor, selecione o condominio.</p></div>";
      } else { ?>

      <form action="../src/db_forms/condominios_info.php" method="POST">
        <div class="containers">
          <div class="box">
            <h2><?php echo $condominio ?></h2>
            <input name="cond-id" type="hidden" value="<?php echo $condFiltro ?>" readonly><br>

            <label for="banco-emissao">Banco de Emissão</label><br>
            <select name="banco-emissao">
              <option value="Indefinido" <?php echo (trim($bancoEmissao) === 'Indefinido') ? 'selected' : ''; ?>>Indefinido</option>
              <option value="Banco do Brasil" <?php echo (trim($bancoEmissao) === 'Banco do Brasil') ? 'selected' : ''; ?>>Banco do Brasil</option>
              <option value="Santander" <?php echo (trim($bancoEmissao) === 'Santander') ? 'selected' : ''; ?>>Santander</option>
              <option value="Unicred" <?php echo (trim($bancoEmissao) === 'Unicred') ? 'selected' : ''; ?>>Unicred</option>
            </select><br>

            <label for="sistema">Sistema</label><br>
            <select name="sistema">
              <option value="Condominio 21" <?php echo (trim($sistema) === 'Condominio 21') ? 'selected' : ''; ?>>Condominio 21</option>
              <option value="COM21" <?php echo (trim($sistema) === 'COM21') ? 'selected' : ''; ?>>COM21</option>
            </select><br>

            <?php
          
              $query = "SELECT * FROM Administradoras ORDER BY Nome ASC";
              $administradoras = selectData($query);

              if (empty($administradoraID)) {
                $administradoraID = 'null';
              }

              echo '<label>Administradora</label><br>';
              echo '<select name="administradora">';
              echo "<option value='" . $administradoraID . "' selected>". $administradora . "</option>";

              foreach ($administradoras as $row) {
                echo "<option value=" . $row['AdministradoraID'] . ">" . $row['Nome'] . "</option>";
              }
              echo '</select><br>';
            ?>

            <label for="perfil">Perfil</label><br>
            <select name="perfil">
              <option value="Inativos" <?php echo (trim($perfil) === 'Inativos') ? 'selected' : ''; ?>>Inativos</option>
              <option value="Somente Emissão" <?php echo (trim($perfil) === 'Somente Emissão') ? 'selected' : ''; ?>>Somente Emissão</option>
              <option value="Emissão + Click Consult" <?php echo (trim($perfil) === 'Emissão + Click Consult') ? 'selected' : ''; ?>>Emissão + Click Consult</option>
              <option value="Garantia Total" <?php echo (trim($perfil) === 'Garantia Total') ? 'selected' : ''; ?>>Garantia Total</option>
            </select> <br>
            <label for="unidades">Número de unidades</label><br>
            <input name="unidades" type="number" value="<?php echo $unidades ?>"><br>

            <h2>Sindico</h2>
            <label for="sindico">Nome</label><br>
            <input name="sindico" type="text" value="<?php echo $sindico ?>"><br>

            <label for="telefone-sindico">Telefone</label><br>
            <input name="telefone-sindico[]" type="text" value="<?php echo $sindicoTelefone ?>">
            <button class="button-plus" type="button" onclick="adicionarCampo('telefone-sindico[]', 'adicionar-telefone-sindico')">+</button><br>
            <div id="adicionar-telefone-sindico"></div>

            <label for="email-sindico">E-mail</label><br>
            <input name="email-sindico[]" type="text" value="<?php echo $sindicoEmail?>">
            <button class="button-plus" type="button" onclick="adicionarCampo('email-sindico[]', 'adicionar-email-sindico')">+</button><br>
            <div id="adicionar-email-sindico"></div>

            <label for="sindico-morador">Síndico morador?</label><br>
            <select name="sindico-morador">
              <option value="Não" <?php echo (trim($sindicoMorador) === 'Não') ? 'selected' : ''; ?>>Não</option>
              <option value="Sim" <?php echo (trim($sindicoMorador) === 'Sim') ? 'selected' : ''; ?>>Sim</option>
            </select><br>
            <label for="unidade-sindico">Unidade</label><br>
            <input name="unidade-sindico" type="text" value="<?php echo $sindicoUnidade?>"><br>
            <label for="sindico-isento">Síndico isento?</label><br>
            <select name="sindico-isento">
              <option value="Não" <?php echo (trim($sindicoIsento) === 'Não') ? 'selected' : ''; ?>>Não</option>
              <option value="Sim" <?php echo (trim($sindicoIsento) === 'Sim') ? 'selected' : ''; ?>>Sim</option>
            </select><br>

            <h2>Porteiro/Zelador</h2>
            <label for="porteiro-zelador">Nome</label><br>
            <input name="porteiro-zelador[]" type="text" value="<?php echo $nomePorteiroZelador ?>" >
            <button class="button-plus" type="button" onclick="adicionarCampo('porteiro-zelador[]', 'adicionar-porteiro-zelador')">+</button><br>
            <div id="adicionar-porteiro-zelador"></div>

            <label for="telefone-porteiro-zelador">Telefone</label><br>
            <input name="telefone-porteiro-zelador[]" type="text" value="<?php echo $telefonePorteiroZelador ?>">
            <button class="button-plus" type="button" onclick="adicionarCampo('telefone-porteiro-zelador[]', 'adicionar-telefone-porteiro-zelador')">+</button><br>
            <div id="adicionar-telefone-porteiro-zelador"></div>

            </div>

            <div class="box">

            <h2>Cobrança</h2>
            <label for="primeira-cobranca">Mês e ano da primeira cobrança</label><br>
            <input name="primeira-cobranca" type="text" value="<?php echo $primeiraCobranca ?>"><br>
            <label for="detalhes-antecipacao">Detalhes antecipação</label><br>
            <textarea name="detalhes-antecipacao" cols="30" rows="5"><?php echo $detalhesAntecipacao ?></textarea><br>

            <h2>Entrega de Boletos</h2>
            <label>Forma de entrega</label><br>
            <select name="forma-entrega">
              <option value="Administradora">Administradora</option>
              <option value="Condomínio">Condomínio</option>
              <option value="E-mail">E-mail</option>
              <option value="Motoboy">Motoboy</option>
              <option value="Não Entregar">Não Entregar</option>
              <option value="Portaria">Portaria</option>
              <option value="Transportadora">Transportadora</option>
              <option value="Síndico">Síndico</option>
              <option value="WhatsApp">WhatsApp</option>
              <option value="WhatsApp e E-mail">WhatsApp e E-mail</option>
              <option value="Outra">Outra</option>
            </select><br>
              <label>Observações</label><br>
              <textarea name="observacoes-entrega" cols="30" rows="5"><?php echo $observacoesEntrega ?></textarea><br>
    
            <h2>Taxas</h2>
            <label for="gas">Gás</label><br>
            <select name="gas">
              <option value="Não" <?php echo (trim($gas) === 'Não') ? 'selected' : ''; ?>>Não</option>
              <option value="Sim" <?php echo (trim($gas) === 'Sim') ? 'selected' : ''; ?>>Sim</option>
            </select> <br>
            <label for="agua">Água</label><br>
            <select name="agua">
              <option value="Não" <?php echo (trim($agua) === 'Não') ? 'selected' : ''; ?>>Não</option>
              <option value="Sim" <?php echo (trim($agua) === 'Sim') ? 'selected' : ''; ?>>Sim</option>
            </select><br>
            <label for="taxa-garantidora">Garantidora (%)</label><br>
            <input name="taxa-garantidora" type="number" value="<?php echo $taxaGarantidora?>" step="0.01" min="0.00"><br>

            <label for="repasse-taxa">Descontar Repasse na Taxa?</label><br>
            <select name="repasse-taxa">
              <option value="Não" <?php echo (trim($repasseTaxa) === 'Não') ? 'selected' : ''; ?>>Não</option>
              <option value="Sim" <?php echo (trim($repasseTaxa) === 'Sim') ? 'selected' : ''; ?>>Sim</option>
            </select><br>

            <label for="taxa-boleto">Boleto (valor)</label><br>
            <input name="taxa-boleto" type="number" value="<?php echo $taxaBoletoValor ?>" step="0.01" min="0.00"><br>

            <label for="repasse-boleto">Descontar Repasse no Boleto?</label><br>
            <select name="repasse-boleto">
              <option value="Não" <?php echo (trim($repasseBoleto) === 'Não') ? 'selected' : ''; ?>>Não</option>
              <option value="Sim" <?php echo (trim($repasseBoleto) === 'Sim') ? 'selected' : ''; ?>>Sim</option>
            </select><br>

            </div>

            <div class="box">

            <h2>Informações Adicionais</h2>
            <label for="dia-vencimento">Dia de vencimento</label><br>
            <input name="dia-vencimento[]" type="text" value="<?php echo $diaVencimento?>">
            <button class="button-plus" type="button" onclick="adicionarCampo('dia-vencimento[]', 'adicionar-dia-vencimento')">+</button><br>
            <div id="adicionar-dia-vencimento"></div>


            <label for="dia-rateio">Recebimento rateio (dias úteis)</label><br>
            <input name="dia-rateio" type="number" value="<?php echo $diaRecebimentoRateio ?>"><br>
            <label for="protocolo">Protocolo</label><br>
            <select name="protocolo">
              <option value="Não" <?php echo (trim($protocolo) === 'Não') ? 'selected' : ''; ?>>Não</option>
              <option value="Sim" <?php echo (trim($protocolo) === 'Sim') ? 'selected' : ''; ?>>Sim</option>
            </select> <br>
            <label for="demonstrativo">Demonstrativo</label><br>
            <select name="demonstrativo">
              <option value="Não" <?php echo (trim($demonstrativo) === 'Não') ? 'selected' : ''; ?>>Não</option>
              <option value="Sim" <?php echo (trim($demonstrativo) === 'Sim') ? 'selected' : ''; ?>>Sim</option>
            </select><br>
            <label for="grafica">Enviar para gráfica?</label><br>
            <select name="grafica">
              <option value="Não" <?php echo (trim($grafica) === 'Não') ? 'selected' : ''; ?>>Não</option>
              <option value="Sim" <?php echo (trim($grafica) === 'Sim') ? 'selected' : ''; ?>>Sim</option>
            </select><br>

            <label for="avisos-email">Enviar avisos de vencimento?</label><br>
            <select name="avisos-email">
              <option value="Não" <?php echo (trim($avisosEmail) === 'Não') ? 'selected' : ''; ?>>Não</option>
              <option value="Sim" <?php echo (trim($avisosEmail) === 'Sim') ? 'selected' : ''; ?>>Sim</option>
            </select><br>

            <h2>Automação</h2>

            <label for="envio-boleto-email">Enviar boleto via e-mail?</label><br>
            <select name="envio-boleto-email">
              <option value="Não" <?php echo (trim($enviarBoletoEmail) === 'Não') ? 'selected' : ''; ?>>Não</option>
              <option value="Sim" <?php echo (trim($enviarBoletoEmail) === 'Sim') ? 'selected' : ''; ?>>Sim</option>
            </select>

            <h2>Antiga Garantidora</h2>
            <label for="antiga-garantidora">Nome</label><br>
            <input name="antiga-garantidora" type="text" value="<?php echo $antigaGarantidora ?>"><br>
            <label for="antiga-garantidora-telefone">Telefone</label><br>
            <input name="antiga-garantidora-telefone" type="text" value="<?php echo $antigaGarantidoraTelefone ?>"><br>
            <label for="antiga-garantidora-email">E-mail</label><br>
            <input name="antiga-garantidora-email" type="text" value="<?php echo $antigaGarantidoraEmail ?>"><br>
            <label for="antiga-garantidora-endereco">Endereço</label><br>
            <input name="antiga-garantidora-endereco" type="text" value="<?php echo $antigaGarantidoraEndereco ?>"><br>
            <label for="fim-contrato">Fim de contrato</label><br>
            <input name="fim-contrato" type="text" value="<?php echo $fimContrato ?>"><br>
            <label for="observacoes">Observações</label><br>
            <textarea name="observacoes-gerais" cols="30" rows="5"><?php echo $ObservacoesGerais ?></textarea><br>
          </div>
          </div>

          <?php } ?>

          <div class="buttons-container">
              <button name="button" value="update" class="btn primary" type="submit">Salvar</button>
              <button name="button" value="delete" class="btn remove" type="submit">Remover</button>
              <a href="consultarCondominio.php"><button class="btn secondary" type="button">Voltar</button></a>
          </div>

      </form>
    </div>
    
  </main>
</body>
<script src="../js/camposAdicionais.js"></script>
<script src='../js/main.js'></script>
</html>
# cobimov


[TOC]

## 🤔 Purpose

cobimov aims to offer solutions for the lack of information on company's internal systems. The website offers reports, data insertion and visualization. The main goal of cobimov is to grow with user's collaboration and provide functional and accessible tools for them to use as they most need it.



## Technical Specs

The website is hosted by BlueHost.

### Database

The web site's data is stored and retrieved in MySQL. At the moment the structure is made of 8 data tables.

| Table                  | Data source | Description |
| ---------------------- | ----------- | ----------- |
| Administradoras        | CobImov     |             |
| ArquivosRemessa        | CobImov     |             |
| Bancos                 | CobImov     |             |
| CondominiosIndCorrecao | CobImov     |             |
| CondominiosInfoAd      | CobImov     |             |
| LancamentosCJudiciais  | CobImov     |             |
| Usuarios               | CobImov     |             |
| Feriados               | CobImov     |             |
| Grupos                 | Cond21      |             |
| Condominios            | Cond21      |             |
| Unidades               | Cond21      |             |



### 🔽 Complemental data from Cond21

Some data tables need data from Cond21.

#### Condominios

```sql
SELECT 
    Condominios.IDCond AS CondID,
    Resumo AS CondName,
    Endereco AS StreetName,
    Bairro AS District,
    Cidade AS City,
    Estado AS StateProvince,
    Telefone AS Phone,
    CEP AS ZipCode,
    CGC
FROM Condominios
JOIN GrupoCondominio ON Condominios.IDCond = GrupoCondominio.IDConD
WHERE GrupoCondominio.NomeGrupo = 'CondoConsult';
```

### Grupos

```sql
SELECT IDCond AS CondID, NomeGrupo AS Grupo FROM GrupoCondominio
WHERE NomeGrupo = 'CondoConsult' OR NomeGrupo = 'NOVA CASA';
```

### Unidades






<?php

require_once 'DoadorController.php';
    
class DoadorCelescController extends DoadorController {

    private $numeroContrato = getenv('NUMERO_CONTRATO_CELESC');
    private $codigoConcessionaria = getenv('CODIGO_CONCESSIONARIA_CELESC'); // 4 digitos
    private $nomeConveniado = getenv('NOME_CONVENIADO_CELESC');             // 5 digitos
    private $codigoDaConta = getenv('CODIGO_DA_CONTA_CELESC');
    private $coberturaOcorrencia = getenv('COBERTURA_OCORRENCIA_CELESC');
    private $sequenciaEnvio;

    public function init() {
        
        parent::init();
        
        /*
         * @todo Número sequencial 6 dígitos
         */
        $this->sequenciaEnvio = '000007';
                        
        /*
         * Número do contrato da Celesc, contém 56 caracteres
         */
        $this->numeroContrato = str_pad($this->numeroContrato, 56, " ", STR_PAD_RIGHT);
        
        /*
         * Nome do conveniado Celesc, contém 20 caracteres
         */
        $this->nomeConveniado = str_pad($this->nomeConveniado, 20, " ", STR_PAD_RIGHT);
    }
    
    function gerarArquivoAction() {
        $this->_helper->layout->disableLayout();

        $tableDoador = new Application_Model_Table_Doador();
        $where = 'valor_celesc > 0';
        $doadores = $tableDoador->fetchAll($where);

        $header = '';
        $registros = array();
        $footer = '';
        $soma = 0;
        $remessa = '';
        $sequencia = 0;

        /*
         * Linha inicial (header)
         *
         * Posição Inicial  Posição Final   Tamanho     Tipo     Nota       Descrição
         * 001              001             1           CHAR     Fixo:1     Identificação do tipo de registro
         * 002              057             56          CHAR     01         Número do contrato
         * 058              061             4           CHAR     02         Código da concessionaria
         * 062              069             8           NUM      DDMMAAAA   Data de envio
         * 070              075             6           CHAR     R$         Sigla da moeda
         * 076              081             6           NUM      03         Número sequencial de envio
         * 082              083             2           CHAR     04         Motivo da recusa do arquivo de remessa
         * 084              103             20          CHAR                Nome do cliente conveniado
         * 104              143             40          CHAR                Espaços
         * 144              144             1           CHAR     05         Tipo de arquivo
         * 145              150             6           NUM                 Número sequencial do registro
         */
        $header = '1'
                . $this->numeroContrato
                . $this->codigoConcessionaria
                . date('dmY')
                . str_pad('R$', 6, " ", STR_PAD_RIGHT)
                . $this->sequenciaEnvio
                . str_repeat(chr(32), 2) // 2 espacos. Motivo de recusa, preenchido somente pela concessionária
                . $this->nomeConveniado
                . str_repeat(chr(32), 40) // 40 espacos
                . '1'
                . str_pad(++$sequencia, 6, "0", STR_PAD_LEFT) // Número sequencial do registro
                . PHP_EOL;

        /*
         * Registros
         *
         * Posição Inicial  Posição Final   Tamanho     Tipo    Nota        Descrição
         * 001              001             1           CHAR    Fixo:2      Identificação do tipo de registro
         * 002              014             13          NUM                 Código da unidade consumidora
         * 015              023             9           NUM     06          Valor do lançamento
         * 024              031             8           NUM     DDMMAAA     Data de geração do registro
         * 032              033             2           CHAR    07          Comando do movimento
         * 034              041             8           CHAR    08          Código da conta
         * 042              043             2           CHAR    09          Cobertura / Ocorrência
         * 044              073             30          CHAR                Descrição da cobertura / Ocorrência
         * 074              083             10          NUM     23          Número do cliente
         * 084              089             6           NUM                 Identificação do cliente no Conveniado
         * 090              101             12          CHAR    10          CPF / CNPJ do Cliente
         * 102              109             8           NUM     11          Data de início vigência
         * 110              117             8           NUM     12          Data fim de vigência
         * 118              119             2           CHAR                Complemento do CNPJ
         * 120              121             2           CHAR                Espaços
         * 122              134             13          NUM     13          Código unidade consumidora anterior
         * 135              144             10          NUM     13          Número do cliente anterior / Unidade Administrativa
         * 145              150             6           NUM     14          Número sequencial do registro
         */
        foreach ($doadores as $doador) {

            $valorCelesc = Zend_Filter::filterStatic($doador->valor_celesc, 'Digits');
            $soma += $valorCelesc;
            $cpfCnpj = isset($doador->cpf) ? $doador->cpf : $doador->cnpj;

            $registros[] = '2'
                    . str_pad($doador->codigo_unidade_consumidora, 13, "0", STR_PAD_LEFT)
                    . str_pad($valorCelesc, 9, "0", STR_PAD_LEFT)
                    //. date('dmY')
                    . date('dmY', strtotime("+1 months", strtotime(date('Y-m-d'))))
                    //. date('d') . (date('m') + 1) . date('Y') // (Proximo mes)
                    . '74' //$doador->comando_do_movimento //Verificar se é necessário incluir os outros códigos
                    . str_pad($this->codigoDaConta, 8, " ", STR_PAD_RIGHT)
                    . $this->coberturaOcorrencia
                    . str_repeat(chr(32), 30) // 30 espacos. Descrição da cobertura / Ocorrência
                    . str_repeat(0, 10) // 10 zeros. Número do cliente (Opcional)
                    . str_pad($doador->id_doador, 6, "0", STR_PAD_LEFT) //Identificação do cliente no Conveniado
                    . str_pad($cpfCnpj, 12, " ", STR_PAD_RIGHT)
                    //. '01' . date('mY') //Data de início da vigência. (Proximo mes)
                    . date('01mY', strtotime("+1 months", strtotime(date('Y-m-d'))))
                    //. '01' . (date('m') + 1) . date('Y') //Data de início da vigência. (Proximo mes)
                    . '00000000' // Data de fim da vigência
                    . str_pad(substr($doador->cnpj, -2), 2, chr(32), STR_PAD_RIGHT) // Complemento do CNPJ
                    . str_repeat(chr(32), 2) // 2 espaços.
                    . str_repeat(0, 13) // 13 zeros. Código da unidade consumidora anterior
                    . str_repeat(0, 10) // 10 zeros. Número do cliente anterior
                    . str_pad(++$sequencia, 6, "0", STR_PAD_LEFT) // Número sequencial do registro
                    . PHP_EOL;
        }
       
        /**
         * Linha final (Footer)
         *
         * Posição Inicial	Posição Final	Tamanho		Tipo	Nota 	Descrição
         * 001	            001             1       	CHAR    Fixo:9  Identificação do tipo de registro
         * 002              012             11      	NUM     22      Valor total dos lançamentos
         * 013              144             132     	CHAR            Espaços
         * 145              150             6       	NUM     14      Número sequencial do registro
         */
        $footer = '9'
                . str_pad($soma, 11, '0', STR_PAD_LEFT)
                . str_repeat(chr(32), 132) // 132 espaços
                . str_pad(++$sequencia, 6, "0", STR_PAD_LEFT);

        /*
         * Monta o arquivo de remessa
         */
        $remessa = $header . join('', $registros) . $footer;

        /*
         * Envia a remessa para a view
         */
        $this->view->arquivo = $this->path . $this->getNomeArquivo();
        $this->view->remessa = $remessa;
    }

    private function getNomeArquivo() {
        /*
         * UF.FTD05.EMXXXYYY.P004MMAA.terceiro
         *
         * UF: Deve ser preenchido com a filial dos telefones cobrados. (Exemplo: AC ou DF)
         * XXX: Número do código de terceiro.
         * YYY: Número da remessa (deverá evoluir de 1 em 1 todo mes, nao podendo ser repetido).
         *      Lembrando que sempre para o primeiro arquivo do ano o número da remessa deve ser 001 independente do mês de envio.
         * MM: Mes do envio
         * AA: Ano do envio
         *
         * Exemplo: SC.FTD05.EM649008.P0040813.terceiro
         */
        //$uf = 'SC';
        //$nomeArquivo = "{$uf}.FTD05.EM" . $this->codigoDeTerceiroOi . $this->numeroDaRemessaOi . ".P004" . date('my') . ".terceiro";

        $nomeArquivo = 'ecel';
        $sequencia = substr($this->sequenciaEnvio, -3);
        $ext = '.ser';
        
        return $nomeArquivo . $sequencia . $ext;
    }
    
}
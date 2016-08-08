<?php

require_once 'DoadorController.php';

class DoadorOiController extends DoadorController {

    private $codigoDeTerceiro;
    private $numeroDaRemessa;

    public function init() {

        parent::init();
        
        $this->codigoDeTerceiro = getenv('CODIGO_DE_TERCEIRO_OI');

        /*
         * Número da remessa (deverá evoluir de 1 em 1 todo mes, nao podendo ser repetido).
         * Lembrando que sempre para o primeiro arquivo do ano o número da remessa deve ser 001 independente do mês de envio.
         * Ex: 001, 002, 003,...,012
         */
        $this->numeroDaRemessa = str_pad(date('m'), 3, "0", STR_PAD_LEFT);
    }

    public function indexAction() {
        $this->_redirect('/doador/index');
    }

    function gerarArquivoAction() {
        $this->_helper->layout->disableLayout();

        $tableDoador = new Application_Model_Table_Doador();
        $where = 'valor > 0';
        $doadores = $tableDoador->fetchAll($where);

        $header = '';
        $registros = array();
        $trailler = '';
        $soma = 0;
        $remessa = '';

        /*
         * Linha inicial (header)
         *
         * Posição Inicial	Posição Final	Nome Campo                          Tamanho         Formato	Obrigatório 	Descrição
         * 001              001             TIPO DO REGISTRO = "0"              X (01)	1       A       S               Corresponde ao registro inicial da remessa (cabeçalho). Será sempre “0”.
         * 002              004             IDENTIFICAÇÃO DA EMPRESA            9 (03)	3       N       S               Corresponde ao código de Identificação da Empresa de Terceiro que está enviando a remessa. Este código será fornecido pela Oi
         * 005              010             NUMERO SEQUENCIAL DO ARQUIVO (NSA)	9 (06)	6       N       S               "O preenchimento deste campo deverá seguir a orientação: as três primeiros posições deverão ser preenchidas com o código de Identificação da Empresa de Terceiro e as três últimas deverão ser preenchidas com um seqüencial, o qual deverá evoluir de 1 em 1 para cada arquivo gerado pelo Terceiro.
         * 011              018             DATA DA REMESSA                     9 (08)	8       N       S               Corresponde a data em que o arquivo está sendo gerado pelo Terceiro. Esta data dever ser informada no formato AAAAMMDD onde AAAA = ano, MM = mês e DD = dia.
         * 019              019             TIPO DA REMESSA = "1"               X (01)	1       A       S               O conteúdo deste campo será sempre igual a “1” identificando que a remessa está sendo enviada pelo Terceiro para a Oi,.
         * 020              100             Filller                             X (81)	81      A       N               Deixar em branco
         */
        $header = '0'
                . $this->codigoDeTerceiro
                . $this->codigoDeTerceiro . $this->numeroDaRemessa
                . date('Ymd')
                . '1'
                . str_repeat(chr(32), 81) // 81 espacos, filler
                . PHP_EOL;

        /*
         * Registros
         *
         * Posição Inicial	Posição Final	Nome Campo                                              Tamanho         Formato	Obrigatório 	Descrição
         * 001              001             TIPO DO REGISTRO = "1"                                  X (01)	1       A       S               Corresponde ao registro para o faturamento, ou seja para a cobrança em conta telefônica. Sempre “1”.
         * 002              003             NUMERO DO DDD                                           9 (02)  2       N       S               Corresponde ao código DDD do telefone. Exemplo: 41, 42, 43,...
         * 004              013             NUMERO DO TELEFONE                                      9 (10)	10      N       S               Corresponde ao número do telefone que solicitou o serviço (número do telefone sem o código DDD.
         * 014              023             Nº CONTRATO DO TELEFONE                                 9 (10)	10      N       N               Corresponde ao número do contrato do telefone na Oi. Pode ser enviado com tudo zerado (10 vezes o zero) se o campo de DDD e Telefone estiverem corretos.
         * 024              031             DATA DO SERVIÇO                                         9 (08)	8       N       S               Corresponde a data em que o cliente solicitou o serviço, a qual deverá ser informada no formato AAAAMMDD. Não pode ser menor que 90 dias.
         * 032              036             Nº SEQÜENCIAL DO REGISTRO – NSR (APRESENTADO NA CONTA)	9 (05)	5       N       N               "Corresponde ao seqüencial do registro dentro da remessa. Este número deverá evoluir de 1 em 1 para cada registro gerado dentro do arquivo (limitado a 99999. Se a remessa for maior entrar em contato com a área de Cobrança de Terceiros. brt-fatterceiros@oi.net.br. O conteúdo deste campo será apresentado na conta telefônica na coluna “NUMERO CHAMADO/REFERÊNCIA” juntamente com o Histórico.."
         * 037              048             HISTÓRICO (APRESENTADO NA CONTA)                        9 (12)	12      N       N               Corresponde a informação adicional ou um controle que o terceiro faz sobre o serviço prestado, que poderá ser o número de parcelas; número do contrato firmado entre o terceiro e o cliente; número do telefone de atendimento da empresa de terceiro, etc... O conteúdo deste campo será apresentado na conta telefônica na coluna “NUMERO CHAMADO/REFERÊNCIA”.
         * 049              059             VALOR DO SERVIÇO (N9,2)                                 9 (11)	11      N       S               Corresponde ao valor do serviço que constará na conta do cliente. Campo numérico sendo que as duas últimas posições serão para centavos. Não colocar virgulas e nem pontos.
         * 060              064             CÓDIGO DO SERVIÇO                                       9 (05)	5       N       S               Corresponde ao código de faturamento e será fornecido pela Oi.
         * 065              065             C – COBRAR  D – DEVOLVER                                X (01)	1       A       S               "Indica se o valor informado na remessa será Cobrado ou Devolvido para o cliente. No caso de Terceiros este campo será sempre preenchido com “C” de Cobrar do cliente."
         * 066              079             CPF_CNPJ                                                X (14)	14      A       N               "CPF ou CNPJ relativo ao Meio de Acesso. (STI 54748)."
         * 080              080             TIPO_MEIO_DE_ACESSO                                     X (1)	1       A       N               "Tipo do Meio de Acesso. Domínio : Branco ou ""C"" (Circuito de Dados) STI 56075."
         * 081              100             Filler                                                  X (20)	20      A       S               Deixar em branco
         */
        foreach ($doadores as $sequencia => $doador) {

            $valor = Zend_Filter::filterStatic($doador->valor, 'Digits');
            $soma += $valor;

            $registros[] = '1'
                    . substr($doador->telefone, 0, 2)
                    . str_pad(substr($doador->telefone, -8), 10, "0", STR_PAD_LEFT)
                    . str_repeat(0, 10) // 10 zeros
                    . date('Ymd')
                    . str_pad($sequencia, 5, "0", STR_PAD_LEFT)
                    . str_repeat(chr(32), 12) // 12 espacos
                    . str_pad($valor, 11, "0", STR_PAD_LEFT)
                    . '13836'
                    . 'C'
                    . str_repeat(chr(32), 14) // 14 espacos, reservado para cpf ou cnpj
                    . str_repeat(chr(32), 1)  // 1 espaco, reservado para tipo de meio de acesso
                    . str_repeat(chr(32), 20) // 20 espacos, filler
                    . PHP_EOL;
        }

        /**
         * Linha final (Trailler)
         *
         * Posição Inicial	Posição Final	Nome Campo                  Tamanho		Formato	Obrigatório 	Descrição
         * 001	            001             TIPO DE REGISTRO = "9"      X (01)	1	A       S               Identifica o registro de totais/fechamento da remessa. Sempre será “9”.
         * 002              007             QUANTIDADE DE REGISTROS     9 (06)	6	N       S               Corresponde a quantidade de registros informados na remessa. Não contar a primeira linha – o header.
         * 008              022             VALOR TOTAL DOS REGISTROS	9 (15)	15	N       S               Corresponde a somatória dos valores informados na remessa. Não arredondar valores.
         * 023              100             Filler                      9 (78)	78	N       S               Deixar em branco
         */
        $trailler = '9'
                . str_pad(count($doadores), 6, "0", STR_PAD_LEFT)
                . str_pad($soma, 15, "0", STR_PAD_LEFT)
                . str_repeat(chr(32), 78); // 78 espacos, filler
                //. PHP_EOL;

        /*
         * Monta o arquivo de remessa
         */
        $remessa = $header . join('', $registros) . $trailler;

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
        $uf = 'SC';
        $nomeArquivo = "{$uf}.FTD05.EM" . $this->codigoDeTerceiro . $this->numeroDaRemessa . ".P004" . date('my') . ".terceiro";

        return $nomeArquivo;
    }

}

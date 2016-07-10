alter table doador add column `valor_celesc` decimal(8,2) after valor;

alter table doador modify telefone varchar(10);

alter table doador modify valor decimal(8,2);

alter table doador add column `codigo_unidade_consumidora` numeric(13) after valor_celesc;

alter table doador add column `comando_do_movimento` varchar(2) after codigo_unidade_consumidora;

alter table doador change column `endereco` `logradouro` varchar(100);

alter table doador add column `numero` varchar(5) after logradouro;

alter table doador add column `tipo` varchar(45) not null after observacao DEFAULT 'doador-oi';

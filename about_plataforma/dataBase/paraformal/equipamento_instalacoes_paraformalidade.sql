CREATE TABLE paraformal.equipamento_instalacoes_paraformalidade (
       id SERIAL NOT NULL
     , equipamento_instalacao_id INTEGER
     , paraformalidade_id INTEGER
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_equipamento_instalacoes_paraformalidade_1 FOREIGN KEY (equipamento_instalacao_id)
                  REFERENCES paraformal.equipamento_instalacoes (id)
     , CONSTRAINT FK_equipamento_instalacoes_paraformalidade_2 FOREIGN KEY (paraformalidade_id)
                  REFERENCES paraformal.paraformalidades (id)
);


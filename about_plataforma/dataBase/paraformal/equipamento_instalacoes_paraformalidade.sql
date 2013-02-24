CREATE TABLE public.equipamento_instalacoes_paraformalidade (
       id SERIAL NOT NULL
     , equipamento_instalacao_id INTEGER
     , imagem_paraformalidade_id INTEGER
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_equipamento_instalacoes_paraformalidade_1 FOREIGN KEY (equipamento_instalacao_id)
                  REFERENCES paraformal.equipamento_instalacoes (id)
     , CONSTRAINT FK_equipamento_instalacoes_paraformalidade_2 FOREIGN KEY (imagem_paraformalidade_id)
                  REFERENCES paraformal.imagens_paraformalidades (id)
);


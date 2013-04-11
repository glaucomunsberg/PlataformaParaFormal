CREATE TABLE paraformal.cenas (
       id SERIAL NOT NULL
     , descricao VARCHAR(255)
     , grupo_atividade_id INTEGER
     , dt_ocorrencia DATE DEFAULT now()
     , estaAtivo CHAR(1) DEFAULT 'S'
     , contribuicao_publica CHAR(1) DEFAULT 'N'
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_cenas_1 FOREIGN KEY (grupo_atividade_id)
                  REFERENCES paraformal.grupos_atividades (id)
);


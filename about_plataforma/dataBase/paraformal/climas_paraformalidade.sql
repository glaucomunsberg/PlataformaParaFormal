CREATE TABLE paraformal.climas_paraformalidade (
       id SERIAL NOT NULL
     , clima_id INTEGER
     , paraformalidade_id INTEGER
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_climas_paraformalidade_2 FOREIGN KEY (paraformalidade_id)
                  REFERENCES paraformal.paraformalidades (id)
     , CONSTRAINT FK_climas_paraformalidade_1 FOREIGN KEY (clima_id)
                  REFERENCES paraformal.climas (id)
);


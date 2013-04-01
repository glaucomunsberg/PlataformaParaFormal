CREATE TABLE paraformal.condicionantes_ambientais_paraformalidade (
       id SERIAL NOT NULL
     , condicionante_ambiental_id INTEGER
     , paraformalidade_id INTEGER
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_condicionantes_ambientais_paraformalidade_1 FOREIGN KEY (condicionante_ambiental_id)
                  REFERENCES paraformal.condicionantes_ambientais (id)
     , CONSTRAINT FK_condicionantes_ambientais_paraformalidade_2 FOREIGN KEY (paraformalidade_id)
                  REFERENCES paraformal.paraformalidades (id)
);


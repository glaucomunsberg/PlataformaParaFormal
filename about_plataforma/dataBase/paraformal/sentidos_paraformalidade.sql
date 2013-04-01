CREATE TABLE paraformal.sentidos_paraformalidade (
       id SERIAL NOT NULL
     , sentido_id INTEGER
     , paraformalidade_id INTEGER
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_sentidos_paraformalidades_1 FOREIGN KEY (sentido_id)
                  REFERENCES paraformal.sentidos (id)
     , CONSTRAINT FK_sentidos_paraformalidade_2 FOREIGN KEY (paraformalidade_id)
                  REFERENCES paraformal.paraformalidades (id)
);


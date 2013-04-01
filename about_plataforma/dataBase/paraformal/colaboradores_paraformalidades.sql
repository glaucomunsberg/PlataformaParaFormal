CREATE TABLE paraformal.colaboradores_paraformalidades (
       id SERIAL NOT NULL
     , pessoa_id INTEGER
     , paraformalidade_id INTEGER
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_colaboradores_paraformalidades_2 FOREIGN KEY (pessoa_id)
                  REFERENCES public.pessoas (id)
     , CONSTRAINT FK_colaboradores_paraformalidades_3 FOREIGN KEY (paraformalidade_id)
                  REFERENCES paraformal.paraformalidades (id)
);

